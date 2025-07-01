<?php

namespace App\Http\Livewire\Dashboard\Properties;

use Livewire\Component;
use App\Models\Category;
use App\Helpers\MyHelper;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as InterventionImage;

class EditTypes extends Component
{
    use WithFileUploads;

    public $type;
    public $of;
    public $sub_types;
    public $new_types = [];
    public $del_id;
    public $createMode;
    public $img;
    public $oldImg;

    public function mount(Category $type)
    {
        if (Request::is('*dashboard/types/blog*')) {
            $this->of = 'blog';
        } elseif (Request::is('*dashboard/types/property*')) {
            $this->of = 'property';
        }

        if ($type->id) {
            // since we use route model binding, edit page get a category instance
            $this->sub_types = Category::where('parent_id', $type->id)->orderBy('name')->get();

            $this->oldImg = $this->type->image?->path;
        } else {
            // else just set it to null
            $this->sub_types = [];

            // and set the mode to create mode
            $this->createMode = true;
        }
    }

    protected $rules = [
        'type.name' => 'required|string',
        'sub_types.*.id' => 'required',
        'sub_types.*.name' => 'required',
    ];

    protected $messages = [
        'type.name.required' => 'Name is required.',
        'sub_types.*.id.required' => 'Something went wrong.',
        'sub_types.*.name.required' => 'Name is required.',
    ];

    public function updated()
    {
        $this->validate();
    }

    public function confirmDel($index)
    {
        $this->del_id = $index;
    }

    public function delType($index, $id)
    {
        $this->sub_types->forget($index);
        Category::find($id)->delete();
        $this->del_id = null;
    }

    public function delNewType($index)
    {
        array_splice($this->new_types, $index, 1);
        $this->del_id = null;
    }

    public function addType()
    {
        $this->new_types[] = [
            'parent_id' => $this->createMode ? '' : $this->type->id,
            'name' => '',
        ];
    }

    public function createType()
    {
        $this->validate();

        // deciding the slug
        //  to avoid duplicate slug, checking existing slug and adding id at the end if it does
        if (Category::where('slug',  Str::slug($this->type['name']))->doesntExist()) {
            $slug = Str::slug($this->type['name']);
        } else {
            $slug = Str::slug($this->type['name']) . '-' . uniqid();
        }

        // Create the main type
        $this->type = Category::create([
            'name' => $this->type['name'],
            'slug' => $slug,
            'of' => $this->of,
        ]);

        if (!empty($this->img)) {
            // Creating image entry
            $this->type->image()->create([
                'user_id' => Auth::user()->id,
                'path' => $this->storeImage(),
            ]);
        }

        // In create mode, there will be only new_types
        $this->createSubTypes($this->new_types, $this->type->id);

        // Resetting variables since we have persisted to database
        $this->new_types = [];
        $this->sub_types = Category::where('parent_id', $this->type->id)->orderBy('name')->get();

        // // Instead of redirecting back we are just changing the mode to edit mode
        // $this->createMode = false;

        // session()->flash('success', 'The type has been created! You are now in edit mode of this type.');

        session()->flash('success', 'The type has been created!');
        return redirect()->to("/dashboard/types/$this->of");
    }

    public function saveType()
    {
        $this->validate();

        // In edit mode $this->type is just an instance of Category, so we just need to save it
        $this->type->save();

        // Same logic applies for sub types
        foreach ($this->sub_types as $type) {
            $type->save();
        }

        // But we need to save the newly created types
        $this->createSubTypes($this->new_types, $this->type->id);

        $this->new_types = [];
        $this->sub_types = Category::where('parent_id', $this->type->id)->orderBy('name')->get();


        if (!empty($this->img)) {

            if ($this->oldImg != null) {
                // Delete old image
                Storage::disk('public')->delete($this->oldImg);

                $this->type->image()->update([
                    'path' => $this->storeImage(),
                ]);
            } else {
                // Creating image entry
                $this->type->image()->create([
                    'user_id' => Auth::user()->id,
                    'path' => $this->storeImage(),
                ]);
            }
        }

        session()->flash('success', 'The type has been updated!');
        return redirect()->to("/dashboard/types/$this->of");
    }

    public function storeImage()
    {
        $path = MyHelper::storeImage(
            image: $this->img,
            options: [
                ['cropWidth' => 400, 'cropHeight' => 267],
            ],
        );

        return $path;
    }

    public function createSubTypes($types, $parent_id)
    {
        foreach ($types as $type) {
            if (Category::where('slug',  Str::slug($type['name']))->doesntExist()) {
                $slug = Str::slug($type['name']);
            } else {
                $slug = Str::slug($type['name']) . '-' . uniqid();
            }

            // Create the sub type
            $type = Category::create([
                'parent_id' => $parent_id,
                'name' => $type['name'],
                'slug' => $slug,
                'of' => $this->of,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.properties.edit-types')->layout('layouts.dashboard.master', ['title' => $this->createMode ? 'Create Type' : 'Edit Type']);
    }
}
