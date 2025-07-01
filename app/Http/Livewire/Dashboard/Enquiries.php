<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Enquiry;
use App\Models\Package;
use Livewire\Component;
use App\Models\Property;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Enquiries extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $keyword;
    public $sortField = 'created_at';
    public $sortAsc = false;
    public $del_id;
    public $property;

    public $modalType = 'property';
    public $modalContent;
    public $msg;

    public function showDetail($id)
    {
        $property = Property::with(['images', 'location', 'type', 'purpose', 'user', 'detail'])->findOrFail($id);
        $this->checkOwner($property);

        $this->modalType = 'property';
        $this->modalContent = $property;
        $this->dispatchBrowserEvent('open-modal');
    }

    public function showPackage($id)
    {
        $package = Package::findOrFail($id);

        $this->checkOwner($package);

        $this->modalType = 'package';
        $this->modalContent = $package;
        $this->dispatchBrowserEvent('open-modal');
    }

    public function done($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $this->checkOwner($enquiry->property);

        $enquiry->update([
            'status' => 'Done',
        ]);
    }

    public function removeDone($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $this->checkOwner($enquiry->property);

        $enquiry->update([
            'status' => null,
        ]);
    }

    public function sortBy($field)
    {
        if ($this->sortField == $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortField = true;
        }
        $this->sortField = $field;
    }

    public function delItem($id)
    {
        $enquiry = Enquiry::findOrFail($id);
        $this->checkOwner($enquiry->property);

        $enquiry->delete();
    }

    public function checkOwner($collection)
    {
        // Check if user is admin or the owner of the property
        if (Auth::user()->role === 'remwdstate20' || Auth::user()->id === $collection->user_id) {
            return true;
        }
        abort(403);
    }

    public function getEnquiries()
    {
        if (Auth::user()->role === 'remwdstate20') {
            $enquiries = Enquiry::where(function ($query) {
                $query->where('name', 'like', '%' . $this->keyword . '%')
                    ->orWhere('phone', 'like', '%' . $this->keyword . '%')
                    ->orWhere('email', 'like', '%' . $this->keyword . '%')
                    ->orWhere('status', 'like', '%' . $this->keyword . '%')
                    ->orDoesntHave('property')
                    ->orWhereHas('property', function ($query) {
                        $query->whereHas('detail', function ($query) {
                            $query->where('title', 'like', "%$this->keyword%");
                        });
                    });
            })
                ->with(['property', 'package', 'agent'])
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);

            return $enquiries;
        } else {
            $enquiries = Enquiry::whereHas('property', function ($query) {
                $query->where('user_id', Auth::user()->id)
                    ->whereHas('detail', function ($query) {
                        $query->where('title', 'like', "%$this->keyword%");
                    });
            })
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->keyword . '%')
                        ->orWhere('phone', 'like', '%' . $this->keyword . '%')
                        ->orWhere('email', 'like', '%' . $this->keyword . '%')
                        ->orWhere('status', 'like', '%' . $this->keyword . '%');
                })
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);

            return $enquiries;
        }
    }

    public function render()
    {
        return view('livewire.dashboard.enquiries', ['enquiries' => $this->getEnquiries()])->layout(
            Auth::user()->role === 'remwdstate20' ? 'layouts.dashboard.master' : 'layouts.app',
            ['title' => __('Enquiries')]
        );
    }
}
