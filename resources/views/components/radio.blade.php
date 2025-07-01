@props(['selected' => 'false', 'label' => '', 'model' => '', 'class' => ''])
<label class="
    {{$class}}
    p-4 py-3 transition-all rounded shadow-md cursor-pointer hover:shadow-none max-w-max
    {{$selected == 'true' ? 'border-2 border-yellow-400 btn bg-gradient-to-b text-gray-600' : 'bg-gray-600 text-white'}}
">
    <input
        {{$attributes}}
        wire:model="{{$model}}"
        type="radio"
        class="hidden"
    >
    <span class="text-sm font-bold align-middle">{{$label}}</span>
</label>