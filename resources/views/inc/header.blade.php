{{-- Main Navigation --}}
<div class="mt-[15px]">
<nav x-data="{ open: false }" class="bg-white sticky top-0 z-50 shadow-md">
    <div class="container mx-auto px-4">
        <div class="flex justify-center items-center" style="height: 104px;">
            <!-- Logo -->
            <div class="absolute left-4">
                <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="flex items-center">
                    <img class="h-20 w-auto" src="{{ asset('assets/images/Myanmar-House-Logo.png') }}" 
                         alt="{{ __('seo.site.name') }} Logo">
                </a>
            </div>

            <!-- Centered Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                @include('navigation-dropdown')
            </div>

            <!-- Right Side Elements -->
            <div class="absolute right-4 flex items-center space-x-4">
                <!-- Language Switcher -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center text-gray-700 hover:text-blue-600">
                        {{ strtoupper(app()->getLocale()) }}
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" 
                         class="origin-top-right absolute right-0 mt-2 w-20 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ strtoupper($localeCode) }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Auth Links -->
                @auth
                    <x-profile-dropdown />
                @else
                    <a href="{{ LaravelLocalization::localizeUrl(route('login')) }}" 
                       class="text-gray-700 hover:text-blue-600">
                        {{ __('Sign In') }}
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ LaravelLocalization::localizeUrl(route('register')) }}" 
                           class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            {{ __('Register') }}
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden flex items-center">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100">
                    <svg class="h-6 w-6" :class="{'hidden': open, 'block': !open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6" :class="{'block': open, 'hidden': !open}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-100" 
         x-transition:enter-start="opacity-0 scale-95" 
         x-transition:enter-end="opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-75" 
         x-transition:leave-start="opacity-100 scale-100" 
         x-transition:leave-end="opacity-0 scale-95" 
         class="lg:hidden bg-white border-t border-gray-200">
        <div class="pt-2 pb-3 space-y-1">
            @include('navigation-dropdown-mobile')
            
            <div class="px-4 py-2 border-t border-gray-200">
                <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">{{ __('Language') }}</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                           class="flex items-center px-3 py-2 text-sm rounded-md {{ app()->getLocale() === $localeCode ? 'bg-gray-100 text-blue-600' : 'text-gray-700 hover:bg-gray-50' }}">
                            <img src="{{ asset('assets/images/' . ($localeCode === 'my' ? 'myanmar' : 'us') . '.svg') }}" 
                                 class="h-4 w-4 mr-2" 
                                 alt="{{ $properties['native'] }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            
            @auth
                <a href="{{ LaravelLocalization::localizeUrl(route('dashboard')) }}" 
                   class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">
                    {{ __('Dashboard') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">
                        {{ __('Log Out') }}
                    </button>
                </form>
            @else
                <a href="{{ LaravelLocalization::localizeUrl(route('login')) }}" 
                   class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">
                    {{ __('Sign In') }}
                </a>
                @if (Route::has('register'))
                    <a href="{{ LaravelLocalization::localizeUrl(route('register')) }}" 
                       class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-gray-50">
                        {{ __('Register') }}
                    </a>
                @endif
            @endauth
            
            <a href="{{ LaravelLocalization::localizeUrl('/dashboard/properties/create') }}" 
               class="block mx-4 my-2 px-4 py-2 text-center text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                {{ __('Add Property') }}
            </a>
        </div>
    </div>
</nav>
</div>
