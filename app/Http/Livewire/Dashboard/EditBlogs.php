<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Blog;
use App\Models\Image;
use Livewire\Component;
use App\Models\Category;
use App\Helpers\MyHelper;
use App\Jobs\ProcessImage;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditBlogs extends Component
{
    use WithFileUploads;

    public $blog;
    public $image;
    public $oldImage;
    public $categories = [];
    public $selectedCats = [];
    public $createMode;

    public function mount(Blog $blog)
    {
        if ($blog->id) { // if editing the blog
            MyHelper::checkOwner($blog);

            // Otherwise, proceed as usual
            $this->selectedCats = array_map('strval', $blog->categories->pluck('id')->all());
            $this->oldImage = Image::where('imageable_type', 'blog')->where('imageable_id', $blog->id)->first();
        } else {
            $this->createMode = true;
            $this->blog = new Blog();
        }

        // Get all the categories
        $this->categories = Category::where('of', 'blog')->whereNull('parent_id')->get();
    }

    protected $rules = [
        'blog.title' => 'required|string',
        'blog.body' => 'required',
    ];

    protected $messages = [
        'blog.title.required' => 'Post title is required.',
        'blog.body.required' => 'Post body is required.',
    ];

    public function updated()
    {
        $this->validate();
    }

    public function createItem()
    {
        $this->validate();

        $this->blog = Blog::create([
            'user_id' => Auth::user()->id,
            'title' => $this->blog['title'],
            'slug' => Str::slug($this->blog['title']),
            'body' => $this->blog['body'],
            'stat' => 0,
        ]);

        $this->storeImage();

        // Creating category entries
        $this->blog->categories()->sync($this->selectedCats);

        $this->createMode = false;

        session()->flash('success', 'The blog has been created!');

        return redirect()->to('/dashboard/blog-posts');
    }

    public function saveItem()
    {
        $this->validate();
        $this->blog->save();

        $this->storeImage();

        // Creating category entries
        $this->blog->categories()->sync($this->selectedCats);

        session()->flash('success', 'The blog has been updated!');
        return redirect()->to('/dashboard/blog-posts');
    }

    public function storeImage()
    {
        $oldImage = $this->oldImage;
        $image = $this->image;

        // dd($image);
        // dd($oldImage);

        if ($image != null) {
            // thumb_ image is required to show when redirect back to blog list
            // so no queue
            $path = MyHelper::storeImage(
                image: $image,
                options: [
                    ['cropWidth' => 150, 'cropHeight' => 70, 'namePrefix' => 'thumb_'],
                ],
                queue: false
            );

            // the rest two versions can be generated in background
            $realPath = $image->getRealPath();
            ProcessImage::dispatch(
                realPath: $realPath,
                uniqueName: $path,
                options: [
                    // large size image
                    ['watermark' => true],
                    // card_ version
                    ['cropWidth' => 415, 'namePrefix' => 'card_'],
                ]
            );
        }

        // if updating the image
        if ($oldImage != null && $image != null) {
            // Check if user own the image
            MyHelper::checkOwner($this->oldImage);

            // deleting the image files
            Storage::drive('public')->delete([$this->oldImage->path, 'card_' . $this->oldImage->path, 'thumb_' . $this->oldImage->path]);

            // update the new image path
            $oldImage->update(['path' => $path]);
        }

        if ($oldImage == null && $image != null) {
            $this->blog->image()->create([
                'user_id' => Auth::user()->id,
                'path' => $path,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.edit-blogs')->layout(Auth::user()->role === 'remwdstate20' ? 'layouts.dashboard.master' : 'layouts.app', ['title' => $this->createMode ? 'Create Blog Post' : 'Edit Blog Post']);
    }
}
