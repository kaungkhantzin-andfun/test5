@if (session()->has('success'))
<div x-data="{open: true}" x-show="open" @click="open = false" class="flex justify-between gap-2 px-4 py-2 text-white bg-green-500 rounded h-min">
    {{session('success')}}
    <a href="#" @click="open = false">
        <x-icon.icon path="M6 18L18 6M6 6l12 12" />
    </a>
</div>
@elseif (session()->has('error'))
<div x-data="{open: true}" x-show="open" @click="open = false" class="flex justify-between gap-2 px-4 py-2 text-white bg-red-500 rounded h-min">
    {{session('error')}}
    <a href="#" @click="open = false">
        <x-icon.icon path="M6 18L18 6M6 6l12 12" />
    </a>
</div>
@elseif (session()->has('status'))
<div x-data="{open: true}" x-show="open" @click="open = false" class="flex justify-between gap-2 px-4 py-2 text-white bg-green-500 rounded h-min">
    {{session('status')}}
    <a href="#" @click="open = false">
        <x-icon.icon path="M6 18L18 6M6 6l12 12" />
    </a>
</div>
@endif