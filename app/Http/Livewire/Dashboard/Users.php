<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedImport;

class Users extends Component
{
    use WithPagination, WithFileUploads;

    public $perPage = 5;
    public $keyword;
    public $sortField = 'created_at';
    public $sortAsc = false;
    public $del_id;
    public $showImportForm = false;
    public $file;

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
        User::find($this->del_id)->delete();

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'User has been deleted!']);
    }

    public function disableTwoFactor($id)
    {
        $user = User::find($id);
        $user->two_factor_secret = null;
        $user->two_factor_recovery_codes = null;
        $user->save();

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Two Factor Authentication has been disabled!']);
    }


    public function exportUsers()
    {
        return (new UsersExport)->download('users.csv');
    }

    public function importUsers()
    {
        (new UsersImport(Auth::user()))->queue($this->file)->chain([
            new NotifyUserOfCompletedImport(request()->user()),
        ]);

        // if (count($import->failures()) > 0) {
        //     $this->dispatchBrowserEvent('notice', ['type' => 'error', 'text' => 'Finished with error: Check the log file for more details.']);

        //     foreach ($import->failures() as $err) {
        //         Log::error('Error on row ' . $err->row() . ': ' . $err->errors()[0]);
        //         // this doesn't work 😠
        //         // $this->dispatchBrowserEvent('notice', ['type' => 'error', 'text' => 'Error on row ' . $err->row() . ': ' . $err->errors()[0]]);
        //     }
        // } else {
        //     $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Users imported successfully!']);
        // }

        $this->dispatchBrowserEvent('notice', ['type' => 'info', 'text' => 'The import is processing in the background. We will send you email when it is done.']);
    }

    public function render()
    {
        return view('livewire.dashboard.users', [
            'users' => User::where(function ($query) {
                $query->where('name', 'like', '%' . $this->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $this->keyword . '%')
                    ->orWhere('role', 'like', '%' . $this->keyword . '%')
                    ->orWhere('email', 'like', '%' . $this->keyword . '%')
                    ->orWhereHas('location', function ($query) {
                        $query->where('name', 'like', '%' . $this->keyword . '%');
                    });
            })
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage)
        ])->layout('layouts.dashboard.master', ['title' => 'All Users', 'addNew' => '/dashboard/users/create']);
    }
}
