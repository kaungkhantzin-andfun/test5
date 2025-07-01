@if (count($slides) > 1)
<div class="relative z-0" wire:ignore class="component" x-data="{swiper: null}" x-init="[
            swiper = new Swiper($refs.top, {
                autoplay: true,
                loop: 1,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            })]">

    <style>
        .swiper-container {
            width: 100%;
        }

        .swiper-button-prev,
        .swiper-button-next {
            display: none;
        }

        .swiper-slide {
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            max-height: 700px;
        }

        .gallery-top {
            height: 85%;
        }
    </style>

    <!-- Swiper -->
    <div class="overflow-hidden swiper-container gallery-top" x-ref="top">
        <div class="flex items-center swiper-wrapper">
            @foreach ($slides as $slide)
            <x-slider-image class="swiper-slide" :slide="$slide" />
            @endforeach
        </div>
    </div>

</div>
@else
{{-- Single image --}}
@if (count($slides) >= 1)
@foreach ($slides as $slide)
<x-slider-image :slide="$slide" />
@endforeach
@else
<img class="object-cover w-screen min-h-[300px] lg:min-h-[600px]" src="{{ asset('assets/images/nia.jpg') }}" alt="No image available">
@endif
@endif