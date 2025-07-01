@props(['size' => 'w-8 h-8', 'mobile' => false])
<div x-data="{ dropdownOpen: false }" class="relative">
	<button @click.prevent="dropdownOpen = ! dropdownOpen" @click.away="dropdownOpen = false"
		class="relative block overflow-hidden rounded-full shadow focus:outline-none {{$size}} {{$mobile ? 'border border-white' : ''}}">
		<img class="object-cover rounded-full {{$size}}" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
	</button>


	<nav x-show="dropdownOpen" x-cloak x-transition.duration.300ms aria-labelledby="profile-dropdown-navigation"
		class="absolute z-40 w-60 overflow-hidden bg-white border rounded-md shadow-xl {{$mobile ? '-mt-60 -ml-20 ' : 'mt-2 right-0'}}">

		<x-dropdown-link class="flex items-center gap-2" href="{{LaravelLocalization::localizeUrl(route('profile.show'))}}"
			:active="request()->routeIs('profile.show')">
			<x-icon.icon
				:path="'M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z'" />
			{{ __('Profile') }}
		</x-dropdown-link>

		<x-dropdown-link class="flex items-center gap-2" href="{{LaravelLocalization::localizeUrl(route('user.edit', Auth::user()->id))}}"
			:active="request()->routeIs('user.edit')">
			<x-icon.icon
				:path="'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
			{{ __('Edit Full Profile') }}
		</x-dropdown-link>

		<x-dropdown-link class="flex items-center gap-2" href="{{LaravelLocalization::localizeUrl(route('saved'))}}"
			:active="request()->routeIs('saved')">
			<x-icon.icon
				:path="'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z'" />
			{{ __('Saved Properties') }}
		</x-dropdown-link>

		<hr class="my-2 border-gray-300">

		<x-dropdown-link class="flex items-center gap-2" href="{{LaravelLocalization::localizeUrl(route('dashboard.index'))}}"
			:active="request()->routeIs('dashboard.index')">
			<x-icon.icon
				path="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
			{{ __('Dashboard') }}
		</x-dropdown-link>

		<!-- Authentication -->
		<form method="POST" action="{{ route('logout') }}">
			@csrf
			<x-dropdown-link class="flex items-center gap-2" href="{{LaravelLocalization::localizeUrl(route('logout'))}}"
				onclick="event.preventDefault(); this.closest('form').submit();">
				<x-icon.icon path="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
				{{ __('Logout') }}
			</x-dropdown-link>
		</form>
	</nav>
</div>