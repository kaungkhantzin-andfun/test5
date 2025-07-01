<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    protected function redirectTo()
    {
        if (Auth::user()->role == 'admin') {
            return 'dashboard';
        } elseif (Auth::user()->role == 'user') {
            return '/';
        }
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');

        // setting previous page so that we can redirect back after a successful login
        if (!session()->has('url.intended')) {
            if ($request->section != null) {
                session(['url.intended' => url()->previous() . "#" . $request->section]);
            } else {
                session(['url.intended' => url()->previous()]);
            }
        }
    }

    // custom functions to call repetedly
    public function downloadAvatar($user, $local_user)
    {
        // user မှာ avatar အသေးကိုသုံးမယ်
        if ($user->avatar) {
            $contents = file_get_contents($user->avatar);
            $name = date('mdYHis') . '_' . uniqid() . '_avatar.jpg';
            Storage::disk('public')->put("profile-photos/$name", $contents);

            // create user do not wait for file download, so updating user for the image
            $local_user->profile_photo_path = "profile-photos/$name";
            $local_user->save();
        } else {
            // user profile pic ပုံအကြီး
            if ($user->avatar_original) {
                $contents = file_get_contents($user->avatar_original);
                $name = date('mdYHis') . '_' . uniqid() . '_avatar.jpg';
                Storage::disk('public')->put("profile-photos/$name", $contents);

                // create user do not wait for file download, so updating user for the image
                $local_user->profile_photo_path = "profile-photos/$name";
                $local_user->save();
            }
        }
    }

    public function saveAndLogin($user, $platform)
    {
        // if there's no id from social media, stop!
        if ($user->id == null) return;

        $local_user = User::where($platform .  '_user_id', $user->id)->first();

        if (empty($local_user)) {
            // create user
            $local_user = User::updateOrCreate(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'slug' => uniqid(), //temporary slug so that creating user won't take too long. Can cause failed login if it is.
                    'password' => Hash::make(Str::random(18)),
                    $platform .  '_user_id' => $user->id,
                ]
            );

            // updating the slug, if we do this before creating the user, Auth::login fails
            // to avoid duplicate slug, checking existing slug and adding id at the end if it does
            if (User::where('slug',  Str::slug($user->name))->doesntExist()) {
                $local_user->update(['slug' => Str::slug($user->name)]);
            } else {
                $local_user->update(['slug' => Str::slug($user->name) . '-' . $local_user->id]);
            }

            $this->downloadAvatar($user, $local_user);
        } else {
            if ($local_user->profile_photo_path == null) {
                $this->downloadAvatar($user, $local_user);
            }
        }

        // Login the user
        // if we wait for downloadAvatar & deciding slug, login failed sometimes
        Auth::login($local_user);

        // return the user instance for redirecting to the edit page
        return $local_user;
    }
    // end of custom functions

    public function toFB()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    // public function fbRegister()
    // {
    //     session()->put('register', true);
    //     return Socialite::driver('facebook')->stateless()->redirect();
    // }

    public function fbCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();

        if ($user->email != null) {
            $local_user = $this->saveAndLogin($user, 'facebook');

            if (!empty(session()->get('user'))) {
                return redirect("/user/$local_user->id/edit");
            } else {
                return redirect()->intended("/user/$local_user->id/edit");
            }
        } else {
            session()->put('user', $user);
            return redirect("/register?name=$user->name&avatar=$user->avatar");

            // if (session()->exists('register')) {
            //     session()->put('user', $user);
            //     return redirect('/register');
            // } else {
            // }
            // return redirect()->intended("/register?name=$user->name&avatar=$user->avatar");
        }
    }

    public function toGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleCallback(Request $request)
    {
        // fix for InvalidStateException. Ref: https://stackoverflow.com/a/53388236
        if (empty($_GET)) {
            $t = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
            parse_str($t, $output);
            foreach ($output as $key => $value) {
                $request->query->set($key, $value);
            }
        }
        // end fix for InvalidStateException

        $user = Socialite::driver('google')->stateless()->user();

        if ($user->email != null) {
            $local_user = $this->saveAndLogin($user, 'google');

            if (!empty(session()->get('user'))) {
                return redirect("/user/$local_user->id/edit");
            } else {
                return redirect()->intended("/user/$local_user->id/edit");
            }
        } else {
            session()->put('user', $user);
            return redirect("/register?name=$user->name&avatar=$user->avatar");

            // return redirect()->intended("/register?name=$user->name&avatar=$user->avatar");
        }
    }

    public function toLinkedin()
    {
        return Socialite::driver('linkedin')->stateless()->redirect();
    }

    public function linkedinCallback()
    {
        $user = Socialite::driver('linkedin')->stateless()->user();

        if ($user->email != null) {
            $local_user = $this->saveAndLogin($user, 'linkedin');

            if (!empty(session()->get('user'))) {
                return redirect("/user/$local_user->id/edit");
            } else {
                return redirect()->intended("/user/$local_user->id/edit");
            }
        } else {
            session()->put('user', $user);
            return redirect("/register?name=$user->name&avatar=$user->avatar");

            // return redirect()->intended("/register?name=$user->name&avatar=$user->avatar");
        }
    }

    public function toTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function twitterCallback()
    {
        $user = Socialite::driver('twitter')->user();

        if ($user->email != null) {
            $local_user = $this->saveAndLogin($user, 'twitter');

            if (!empty(session()->get('user'))) {
                return redirect("/user/$local_user->id/edit");
            } else {
                return redirect()->intended("/user/$local_user->id/edit");
            }
        } else {
            session()->put('user', $user);
            return redirect("/register?name=$user->name&avatar=$user->avatar");

            // return redirect()->intended("/register?name=$user->name&avatar=$user->avatar");
        }
    }
}
