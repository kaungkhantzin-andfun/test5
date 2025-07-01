<span x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-in-out duration-300" x-transition:enter-start="opacity-0 -translate-x-full"
	x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in-out duration-300"
	x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-full" {{$attributes}}>
	{{$slot}}
</span>