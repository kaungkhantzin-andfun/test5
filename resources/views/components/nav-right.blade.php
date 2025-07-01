@props(['class' => null])
<nav class="items-center justify-between hidden gap-5 min-w-max text-logo-blue-dark lg:text-base {{$class}}"
	aria-labelledby="header-right-navigation">

	{{-- Languages --}}
	@if (LaravelLocalization::getCurrentLocale() == 'my')
	<a class="flex items-center gap-1" rel="alternate" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
		<img class="w-8 border border-white rounded" src="{{asset('assets/images/us.svg')}}" alt="US Flag">
		{{-- {{__('English')}} --}}
	</a>
	@else
	<a class="flex items-center gap-1" rel="alternate" hreflang="my" href="{{ LaravelLocalization::getLocalizedURL('my', null, [], true) }}">
		<img class="w-8 border border-white rounded" src="{{asset('assets/images/myanmar.svg')}}" alt="Myanmar Flag">
		{{-- {{__('Burmese')}} --}}
	</a>
	@endif

	@if (Route::has('login'))
	@auth
	<x-profile-dropdown size="w-10 h-10" />
	@else
	<a href="{{LaravelLocalization::localizeUrl(route('login'))}}" class="flex items-center gap-1 {{ Route::is('login') ? 'underline' : ''}}">
		<x-icon.icon
			:path="'M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z'" />
		<span>{{__('Sign In')}}</span>
	</a>

	@if (Route::has('register'))
	<a href="{{LaravelLocalization::localizeUrl(route('register'))}}" class="flex items-center gap-1 {{ Route::is('register') ? 'underline' : ''}}">
		<x-icon.icon path="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
		<span>{{__('Register')}}</span>
	</a>
	@endif

	@endauth

	@endif

	<!-- <a class="flex items-center gap-2 bg-gradient-to-r blue-gradient btn" href="{{LaravelLocalization::localizeUrl('/dashboard/properties/create')}}">
		<x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" />
		{{__('Add Property')}}
	</a> -->
</nav>