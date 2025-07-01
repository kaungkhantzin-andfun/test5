<form wire:submit.prevent="{{$createMode ? 'createType' : 'saveType'}}" action="#" class="min-h-screen my-6 space-y-6">
    <div class="grid items-center justify-between grid-cols-2 gap-6">
        <x-input.text model="type.name" label="Name" />

        <div>
            <x-input.file model="img" label="Type Image (230 x 600)" />
            @if ($img != null)
            <img class="h-40 mt-4 rounded shadow-md" src="{{$img->temporaryUrl()}}" />
            @elseif ($oldImg != null)
            <img class="h-40 mt-4 rounded shadow-md" src="{{Storage::url($oldImg)}}" />
            @endif
        </div>
    </div>

    <div class="grid items-center grid-cols-8">
        <div class="col-span-8 mb-4 space-y-2">
            <label>{{$createMode ? __('Create') : __('Edit ')}}{{ $of == 'property' ? __('facilities') : __('sub categories')}}:</label>

            <div class="grid grid-cols-4 gap-4">
                @forelse($sub_types as $key => $item)

                <div class="flex items-center gap-4">
                    <x-input.text no-label="true" model="sub_types.{{$key}}.name"
                        label="{{$of == 'property' ? __('Facility') : __('Sub category')}} name" />

                    @if ($del_id === $item->id)
                    <a wire:click="delType({{$key}}, {{$item->id}})" href="#" class="text-red-600">Sure?</a>
                    @else
                    <a wire:click="confirmDel({{$item->id}})" href="#" class="text-red-600">
                        <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                    </a>
                    @endif
                </div>

                @empty
                {{-- no action required if empty --}}
                @endforelse

                {{-- for newly added items --}}
                @foreach ($new_types as $key => $item)
                <div>
                    <div class="flex items-center gap-4">
                        <x-input.text no-label="true" model="new_types.{{$key}}.name"
                            label="{{ $of == 'property' ? __('Facility') : __('Sub category')}} name" />

                        @if ($del_id === $key)
                        <a wire:click="delNewType({{$key}})" href="#" class="text-red-600">Sure?</a>
                        @else
                        <a wire:click="confirmDel({{$key}})" href="#" class="text-red-600">
                            <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                        </a>
                        @endif
                    </div>
                    @error('new_types.' . $key . '.name') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
                @endforeach

                <a wire:click.prevent="addType" href="#" class="flex items-center gap-2 bg-green-600 w-max slider-btn">
                    <x-icon.icon path="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    {{ $of == 'property' ? __('Facility') : __('Sub Category')}}
                </a>
            </div>
        </div>
    </div>

    <input class="btn bg-gradient-to-r blue-gradient" type="submit" value="{{$createMode ? 'Create' : 'Update'}}">

</form>