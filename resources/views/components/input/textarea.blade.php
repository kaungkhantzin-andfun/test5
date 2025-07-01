@props(['label' => false, 'model' => false, 'class' => '', 'type' => 'text'])
{{-- <div {{ $attributes }}> --}}
<div class="w-full">
    <label class="label">
        {{__($label)}}

        <textarea wire:model.lazy="{{__($model)}}" class="input {{$class}} @error($model) border border-red-600 @enderror" type="{{$type}}"
            placeholder="{{ $label ? 'Enter ' . trans((string) Str::lower($label)) . ' ..' : ''}}" {{$attributes}}></textarea>

    </label>
    @error($model) <span class="error">{{ $message }}</span> @enderror
</div>