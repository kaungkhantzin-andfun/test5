@props(['route', 'createRoute' => null, 'path', 'path2' => null, 'text', 'textClass' => null])

@if ($createRoute)
<li class="nav_item_wrapper">
	<a class="{{Auth::user()->role == 'remwdstate20' ? 'nav_item' : 'user_nav_item'}} {{Request::is('*' . $route) && !Request::is('*' . $createRoute) ? 'current' : ''}}"
		href="{{LaravelLocalization::localizeUrl($route)}}">
		@if (!empty($path2))
		<x-icon.icon path="{{$path}}" path2="{{$path2}}" />
		@else
		<x-icon.icon path="{{$path}}" />
		@endif
		<x-dashboard.nav-text class="{{$textClass}}">
			{{__($text)}}
			{{$slot}} {{-- Especially for enquiries unread count --}}
		</x-dashboard.nav-text>
	</a>

	<a class="{{Auth::user()->role == 'remwdstate20' ? 'plus_icon' : 'user_plus_icon'}} {{Request::is('*' . $createRoute) ? 'sub_current' : ''}}"
		href="{{LaravelLocalization::localizeUrl($createRoute)}}">
		<x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" />
	</a>
</li>
@else
<a class="{{Auth::user()->role == 'remwdstate20' ? 'nav_item' : 'user_nav_item'}} {{Request::is('*' . $route) ? 'current' : ''}}"
	href="{{LaravelLocalization::localizeUrl($route)}}">
	<span class="flex items-center gap-2">
		@if (!empty($path2))
		<x-icon.icon path="{{$path}}" path2="{{$path2}}" />
		@else
		<x-icon.icon path="{{$path}}" />
		@endif
		<x-dashboard.nav-text class="{{$textClass}}">
			{{__($text)}}
			{{$slot}}
		</x-dashboard.nav-text>
	</span>
</a>
@endif