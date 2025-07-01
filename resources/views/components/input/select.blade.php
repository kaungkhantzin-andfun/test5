@props(['label' => false, 'model' => false, 'items' => false, 'noLabel' => false])

<div class="flex flex-col w-full">

    @if (!$noLabel)
    <label class="label" for="{{Str::slug($label)}}">{{__($label)}}</label>
    @endif

    <select {{ $attributes }} wire:model="{{$model}}" id="{{Str::slug($label)}}" class="w-full @error($model) border border-red-600 @enderror">
        {{-- <option value="">{{__('Select ' . Str::lower("__($label"))}}</option> --}}
        <option value="">{{__($label)}}</option>
        {{$slot}}
    </select>

    @error($model) <span class="error">{{ __($message) }}</span> @enderror
</div>