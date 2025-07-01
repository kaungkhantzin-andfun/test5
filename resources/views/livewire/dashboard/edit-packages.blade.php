<div>
    <form wire:submit.prevent="{{$createMode ? 'createItem' : 'saveItem'}}">
        @csrf
        <div class="max-w-lg mt-4 space-y-4">
            <x-input.text label="Name" model="package.name" />
            <x-input.text type="number" label="Credit" model="package.credit" />
            <x-input.text type="number" label="Price" model="package.price" />
            <x-input.text type="number" label="Discount in %" model="package.discount" />

            <input type="submit" value="{{ __('Save') }}"
                class="float-right py-2 text-white cursor-pointer bg-gradient-to-r blue-gradient btn">
        </div>

    </form>
</div>