<?php

namespace App\Http\Livewire\Dashboard;

use App\Helpers\MyHelper;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Image;
use Livewire\Component;
use App\Models\Property;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Support\Facades\Storage;

class Properties extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $keyword;
    public $sortField = 'created_at';
    public $sortAsc = false;
    public $del_id;
    public $selectedProperties = [];
    public $users;
    public $selectedUser;
    public $pageSelected;

    public function mount()
    {
        // This is for updating properties table
        // $ppts = Property::all();
        // foreach ($ppts as $ppt) {
        //     $id = $ppt->categories()->whereNull('parent_id')->first()->id;
        //     $ppt->type_id = $id;
        //     $ppt->save();
        // }

        $this->users = User::all();

        // SEO Optimizations
        SEOTools::setTitle('Property in Myanmar | Find Condo, Apartment, House and many properties');
        SEOTools::setDescription('');
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

    public function delItem()
    {
        $property = Property::findOrFail($this->del_id);

        $this->checkOwner($property);

        $title = $property->translation->title;

        // Deleting entries from categorizables table
        $property->categories()->detach();
        $property->location()->detach();

        // Prepare to delete images
        $images = Image::where('imageable_id', $this->del_id)->where('imageable_type', 'property');

        // Deleting from storage
        $paths = $images->pluck('path')->all();
        foreach ($paths as $path) {
            // Storage::disk('public')->delete($images->pluck('path')->all());
            Storage::disk('public')->delete([$path, 'card_' . $path, 'thumb_' . $path]);
        }

        // Deleting the image records from db
        $images->delete();

        // Delete property
        $property->delete();

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => Str::limit($title, 65) . ' has been deleted!']);
    }

    public function feature($id)
    {
        $property = Property::find($id);
        $this->checkOwner($property);

        // if (Auth::user()->role === 'remwdstate20') {
        //     $property->update([
        //         'featured' => Carbon::now(),
        //         'featured_expiry' => Carbon::now()->addMonth(),
        //     ]);

        //     $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => Str::limit($property->translation->title, 65) . ' has been featured!']);
        // } else {
        //     if ($property->user->credit >= 4) {
        //         $property->update([
        //             'featured' => Carbon::now(),
        //             'featured_expiry' => Carbon::now()->addMonth(),
        //         ]);

        //         $property->user->update(['credit' => $property->user->credit - 4]);

        //         $this->dispatchBrowserEvent('notice', ['type' => 'info', 'text' => 'The property has been featured. If it was a mistake, revert it within 5 mins to get your credit back.']);
        //     } else {
        //         session()->flash('error', "You must top up points to feature your property.");
        //         return redirect()->route('dashboard.top-up');
        //     }
        // }

        // for now we will let people feature as will
        $property->update([
            'featured' => Carbon::now(),
            'featured_expiry' => Carbon::now()->addMonth(),
        ]);
        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Property has been featuerd for 1 month.']);
    }

    public function removeFeatured($id)
    {
        $property = Property::find($id);
        $this->checkOwner($property);

        // if (Auth::user()->role === 'remwdstate20') {
        //     $property->update([
        //         'featured' => null,
        //         'featured_expiry' => null,
        //     ]);

        //     $msg = 'The property has been unfeatured!';
        // } else {
        //     $featured = Carbon::parse($property->featured);
        //     $diff = $featured->diffInMinutes(Carbon::now());

        //     // unfeatured the property
        //     $property->update([
        //         'featured' => null,
        //         'featured_expiry' => null,
        //     ]);

        //     // give back the credit if the diff is within 5 mins
        //     if ($diff <= 5) {
        //         $property->user->update(['credit' => $property->user->credit + 4]);
        //         $msg = 'The property has been unfeatured and your credit has been refunded.';
        //     } else {
        //         $msg = 'The property has been unfeatured!';
        //     }
        // }

        $property->update([
            'featured' => null,
            'featured_expiry' => null,
        ]);

        // $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => $msg]);
        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'The property has been unfeatured.']);
    }

    public function renewProperty($id)
    {
        $property = Property::findOrFail($id);
        $this->checkOwner($property);

        $property->update(['created_at' => Carbon::now()]);

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Property renewed successfully!']);
    }

    public function duplicateProperty($id)
    {
        $property = Property::findOrFail($id);
        $this->checkOwner($property);

        // replicate and set created date
        $newProperty = $property->replicate();
        $newProperty->stat = 0;
        $newProperty->created_at = Carbon::now();

        // push the new property so that it has an id
        $newProperty->push();

        // load relations to sync
        $property->load('categories', 'location');

        // Syncing relations ids
        // ref: https://stackoverflow.com/a/34032304/2218290
        foreach ($property->getRelations() as $relation => $items) {
            foreach ($items as $item) {
                $newProperty->{$relation}()->syncWithoutDetaching($item->id);
            }
        }

        // Duplicating property's title & description entries
        // ref: https://stackoverflow.com/a/34032304/2218290
        foreach ($property->detail as $item) {
            unset($item->id);
            $newProperty->detail()->create($item->toArray());
        }

        return redirect("/dashboard/properties/$newProperty->id/edit?slug=draft");
    }

    public function soldOut($id)
    {
        $property = Property::findOrFail($id);
        $this->checkOwner($property);

        $property->update([
            'soldout' => now(),
        ]);

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => Str::limit($property->translation->title, 65) . ' has been marked as sold out!']);
    }

    public function removeSoldOut($id)
    {
        $property = Property::findOrFail($id);
        $this->checkOwner($property);

        $property->update([
            'soldout' => null,
        ]);

        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => Str::limit($property->translation->title, 65) . ' has been unmarked as sold out!']);
    }

    public function checkOwner($collection)
    {
        // Check if user is admin or the owner of the property
        if (Auth::user()->role === 'remwdstate20' || Auth::user()->id === $collection->user_id) {
            return true;
        }
        abort(403);
    }

    public function changeOwner()
    {
        Property::whereIn('id', $this->selectedProperties)->update(['user_id' => $this->selectedUser]);
        $this->dispatchBrowserEvent('notice', ['type' => 'success', 'text' => 'Properties transferred successfully!']);
    }

    public function selectPage($currentPage)
    {
        // get properties of the current page
        $properties = $this->getProperties();
        $ids = array_map('strval', $properties->pluck('id')->all());

        // if (in_array($ids, $this->selectedProperties)) {
        //     $this->selectedProperties = array_diff($this->selectedProperties, $ids);
        //     dd($this->selectedProperties);
        // } else {
        //     $this->selectedProperties = $ids;
        // }

        if ($this->pageSelected[$currentPage]) {
            foreach ($ids as $id) {
                array_push($this->selectedProperties, $id);
            }
        } else {
            $this->selectedProperties = array_diff($this->selectedProperties, $ids);
            // dd($this->selectedProperties);
            // if (!empty($diffIds)) {
            //     foreach ($diffIds as $id) {
            //         array_push($this->selectedProperties, $id);
            //     }
            // }
        }

        // to get $users
        // $this->updated();
    }

    public function getProperties()
    {
        // for searching with ID
        $keyword = null;
        if (Str::contains(Str::lower($this->keyword), ['mhs-', 'mhr-', 'mh-'])) {
            $propertyID = (int) filter_var($this->keyword, FILTER_SANITIZE_NUMBER_INT);
            $keyword = str_replace('-', '', $propertyID);
        }

        if (Auth::user()->role === 'remwdstate20') {
            $properties = Property::where('price', 'like', "%$this->keyword%")
                ->orWhere('id', $keyword)
                ->orWhereHas('purpose', function ($query) {
                    $query->where('name', 'like', "%$this->keyword%");
                })
                ->orWhereHas('detail', function ($query) {
                    $query->where('title', 'like', "%$this->keyword%");
                })
                ->orWhereHas('categories', function ($query) {
                    $query->where('name', 'like', "%$this->keyword%");
                })
                ->orWhereHas('location', function ($query) {
                    $query->where('name', 'like', "%$this->keyword%");
                })
                ->orWhereHas('user', function ($query) {
                    $query->where('name', 'like', "%$this->keyword%");
                })
                ->with(['images', 'location', 'type', 'purpose', 'user', 'detail'])
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);
        } else {
            $properties = Property::where('user_id', Auth::user()->id)->where(function ($query) use ($keyword) {
                $query->where('price', 'like', "%$this->keyword%")
                    ->orWhere('id', $keyword)
                    ->orWhereHas('purpose', function ($query) {
                        $query->where('name', 'like', "%$this->keyword%");
                    })
                    ->orWhereHas('detail', function ($query) {
                        $query->where('title', 'like', "%$this->keyword%");
                    })
                    ->orWhereHas('categories', function ($query) {
                        $query->where('name', 'like', "%$this->keyword%");
                    })
                    ->orWhereHas('location', function ($query) {
                        $query->where('name', 'like', "%$this->keyword%");
                    });
            })
                ->with(['images', 'location', 'type', 'purpose', 'user', 'detail'])
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);
        }

        return $properties;
    }

    public function render()
    {
        return view('livewire.dashboard.properties', ['properties' => $this->getProperties()])->layout(
            Auth::user()->role === 'remwdstate20' ? 'layouts.dashboard.master' : 'layouts.app',
            ['title' => 'All Properties', 'addNew' => '/dashboard/properties/create']
        );
    }
}
