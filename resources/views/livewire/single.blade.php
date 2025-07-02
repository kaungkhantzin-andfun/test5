<article class="grid-cols-3 gap-6 px-4 mx-auto my-4 space-y-6 md:container lg:space-y-0 md:my-6 xl:px-0 lg:grid lg:my-8">

    {{-- Title, Agent and Slider --}}
    <div class="relative col-span-2 space-y-4">
        <header class="flex justify-between gap-6">
            @php
            // getting translation from model attribute would cost extra queries
            // thus eager loaded and getting translations like this
            $translation = $property->detail->where('locale',
            app()->getLocale())->first() ?:
            $property->detail->first();
            @endphp
            <h1 class="text-lg font-bold leading-7 lg:leading-9 md:text-xl lg:text-2xl text-gradient">
                {{$translation->title}}
            </h1>
        </header>

        <div class="items-center sm:justify-between sm:flex">
            {{-- Total Views --}}
            <div class="mb-2 sm:flex sm:gap-6">
                <x-readable-date :date="$property->created_at" />

                <div class="flex items-center gap-2 text-sm">
                    <x-icon.icon path="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        path2="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    {{ number_format($property->stat) }} {{ __('Views') }}
                </div>
            </div>

            <div class="flex justify-between gap-6">
                {{-- Save/Unsave --}}
                {{-- if the current user saved this property --}}
                @if (in_array($property->id, $savedPropertyIds))
                <a wire:click.prevent="unsave"
                    class="flex items-center justify-center gap-1 px-2 py-1 text-sm text-white rounded-full shadow bg-gradient-to-tr from-logo-green to-logo-green-light"
                    href="#">
                    <x-icon.solid-icon
                        path="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" />
                    <span>{{__('Saved')}}</span>
                </a>
                @else
                <a wire:click.prevent="save" class="flex items-center justify-between gap-1 px-2 py-1 text-sm border rounded-full shadow" href="#">
                    <x-icon.icon
                        path="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    <span>{{__('Save')}}</span>
                </a>
                @endif

                {{-- Compare/not compare --}}
                {{-- $compareIds is coming from AppServiceProvider --}}
                @if (in_array($property->id, $compareIds))
                <a wire:click.prevent="removeCompare({{$property->id}})"
                    class="flex items-center justify-center gap-1 px-2 py-1 text-sm text-white rounded-full shadow bg-gradient-to-tr from-logo-blue to-logo-blue-light"
                    href="#">
                    <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                    <span>{{__('Remove Compare')}}</span>
                </a>

                @else
                <a wire:click.prevent="compare({{$property->id}})"
                    class="flex items-center justify-between gap-1 px-2 py-1 text-sm border rounded-full shadow" href="#">
                    <x-icon.solid-icon path="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    <span>{{__('Compare')}}</span>
                </a>
                @endif
            </div>
        </div>

        <div wire:ignore>
            <x-thumb-slider :images="$property->images" :alt="$translation->title" />
        </div>

    </div>

    {{-- First Row's Sidebar --}}
    <div> {{-- empty wrapper is needed for sticky --}}
        <div x-data="{showModal: false}" @keyup.escape.window="showModal = false" :class="showModal ? 'z-30' : 'z-20'" class="sticky top-0 space-y-8">

            <section class="sticky top-0 z-10 bg-white lg:top-12">
                <h2 class="single-h2">{{__('Contact Information')}}</h2>
                <div x-data="{}"
                    class="flex flex-col items-center justify-between gap-4 p-4 border border-gray-200 rounded md:flex-row lg:flex-col shadow-raised">
                    {{-- Uploader information --}}
                    @if (!empty($property->user))
                    <div class="flex items-center gap-2 overflow-hidden text-left">
                        <a class="w-12 h-12 overflow-hidden rounded-full"
                            href="{{LaravelLocalization::localizeUrl('/real-estate-agents') . '/' . $property->user->slug}}">
                            <img class="object-cover w-12 h-12"
                                src="{{ $property->user->profile_photo_path != null ? Storage::url($property->user->profile_photo_path) : asset('assets/images/nia.jpg') }}"
                                alt="">
                        </a>

                        <div class="truncate">
                            <a class="font-semibold text-logo-blue-dark"
                                href="{{LaravelLocalization::localizeUrl('/real-estate-agents') . '/' . $property->user->slug}}">{{
                                $property->user->name }}</a>
                        </div>
                    </div>
                    @endif

                    <x-notices />

                    @php
                    if ($property->purpose->id==1) {
                    $propertyId = "MHS-" . $property->id;
                    } else if ($property->purpose->id==2) {
                    $propertyId = "MHR-" . $property->id;
                    } else {
                    $propertyId = "MH-" . $property->id;
                    }
                    @endphp

                    <div @click="$clipboard('{{$propertyId}}'); $dispatch('notice', {'type': 'success', 'text': '{{$propertyId}} copied!'});"
                        class="flex items-center gap-2 text-sm tooltip">
                        <span class="font-bold">{{ __('Property ID') }}:</span>
                        <span class="flex items-center gap-2 bg-gray-100 border btn">{{$propertyId}}
                            <x-icon.icon
                                path="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </span>
                        <span class="tooltiptext">Click to copy</span>
                    </div>

                    <a @click.prevent="showModal=true" href="#"
                        class="flex items-center gap-2 px-3 py-2 text-sm text-white rounded bg-gradient-to-tr blue-gradient">
                        <x-icon.icon path="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        {{ __('Contact Ad Owner') }}
                    </a>

                    {{-- Contact to ad owner modal --}}
                    <div x-show="showModal" x-cloak x-transition.duration.300ms
                        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60">
                        <div @click.away="showModal = false" class="relative w-full p-4 mx-2 bg-white rounded shadow-2xl sm:max-w-md">

                            <a href="#" @click.prevent="showModal = false" class="absolute p-0.5 text-white bg-red-600 rounded-full -right-2 -top-2">
                                <x-icon.icon path="M6 18L18 6M6 6l12 12" />
                            </a>

                            <h2 class="mb-2 h3">{{ __('Send enquiry to the ad
                                owner') }}</h2>

                            <livewire:contact-form :property="$property" msg="{{__('mytranslations.contact_msg', ['propertyId' => $propertyId])}}" />
                        </div>
                    </div>

                </div>
            </section>

            @if (!empty($property->type) &&
            !in_array(Str::lower($property->type->name), ['land', 'warehouse']))
            <section>
                <h2 class="single-h2">{{__('Property Features')}}</h2>
                <div class="p-4 space-y-4 border border-gray-200 rounded shadow-raised">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-3 tooltip">
                            <i class="text-white icon-circle fas fa-bed fa-sm bg-logo-blue"></i>
                            <span>{{ __($property->beds) }}</span>
                            <span class="hidden text-gray-400 sm:block lg:hidden 2xl:block 2xl:text-sm 2xl:font-bold">{{__('Bed
                                rooms')}}</span>
                            <span class="tooltiptext">{{ __('Bed rooms')
                                }}</span>
                        </span>

                        <span class="flex items-center gap-3 tooltip">
                            <i class="text-white bg-logo-purple fa-bath fas icon-circle"></i>
                            <span>{{ __($property->baths) }}</span>
                            <span class="hidden text-gray-400 sm:block lg:hidden 2xl:block 2xl:text-sm 2xl:font-bold">{{__('Bath
                                rooms')}}</span>
                            <span class="tooltiptext">{{ __('Bath rooms')
                                }}</span>
                        </span>

                        <span class="flex items-center gap-3 tooltip">
                            <i class="text-white bg-gray-700 icon-circle fas fa-parking"></i>
                            <span>{{ __($property->parking) }}</span>
                            <span class="hidden text-gray-400 sm:block lg:hidden 2xl:block 2xl:text-sm 2xl:font-bold">{{__('Car
                                parkings')}}</span>
                            <span class="tooltiptext">{{ __('Car parkings')
                                }}</span>
                        </span>
                    </div>
                </div>
            </section>
            @endif

            <section>
                <h2 class="single-h2">{{__('Property Details')}}</h2>
                <div class="p-4 space-y-4 border border-gray-200 rounded shadow-raised">
                    @if (!empty($property->type))
                    <div class="w-full tooltip">
                        <span class="flex items-center gap-2 text-logo-green">
                            <div class="p-1 bg-green-600 icon-circle">
                                <x-icon.icon class="text-white" :add-class="true"
                                    path="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </div>
                            <a class="text-logo-green hover:underline"
                                href="{{LaravelLocalization::localizeUrl('/search/' . $property->type->slug .'/all-purposes/all-regions/all-townships')}}">
                                {{__($property->type->name)}}
                            </a>
                        </span>
                        <span class="tooltiptext">Property Type</span>
                    </div>
                    @endif

                    <div class="flex gap-2">
                        <span class="tooltip">
                            <span class="flex items-center gap-2 text-logo-blue">
                                <div class="icon-circle bg-logo-blue">
                                    <x-icon.solid-icon class="text-white" :add-class="true"
                                        path="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" />
                                </div>

                                @if (!empty($property->purpose))
                                <a class="text-logo-blue hover:underline"
                                    href="{{LaravelLocalization::localizeUrl('/search/properties/' . $property->purpose->slug .'/all-regions/all-townships')}}">{{$property->purpose->name}}</a>
                                @endif

                                @if (!empty($property->user) &&
                                $property->user->role == 'user')
                                <span class="text-sm font-bold text-logo-purple">({{__('By
                                    Owner')}})</span>
                                @endif
                            </span>
                            <span class="tooltiptext">{{ __('Purpose') }}</span>
                        </span>
                    </div>

                    <div class="flex items-center gap-2 tooltip text-logo-purple">
                        <i class="mr-1 text-white fas icon-circle bg-logo-purple fa-ruler-combined"></i>
                        <span class="tooltiptext">{{ __('Area') }}</span>

                        @php
                        // preparing area field
                        // read more about @ operator:
                        https://www.php.net/manual/en/language.operators.errorcontrol.php
                        $area = @unserialize($property->area);// return false if area is not serialized string which is
                        @endphp

                        @if ($area !== false)
                        @foreach ($area as $key => $value)
                        @if ($key == 'length_width')
                        {{ $value[0] }}
                        x
                        {{ $value[1] }}
                        @else
                        {{ $value }}
                        {{ Str::of($key)->replace('_', ' ')->title()}}
                        @endif
                        @endforeach
                        @else
                        {{ $property->area }}
                        @endif
                    </div>

                    <div class="w-full tooltip">
                        <span class="flex items-center gap-2 text-logo-green">
                            <div class="icon-circle bg-logo-green">
                                {{--
                                <x-icon.solid-icon class="text-white" :add-class="true"
                                    path="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" />
                                --}}
                                <x-icon.icon class="text-white" :add-class="true"
                                    path="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </div>
                            {{ floatval($property->price) }} {{ __('Lakhs') }}

                            @if ($property->purpose->id !== 2)

                            <span class="flex gap-2 text-sm font-bold text-logo-purple">
                                (

                                {{__('Installment')}}
                                @if ($property->installment == 'yes')
                                <x-icon.solid-icon class="text-logo-green" :add-class="true"
                                    path="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                @else
                                <x-icon.solid-icon class="text-red-500" :add-class="true"
                                    path="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" />
                                @endif
                                )
                            </span>

                            @endif


                        </span>
                        <span class="tooltiptext">{{__('Price')}}</span>
                    </div>

                    <div class="w-full tooltip">
                        {{-- Location --}}
                        <div class="flex items-center gap-2 text-logo-blue">
                            <div class="icon-circle bg-logo-blue">
                                <x-icon.solid-icon class="text-white" :add-class="true"
                                    path="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" />
                            </div>
                            <span>
                                @php
                                $tsp =
                                $property->location->whereNotNull('parent_id')->first();
                                $region =
                                $property->location->whereNull('parent_id')->first();
                                // split string by last space
                                $reg=preg_split("/\s+(?=\S*+$)/",
                                $region->name);
                                @endphp

                                <a class="text-logo-blue hover:underline"
                                    href="{{LaravelLocalization::localizeUrl('/search/properties/all-purposes/' . $region->slug . '/' . $tsp->slug)}}">{{trans($tsp->name)}}</a>{{',
                                '}}

                                <a class="text-logo-blue hover:underline"
                                    href="{{LaravelLocalization::localizeUrl('/search/properties/all-purposes/' . $region->slug . '/all-townships')}}">
                                    {{ trans($reg[0] ?? '') . ' ' . trans($reg[1] ?? '') }}
                                </a>
                            </span>
                        </div>
                        <span class="tooltiptext">{{__('Location')}}</span>
                    </div>
                </div>
                <span class="tooltiptext">{{__('Location')}}</span>
            </section>

            <section>
                <h2 class="single-h2">{{__('Book this Property')}}</h2>
                <div class="p-4 space-y-4 border border-gray-200 rounded shadow-raised">
                    @if (session()->has('success'))
                        <div class="p-4 text-white bg-green-500 rounded">
                            {{ session('success') }}
                            @if (session()->has('booking_details'))
                                <p>{{__('Check-in Date')}}: {{ session('booking_details')['check_in_date'] }}</p>
                                <p>{{__('Check-out Date')}}: {{ session('booking_details')['check_out_date'] }}</p>
                                <p>{{__('Number of Guests')}}: {{ session('booking_details')['number_of_guests'] }}</p>
                            @endif
                        </div>
                    @endif
                    <form wire:submit.prevent="booking">
                        <div class="mb-4">
                            <label for="check_in_date" class="block text-sm font-medium text-gray-700">{{__('Check-in Date')}}</label>
                            <input type="date" id="check_in_date" wire:model="check_in_date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('check_in_date') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="check_out_date" class="block text-sm font-medium text-gray-700">{{__('Check-out Date')}}</label>
                            <input type="date" id="check_out_date" wire:model="check_out_date" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('check_out_date') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label for="number_of_guests" class="block text-sm font-medium text-gray-700">{{__('Number of Guests')}}</label>
                            <input type="number" id="number_of_guests" wire:model="number_of_guests" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('number_of_guests') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">{{__('Book Now')}}</button>
                    </form>
                </div>
            </section>
        </div>
    </div>

    <section class="col-span-2">
        <h2 class="single-h2">{{ __('Property Description') }}</h2>
        <div class="p-4 prose border border-gray-200 rounded max-w-none shadow-raised">
            <div class="prose related_searches">
                {!! $translation->detail !!}

                {{-- related search internal links --}}
                <h3 class="text-gradient">{{__('You might also be interested in:')}}</h3>

                <ul>
                    @if (app()->getLocale() == 'my')
                    {{-- type purpose in township --}}
                    <li>
                        <a href="/search/{{$property->type->slug}}/{{$property->purpose->slug}}/{{$region->slug}}/{{$tsp->slug}}">
                            {{trans($tsp->name)}}မြို့နယ်ရှိ {{__($property->purpose->name)}} {{__($property->type->name)}}များ
                        </a>
                    </li>
                    {{-- type purpose in region --}}
                    <li>
                        <a href="/search/{{$property->type->slug}}/{{$property->purpose->slug}}/{{$region->slug}}/all-townships">
                            {{ trans($reg[0] ?? '')}}ရှိ {{__($property->purpose->name)}} {{__($property->type->name)}}များ
                        </a>
                    </li>
                    {{-- type in township --}}
                    <li>
                        <a href="/search/{{$property->type->slug}}/all-purposes/{{$region->slug}}/{{$tsp->slug}}">
                            {{trans($tsp->name)}}မြို့နယ်ရှိ {{__($property->type->name)}}များ
                        </a>
                    </li>
                    {{-- type in region --}}
                    <li>
                        <a href="/search/{{$property->type->slug}}/all-purposes/{{$region->slug}}/all-townships">
                            {{ trans($reg[0] ?? '')}}ရှိ {{__($property->type->name)}}များ
                        </a>
                    </li>
                    {{-- properties purpose in township --}}
                    <li>
                        <a href="/search/properties/{{$property->purpose->slug}}/{{$region->slug}}/{{$tsp->slug}}">
                            {{trans($tsp->name)}}မြို့နယ်ရှိ {{__($property->purpose->name)}} အိမ်ခြံမြေများ
                        </a>
                    </li>
                    {{-- properties purpose in region --}}
                    <li>
                        <a href="/search/properties/{{$property->purpose->slug}}/{{$region->slug}}/all-townships">
                            {{ trans($reg[0] ?? '')}}ရှိ {{__($property->purpose->name)}} အိမ်ခြံမြေများ
                        </a>
                    </li>
                    @else
                    {{-- type purpose in township --}}
                    <li>
                        <a href="/en/search/{{$property->type->slug}}/{{$property->purpose->slug}}/{{$region->slug}}/{{$tsp->slug}}">
                            {{__(Str::plural($property->type->name))}} {{__($property->purpose->name)}} in {{trans($tsp->name)}}
                        </a>
                    </li>
                    {{-- type purpose in region --}}
                    <li>
                        <a href="/en/search/{{$property->type->slug}}/{{$property->purpose->slug}}/{{$region->slug}}/all-townships">
                            {{__(Str::plural($property->type->name))}} {{__($property->purpose->name)}} in {{ trans($reg[0] ?? '')}}
                        </a>
                    </li>
                    {{-- type in township --}}
                    <li>
                        <a href="/en/search/{{$property->type->slug}}/all-purposes/{{$region->slug}}/{{$tsp->slug}}">
                            {{__(Str::plural($property->type->name))}} in {{trans($tsp->name)}}
                        </a>
                    </li>
                    {{-- type in region --}}
                    <li>
                        <a href="/en/search/{{$property->type->slug}}/all-purposes/{{$region->slug}}/all-townships">
                            {{__(Str::plural($property->type->name))}} in {{ trans($reg[0] ?? '')}}
                        </a>
                    </li>
                    {{-- properties purpose in township --}}
                    <li>
                        <a href="/en/search/properties/{{$property->purpose->slug}}/{{$region->slug}}/{{$tsp->slug}}">
                            Properties {{__($property->purpose->name)}} in {{trans($tsp->name)}}
                        </a>
                    </li>
                    {{-- properties purpose in region --}}
                    <li>
                        <a href="/en/search/properties/{{$property->purpose->slug}}/{{$region->slug}}/all-townships">
                            Properties {{__($property->purpose->name)}} in {{ trans($reg[0] ?? '')}}
                        </a>
                    </li>
                    @endif
                    {{-- properties in myanmar --}}
                    <li>
                        <a href="{{LaravelLocalization::localizeUrl('/properties-in-myanmar')}}">{{__('Properties in Myanmar')}}</a>
                    </li>
                </ul>

                {{-- end of related search internal links --}}
            </div>
        </div>
    </section>

    <section>
        <h2 class="single-h2">{{ __('Property Facilities') }}</h2>
        <div class="grid-cols-2 p-4 mt-1 space-y-2 border border-gray-200 rounded sm:grid shadow-raised">
            @foreach ($facilities as $facility)
            <span class="flex items-center gap-1">
                <x-icon.solid-icon class="text-green-600" :add-class="true"
                    path="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                {{ __($facility->name) }}
            </span>
            @endforeach
        </div>
    </section>

    <section class="col-span-3">
        <h3 class="mb-1 h3">{{__('Similar Properties')}}</h3>

        <div class="grid gap-4 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2">
            @forelse ($similarProperties as $property)
            <livewire:property-card :key="time().$property->id" :property="$property" layout="vertical" />
            @empty
            <p>{{__('No similar properties found!')}}</p>
            @endforelse
        </div>
    </section>

</article>