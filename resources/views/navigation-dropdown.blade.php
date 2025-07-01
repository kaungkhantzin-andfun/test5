<nav aria-labelledby="main-navigation">
    <ul class="items-center w-full gap-5 font-bold divide-y main_nav lg:container lg:divide-y-0 lg:flex lg:mx-auto xl:px-0 lg:px-4">
        <li>
            <a class="parent_nav {{Route::is('home') ? 'current_nav' : ''}}" href="{{LaravelLocalization::localizeUrl('/')}}">@lang('Home')</a>
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

        <li>
            <a class="parent_nav {{Request::is('*real-estate-agents') ? 'current_nav' : ''}}"
                href="{{LaravelLocalization::localizeUrl('/real-estate-agents')}}">
                {{__('Real Estate Agents')}}</a>
        </li>

        @if (count($blogCategories) > 0)
        <x-nav-dropdown-item :current="Request::is('*blog*')" :ul-class="''" :parent-link="'/blog'" :parent="'Blog'">
            @foreach ($blogCategories->whereNull('parent_id') as $parent_cat)
            <li class="relative z-10 flex flex-col sub_menu">
                @php
                $subCategories = $blogCategories->where('parent_id', $parent_cat->id);
                @endphp

                <a class="flex items-center nav_item justify-between {{Request::is(" *blog/$parent_cat->slug*") ? 'current_nav' : ''}}"
                    href="{{LaravelLocalization::localizeUrl('/blog/' . $parent_cat->slug . '/')}}">
                    {{__($parent_cat->name)}}
                    @if ( count( $subCategories ) > 0 )
                    <x-icon.icon class="w-3 h-3" path="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    @endif
                </a>

                @if ( count( $subCategories ) > 0 )
                <ul class="absolute invisible p-4 space-y-1 bg-white rounded-lg shadow-lg left-full min-w-max">
                    @foreach ($subCategories as $sub_cat)
                    <li class="flex flex-col">
                        <a class="nav_item {{Request::is(" *blog/$sub_cat->slug*") ? 'current_nav' : ''}}"
                            href="{{LaravelLocalization::localizeUrl('/blog/' . $sub_cat->slug . '/')}}">{{__($sub_cat->name)}}</a>
                    </li>
                    @endforeach
                </ul>
                @endif

            </li>
            @endforeach
        </x-nav-dropdown-item>
        @endif

        <x-nav-dropdown-item :current="Route::is('tools.*')" parent="Tools"
            parent-icon="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
            <li>
                <a class="flex gap-1 nav_item items-center {{Route::is('tools.font-download') ? 'current_nav' : ''}}"
                    href="{{route('tools.font-download')}}">
                    <x-icon.icon path="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    <span class="shrink-0">{{__('Myanmar Font Download')}}</span>
                </a>
            </li>
            <li>
                <a class="flex gap-1 nav_item items-center {{Route::is('tools.font-converter') ? 'current_nav' : ''}}"
                    href="{{route('tools.font-converter')}}">
                    <x-icon.icon path="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    <span class="shrink-0">{{__('Myanmar Font Converter')}}</span>
                </a>
            </li>
        </x-nav-dropdown-item>

        @auth
        <x-nav-dropdown-item :current="Route::is('dashboard.*')" parent="Dashboard"
            parent-icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
            <x-dashboard.user-nav :clean="true" />
        </x-nav-dropdown-item>
        @endauth

    </ul>
</nav>