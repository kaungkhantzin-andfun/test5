@props(['clean' => false])

<div x-data="{open: $persist(true), sidebarOpen: true}">

	@if (!$clean)
	<a @click.prevent="open = !open" href="#" class="flex items-center gap-2 md:hidden bg-gradient-to-r btn blue-gradient">
		<x-icon.icon x-show="!open" path="M4 6h16M4 12h16M4 18h16" />
		<x-icon.icon x-show="open" path="M6 18L18 6M6 6l12 12" />
		<span>{{__('Dashboard Menu')}}</span>
	</a>
	@endif

	@if ($clean)
	<div
		class="flex flex-col justify-center gap-2 overflow-hidden transition-all md:justify-start md:h-auto md:flex-wrap md:flex-row md:items-center">
		@else
		<div :class="open ? 'h-[200px]' : 'h-0'" x-cloak
			class="flex flex-col justify-center gap-2 overflow-hidden transition-all md:justify-start md:h-auto md:flex-wrap md:flex-row md:items-center">
			@endif
			<x-dashboard.nav-item route="dashboard"
				path="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
				text="{{__('Dashboard')}}" />

			{{--
			<x-dashboard.nav-item route="dashboard/top-up"
				path="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"
				text="{{__('Top Up Points')}}" /> --}}

			<x-dashboard.nav-item route="dashboard/enquiries"
				path="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" text="{{__('Enquiries')}}"
				text-class="flex items-center gap-2">

				@php
				$enquiryCount = App\Models\Enquiry::whereNull('status')->whereHas('property', function ($query) {
				$query->where('user_id', Auth::user()->id);
				})->count();
				@endphp

				@if ($enquiryCount > 0)
				<span class="flex justify-center w-5 h-5 text-sm font-bold text-white bg-red-600 border border-white rounded-full">
					{{$enquiryCount}}
				</span>
				@endif

			</x-dashboard.nav-item>

			@if ($clean)
			<x-dashboard.nav-item route="dashboard/properties"
				path="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
				text="{{__('Your Properties')}}" />

			<x-dashboard.nav-item route="dashboard/blog-posts"
				path="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"
				text="{{__('Blog Posts')}}" />
			@else
			<x-dashboard.nav-item route="dashboard/properties" create-route="dashboard/properties/create"
				path="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
				text="{{__('Your Properties')}}" />

			<x-dashboard.nav-item route="dashboard/blog-posts" create-route="dashboard/blog-posts/create"
				path="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"
				text="{{__('Blog Posts')}}" />
			
			<x-dashboard.nav-item route="dashboard.bookings"
				path="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
				text="{{__('My Bookings')}}" />
			@endif

		</div>
	</div>