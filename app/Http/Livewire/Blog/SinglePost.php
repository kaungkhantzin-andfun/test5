<?php

namespace App\Http\Livewire\Blog;

use App\Models\Blog;
use Livewire\Component;
use App\Helpers\MyHelper;

class SinglePost extends Component
{
    public $post;
    public $related;
    public $isPagesCat = false;

    public function mount($id)
    {
        $postBuiler = Blog::with('categories', 'image')->where('id', $id);
        MyHelper::increaseViewCount($postBuiler);
        $this->post = $postBuiler->firstOrFail();

        if (in_array('pages', $this->post->categories->pluck('slug')->toArray())) {
            $this->isPagesCat = true;
        } else {
            // we only need related post when it's not in pages category
            $relatedBuilder = Blog::whereHas('categories', function ($q) {
                $q->where('of', 'blog')->whereIn('slug', $this->post->categories->pluck('slug')->all());
            })
                ->where('id', '<>', $this->post->id)
                ->with('categories')
                ->latest()
                ->take(10);


            // want to know the actual popular posts, so not increasing the count here
            // MyHelper::increaseViewCount($relatedBuilder);
            $this->related = $relatedBuilder->get();
        }

        // SEO Optimizations
        MyHelper::setGlobalSEOData($this->post->title, $this->post->seoDescription);
    }
    public function render()
    {
        return view('livewire.blog.single-post');
    }
}
