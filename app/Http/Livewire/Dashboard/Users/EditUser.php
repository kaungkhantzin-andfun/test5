<?php

namespace App\Http\Livewire\Dashboard\Users;

use App\Models\User;
use Livewire\Component;
use App\Models\Location;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image as InterventionImage;

class EditUser extends Component
{
    use WithFileUploads;

    public $user;
    public $photo;
    public $editedPhoto;
    public $credit;
    public $townships = [];
    public $checkAll = false;
    public $userTownships = [];
    public $createMode;
    public $password;
    public $changePassword;
    public $password_confirmation;


    public function mount(User $user)
    {
        if (empty($user->id)) {
            // no user mean accessing this from create route
            $this->user = new User();
            $this->createMode = true;
            $this->changePassword = true;
        } else {
            // check if the user is editing the own account
            $this->checkOwner($user);
            $this->createMode = false;
        }

        if ($this->user->service_region_id != null && strval($this->user->service_region_id) != "0") {
            $this->townships = Location::where('parent_id', $this->user->service_region_id)->get();
        }

        if ($this->user->service_township_id != null) {
            $this->userTownships = unserialize($this->user->service_township_id);
        }
    }

    public function removeEditedPhoto()
    {
        $this->editedPhoto = null;
        // $this->dispatchBrowserEvent('photo-updated');
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
        'user.email' => 'required|email,unique:users,email',
        'user.credit' => 'integer',
        'password' => 'sometimes|min:8|same:password_confirmation',
        'user.role' => 'required',
        'user.service_region_id' => 'required|integer',
        'userTownships' => 'required',
        'user.address' => 'required',
        'user.about' => 'required',
    ];

    protected $messages = [
        'user.name.required' => "Username is required.",
        'user.name.min' => "Username must be minimum of 6 characters.",
        'user.phone.required' => "Phone is required.",
        'user.email.required' => "Email is required.",
        'user.email.email' => "Email format is not correct.",
        'user.email.unique' => "There's already a user with this email.",
        'user.credit.integer' => "Credit must be an integer.",
        'password.min' => "Password must be minimum of 8 characters.",
        'password.same' => "Password & Confirm Password must match.",
        'user.role.required' => "Account type is required.",
        'user.service_region_id.required' => "Service Region is required.",
        'userTownships' => "Service Township is required.",
        'user.address.required' => 'Address is required.',
        'user.about.required' => 'About is required.',
        'userTownships.required' => 'Township is required.',
    ];

    public function updatedCheckAll()
    {
        if ($this->checkAll == true) {
            foreach ($this->townships as $tsp) {
                array_push($this->userTownships, strval($tsp->id));
            }
        } else {
            $this->userTownships = [];
        }
    }

    public function updatedUserTownships()
    {
        count($this->userTownships) != count($this->townships) ? $this->checkAll = false : $this->checkAll = true;
    }

    public function updated()
    {
        $this->updateValidationRules();
        $this->validate();
    }

    public function updateValidationRules()
    {
        // Disabled for admin » edit user » change password (since it is not required)
        if (!$this->changePassword) {
            unset($this->rules['password']);
        }

        if ($this->user->role != 'remwdstate20') {
            unset($this->rules['user.credit']);
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
            $this->rules['user.service_region_id'] = 'integer';
            $this->rules['user.address'] = 'required';
            $this->rules['user.about'] = 'required';
        }

        if ($this->user->service_region_id != 0) {
            $this->rules['userTownships'] = 'required';
        }
    }

    public function preventRoleHack()
    {
        // if someone use dev tool and updated the role value
        if (in_array($this->user->role, ['remwdstate20', 'admin'])) {

            // and it is logged in user and the admin
            if (!empty(Auth::user()) && Auth::user()->role == 'remwdstate20') {
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

        // Only now we can validate the fields
        $this->validate();

        if (!empty($this->password)) {
            $this->user->password = Hash::make($this->password);
        }

        $this->user->service_township_id = serialize($this->userTownships);

        if (empty($this->user->slug)) {
            $this->user->slug = $this->decideSlug();
        }

        if (!empty($this->photo)) {
            $path = $this->storeImage($this->photo);
            $this->user->profile_photo_path = $path;
        } else if (!empty($this->editedPhoto)) {
            $path = $this->storeImage($this->editedPhoto);
            $this->user->profile_photo_path = $path;
        }

        $this->user->save();

        session()->flash('success', 'Successfully updated the details.');

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
            'slug' => $this->decideSlug(),
            'phone' => $this->user->phone,
            'email' => $this->user->email,
            'credit' => $this->user->credit,

            // 'password' => bcrypt($this->password),
            'password' => Hash::make($this->password),
            'role' => $this->user->role,
            'service_region_id' => $this->user->service_region_id,
            'service_township_id' => $this->user->service_township_id,
            'address' => $this->user->address,
            'about' => $this->user->about,
        ]);

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

    public function decideSlug()
    {
        // deciding the slug
        //  to avoid duplicate slug, checking existing slug and adding id at the end if it does
        if (User::where('slug',  Str::slug($this->user->name))->doesntExist()) {
            $slug = Str::slug($this->user->name);
        } else {
            $slug = Str::slug($this->user->name) . '-' . uniqid();
        }

        return $slug;
    }

    public function storeImage($img)
    {
        if (!empty($this->photo)) {
            // prepare unique file name
            $fileName = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
            $fileExt = pathinfo($img->getClientOriginalName(), PATHINFO_EXTENSION);
            $uniqueName = uniqid($fileName . '_') . '.' . $fileExt;
        } else {
            $uniqueName = uniqid() . '.jpg';
        }

        $image = InterventionImage::make(!empty($this->editedPhoto) ? $this->editedPhoto : $img->getRealPath());

        if ($image->width() > 200) {
            $image->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $image->save('storage/profile-photos/' . $uniqueName, 100);

        return "profile-photos/" . $uniqueName;
    }

    public function render()
    {
        return view('livewire.dashboard.users.edit-user')->layout(
            'layouts.dashboard.master',
            ['title' => $this->createMode ? 'Create User' : 'Edit User']
        );
    }
}
