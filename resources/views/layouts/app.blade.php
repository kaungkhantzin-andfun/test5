<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

    {!! SEO::generate() !!}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">

    @livewireStyles

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3PFM5R9BSJ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-3PFM5R9BSJ');
    </script>

</head>

<body class="antialiased 2xl:text-lg">

    @include('inc.header')

    <!-- Page Content -->
    <main>
        @livewire('compare.compare-box')
        <div class="fixed top-1 left-1/2 -ml-28">
            <x-messages />
        </div>

        <div class="{{Route::is('dashboard.*') ? 'container min-h-screen px-4 mx-auto xl:px-0 my-4' : ''}}">

            {{-- font end nav for logged users --}}
            @if (Route::is('dashboard.*'))
            <x-dashboard.user-nav />
            <a href="{{ route('bookings') }}" class="text-blue-500 hover:underline">{{__('My Bookings')}}</a>
            @endif

            {{ $slot }}
        </div>
    </main>

    @include('inc.footer')


    <!-- begin Back to Top button -->
    <a class="fixed z-10 flex justify-center w-10 h-10 py-2 text-xl text-white bg-gray-800 border border-gray-200 rounded-lg shadow-lg cursor-pointer right-1 bottom-24 hover:bg-white hover:text-black back_to_top"
        title="Back to Top">&uarr;</a>
    <!-- end Back to Top button -->

    @stack('modals')

    {{-- deferred css --}}
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/defer.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('assets/js/swiper-bundle.min.js') }}" defer></script>
    <script src="{{ mix('assets/js/app.js') }}" defer></script>

    @stack('f_scripts')

    @livewireScripts


    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        /* begin begin Back to Top button  */
            (function () {
                'use strict';

                function trackScroll() {
                    var scrolled = window.pageYOffset;
                    var coords = document.documentElement.clientHeight;

                    if (scrolled > coords) {
                        goTopBtn.classList.remove('hidden');
                    }
                    if (scrolled < coords) {
                        goTopBtn.classList.add('hidden');
                    }
                }

                function backToTop() {
                    if (window.pageYOffset > 0) {
                        window.scrollBy(0, -80);
                        setTimeout(backToTop, 0);
                    }
                }

                var goTopBtn = document.querySelector('.back_to_top');

                window.addEventListener('scroll', trackScroll);
                goTopBtn.addEventListener('click', backToTop);
            })();
            /* end begin Back to Top button  */
    </script>
</body>

</html>