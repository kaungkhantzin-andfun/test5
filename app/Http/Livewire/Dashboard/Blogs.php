<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Blog;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Categorizable;
use Illuminate\Support\Facades\Auth;

class Blogs extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $keyword;
    public $sortField = 'created_at';
    public $sortAsc = false;
    public $del_id;

    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortField = true;
        }
        $this->sortField = $field;
    }

    public function delItem()
    {
        Blog::find($this->del_id)->delete();

        // Delete related categorizables rows
        Categorizable::where('categorizable_id', $this->del_id)->where('categorizable_type', 'blog')->delete();
    }

    public function render()
    {
        return view('livewire.dashboard.blogs', [
            'blogs' => Blog::when(Auth::user()->role != 'remwdstate20', function ($q) {
                $q->where('user_id', Auth::user()->id);
            })->where(function ($q) {
                $q->where('title', 'like', '%' . $this->keyword . '%')
                    ->orWhere('body', 'like', '%' . $this->keyword . '%');
            })
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
        ])->layout(Auth::user()->role === 'remwdstate20' ? 'layouts.dashboard.master' : 'layouts.app', ['title' => 'All Blog Posts', 'addNew' => '/dashboard/blog-posts/create']);
    }
}
