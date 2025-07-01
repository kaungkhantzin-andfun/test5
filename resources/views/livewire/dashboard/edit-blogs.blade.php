<div>
    <form wire:submit.prevent="{{$createMode ? 'createItem' : 'saveItem'}}" enctype="multipart/form-data" action="post"
        class="max-w-4xl px-8 py-4 mx-auto my-8 space-y-4 border rounded shadow-md">
        @csrf

        <x-input.text model="blog.title" label="{{__('Post Title')}}" />

        <div class="">
            <label for="image" class="flex items-center gap-4 cursor-pointer w-max">
                <div>
                    @if (empty($image) && empty($oldImage))
                    <x-icon.icon class="w-24" stroke-width="0.8"
                        path="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    @endif
                    <input wire:model="image" class="hidden" type="file" name="image" id="image">
                    @if (!empty($image))
                    <img class="max-w-md rounded shadow-md max-h-36" src="{{$image->temporaryUrl()}}" />
                    @elseif ($createMode != true && !empty($oldImage))
                    <img class="max-w-md rounded shadow-md max-h-36" src="{{Storage::url('thumb_' . $oldImage->path)}}" />
                    @endif
                    @error('image') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <span class="flex items-center gap-1">
                    @lang('Click to choose image')
                    <x-icon.icon path="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </span>
            </label>
        </div>

        <div wire:ignore>
            <input id="text" value="Content here" type="hidden" name="content">
            <x-input.ckeditor model="blog.body" label="{{__('Post Content')}}">
                {!! $blog?->body !!}
            </x-input.ckeditor>
        </div>

        @if (Auth::user()->role == 'remwdstate20')
        <div>
            <label class="label">@lang('Choose Category'):</label>
            <div class="w-full p-4 overflow-y-auto bg-white border rounded-md h-60">
                @forelse ($categories as $cat)
                <div>
                    <label class="inline-flex items-center w-full">
                        <input type="checkbox" class="checkbox" wire:model="selectedCats" value="{{$cat->id}}" />
                        <span class="ml-2">{{$cat->name}}</span>
                    </label>
                    @foreach (App\Models\Category::where('parent_id', $cat->id)->get() as $sub_cat)
                    <label class="inline-flex items-center w-full ml-6">
                        <input type="checkbox" class="checkbox" wire:model="selectedCats" value="{{$sub_cat->id}}" />
                        <span class="ml-2">{{$sub_cat->name}}</span>
                    </label>
                    @endforeach

                </div>
                @empty
                <p class="mt-8 text-lg text-center">No category found! <br> Please <a class="font-semibold text-blue-600"
                        href="{{LaravelLocalization::localizeUrl('dashboard/types/blog/create')}}">@lang('create one')</a>
                    first.</p>
                @endforelse
            </div>

        </div>
        @endif

        <ul class="add-post-notice">
            <li>
                <x-icon.icon
                    path="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                {{__('If you are not the owner of the content, you must credit to owner.')}}
            </li>
            <li>
                <x-icon.icon
                    path="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                {{__('If you found your content on our website, you can claim or ask us for deletion.')}}
            </li>
            <li>
                <x-icon.icon
                    path="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                {{__('MyanmarHouse.com.mm should not be hold accountable for any user generated content.')}}
            </li>
        </ul>

        <input class="mt-2 bg-gradient-to-r blue-gradient btn" type="submit" value="{{ $createMode ? 'Create' : 'Update' }} Post">

    </form>
</div>