<div x-data="{compareOpen: $persist(true)}" class="fixed right-0 z-30 flex items-start">
    @if (count($compareProperties) > 0)
    <a @click.prevent="compareOpen = !compareOpen" x-show="compareOpen" href="#"
        class="absolute bg-red-600 p-0.5 right-2 rounded-full text-white top-2 z-10">
        <x-icon.icon class="w-8 h-8 p-0.5" :add-class="true" path="M6 18L18 6M6 6l12 12" />
    </a>

    <a @click.prevent="compareOpen = !compareOpen" x-show="!compareOpen" href="#"
        class="absolute bg-logo-blue-dark p-0.5 right-2 rounded-full text-white top-2 z-10 ">
        <x-icon.solid-icon class="w-8 h-8 p-0.5" :add-class="true"
            path="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z" />
    </a>

    <div x-show="compareOpen" x-cloak x-transition:enter="ease-out" x-transition:enter-start="opacity-0 translate-x-full"
        x-transition:enter-end="opacity-100 traslate-x-0" x-transition:leave="ease-in" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="relative p-3 transition duration-200 ease-in-out bg-white border border-gray-100 rounded-tl rounded-bl shadow-raised w-60">

        <h3 class="mb-3 text-lg font-bold ">Compare Listings</h3>
        <div class="grid grid-cols-2 gap-2">
            @foreach ($compareProperties as $ppt)
            <div class="relative">
                <img class="w-full h-20 rounded"
                    src="{{$ppt->images->first() ? Storage::url($ppt->images->first()->path) : asset('assets/images/nia.jpg')}}" alt="" />

                <a wire:click.prevent="removeCompare({{$ppt->id}})" class="absolute z-10 text-white bg-red-600 rounded-full top-1 right-1" href="#">
                    <x-icon.icon path="M18 12H6" />
                </a>
            </div>
            @endforeach
        </div>

        <a href="{{LaravelLocalization::localizeUrl('/compare-properties')}}"
            class="justify-center w-2/3 gap-2 mx-auto mt-2 btn bg-gradient-to-r blue-gradient">
            <x-icon.icon path="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
            @lang('Compare')
        </a>
    </div>

    @endif
</div>