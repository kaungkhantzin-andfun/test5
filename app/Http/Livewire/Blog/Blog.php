<?php

namespace App\Http\Livewire\Blog;

use Livewire\Component;
use App\Models\Category;
use App\Helpers\MyHelper;
use Livewire\WithPagination;
use App\Models\Blog as ModelsBlog;

class Blog extends Component
{
    use WithPagination;

    public $categories = [];
    public $keyword;

    public function mount($category = '')
    {
        if (!empty($category)) {
            $this->categories[] = $category;
            $active_cat = Category::where('slug', $category)->where('of', 'blog')->first();

            if ($active_cat?->parent_id == null) { // then the active category is the parent category
                // so we need to find child categories
                $child_cats = Category::where('parent_id', $active_cat?->id)->pluck('slug')->all();

                if (!empty($child_cats)) {
                    foreach ($child_cats as $key => $value) {
                        array_push($this->categories, $value);
                    }
                }
            }
        }

        // SEO Optimizations
        MyHelper::setGlobalSEOData(__('seo.blog.title'), __('seo.blog.description'));
    }

    public function getPosts()
    {
        if (!empty($this->categories)) {
            $blogs = ModelsBlog::whereHas('categories', function ($query) {
                $query->whereIn('categories.slug', $this->categories);
            })
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->keyword . '%')
                        ->orWhere('body', 'like', '%' . $this->keyword . '%');
                })
                ->with('categories', 'image')
                ->latest();
        } else {
            $blogs = ModelsBlog::where(function ($q) {
                $q->whereHas('categories', function ($q) {
                    $q->whereNotIn('categories.slug', ['pages', 'event']);
                })
                    ->orWhereDoesntHave('categories');
            })
                ->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->keyword . '%')
                        ->orWhere('body', 'like', '%' . $this->keyword . '%');
                })
                ->with('categories', 'image')
                ->latest();
        }

        // increase view count for each blog
        // want to know the actual popular posts, so not increasing the count here
        // MyHelper::increaseViewCount($blogs);

        return $blogs;
    }

    public function render()
    {
        return view('livewire.blog.blog', [
            'blogs' => $this->getPosts()->paginate(9),
        ]);
    }
}
