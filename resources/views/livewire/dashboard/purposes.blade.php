<form wire:submit.prevent="saveItem" action="post" class="my-4 space-y-4">
    <div class="grid gap-4 md:grid-cols-2">
        @foreach($purposes as $key => $psp)
        <div class="flex items-center justify-between gap-4">

            <x-input.text no-label="true" model="purposes.{{$key}}.name" label="Name" />

            <a wire:click.prevent="addItem" class="text-green-600" href="#">
                <x-icon.icon path="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </a>

            @if ($del_id === $psp->id)
            <a wire:click="deleteItem({{$key}}, {{$psp->id}})" href="#" class="text-red-600">Sure?</a>
            @else
            <a wire:click="confirmDel({{$psp->id}})" href="#" class="text-red-600">
                <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
            </a>
            @endif
        </div>
        @endforeach

        {{-- for newly added items --}}
        @foreach ($new_purposes as $key => $psp)
        <div class="flex items-center justify-between gap-4">
            <x-input.text no-label="true" model="new_purposes.{{$key}}.name" label="Name" />

            <a wire:click.prevent="addItem" class="text-green-600" href="#">
                <x-icon.icon :path="'M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z'" />
            </a>

            @if ($del_id === $key)
            <a wire:click="deleteNewItem({{$key}})" href="#" class="text-red-600">Sure?</a>
            @else
            <a wire:click="confirmDel({{$key}})" href="#" class="text-red-600">
                <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
            </a>
            @endif

        </div>
        @endforeach
    </div>

    <x-notices />

    <input class="btn bg-gradient-to-r blue-gradient" type="submit" value="{{ __('Update') }}">

</form>