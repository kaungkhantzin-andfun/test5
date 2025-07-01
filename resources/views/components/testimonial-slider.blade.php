<div x-data="{swiper: null}" x-init="[
        swiper = new Swiper($refs.top, {
            spaceBetween: 10,
            autoplay: true,
            speed: 1500,
            loop: 1,
        })]" class="container mx-auto">

    <style>
        .swiper-container {
            width: 100%;
        }

        .swiper-slide {
            /* background-size: cover; */
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>

    <div class="w-11/12 mx-auto sm:px-4 sm:w-full">
        <!-- Swiper -->
        <div class="overflow-hidden swiper-container gallery-top lg:h-4/6" x-ref="top">
            <div class="swiper-wrapper">
                @forelse ($images as $image)
                {{-- <div class="flex items-center justify-around px-16 swiper-slide"> --}}
                    <div class="flex flex-col items-center lg:flex-row swiper-slide">
                        <img class="max-w-md rounded" src="{{Storage::url($image->path)}}" alt="{{$image->caption ?: ''}}">

                        <div class="relative px-10 mt-4 text-lg font-bold text-white md:text-2xl lg:ml-12 testimonial_detail">
                            {!! $image->caption !!}
                        </div>
                    </div>
                    @empty
                    <div class="rounded swiper-slide" style="background-image:url({{asset('assets/images/nia.jpg')}})"></div>
                    @endforelse
                </div>

                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-white" @click="swiper.slideNext()"></div>
                <div class="swiper-button-prev swiper-button-white" @click="swiper.slidePrev()"></div>
            </div>
        </div>
    </div>