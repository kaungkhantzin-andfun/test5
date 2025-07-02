<nav aria-labelledby="main-navigation" class="w-full">
    <ul class="flex items-center justify-center space-x-8 font-medium main_nav">
        <li class="flex items-center h-full">
            <a class="parent_nav {{Route::is('home') ? 'current_nav' : ''}} py-2 px-3 block" href="{{LaravelLocalization::localizeUrl('/')}}">@lang('Home')</a>
        </li>

        {{-- All properties --}}
        <x-nav-dropdown-item parent="{{__('All Properties')}}">
            <li>
                <a class="nav_item {{Request::is('*properties-in-myanmar') ? 'current_nav' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/properties-in-myanmar')}}">{{__('All Properties')}}</a>
            </li>
            @forelse ($propertyTypes as $type)
            <li>
                <a class="flex nav_item py-3 text-gray-600 {{Request::is('*search/' . $type->slug . '/all-purposes/all-regions/all-townships') ? 'current_nav' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/search/' . $type->slug .'/all-purposes/all-regions/all-townships')}}">
                    {{__(Str::plural($type->name))}}
                </a>
            </li>
            @empty
            @endforelse
        </x-nav-dropdown-item>

        {{-- For sale --}}
        <x-nav-dropdown-item parent="{{__('For Sale')}}">
            <li>
                <a class="nav_item {{Request::is('*properties-for-sale-in-myanmar') ? 'current_nav' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/properties-for-sale-in-myanmar')}}">{{__('All Properties For Sale')}}</a>
            </li>

            @forelse ($propertyTypes as $type)
            <li>
                <a class="flex nav_item py-3 text-gray-600 {{Request::is('*search/' . $type->slug . '/for-sale/all-regions/all-townships') ? 'current_nav' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/search/' . $type->slug .'/for-sale/all-regions/all-townships')}}">
                    {{__(Str::plural($type->name))}}
                </a>
            </li>
            @empty
            @endforelse
        </x-nav-dropdown-item>

        {{-- For rent --}}
        <x-nav-dropdown-item parent="{{__('For Rent')}}">
            <li>
                <a class="nav_item {{Request::is('*properties-for-rent-in-myanmar') ? 'current_nav' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/properties-for-rent-in-myanmar')}}">{{__('All Properties For Rent')}}</a>
            </li>

            @forelse ($propertyTypes as $type)
            <li>
                <a class="flex nav_item py-3 text-gray-600 {{Request::is('*search/' . $type->slug . '/for-rent/all-regions/all-townships') ? 'current_nav' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/search/' . $type->slug .'/for-rent/all-regions/all-townships')}}">
                    {{__(Str::plural($type->name))}}
                </a>
            </li>
            @empty
            @endforelse
        </x-nav-dropdown-item>

        {{-- By location --}}
        <x-nav-dropdown-item parent="{{__('By Location')}}">
            @forelse ($regions as $region)
            <li>
                <a class="flex nav_item py-3 text-gray-600 {{Request::is('*search/properties/all-purposes/' . $region->slug . '/all-townships') ? 'current_nav' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/search/properties/all-purposes/' . $region->slug . '/all-townships')}}">

                    @php
                    // split string by last space
                    // ref: https://stackoverflow.com/questions/1530883/regex-to-split-a-string-only-by-the-last-whitespace-character
                    $reg=preg_split("/\s+(?=\S*+$)/", $region->name);
                    @endphp
                    {{ trans($reg[0] ?? '') . ' ' . trans($reg[1] ?? '') }}
                </a>
            </li>
            @empty
            @endforelse
        </x-nav-dropdown-item>

        {{-- <x-nav-dropdown-item :current="Request::is('*search/properties/to-*')" :parent="'Wanted Properties'">
            <li class="flex flex-col">
                <a class="text-gray-600 {{Request::is('*search/properties/to-buy/all-regions/all-townships') ? 'font-bold' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/search/properties/to-buy/all-regions/all-townships')}}">{{__('Wanted To Buy')}}</a>
            </li>
            <li class="flex flex-col">
                <a class="text-gray-600 {{Request::is('*search/properties/to-rent/all-regions/all-townships') ? 'font-bold' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/search/properties/to-rent/all-regions/all-townships')}}">{{__('Wanted To Rent')}}</a>
            </li>
        </x-nav-dropdown-item> --}}

        {{-- @if (count($roles) > 0)
        <x-nav-dropdown-item :current="Request::is('*directory*')" :parent="'Business Directory'">
            @foreach ($roles as $role)
            <li class="flex flex-col sub_menu">

                <a class="flex items-center justify-between py-3 text-gray-600 {{Request::is(" *directory*") ? 'current_nav' : '' }}"
                    href="{{LaravelLocalization::localizeUrl('{{$role->role}}s')}}">
                    @php
                    $name = Str::of($role->role)->title()->singular()->plural();
                    $name = str_replace('-', ' ', $name);
                    @endphp
                    {{__($name)}}
                </a>

            </li>
            @endforeach
        </x-nav-dropdown-item>
        @endif --}}



        @auth
        <x-nav-dropdown-item :current="Route::is('dashboard.*')" parent="Dashboard"
            parent-icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
            <x-dashboard.user-nav :clean="true" />
        </x-nav-dropdown-item>
        <li class="flex items-center h-full">
            <a class="parent_nav {{Route::is('bookings') ? 'current_nav' : ''}} py-2 px-3 block" href="{{LaravelLocalization::localizeUrl('/user/bookings')}}">@lang('My Bookings')</a>
        </li>
        @endauth

    </ul>
</nav>