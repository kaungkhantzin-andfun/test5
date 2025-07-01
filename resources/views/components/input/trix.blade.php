@props(['label' => false, 'model' => false])

<div wire:ignore x-data @trix-change="$dispatch('change', $event.target.value)">

    <label class="label">{{$label}}</label>

    <input id="{{Str::slug($label)}}" type="hidden" name="content">

    <trix-editor wire:model.debounce.500ms="{{$model}}" {{-- wire:model.lazy="{{$model}}" --}}
        class="p-4 bg-white shadow-sm trix-content input" input="{{Str::slug($label)}}"
        placeholder="{{Str::ucfirst($label)}} ..">
    </trix-editor>

</div>

@error($model) <span class="error">{{ $message }}</span> @enderror