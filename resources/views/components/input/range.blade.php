@props(['price', 'isHome' => false])
<div x-data="range()" x-init="mintrigger(); maxtrigger()" class="flex items-center md:col-span-2 lg:col-span-1">
    <style>
        input[type=range]::-webkit-slider-thumb {
            pointer-events: all;
            width: 24px;
            height: 24px;
            -webkit-appearance: none;
        }
    </style>

    <div class="relative w-full">
        <div>
            <input type="range" step="100" x-bind:min="min" x-bind:max="max" x-on:input="mintrigger" wire:model="price.min" x-model="minprice"
                class="absolute z-20 w-full h-2 opacity-0 appearance-none cursor-pointer pointer-events-none">
            <input type="range" step="100" x-bind:min="min" x-bind:max="max" x-on:input="maxtrigger" wire:model="price.max" x-model="maxprice"
                class="absolute z-20 w-full h-2 opacity-0 appearance-none cursor-pointer pointer-events-none">

            <div class="relative z-10 h-2">

                <div class="absolute top-0 bottom-0 left-0 right-0 z-10 bg-gray-200 rounded-md"></div>

                <div class="absolute top-0 bottom-0 z-20 rounded-md bg-gradient-to-r blue-gradient"
                    x-bind:style="'right:'+maxthumb+'%; left:'+minthumb+'%'"></div>

                <div class="absolute top-0 left-0 z-30 w-6 h-6 -mt-2 rounded-full bg-logo-blue" x-bind:style="'left: '+minthumb+'%'"></div>

                <div class="absolute top-0 right-0 z-30 w-6 h-6 -mt-2 rounded-full bg-logo-purple" x-bind:style="'right: '+maxthumb+'%'"></div>

            </div>

        </div>

        <div class="flex items-center gap-1 pt-3">
            {{-- <input wire:model="price.min" type="text" @input.debounce.500ms="mintrigger" x-model="minprice" class="flex-1 px-1 text-center w-min"> --}}
            <input wire:model="price.min" type="text" @blur="mintrigger" x-model="minprice" class="flex-1 px-1 text-center w-min">

            <span class="flex-wrap flex-1 font-semibold text-center">{{ __('Price (lakh)') }}</span>

            {{-- <input wire:model="price.max" type="text" @input.debounce.500ms="maxtrigger" x-model="maxprice" class="flex-1 px-1 text-center w-min"> --}}
            <input wire:model="price.max" type="text" @blur="maxtrigger" x-model="maxprice" class="flex-1 px-1 text-center w-min">
        </div>

    </div>

    <script>
        function range() {
                return {
                    minprice: {{$price['min'] ?: 0}},
                    maxprice: {{$price['max'] ?: 0}},
					
                    // min & max prices from all properties
                    min: {{$price['all_min'] ?: 0}},
                    max: {{$price['all_max'] ?: 0}},
                    minthumb: 0,
                    maxthumb: 0,
                    mintrigger() {
                        this.validation();
                        this.minprice = Math.min(this.minprice, this.maxprice - 1);
                        this.minthumb = ((this.minprice - this.min) / (this.max - this.min)) * 100;
                    },
                    maxtrigger() {
                        this.validation();
                        this.maxprice = Math.max(this.maxprice, this.minprice + 1);
                        this.maxthumb = 100 - (((this.maxprice - this.min) / (this.max - this.min)) * 100);
                    },
                    validation() {
                        if (/^\d*$/.test(this.minprice)) {
                            if (this.minprice > this.max) {
                                this.minprice = 9500;
                            }
                            if (this.minprice < this.min) {
                                this.minprice = this.min;
                            }
                        } else {
                            this.minprice = 0;
                        }
                        if (/^\d*$/.test(this.maxprice)) {
                            if (this.maxprice > this.max) {
                                this.maxprice = this.max;
                            }
                            if (this.maxprice < this.min) {
                                this.maxprice = 200;
                            }
                        } else {
                            this.maxprice = 10000;
                        }
                    }
                }
            }
    </script>

</div>