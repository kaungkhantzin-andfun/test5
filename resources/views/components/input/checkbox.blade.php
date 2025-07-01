@props(['value', 'model', 'label', 'class' => null])
<label class="flex items-center gap-2 cursor-pointer">
    {{-- without defer, add ppt » quick select facility checkboxes » laggy and error --}}
    <input {{$attributes}} wire:model.defer="{{$model}}" value="{{$value}}" class="checkbox {{$class}}" type="checkbox">
    <span>{{__($label)}}</span>
</label>