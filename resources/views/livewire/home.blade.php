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
    <style>
        .card-overlay {
            position: relative;
        }

        .card-overlay .overlay-content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-overlay img {
            width: 100%;
            height: 48vh;
            object-fit: cover;
        }
    </style>
    <section class="px-4 py-10 mx-auto lg:container xl:px-0">
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-12">
            <div class="mb-4 lg:mb-0">
                <h2 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight">
                    {{ __('Recent Properties for Buy') }}
                </h2>
            </div>

            <a href="{{ LaravelLocalization::localizeUrl('/properties') }}" class="group flex items-center space-x-3 hover:opacity-90 transition-opacity">
                <div class="bg-blue-100 p-3 rounded-full group-hover:bg-blue-200 transition-colors">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-lg text-gray-600 font-medium">ALL PROPERTIES</div>
                    <div class="text-blue-600 font-bold text-xl">FOR BUY</div>
                </div>
            </a>
        </div>
      

        <div class="space-y-6">
            <!-- First Row: 2 Posts -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Card 1 -->
                <div class="card-overlay bg-white overflow-hidden transform transition duration-300">
                    <img src="http://127.0.0.1:8000/storage/card_22182601-0825553001750953303_6863625579565.webp" alt="Apartment in NE 7th Victory Palace">
                    <div class="overlay-content">
                       
                        <div>
                            <span class="inline-block px-2 py-1 text-lg  text-white ">Welcome to BR104 – Your Relaxing Holiday Hideaway in Bali Residence!</span>
                            <div class="flex items-center mt-2">
                                <span class="text-xl font-bold">$134,000</span>
                                <span class="text-sm ml-2">6 Beds · 3 Baths · 1900 sqft</span>
                            </div>
                        </div>
                        <span class="eye-icon" style="font-size: 1.2rem;">
                            <div class="flex items-center gap-1  px-2 py-1 rounded">
                                <svg class="w-6 h-6" fill="none" stroke="#CCCCCC" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>

                            </div>
                        </span>
                    </div>
                    <span class="absolute top-2 left-2 px-2 py-1 text-xs font-semibold text-white bg-red-500">Featured</span>
                </div>

                <!-- Card 2 -->
                <div class="card-overlay bg-white overflow-hidden transform transition duration-300">
                    <img src="http://127.0.0.1:8000/storage/card_22182601-0825553001750953303_6863625579565.webp" alt="Modern apartment on the Bay">
                    <div class="overlay-content">
                        <div>
                        <span class="inline-block px-2 py-1 text-lg   text-white ">Welcome to BR104 – Your Relaxing Holiday Hideaway in Bali Residence!</span>
                        <div class="flex items-center mt-2">
                                <span class="text-xl font-bold">$3,422</span>
                                <span class="text-sm ml-2">4 Beds · 3 Baths · 4621 sqft</span>
                            </div>
                        </div>
                        <span class="eye-icon" style="font-size: 1.2rem;">
                            <div class="flex items-center gap-1  px-2 py-1 rounded">
                                <svg class="w-6 h-6" fill="none" stroke="#CCCCCC" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>

                            </div>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Second Row: 3 Posts -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Card 3 -->
                <div class="card-overlay bg-white overflow-hidden transform transition duration-300">
                    <img src="http://127.0.0.1:8000/storage/card_22182601-0825553001750953303_6863625579565.webp" alt="Apartment on Grand Avenue">
                    <div class="overlay-content">
                        <div>
                        <span class="inline-block px-2 py-1 text-lg  text-white ">Welcome to BR104 – Your Relaxing Holiday Hideaway in Bali Residence!</span>
                        <div class="flex items-center mt-2">
                                <span class="text-xl font-bold">$1,500/mo</span>
                                <span class="text-sm ml-2">3 Beds · 2 Baths · 2480 sqft</span>
                            </div>
                        </div>
                        <span class="eye-icon" style="font-size: 1.2rem;">
                            <div class="flex items-center gap-1  px-2 py-1 rounded">
                                <svg class="w-6 h-6" fill="none" stroke="#CCCCCC" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>

                            </div>
                        </span>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="card-overlay bg-white overflow-hidden transform transition duration-300">
                    <img src="http://127.0.0.1:8000/storage/card_22182601-0825553001750953303_6863625579565.webp" alt="Contemporary Apartment">
                    <div class="overlay-content">
                        <div>
                        <span class="inline-block px-2 py-1 text-lg   text-white ">Welcome to BR104 – Your Relaxing Holiday Hideaway in Bali Residence!</span>
                        <div class="flex items-center mt-2">
                                <span class="text-xl font-bold">$120/mo</span>
                                <span class="text-sm ml-2">1 Bed · 1 Bath · 1660 sqft</span>
                            </div>
                        </div>
                        <span class="eye-icon" style="font-size: 1.2rem;">
                            <div class="flex items-center gap-1  px-2 py-1 rounded">
                                <svg class="w-6 h-6" fill="none" stroke="#CCCCCC" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>

                            </div>
                        </span>
                    </div>
                </div>


                <div class="card-overlay bg-white overflow-hidden transform transition duration-300">
                    <img src="http://127.0.0.1:8000/storage/card_22182601-0825553001750953303_6863625579565.webp" alt="Awesome family Apartment">
                    <div class="overlay-content">
                        <div>
                        <span class="inline-block px-2 py-1 text-lg   text-white ">Welcome to BR104 – Your Relaxing Holiday Hideaway in Bali Residence!</span>
                        <div class="flex items-center mt-2">
                                <span class="text-xl font-bold">$345</span>
                                <span class="text-sm ml-2">3 Beds · 5 Baths · 3356 sqft</span>
                            </div>
                        </div>
                        <span class="eye-icon" style="font-size: 1.2rem;">
                            <div class="flex items-center gap-1  px-2 py-1 rounded">
                                <svg class="w-6 h-6" fill="none" stroke="#CCCCCC" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>

                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-700 py-20">
    <div class="container mx-auto px-20 ">
        <h2 class="text-3xl font-bold text-center text-white mb-10">Why Choose Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 place-items-center">
            <!-- Feature 1 -->
            <div style="border-top: 4px solid yellow" class=" border-yellow-300 p-8 gap-4 flex text-white transform hover:-translate-y-2 transition-transform duration-300">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ms-5">
                    <h3 class="text-xl font-semibold text-white mb-2">Trusted by Thousands</h3>
                    <p class="text-gray-200">We have a proven track record of success, with thousands of satisfied clients who have found their dream homes with us.</p>
                </div>
            </div>
            <!-- Feature 1 -->
            <div style="border-top: 4px solid yellow" class=" border-yellow-300 p-8 gap-4 flex text-white transform hover:-translate-y-2 transition-transform duration-300">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ms-5">
                    <h3 class="text-xl font-semibold text-white mb-2">Trusted by Thousands</h3>
                    <p class="text-gray-200">We have a proven track record of success, with thousands of satisfied clients who have found their dream homes with us.</p>
                </div>
            </div>
            <!-- Feature 1 -->
            <div style="border-top: 4px solid yellow" class=" border-yellow-300 p-8 gap-4 flex text-white transform hover:-translate-y-2 transition-transform duration-300">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ms-5">
                    <h3 class="text-xl font-semibold text-white mb-2">Trusted by Thousands</h3>
                    <p class="text-gray-200">We have a proven track record of success, with thousands of satisfied clients who have found their dream homes with us.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- New Latest News Section -->
