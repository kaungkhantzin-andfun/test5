<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Location;
use App\Helpers\MyHelper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Register extends Component
{
    public $user;
    public $avatar;
    public $townships = [];
    public $selectAll = false;
    public $userTownships = [];
    public $createMode;
    public $password;
    public $password_confirmation;

    // for call back from social registration
    public $normal = 'false';

    public function mount(User $user)
    {
        // register
        if (empty($user->id)) {
            // social register, failed Auth::login()
            if (session()->has('user')) {
                $this->user = new User();

                // get data from session which is put by SocialController
                $user = session()->get('user');
                $this->user->name = $user->name;
                $this->user->email = $user->email;
                $this->avatar = $user->avatar_original;
                $this->user->role = 'user';

                $this->normal = 'true';
                $this->createMode = true;
            } else if (Auth::check()) {
                // social register, success Auth::login()
                $this->user = Auth::user();
                $this->user->role = 'user';
                $this->normal = 'true';
            } else {
                // no user mean accessing this from create route
                $this->user = new User();
                $this->createMode = true;
            }
        } else { // editing the account
            // check if the user is editing the own account
            $this->checkOwner($user);
            $this->townships = Location::where('parent_id', $this->user->service_region_id)->get();
            $this->userTownships = unserialize($this->user->service_township_id);
            $this->createMode = false;
            $this->normal = 'true';
        }

        $this->user->role = $this->user->role ?: 'user';

        // SEO Optimizations
        MyHelper::setGlobalSEOData(empty($this->user) ? __('Register') : __('Update Account'), __('Create an account on our website to post your properties for free.'));
    }

    public function checkOwner($user)
    {
        // Check if user is admin or the owner of the property
        if (Auth::user()->role === 'remwdstate20' || Auth::user()->id === $user->id) {
            return true;
        }

        abort(403);
    }

    public function getTownships()
    {
        $this->townships = Location::where('parent_id', $this->user->service_region_id)->get();
    }

    protected $rules = [
        'user.name' => 'required|string|min:6',
        'user.phone' => 'required|string',
        'user.email' => 'required|email',
        'user.role' => 'string',
        'password' => 'sometimes|min:8|same:password_confirmation',
        'user.service_region_id' => 'required|integer',
        'userTownships' => 'required',
        'user.address' => 'required',
        'user.about' => 'required',
    ];

    protected $messages = [
        'user.name.required' => "Name is required.",
        'user.name.min' => "Name must be minimum of 6 characters.",
        'user.phone.required' => "Phone is required.",
        'user.email.required' => "Email is required.",
        'user.email.email' => "Email format is not correct.",
        'password.required' => "Password is required.",
        'password.min' => "Password must be minimum of 8 characters.",
        'user.service_region_id.required' => "Service Region is required.",
        'userTownships' => "Service Township is required.",
        'user.address.required' => 'Address is required.',
        'user.about.required' => 'About is required.',
        'userTownships.required' => 'Township is required.',
    ];

    public function checkAll()
    {
        if ($this->selectAll == true) {
            // strval is needed
            // read more at https://github.com/livewire/livewire/issues/788

            foreach ($this->townships as $tsp) {
                array_push($this->userTownships, strval($tsp->id));
            }

            // $this->userTownships = array_map('strval', $this->townships->pluck('id')->all());
        } else {
            $this->userTownships = [];
        }
    }

    public function updatedUserTownships()
    {
        count($this->userTownships) != count($this->townships) ? $this->selectAll = false : $this->selectAll = true;
    }

    public function updated()
    {
        session()->put('user', $this->user);

        $this->updateValidationRules();
        $this->validate();
    }

    public function updateValidationRules()
    {
        // Disabled for admin » edit user » change password (since it is not required)
        if (!$this->createMode) {
            unset($this->rules['password']);
        }

        if ($this->user->role != 'real-estate-agent') {
            // remove optional rules if the role is not agent
            unset(
                $this->rules['user.service_region_id'],
                $this->rules['userTownships'],
                $this->rules['user.address'],
                $this->rules['user.about'],
            );
        } else {
            // adding back if the role is agent
            $this->rules['user.service_region_id'] = 'required|integer';
            $this->rules['user.address'] = 'required';
            $this->rules['user.about'] = 'required';

            if ($this->user->service_region_id != 0) {
                $this->rules['userTownships'] = 'required';
            } else {
                unset($this->rules['userTownships']);
            }
        }
    }

    public function preventRoleHack()
    {
        // if someone use dev tool and updated the role value
        if (in_array($this->user->role, ['remwdstate20', 'admin'])) {

            // and it is logged in user and the admin
            if (Auth::check() && Auth::user()->role == 'remwdstate20') {
                //
            } else {
                $this->user->role = null;
                abort(403);
            }
        }
    }

    public function saveUser()
    {
        // checking if the role values are modified
        $this->preventRoleHack();

        // check if the user is saving the own account
        $this->checkOwner($this->user);

        // update validation rules according to user role selection
        $this->updateValidationRules();

        // if user filled the password
        if ($this->password != null) {
            // $this->user->password = bcrypt($this->password);
            $this->user->password = Hash::make($this->password);
        } else {
            // then user didn't wanted to update the password
            unset($this->rules['password']);
        }

        // Only now we can validate the fields
        $this->validate();

        $this->user->service_township_id = serialize($this->userTownships);

        $this->user->save();

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Successfully updated the details.']);

        if (Auth::user()->role === 'remwdstate20') {
            if ($this->user->email === Auth::user()->email) {
                Auth::login($this->user);
            }
            // if admin, redirected to dashboard
            return redirect()->to('/dashboard/users');
        } else {
            Auth::login($this->user);
            // else redirect to their profile page
            return redirect()->to('/user/profile');
        }
    }

    public function createUser()
    {
        // checking if the role values are modified
        $this->preventRoleHack();

        // update validation rules according to user role selection
        $this->updateValidationRules();

        $this->validate();

        $this->user->service_township_id = serialize($this->userTownships);

        $newUser = $this->user->create([
            'name' => $this->user->name,
            'slug' => Str::slug($this->user->name),
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'password' => Hash::make($this->password),
            'role' => $this->user->role,
            'service_region_id' => $this->user->service_region_id,
            'service_township_id' => $this->user->service_township_id,
            'address' => $this->user->address,
            'about' => $this->user->about,
        ]);

        if (!empty($this->user->avatar)) {
            $contents = file_get_contents($this->user->avatar);
            $name = date('mdYHis') . '_' . uniqid() . '_avatar.jpg';
            Storage::disk('public')->put("profile-photos/$name", $contents);

            $newUser->update('profile_photo_path', "profile-photos/$name");
        }

        session()->flash('success', 'Successfully registered!');

        if (!empty(Auth::user()) && Auth::user()->role === 'remwdstate20') {
            return redirect()->to('/dashboard/users');
        } else {
            // if not admin, login the newly created user
            Auth::login($newUser);
            // and redirect to the profile page
            return redirect()->to('/user/profile');
        }
    }

    public function render()
    {
        return view('livewire.register')->layout(
            'layouts.app',
            ['title' => empty($this->user) ? 'Register' :  'Update Account']
        );
    }
}
