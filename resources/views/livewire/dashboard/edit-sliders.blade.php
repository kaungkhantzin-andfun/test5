<form wire:submit.prevent="{{$createMode ? 'createItem' : 'saveItem'}}" class="space-y-6 xl:w-2/3">
    <div class="mt-4">
        <div class="flex flex-col gap-4 md:flex-row">
            <label class="inline-flex items-center w-full mt-1 text-sm font-medium">
                <input type="radio" class="radio @error('type') border border-red-600 @enderror" wire:model="type"
                    value="slider" />
                <span class="ml-2">{{ __('Main Slider') }} <br /> (1500 x 700)</span>
            </label>
            <label class="inline-flex items-center w-full mt-1 text-sm font-medium">
                <input type="radio" class="radio @error('type') border border-red-600 @enderror" wire:model="type"
                    value="testimonial" />
                <span class="ml-2">{{ __('Testimonial Slider') }} <br /> (450 x 260)</span>
            </label>
            <label class="inline-flex items-center w-full mt-1 text-sm font-medium">
                <input type="radio" class="radio @error('type') border border-red-600 @enderror" wire:model="type"
                    value="youtube" />
                <span class="ml-2">{{ __('YouTube Video Slider') }}</span>
            </label>
        </div>
        @error('type') <span class="text-sm font-medium text-red-600">{{ $message }}</span> @enderror
    </div>

    <x-input.text model="name" label="Title" />

    @if ($type == 'youtube')
    <x-input.text model="youtubeLink" label="YouTube Video Link" />
    @if ($linkError)
    <span class="text-sm font-medium text-red-600">{{ __('YouTube link must contains youtube.com') }}</span>
    @endif

    @if (!empty($oldImg) && filter_var($oldImg, FILTER_VALIDATE_URL))
    <x-youtube-video :path="$oldImg" />
    @endif
    @else
    <div>
        <x-input.file type="file" model="img" label="Image" />

        @if ($img != null)
        <img class="h-40 mt-4 rounded shadow-md" src="{{$img->temporaryUrl()}}" />
        @elseif ($oldImg != null)
        <img class="h-40 mt-4 rounded shadow-md" src="{{Storage::url($oldImg)}}" />
        @endif
    </div>
    @endif

    <x-input.ckeditor model="caption" label="Caption or testimonial content with text formatting.">
        {!!$caption!!}
    </x-input.ckeditor>

    <input type="submit" value="{{ __('Save') }}" class="text-white bg-gradient-to-r btn blue-gradient">

</form>