<section class="bg-white py-10">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-black mb-6 text-center">Latest News</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- News Item 1 -->
            <div class="flex gap-10 p-4">
                <div class="flex flex-col justify-start mb-6 me-6 px-6">
                    <div class="border border-yellow-400 p-6">
                        <span class="bg-white text-blue-800 text-2xl font-semibold px-2 py-1 rounded">1</span>
                        <span class="text-gray-500 text-md ml-2">MAY</span>
                    </div>
                </div>
                <div class="text-start ms-6s">
                    <h3 class="text-lg font-semibold text-black mb-2">Dating With A Objective</h3>
                    <p class="text-black text-sm">A revitalizing and fascinating occasion can be had while dating. Additionally, it may drain your strength. For some, dating is a means of finding a lifelong partner for a marria...</p>
                </div>
            </div><!-- News Item 1 -->
            <div class="flex gap-10 p-4">
                <div class="flex flex-col justify-start mb-6 me-6 px-6">
                    <div class="border border-yellow-400 p-6">
                        <span class="bg-white text-blue-800 text-2xl font-semibold px-2 py-1 rounded">1</span>
                        <span class="text-gray-500 text-md ml-2">MAY</span>
                    </div>
                </div>
                <div class="text-start ms-6s">
                    <h3 class="text-lg font-semibold text-black mb-2">Dating With A Objective</h3>
                    <p class="text-black text-sm">A revitalizing and fascinating occasion can be had while dating. Additionally, it may drain your strength. For some, dating is a means of finding a lifelong partner for a marria...</p>
                </div>
            </div>
            <!-- News Item 1 -->
            <div class="flex gap-10 p-4">
                <div class="flex flex-col justify-start mb-6 me-6 px-6">
                    <div class="border border-yellow-400 p-6">
                        <span class="bg-white text-blue-800 text-2xl font-semibold px-2 py-1 rounded">1</span>
                        <span class="text-gray-500 text-md ml-2">MAY</span>
                    </div>
                </div>
                <div class="text-start ms-6s">
                    <h3 class="text-lg font-semibold text-black mb-2">Dating With A Objective</h3>
                    <p class="text-black text-sm">A revitalizing and fascinating occasion can be had while dating. Additionally, it may drain your strength. For some, dating is a means of finding a lifelong partner for a marria...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Partners Section -->
<section class="bg-[#F6F6F6] py-10">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold text-black mb-6">Our Partners</h2>
        <div class="flex justify-center items-center gap-8 flex-wrap">
            <!-- Partner 1 -->
            <div class="text-center">
                <div class="w-32 h-16 bg-gray-200 flex items-center justify-center text-gray-800 font-semibold">High-Rise Real Estate Company</div>
            </div>
            <!-- Partner 2 -->
            <div class="text-center">
                <div class="w-32 h-16 bg-gray-200 flex items-center justify-center text-gray-800 font-semibold">Mark & Co. Buildings</div>
            </div>
            <!-- Partner 3 -->
            <div class="text-center">
                <div class="w-32 h-16 bg-gray-200 flex items-center justify-center text-gray-800 font-semibold">Real Estate Experts</div>
            </div>
            <!-- Partner 4 -->
            <div class="text-center">
                <div class="w-32 h-16 bg-gray-200 flex items-center justify-center text-gray-800 font-semibold">Home Design</div>
            </div>
        </div>
    </div>
</section>
   
</div>