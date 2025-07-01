<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}} - {{ config('app.name', 'MWD') }}</title>

    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">

    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/assets/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    {{-- End Favicons --}}

    @livewireStyles

</head>

<body class="antialiased">
    <div x-cloak x-data="{ sidebarOpen: $persist(true), mobileShow: false}" class="lg:flex">

        {{-- mobileShow white transparent bg --}}
        <div x-show="mobileShow" x-transition.duration.500ms @click="mobileShow = false"
            class="fixed inset-0 z-10 flex items-center justify-end pr-4 transition-opacity sm:justify-center bg-white/70 lg:hidden">
            <x-icon.solid-icon class="w-16 h-16 text-red-600 opacity-50"
                path="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" />
        </div>

        <div :class="mobileShow ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
            class="fixed inset-y-0 left-0 z-20 overflow-y-auto transition duration-300 w-max bg-gradient-to-b blue-gradient lg:translate-x-0 lg:static lg:inset-0">
            <div class="flex items-center justify-center px-4 my-5">
                <div class="flex items-center">
                    <x-dashboard.nav-text>
                        <a href="{{LaravelLocalization::localizeUrl(route('home'))}}">
                            <img class="w-36" src="{{ asset('assets/images/Myanmar-House-Logo-White.png')}}"
                                alt="{{__(config('app.name')) . ' Logo'}}" />
                        </a>
                    </x-dashboard.nav-text>
                </div>
            </div>

            <nav class="mt-3 space-y-1 max-w-[250px]">

                <x-dashboard.nav-item route="dashboard"
                    path="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                    text="{{__('Dashboard')}}" />

                <x-dashboard.nav-item route="dashboard/top-up"
                    path="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"
                    text="{{__('Top Up Points')}}" />

                <x-dashboard.nav-item route="dashboard/enquiries"
                    path="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    text="{{__('Enquiries')}}" text-class="flex items-center gap-2">
                    @if (Auth::user()->role === 'remwdstate20')
                    @php
                    $enquiryCount = App\Models\Enquiry::whereNull('status')->count();
                    @endphp

                    @if ($enquiryCount > 0)
                    <span class="flex justify-center w-5 h-5 text-sm font-bold text-white bg-red-600 border border-white rounded-full">
                        {{$enquiryCount}}
                    </span>
                    @endif

                    @else

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
                    @endif
                </x-dashboard.nav-item>

                @if (Auth::user()->role == 'remwdstate20')
                <x-dashboard.nav-item route="dashboard/sliders" create-route="dashboard/sliders/create"
                    path="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" text="{{__('Sliders')}}" />
                @endif

                <x-dashboard.nav-item route="dashboard/properties" create-route="dashboard/properties/create"
                    path="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                    text="{{__('Your Properties')}}" />

                @if (Auth::user()->role == 'remwdstate20')
                <div class="nav_sub">

                    <x-dashboard.nav-item route="dashboard/purposes"
                        path="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"
                        text="{{__('Purposes')}}" />

                    <x-dashboard.nav-item route="dashboard/types/property" create-route="dashboard/types/property/create"
                        path="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                        text="{{__('Types / Facilities')}}" />

                    <x-dashboard.nav-item route="dashboard/locations" create-route="dashboard/locations/create"
                        path="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                        path2="M15 11a3 3 0 11-6 0 3 3 0 016 0z" text="{{__('Locations')}}" />
                </div>


                <x-dashboard.nav-item route="dashboard/packages" create-route="dashboard/packages/create"
                    path="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" text="{{__('Packages')}}" />
                <x-dashboard.nav-item route="dashboard/users" create-route="dashboard/users/create"
                    path="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    text="{{__('Users')}}" />
                <x-dashboard.nav-item route="dashboard/blog-posts" create-route="dashboard/blog-posts/create"
                    path="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                    text="{{__('Blog Posts')}}" />

                <div class="nav_sub">
                    <x-dashboard.nav-item route="dashboard/types/blog" create-route="dashboard/types/blog/create"
                        path="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                        text="{{__('Blog Categories')}}" />
                </div>

                <x-dashboard.nav-item route="dashboard/ads" create-route="dashboard/ads/create"
                    path="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                    class="w-8 h-8 shrink-0 lg:w-5 lg:h-5 2xl:w-6 2xl:h-6" text="{{__('Advertisement')}}" />
                @endif

            </nav>
        </div>

        <div class="flex flex-col flex-1 min-h-screen {{Request::is('*/create') || Request::is('*/edit') ? 'overflow-y-auto' : ''}}">
            <header class="flex flex-col gap-3 px-4 py-2 bg-white shadow md:justify-between md:items-center md:flex-row">
                <div class="flex items-center gap-4">

                    {{-- Toggle btn on desktop --}}
                    <div @click="sidebarOpen = !sidebarOpen" class="hidden gap-2 cursor-pointer lg:flex">
                        <button class="text-blue-500 focus:outline-none">
                            <x-icon.icon :path="'M4 6h16M4 12h16M4 18h7'" />
                        </button>

                        <h1 class="text-xl text-logo-blue sm:text-2xl">{{__($title)}}</h1>
                    </div>

                    {{-- Toggle btn on mobile --}}
                    <div @click="sidebarOpen = true; mobileShow = !mobileShow" class="flex gap-2 cursor-pointer lg:hidden">
                        <button class="text-blue-500 focus:outline-none">
                            <x-icon.icon :path="'M4 6h16M4 12h16M4 18h7'" />
                        </button>

                        <h1 class="text-xl text-logo-blue sm:text-2xl">{{__($title)}}</h1>
                    </div>

                    @if (!empty($addNew))
                    <div class="relative flex">
                        <a href="{{LaravelLocalization::localizeUrl($addNew)}}" class="flex justify-between gap-1 bg-gradient-to-r blue-gradient btn">
                            {{__('Add New')}}
                            <x-icon.solid-icon
                                :path="'M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z'" />
                        </a>
                    </div>
                    @endif
                </div>

                @if (Request::is('*dashboard/properties'))
                <div class="flex items-center gap-2 text-sm md:flex-col xl:flex-row sm:text-base">
                    @if (!empty( Auth::user()->credit ))
                    <p>{!! __('You have <strong>' . number_format( Auth::user()->credit ) . ' credit points</strong>
                        which you can use to feature your properties.') !!}</p>
                    @else
                    <p>{{ __("You don't have any point left!") }}</p>
                    @endif
                    <a class="font-semibold text-blue-600 hover:underline" href="{{LaravelLocalization::localizeUrl(route('dashboard.top-up'))}}">{{
                        __('Top Up
                        Now!') }}</a>
                </div>
                @endif

                <div class="flex items-center justify-between gap-5 sm:justify-items-start sm:gap-8">
                    <ul class="flex">
                        @if (LaravelLocalization::getCurrentLocale() == 'my')
                        <a rel="alternate" hreflang="en" href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}">
                            <img class="w-8 rounded shadow" src="{{asset('assets/images/us.svg')}}" alt="US Country Flag">
                        </a>
                        @else
                        <a rel="alternate" hreflang="my" href="{{ LaravelLocalization::getLocalizedURL('my', null, [], true) }}">
                            <img class="w-8 rounded shadow" src="{{asset('assets/images/myanmar.svg')}}" alt="Myanmar Country Flag">
                        </a>
                        @endif
                    </ul>

                    <a class="text-gray-700" href="{{LaravelLocalization::localizeUrl(route('homesssss'))}}">
                        <x-icon.icon
                            :path="'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'"
                            class="w-5 h-5" />
                    </a>

                    <x-profile-dropdown />

                </div>
            </header>
            <main class="px-6 {{Request::is('*/create') || Request::is('*/edit') ? '' : 'overflow-y-auto'}}">
                {{$slot}}
            </main>
        </div>

        @livewire('compare.compare-box')
    </div>

    {{-- deferred css --}}
    <link rel="stylesheet" href="{{ mix('assets/css/defer.css') }}">

    <livewire:scripts />

    <script src="{{ mix('assets/js/app.js') }}" defer></script>

    @stack('scripts')
</body>

</html>