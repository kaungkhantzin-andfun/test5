<div x-data="{showSearch: false}">
    <div class="relative">
        {{-- Main Featured slideshow --}}
        <x-main-slider :slides="$slides" />

        {{-- Search form --}}
        <livewire:search-form main-class="container absolute inset-0 z-10 items-center justify-end hidden mx-auto lg:flex"
            searchWrapperClass="backdrop-blur max-w-md bg-opacity-30 bg-white mx-2 px-4 py-6 rounded-2xl shadow-2xl"
            inputClass="bg-gray-100 border border-gray-300 text-gray-800 shadow-none focus:border-0 focus:ring-0" class="space-y-4"
            class2="mt-4 space-y-6" :regions="$regions" :is-home="'true'" />

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
        class="fixed right-0 z-30 flex items-center gap-1 transition-all duration-300 -translate-y-1/2 lg:hidden top-1/2">

        <x-icon.solid-icon @click="showSearch = true"
            class="w-10 h-10 p-2 -ml-6 rounded shadow-md cursor-pointer lg:-ml-8 bg-gradient-to-r blue-gradient"
            path="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />

        <div class="max-w-[320px] xs:max-w-xs max-h-screen overflow-y-scroll sm:max-w-sm p-4 bg-white border border-gray-200 rounded shadow-raised">

            <livewire:search-form main-class="mt-2" searchWrapperClass="flex flex-col gap-2" class="flex flex-col gap-2" class2="flex flex-col gap-2"
                :regions="$regions" :is-drawer="'true'" />

        </div>

    </div>

    <!-- <section class="container my-8 prose">
        <span class="font-semibold text-logo-purple">@lang('About Us')</span>
        <h2 class="mt-0 mb-2 h2">{{ __('home.welcome.title') }}</h2>
        <p>@lang('home.welcome.body')</p>
    </section> -->

    {{-- Featured properties --}}
    {{-- without wire:ignore this part is reloading (including images) everytime price on search form is change
    we don't want the server to be busy sending images again and again --}}
    <section wire:ignore class="px-4 lg:container lg:mx-auto xl:px-0">

        @if (count($featuredProperties) > 0)
        {{-- $savedPropertyIds is coming from appserviceprovier --}}
        <x-featured-properties :featured-properties="$featuredProperties" :saved-property-ids="$savedPropertyIds" :compare-ids="$compareIds" />
        @endif

    </section>

 

    {{-- by types --}}
    @if (!empty($types))
<section wire:ignore class="relative h-[500px]">
   
    <img class="object-cover w-full h-full absolute top-0 left-0 z-0"
         src="{{ asset('assets/images/ny.jpg') }}"
         alt="Modern white room">


    <div class="relative z-10 h-full flex justify-center items-center">
        <div class="max-w-6xl w-full px-4 grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="bg-yellow-400 bg-opacity-90 p-6 md:p-8 rounded shadow-md flex items-start gap-4">
             
                <div class="text-black text-5xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 10l1.5-1.5L12 3l7.5 5.5L21 10v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 22V12h6v10" />
                    </svg>
                </div>
               
                <div>
                    <h3 class="text-xl font-semibold text-black mb-2">Looking for the new home?</h3>
                    <p class="text-sm text-black">
                        10 new offers every day. 350 offers on site, trusted by a community of thousands of users.
                    </p>
                </div>
            </div>

          
            <div class="bg-yellow-400 bg-opacity-90 p-6 md:p-8 rounded shadow-md flex items-start gap-4">
             
                <div class="text-black text-5xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 21V9a1 1 0 011-1h4a1 1 0 011 1v12M9 21h6M3 10l9-7 9 7" />
                    </svg>
                </div>
             
                <div>
                    <h3 class="text-xl font-semibold text-black mb-2">Want to sell your home?</h3>
                    <p class="text-sm text-black">
                        10 new offers every day. 350 offers on site, trusted by a community of thousands of users.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif



    {{-- without wire:ignore this part is reloading (including images) everytime price on search form is change
    we don't want the server to be busy sending images again and again --}}
    <section class="px-4 py-10 mx-auto lg:container xl:px-0">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Popular Properties</h2>
            <span class="text-sm text-gray-600">🏠 1,300 AVAILABLE PROPERTIES</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="relative bg-white rounded-lg shadow-lg overflow-hidden transform hover:shadow-xl transition duration-300">
                <img src="https://via.placeholder.com/300x200" alt="Apartment in NE 7th Victory Palace" class="w-full h-48 object-cover">
                <div class="p-4">
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">Featured Buy</span>
                    <h3 class="text-lg font-semibold text-gray-800 mt-2">Apartment in NE 7th Victory Palace</h3>
                    <p class="text-gray-600 text-sm">NE 7th Victory Palace</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xl font-bold text-green-600">$134,000</span>
                        <div class="text-sm text-gray-500">6 Beds · 3 Baths · 1900 sqft</div>
                    </div>
                    <a href="#" class="mt-2 inline-block text-blue-500 text-sm hover:underline">View</a>
                </div>
                <span class="absolute top-2 left-2 px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">Featured</span>
            </div>

            <!-- Card 2 -->
            <div class="relative bg-white rounded-lg shadow-lg overflow-hidden transform hover:shadow-xl transition duration-300">
                <img src="https://via.placeholder.com/300x200" alt="Modern apartment on the Bay" class="w-full h-48 object-cover">
                <div class="p-4">
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full">Featured Rent</span>
                    <h3 class="text-lg font-semibold text-gray-800 mt-2">Modern apartment on the Bay</h3>
                    <p class="text-gray-600 text-sm">Bay Area</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xl font-bold text-green-600">$3,422</span>
                        <div class="text-sm text-gray-500">4 Beds · 3 Baths · 4621 sqft</div>
                    </div>
                    <a href="#" class="mt-2 inline-block text-blue-500 text-sm hover:underline">View</a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="relative bg-white rounded-lg shadow-lg overflow-hidden transform hover:shadow-xl transition duration-300">
                <img src="https://via.placeholder.com/300x200" alt="Awesome family Apartment" class="w-full h-48 object-cover">
                <div class="p-4">
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-red-500 rounded-full">Featured Sold</span>
                    <h3 class="text-lg font-semibold text-gray-800 mt-2">Awesome family Apartment</h3>
                    <p class="text-gray-600 text-sm">Family Area</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xl font-bold text-green-600">$345</span>
                        <div class="text-sm text-gray-500">3 Beds · 5 Baths · 3356 sqft</div>
                    </div>
                    <a href="#" class="mt-2 inline-block text-blue-500 text-sm hover:underline">View</a>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="relative bg-white rounded-lg shadow-lg overflow-hidden transform hover:shadow-xl transition duration-300">
                <img src="https://via.placeholder.com/300x200" alt="Apartment on Grand Avenue" class="w-full h-48 object-cover">
                <div class="p-4">
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full">Featured Rent</span>
                    <h3 class="text-lg font-semibold text-gray-800 mt-2">Apartment on Grand Avenue</h3>
                    <p class="text-gray-600 text-sm">Grand Avenue</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xl font-bold text-green-600">$1,500/mo</span>
                        <div class="text-sm text-gray-500">3 Beds · 2 Baths · 2480 sqft</div>
                    </div>
                    <a href="#" class="mt-2 inline-block text-blue-500 text-sm hover:underline">View</a>
                </div>
            </div>

            <!-- Card 5 -->
            <div class="relative bg-white rounded-lg shadow-lg overflow-hidden transform hover:shadow-xl transition duration-300">
                <img src="https://via.placeholder.com/300x200" alt="Contemporary Apartment" class="w-full h-48 object-cover">
                <div class="p-4">
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full">Featured Rent</span>
                    <h3 class="text-lg font-semibold text-gray-800 mt-2">Contemporary Apartment</h3>
                    <p class="text-gray-600 text-sm">Contemporary Zone</p>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xl font-bold text-green-600">$120/mo</span>
                        <div class="text-sm text-gray-500">1 Bed · 1 Bath · 1660 sqft</div>
                    </div>
                    <a href="#" class="mt-2 inline-block text-blue-500 text-sm hover:underline">View</a>
                </div>
            </div>
        </div>
    </section>
   
</div>