<div x-data="{showSearch: true}" x-init="showSearch = window.innerWidth >= 1024 ? true : false" class="mb-6">

    <div class="sticky top-0 z-10 px-4 py-2 mb-6 bg-blue-100">

        <a @click.prevent="showSearch = !showSearch" class="flex items-center justify-center gap-2 lg:hidden btn bg-gradient-to-r blue-gradient"
            href="#">
            <x-icon.icon x-show="showSearch" path="M6 18L18 6M6 6l12 12" />
            <x-icon.icon x-show="!showSearch"
                path="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            <span x-text="showSearch ? '{{__('Hide Filters')}}' : '{{__('Show Filters')}}'"></span>
        </a>

        <div x-cloak :class="showSearch ? 'h-[395px] sm:h-[300px] md:h-[250px] lg:h-auto mt-4 lg:my-0' : 'h-0'"
            class="container flex flex-col items-center mx-auto overflow-y-auto transition-all duration-300 ease-in-out">

            {{-- results found --}}
            <x-result-found class="mb-1 lg:absolute" :properties="$properties" />

            {{-- propertyTypes is coming from appserviceprovider --}}
            <x-realtime-search-form main-class="w-full mt-2" searchWrapperClass="flex flex-col items-end gap-2 mb-1 lg:flex-row"
                class="grid items-end w-full grid-cols-1 gap-1 sm:grid-cols-2 md:grid-cols-3 lg:flex"
                inputClass="h-full w-full pr-6 lg:flex-1 lg:min-w-max" :types="$propertyTypes" :regions="$regions" :townships="$townships"
                :purposes="$purposes" :price="$price" page="profile" />

            {{-- close to see the results --}}
            <x-search-guide @click="showSearch = false" :properties="$properties" />

        </div>

    </div>

    <div class="container grid gap-3 px-4 mx-auto md:grid-cols-2 xl:px-0">

        @forelse ($properties as $property)
        {{-- :key is required since the property card component needs to be refresh when 'Per Page' select box is changed Livewire component doesn't
        refresh but Laravel component does But this need to be livewire component because, we have "Save" button on every property card which needs to
        interact with backend without refreshing the page --}}
        {{--
        Refs;
        https://laravel-livewire.com/docs/2.x/troubleshooting
        https://github.com/livewire/livewire/issues/2044
        https://laracasts.com/discuss/channels/livewire/typeerror-cannot-read-property-fingerprint-of-null
        https://github.com/livewire/livewire/issues/1686
        --}}
        {{-- error msg; Uncaught (in promise) TypeError: Cannot read property 'fingerprint' of null --}}
        <livewire:property-card :key="time().$property->id" layout="horizontal" :property="$property" :saved-property-ids="$savedPropertyIds"
            :compare-ids="$compareIds">
            @empty
            <div class="flex flex-col items-center col-span-4 space-y-4">
                <p class="mt-8 text-2xl text-red-600">{{ __('No properties found!') }}</p>
                <a class="btn btn-danger" href="{{$isSavedPage ? LaravelLocalization::localizeUrl('/user/saved') :
                LaravelLocalization::localizeUrl('/real-estate-agents/' . $user->slug) }}">{{ __('Reset Filter') }}</a>
            </div>
            @endforelse
    </div>

    <div class="container px-4 mx-auto mt-6 xl:px-0">
        {{$properties->links()}}
    </div>
</div>