@props(['label' => false, 'model' => false])
<div>
    <label class="label">
        {{$label}}
        <input {{$attributes}} wire:model="{{$model}}" class="w-full" type="file">
    </label>
    @error($model) <span class="error">{{ $message }}</span> @enderror
</div>