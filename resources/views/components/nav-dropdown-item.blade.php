@props(['current' => '', 'parent' => '', 'parentIcon' => null, 'parentLink' => null, 'ulClass' => 'p-4'])
<li x-data="{open: true}" x-init="open = window.innerWidth >= 1024 ? true : false"
	class="relative flex flex-col-reverse lg:flex-col group hover:text-logo-blue hover:font-bold {{$current ? 'current_nav' : ''}}">
	<a @click="window.innerWidth >= 1024 ? true : $event.preventDefault(); open = !open" class="flex items-center py-3" href="{{$parentLink ?: '#'}}">
		@if ($parentIcon)
		<x-icon.icon class="mr-1" :add-class="true" path="{{$parentIcon}}" />
		@endif

		{{__($parent)}}
		<x-icon.solid-icon
			path="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
	</a>

	{{-- nav-dropdown class is used for dashboard menu which appear after logged in --}}
	<ul x-show="open" x-transition
		class="relative z-10 min-w-[200px] mt-4 p-4 bg-white border rounded-lg nav-dropdown lg:hidden lg:mt-0 lg:group-hover:block lg:absolute shadow-raised lg:top-full {{$ulClass}}">

		{{-- bottom pointing arrow --}}
		<span
			class="absolute w-4 h-4 {{$ulClass != '' ? '' : 'ml-4'}} rotate-45 bg-white border-b border-r -bottom-2 lg:border-t lg:border-l lg:border-r-0 lg:border-b-0 lg:-top-2"></span>

		{{$slot}}

	</ul>

</li>