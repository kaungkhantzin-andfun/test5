@props(['label' => false, 'model' => false, 'class' => '', 'type' => 'text', 'noLabel' => false])
<div class="w-full">
    <label class="label">
        @if (!$noLabel)
        {{-- {{ trans((string) $label)}} --}}
        {{trans((string) Str::of($label)->lower()->title())}}
        @endif

        <input wire:model.lazy="{{$model}}" class="{{$class}} @error($model) border border-red-600 @enderror" type="{{$type}}"
            placeholder="{{$label ? trans((string) Str::of($label)->lower()->title()) . ' ..' : ''}}" {{$attributes}}>

    </label>
    @error($model) <span class="error">{{__($message)}}</span> @enderror
</div>