@props(['images' => [], 'alt' => ''])
<div class="relative" :class="largeSlider ? 'z-50' : ''" x-data="data()" x-init="slideInit()">

    <script>
        function data() {
            return {
                galleryThumbs: null, swiper: null, largeSlider: false,
                slideInit(initialSlide = 0) {
                    this.galleryThumbs = new Swiper('.gallery-thumbs', {
                        spaceBetween: 10,
                        slidesPerView: 3,
                        freeMode: true,
                        lazy: true,
                        watchSlidesVisibility: true,
                        watchSlidesProgress: true,
                        breakpoints: {
                            640: {
                                slidesPerView: 5,
                            },
                            768: {
                                slidesPerView: 5,
                            },
                            1024: {
                                slidesPerView: 7,
                            },
                        },

                    });

                    this.swiper = new Swiper('.swiper-large', {
                        initialSlide: initialSlide,
                        loop: true,
                        loopFillGroupWithBlank: true,
                        spaceBetween: 10,
                        // {{-- cssMode: true, --}}
                        autoHeight: true,
                        grabCursor: true,
                        speed: 400,
                        keyboard: {
                            enabled: true,
                        },
                        zoom: true,
                        lazy: true,
                        // autoplay: true,
                        // {{-- to make it work for large slider --}}
                        // {{-- https://stackoverflow.com/questions/43770106/swiper-slider-not-working-unless-page-is-resized --}}
                        observer: true,
                        observeParents: true,
                        // {{-- end --}}
                        loop: true,
                        thumbs: {
                            swiper: this.galleryThumbs
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            type: 'fraction',
                        },
                    });
                },
            }
        }
    </script>

    <div x-ref="scroll" @keyup.left.window="$refs.scroll.scrollIntoView({behavior: 'smooth', block: 'start'})"
        @keyup.right.window="$refs.scroll.scrollIntoView({behavior: 'smooth', block: 'start'})" class="absolute left-0 -mt-14"></div>

    <style>
        .swiper-container {
            width: 100%;
        }

        .swiper-slide {
            background-repeat: no-repeat;
            /* max-height: 800px; */
        }

        .gallery-thumbs .swiper-slide {
            opacity: 1;
            max-height: 70px;
            width: auto;
        }

        .gallery-thumbs .swiper-slide-thumb-active {
            opacity: 0.4;
        }
    </style>

    <a x-show="largeSlider == true" x-cloak href="#" @click.prevent="largeSlider = false;" x-on:keydown.escape.window="largeSlider = false;"
        class="bg-red-600 fixed p-0.5 right-10 rounded-full text-white top-10 z-10">
        <x-icon.icon path="M6 18L18 6M6 6l12 12" />
    </a>

    <div :class="largeSlider ? 'fixed inset-0 bg-gray-900' : ''" :style="largeSlider ? 'height: 100vh!important' : ''">

        {{-- Thumbnails --}}
        <div x-show="!largeSlider" class="overflow-hidden swiper-container gallery-thumbs" x-ref="thumbs">
            <div class="flex items-center swiper-wrapper">
                @forelse ($images as $image)
                <img class="object-cover border rounded swiper-slide swiper-lazy" data-src="{{Storage::url('thumb_' . $image->path) }}"
                    @click="$refs.scroll.scrollIntoView({behavior: 'smooth', block: 'start'});" alt="{{$alt}}" />
                @empty
                <img class="object-cover rounded swiper-slide" src="{{ asset('assets/images/nia.jpg') }}" alt="No image available" />
                @endforelse
            </div>
        </div>

        <p :class="largeSlider ? 'text-blue-200 justify-center' : 'text-blue-600'"
            class="flex items-center gap-3 mt-3 mb-2 text-sm font-bold md:text-md">
            <span class="flex items-center gap-1">
                <x-icon.solid-icon
                    path="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
                {{__('Double click on image to zoom.')}}
            </span>
            <span class="items-center hidden gap-1 lg:flex">
                <x-icon.solid-icon
                    path="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
                {{__('Press escape to exit.')}}
            </span>
        </p>

        {{-- Main Slide --}}
        <div class="relative">

            {{-- <div :class="largeSlider ? '' : 'overflow-hidden'" class="mt-2 swiper-container md:mt-0" x-ref="top"> --}}
                <div class="mt-2 overflow-hidden swiper-container swiper-large md:mt-0" x-ref="top">
                    {{-- Slider --}}
                    <div class="flex items-center swiper-wrapper">
                        @forelse ($images as $image)

                        <div @click.prevent="largeSlider = true;" class="swiper-slide">
                            <div class="swiper-zoom-container">
                                <img class="object-contain rounded swiper-lazy" :class="largeSlider ? 'h-screen' : ''"
                                    data-src="{{ Storage::url($image->path) }}" alt="{{$alt}}" />
                            </div>
                            <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                        </div>

                        @empty
                        <img @click.prevent="largeSlider = true;" class="object-cover rounded swiper-slide" src="{{ asset('assets/images/nia.jpg') }}"
                            alt="No image available" />
                        @endforelse
                    </div>

                    <div style="position: relative; max-width: 70px;" :class="largeSlider ? '-mt-20' : ''"
                        class="mx-auto text-xs text-white border border-white rounded shadow sm:text-sm lg:text-lg swiper-pagination bg-logo-blue-dark">
                    </div>

                </div>

                <div :class="largeSlider ? 'left-3' : '-left-3'" class="absolute inset-y-0 z-10 flex items-center">
                    <button @click="swiper.slidePrev(); $refs.scroll.scrollIntoView({behavior: 'smooth', block: 'start'});"
                        class="p-1 border border-white slider-btn blue-gradient tooltip">
                        <x-icon.solid-icon
                            path="M15.707 15.707a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 010 1.414zm-6 0a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414l5-5a1 1 0 011.414 1.414L5.414 10l4.293 4.293a1 1 0 010 1.414z" />
                        {{-- <span class="tooltiptext tt-right">{{__('Press left arrow go previous')}}</span> --}}
                    </button>
                </div>

                <div :class="largeSlider ? 'right-3' : '-right-3'" class="absolute inset-y-0 z-10 flex items-center">
                    <button @click="swiper.slideNext(); $refs.scroll.scrollIntoView({behavior: 'smooth', block: 'start'});"
                        class="p-1 border border-white slider-btn blue-gradient tooltip">
                        <x-icon.solid-icon
                            path="M10.293 15.707a1 1 0 010-1.414L14.586 10l-4.293-4.293a1 1 0 111.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                            path2="M4.293 15.707a1 1 0 010-1.414L8.586 10 4.293 5.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z" />
                        {{-- <span class="tooltiptext">{{__('Press right arrow go next')}}</span> --}}
                    </button>
                </div>


            </div>

        </div>
    </div>