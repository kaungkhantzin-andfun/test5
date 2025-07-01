@props(['value' => '', 'model', 'label', 'class' => ''])
<label class="flex items-center gap-1 cursor-pointer">
    <input {{$attributes }} wire:model="{{$model}}" value="{{$value}}" type="radio">
    <span class="text-sm font-bold align-middle">{{$label}}</span>
</label>