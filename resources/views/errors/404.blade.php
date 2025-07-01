<x-app-layout>
	<div class="container flex flex-wrap items-center min-h-[calc(100vh-180px)] py-8 gap-16">
		<img class="w-1/2" src="{{asset('assets/images/404-page-not-found.svg')}}" alt="Error 404 - Page Not Found!">

		<div>
			<h1 class="font-bold h1">{{__('Error 404 - Page not found!')}}</h1>
			<p>{{__('The page you entered is not existing on our website.')}}</p>

			<a class="flex items-center gap-2 mt-8 bg-gradient-to-r blue-gradient btn" href="{{LaravelLocalization::localizeUrl('/')}}">
				<x-icon.icon
					path="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />

				{{__('Go to home page')}}
			</a>
		</div>
	</div>
</x-app-layout>