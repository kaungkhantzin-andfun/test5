<form class="grid grid-cols-5 gap-6 my-4" wire:submit.prevent="{{$createMode ? 'createLocation' : 'saveLocation'}}" action="post">

    <div class="col-span-2 space-y-4">
        <x-input.text model="location.name" label="City Name" />
        <x-input.text type="number" model="location.postal_code" label="Postal Code" />
        <div class="space-y-3">
            <x-input.file model="img" label="Location Image (230 x 600)" />
            @if ($img != null)
            <img class="h-40 rounded shadow-md" src="{{$img->temporaryUrl()}}" />
            @elseif ($oldImg != null)
            <img class="h-40 rounded shadow-md" src="{{Storage::url($oldImg)}}" />
            @endif
        </div>
    </div>

    <div class="col-span-3">
        <x-input.ckeditor model="location.description" label="{{__('Description')}}">
            @if (is_array($location))
            @if (array_key_exists('description', $location))
            {!! $location['description'] !!}
            @else
            {{''}}
            @endif
            @else
            {!! $location?->description !!}
            @endif
        </x-input.ckeditor>

        <span class="label">Townships in this region</span>
        <div class="grid grid-cols-2 gap-4 mt-1">
            @forelse($townships as $key => $tsp)
            <div class="flex items-center justify-between gap-4">
                <x-input.text no-label="true" model="townships.{{$key}}.name" label="Township" />

                @if ($del_id === $tsp->id)
                <a wire:click="deleteTownship({{$key}}, {{$tsp->id}})" href="#" class="text-red-600">Sure?</a>
                @else
                <a wire:click="confirmDel({{$tsp->id}})" class="text-red-600" href="#">
                    <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                </a>
                @endif
            </div>
            @empty
            {{-- no action required if empty --}}
            @endforelse

            {{-- for newly added items --}}
            @foreach ($new_townships as $key => $tsp)
            <div class="flex items-center justify-between gap-4">
                <x-input.text no-label="true" model="new_townships.{{$key}}.name" label="Township" />

                @if ($del_id === $key)
                <a wire:click="deleteNewTownship({{$key}})" href="#" class="text-red-600">Sure?</a>
                @else
                <a wire:click="confirmDel({{$key}})" class="text-red-600" href="#">
                    <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                </a>
                @endif
            </div>
            @endforeach
        </div>

        <a wire:click.prevent="addTownship" href="#" class="flex justify-between float-left mt-4 btn btn-success">
            <x-icon.icon class="w-6 h-6 mr-2 text-gray-100" :path="'M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z'" /> Township
        </a>
    </div>

    <div class="w-full col-span-5 mt-4">
        @error('*')
        <span class="flex error">There were some errors in the form. Please fix it and submit again.</span>
        @enderror

        <button wire:loading.attr="disabled" wire:target="{{$createMode ? 'createLocation' : 'saveLocation'}}" type="submit"
            class="right-0 float-right mt-2 mb-4 cursor-pointer md:mb-0 btn bg-gradient-to-r blue-gradient disabled:bg-logo-blue-dark md:float-left">
            <span wire:loading.remove wire:target="{{$createMode ? 'createLocation' : 'saveLocation'}}" class="flex items-center justify-center">
                {{ $createMode ? __('Create Location') : __('Update Location') }}
            </span>

            <span wire:loading wire:target="{{$createMode ? 'createLocation' : 'saveLocation'}}" class="flex items-center justify-center gap-2">
                <i class="animate-spin fas fa-spinner"></i>
                {{__("Saving ..")}}
            </span>
        </button>
    </div>
</form>