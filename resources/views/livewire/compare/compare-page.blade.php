{{-- <div class="container grid grid-flow-col-dense px-4 mx-auto my-4 overflow-x-scroll overflow-y-visible"> --}}

    <div class="container h-full px-4 mx-auto my-4 bg-white">
        <h1 class="my-8 text-xl xl:text-2xl">{{__('Compare Properties')}}</h1>
        <div class="flex pb-20 overflow-x-auto overflow-y-hidden">
            @if (count($properties) > 0)
            {{-- <div class="sticky left-0 z-20 grid bg-white min-w-max">
                <div class="table-cell h-32 p-2 "></div>
                <div class="table-cell h-10 p-2"></div>
                <div class="table-cell h-10 p-2"></div>
                <div class="table-cell h-10 p-2 bg-gray-100 border">Area</div>
                <div class="table-cell h-10 p-2 border">Bath Rooms</div>
                <div class="table-cell h-10 p-2 bg-gray-100 border">Bed Rooms</div>
                <div class="table-cell h-10 p-2 border">Installment</div>
                <div class="table-cell h-10 p-2 bg-gray-100 border">Location</div>
                <div class="table-cell h-10 p-2 border">Parking</div>
                <div class="table-cell h-10 p-2 bg-gray-100 border">Purpose</div>
                <div class="table-cell h-10 p-2 border">Types</div>
                <div class="table-cell p-2">Facilities</div>
                <div class="table-cell h-10 p-2"></div>
            </div> --}}

            <div class="sticky left-0 z-20 bg-white min-w-max">

                <div class="h-32 p-2"></div>
                <div class="h-10 p-2"></div>
                <div class="h-10 p-2"></div>
                <div class="h-10 p-2 bg-gray-100 border ">Area</div>
                <div class="h-10 p-2 border ">Bath Room</div>
                <div class="h-10 p-2 bg-gray-100 border ">Bed Room</div>
                <div class="h-10 p-2 border ">Installment</div>
                <div class="p-2 bg-gray-100 border h-14 ">Location</div>
                <div class="h-10 p-2 border ">Parking</div>
                <div class="h-10 p-2 bg-gray-100 border ">Purpose</div>
                <div class="h-10 p-2 border ">Type</div>
                <div class="p-2 ">Facility </div>
                <div class="h-10 p-2"></div>

            </div>

            @endif

            @forelse ($properties as $property)

            @php
            $img = $property->images()->first();
            @endphp

            <div x-data="{ open: false }" class="relative grid min-w-max">

                <a href="#" wire:click="removeCompare({{$property->id}})" class="absolute z-10 text-white bg-red-600 rounded-full top-1 right-3">
                    <x-icon.icon path="M18 12H6" class="w-4 h-4" />
                </a>

                <template x-if="!open">

                    <div class="w-60">
                        <div class="h-32 p-2 mx-2 aspect-h-2 aspect-w-1">
                            <img class="object-cover w-full h-full rounded shadow-lg"
                                src="{{$img ? Storage::url($img->path) : asset('assets/images/nia.jpg')}}" />
                        </div>
                        <div class="h-10 p-2 font-semibold">
                            <h3 class="text-xl font-semibold truncate hover:underline text-logo-blue">
                                <a
                                    href="{{LaravelLocalization::localizeUrl('/properties/' . $property->id . '/' . $property->slug)}}">{{$property->translation->title}}</a>
                            </h3>
                        </div>
                        <div class="h-10 p-2 font-semibold">{{$property->price . ' Lahks'}}</div>
                        <div class="h-10 p-2 bg-gray-100 border ">
                            {{-- <span class="font-semibold">Area :</span> --}}
                            @php
                            // preparing area field
                            // read more about @ operator: https://www.php.net/manual/en/language.operators.errorcontrol.php
                            $area = @unserialize($property->area); // return false if area is not serialized string which is
                            @endphp

                            @if ($area !== false)
                            @foreach ($area as $key => $value)
                            @if ($key == 'length_width')
                            {{ $value[0] }}
                            x
                            {{ $value[1] }}
                            @else
                            {{ $value }}
                            {{ $key }}
                            @endif
                            @endforeach
                            @else
                            {{ $property->area }}
                            @endif

                        </div>
                        <div class="h-10 p-2 border ">
                            {{-- <span class="font-semibold">Bath Rooms :</span> --}}
                            {{$property->baths}}
                        </div>
                        <div class="h-10 p-2 bg-gray-100 border ">
                            {{-- <span class="font-semibold">Bed Room :</span> --}}
                            {{$property->beds}} </div>
                        <div class="h-10 p-2 border ">

                            @if ($property->installment == 'yes')
                            <a href="#" class="font-bold text-green-600">
                                <x-icon.icon path="M5 13l4 4L19 7" class="w-5 h-5" />
                            </a>

                            @else
                            <a href="#" class="font-bold text-red-600">
                                <x-icon.icon path="M6 18L18 6M6 6l12 12" class="w-5 h-5" />
                            </a>


                            @endif



                        </div>
                        <div class="flex flex-col p-2 bg-gray-100 border h-14 ">
                            {{-- <span class="font-semibold">Location : </span> --}}
                            @foreach ($property->location()->get() as $location)
                            {{ __($location->name) }}{{ $loop->last ? '' : ' »' }}
                            @endforeach
                        </div>
                        <div class="h-10 p-2 border ">
                            {{-- <span class="font-semibold">Parking : </span> --}}
                            {{-- {{$property->parking}} --}}

                            @if ($property->parking == '0')
                            <a href="#" class="font-bold text-red-600">
                                <x-icon.icon path="M6 18L18 6M6 6l12 12" class="w-5 h-5" />
                            </a>
                            @else

                            {{$property->parking}}

                            @endif
                        </div>
                        <div class="h-10 p-2 bg-gray-100 border ">
                            @foreach ($property->purpose()->get() as $purpose)
                            {{ __($purpose->name) }}
                            @endforeach
                        </div>
                        <div class="h-10 p-2 border ">
                            {{-- <span class="font-semibold">Type : </span> --}}
                            @foreach ($property->type()->get() as $type)
                            {{__($type->name)}}
                            @endforeach
                        </div>
                        <div class="flex flex-col p-2">
                            {{-- <span class="font-semibold">Facilities : </span> --}}
                            @foreach ($property->categories()->get() as $category)
                            <span><i class="pr-1 text-logo-green fas fa-check-circle"></i>{{ __($category->name)}}</span>
                            @endforeach
                        </div>
                        <div class="flex">
                            <a class="justify-center gap-2 mt-2 text-sm btn bg-gradient-to-r blue-gradient"
                                href="{{LaravelLocalization::localizeUrl('/properties/' . $property->id . '/' . $property->slug)}}">
                                @lang('Property Detail')
                            </a>
                        </div>
                    </div>
                </template>

            </div>
            @empty
            <p class="mx-auto mt-10">@lang('There are no property to compare. Please select property you want to compare
                first.')</p>
            @endforelse
        </div>

    </div>