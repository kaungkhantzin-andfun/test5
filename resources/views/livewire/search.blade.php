<div x-data="{showSearch: false}" class="min-h-screen px-4 py-6 mx-auto md:container xl:px-0 md:px-4">
    <!-- Search Form -->
    <div class="mb-8">
        <livewire:search-form :mainClass="'mb-8'" />
    </div>

    <div class="flex flex-col py-4 space-y-4 md:flex-row md:items-center md:justify-between md:space-y-0 md:px-0">
        <header>
            <h1 class="text-gray-700 h3">{{$pageTitle}}</h1>
            <h2 class="text-gray-700">
                {{__('From the best real estate agents in Myanmar') }}
            </h2>
        </header>

        <div>
            <label class="label">{{__('Sorting')}}</label>
            <select wire:model="sorting" class="pr-8">
                <option value="created_at-desc">{{ __('New to Old') }}</option>
                <option value="created_at-asc">{{ __('Old to New') }}</option>
                <option value="price-asc">{{ __('Price (Low to High)') }}</option>
                <option value="price-desc">{{ __('Price (High to Low)') }}</option>
            </select>
        </div>
    </div>

    <div class="grid gap-4 sm:gap-6 sm:grid-cols-2 xl:grid-cols-4 2xl:grid-cols-5">
        @forelse ($properties as $property)
        {{-- Ref https://laravel-livewire.com/docs/2.x/troubleshooting for using :key but sorting won't work $loop->index --}}
        <livewire:property-card :key="time().$property->id" layout="vertical" :property="$property" :show-uploader="true"
            :saved-property-ids="$savedPropertyIds" :compare-ids="$compareIds" />
        @empty
        <div class="flex flex-col gap-4 my-16 sm:col-span-2 xl:col-span-4 2xl:col-span-5">
            <img class="w-1/2 mx-auto sm:w-52" src="{{asset('assets/images/property-not-found.svg')}}" alt="No property found vector image">
            <p class="text-xl text-center text-logo-purple">{{ __('No properties found!') }}</p>
            <a class="gap-2 mx-auto bg-gradient-to-r blue-gradient btn max-w-max"
                href="{{(app()->getLocale() == 'en' ? '/en' : '') . '/search/properties/all-purposes/all-regions/all-townships/' . $price['all_min'] . '/' . $price['all_max']}}">
                <x-icon.solid-icon
                    path="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" />
                {{ __('Reset Filter') }}
            </a>
        </div>
        @endforelse
    </div>

    {{-- search black bg --}}
    <div x-show="showSearch" x-cloak x-transition class="fixed inset-0 z-30 flex items-end justify-center bg-black/60 lg:hidden">
        <x-icon.solid-icon class="mb-8 text-red-600 bg-white rounded-full w-14 h-14 opacity-70"
            path="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" />
    </div>

    {{-- @mouseleave doesn't works well in firefox & edge --}}
    {{-- need to pull left a little to catch mouse over event wider --}}
    <div x-cloak @click.away="showSearch = false" @mouseover="showSearch = true" @keyup.escape.window="showSearch = false"
        :style="showSearch ? 'transform: translateX(0) translateY(-50%)' : 'transform: translateX(calc(100% - 18px)) translateY(-50%)'"
        class="fixed right-0 z-30 flex items-center gap-1 transition-all duration-300 -translate-y-1/2 top-1/2">

        <x-icon.solid-icon @click="showSearch = true"
            class="w-10 h-10 p-2 -ml-6 rounded shadow-md cursor-pointer lg:-ml-8 bg-gradient-to-r blue-gradient"
            path="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />

        <div class="max-w-[320px] xs:max-w-xs max-h-screen overflow-y-scroll sm:max-w-sm p-4 bg-white border border-gray-200 rounded shadow-raised">

            {{-- results found --}}
            <x-result-found :properties="$properties" />

            <x-realtime-search-form main-class="mt-2" searchWrapperClass="flex flex-col gap-2" class="flex flex-col gap-2"
                class2="flex flex-col gap-2" :types="$propertyTypes" :regions="$regions" :townships="$townships" :purposes="$purposes" :price="$price"
                :url="$url" />

            {{-- close to see the results --}}
            <x-search-guide @click="showSearch = false" :properties="$properties" />

        </div>

    </div>

    <div class="my-8">
        {{$properties->links()}}
    </div>

    @push('f_scripts')
    <script>
        window.addEventListener('replace-url', event => {
                setTimeout(() => {
                    window.history.pushState('', event.detail.title, event.detail.url);
                    document.title = event.detail.title;
                    document.querySelector('meta[name="description"]').setAttribute("content", event.detail.description);
                }, 100);
            })
    </script>
    @endpush
</div>