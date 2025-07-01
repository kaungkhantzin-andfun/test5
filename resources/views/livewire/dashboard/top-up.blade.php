<div class="my-6">

    <p class="text-xs font-light text-center md:text-xl">
        {{__('Top up to put your properties in featured section.')}}
    </p>

    <p class="mt-4 font-light text-center text-blue-600 text-md md:text-xl">
        {{__('Featured properties get 10 times more views and sell out faster!')}}
    </p>

    <div x-data="{showModal: false}" class="grid gap-4 mt-4 md:mt-8 lg:gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($packages as $pkg)
        <div class="p-4 rounded lg:px-2 xl:px-4 bg-gradient-to-tr blue-gradient">

            <h3 class="flex items-center justify-center text-xl font-black uppercase">
                {{$pkg->name}}
            </h3>

            <div class="bg-white/70 border border-white leading-7 m-2.5 p-4 lg:p-2 xl:p-4 rounded space-y-4">

                <ul class="text-left text-gray-900">
                    <li class="grid grid-cols-4 gap-3">
                        <span>Credit:</span>
                        <span class="col-span-3">{{number_format($pkg->credit)}} Points</span>
                    </li>
                    <li class="grid items-center grid-cols-4 gap-3">
                        <span>Price:</span>
                        <span class="col-span-3">
                            @if (!empty($pkg->discount) && $pkg->discount != 0)
                            <span class="text-sm text-red-600 line-through">
                                <span class="flex text-black">{{number_format($pkg->price)}} MMK</span>
                            </span>
                            <span class="flex text-red-600">{{number_format(($pkg->price - ($pkg->price * $pkg->discount / 100)))}}
                                MMK</span>
                            @else
                            {{number_format($pkg->price)}} MMK
                            @endif
                        </span>
                    </li>
                </ul>

                <a wire:click="setPackage({{ $pkg }})" @click.prevent="showModal = 'contact'"
                    class="flex justify-center w-1/2 px-4 py-1 mx-auto text-center text-white border border-gray-200 rounded shadow-md hover:shadow-none bg-gradient-to-bl blue-gradient"
                    href="#">
                    {{__('Enquire')}}
                </a>

            </div>
        </div>
        @endforeach

        <div x-show="showModal=='contact'" style="display: none" class="fixed inset-0 bg-gray-900 bg-opacity-60">
            <div @click.away="showModal = false" class="absolute inset-0 max-w-lg p-4 mx-auto my-auto bg-white rounded shadow-2xl"
                style="height: 520px;">
                <a href="#" @click.prevent="showModal = false" class="absolute p-0.5 text-white bg-red-600 rounded-full -right-2 -top-2">
                    <x-icon.icon :class="'h-6 w-6'" :path="'M6 18L18 6M6 6l12 12'" />
                </a>

                <h3 class="mb-4 text-lg md:text-2xl">{{ __('Send enquiry to top up points.') }}</h3>
                <x-notices />

                <livewire:contact-form :credit-page="true" />
            </div>
        </div>
    </div>
</div>