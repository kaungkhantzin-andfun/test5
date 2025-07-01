<form enctype="multipart/form-data" wire:submit.prevent="{{$createMode ? 'createItem' : 'saveItem'}}"
    class="grid grid-cols-1 gap-4 py-3 lg:grid-cols-4 xl:grid-cols-5">

    <div x-data="{currentLang: 'my'}" class="relative col-span-2 xl:col-span-3">
        <div class="absolute flex items-center gap-1 justify-items-auto">
            <a @click.prevent="currentLang = 'my'" :class="{'bg-white' : currentLang === 'my'}"
                class="flex items-center gap-2 p-2 border border-b-0 rounded-t" href="#">
                <img class="w-8 rounded" src="{{asset('assets/images/myanmar.svg')}}" alt="Myanmar flag">
                <span>{{__('Burmese')}}</span>
            </a>
            <a @click.prevent="currentLang = 'en'" :class="{'border-b-0' : currentLang === 'en'}"
                class="flex items-center gap-2 p-2 border rounded-t bg-blue-50" href="#">
                <img class="w-8 rounded" src="{{asset('assets/images/us.svg')}}" alt="English flag">
                <span>{{__('English')}}</span>
            </a>
        </div>

        <div class="p-4 pb-6 mt-10 border rounded rounded-tl-none" :class="currentLang == 'my' ? 'bg-white' : 'bg-blue-50'">

            <div class="mb-2">
                @if (app()->getLocale() == 'my')
                <p class="flex gap-1 info">
                    <x-icon.solid-icon class="w-4 h-4"
                        path="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
                    ဇော်ဂျီဖောင့် သုံးနိုင်ပါသည်။ သို့သော် ယူနီကုဒ်ဖောင့်ကို ပိုမှန်စွာ ပြနိုင်ပါတယ်။ <a target="_blank"
                        class="underline text-logo-blue hover:no-underline" href="{{route('tools.font-converter')}}">ဇော်ဂျီ ↔ ယူနီကုဒ်
                        ပြောင်းရန်</a>
                </p>
                @else
                <p class="flex gap-1 info">
                    <x-icon.solid-icon class="w-4 h-4"
                        path="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" />
                    You can use Zawgyi font but we can display unicode font better. Use <a target="_blank"
                        class="underline text-logo-blue hover:no-underline" href="{{route('tools.font-converter')}}">Zawgyi ↔ Unicode</a> converter.
                </p>
                @endif
            </div>

            <div class="flex" :class="currentLang == 'my' ? 'flex-col' : 'flex-col-reverse'">
                <x-dashboard.transition-wrapper x-show="currentLang == 'my'">
                    <x-input.text model="translations.my.title" label="{{__('Property title in Burmese')}}" />
                </x-dashboard.transition-wrapper>

                <x-dashboard.transition-wrapper x-show="currentLang == 'en'">
                    <x-input.text model="translations.en.title" class="shadow-none" label="{{__('Property title in English')}}" />
                </x-dashboard.transition-wrapper>
            </div>

            <div class="my-4">
                <div>
                    {{-- temporarily hiding so that it don't look the same as yuzanar land --}}
                    {{-- <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false" x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"> --}}

                        {{-- Loading indicator --}}
                        <!-- Progress Bar -->
                        {{-- <div class="my-3" x-show="isUploading">
                            <span class="text-sm">{{ __('Uploading ..') }} <span x-text="progress"></span> %</span>
                            <progress max="100" x-bind:value="progress"></progress>
                        </div> --}}
                        {{-- End of Loading indicator --}}

                        <span class="label">{{__('Images')}}</span>
                        <div class="relative flex items-center border-2 border-dashed rounded bg-logo-purple/10 border-logo-purple">

                            <div class="absolute flex flex-col w-full gap-1 text-sm text-center text-logo-purple">
                                <span>{{__('Drop your images here!')}}</span>
                                <span>{{__('You can also click this to choose images.')}}</span>
                            </div>

                            <input wire:model="images" accept="image/*" id="images"
                                class="relative z-10 @error('images') border border-red-600 @enderror pl-0 shadow-none w-full h-20 opacity-0"
                                type="file" multiple>
                        </div>

                        @error('images.*') <span class="error">{{ $message }}</span> @enderror
                        @if (!empty($images))
                        <x-dashboard.image-preview :images="$images" />
                        @endif

                        {{-- @if (!empty($images))
                        <x-dashboard.image-preview title="{{__('Newly uploaded images')}}" :images="$images" :newly-uploaded="true" />
                        @endif

                        @if (!$createMode && count($oldImages) > 0)
                        <x-dashboard.image-preview title="{{__('Existing Images')}}" :images="$oldImages" :del-id="$del_id" />
                        @endif --}}

                    </div>
                </div>

                <div class="flex" :class="currentLang == 'my' ? 'flex-col' : 'flex-col-reverse'">
                    <x-dashboard.transition-wrapper x-show="currentLang == 'my'">
                        <x-input.ckeditor model="translations.my.detail" label="{{__('Property description in Burmese')}}">
                            {!! array_key_exists('my', $translations) && array_key_exists('detail', $translations['my']) ?
                            $translations['my']['detail'] :
                            '' !!}
                        </x-input.ckeditor>
                    </x-dashboard.transition-wrapper>

                    <x-dashboard.transition-wrapper x-show="currentLang=='en'">
                        <x-input.ckeditor model="translations.en.detail" label="{{__('Property description in English')}}">
                            {!! array_key_exists('en', $translations) && array_key_exists('detail', $translations['en']) ?
                            $translations['en']['detail'] : '' !!}
                        </x-input.ckeditor>
                    </x-dashboard.transition-wrapper>
                </div>

            </div>

        </div>

        <div class="col-span-2">
            <div x-data="{ hide: false }" x-init="hide = ($refs.type.value == 7 || $refs.type.value == 14) ? true : false"
                class="items-start grid-cols-3 gap-4 space-y-4 sm:space-y-0 sm:grid">
                <x-input.select model="property.type_id" x-ref="type" @change="hide = ($el.value == 7 || $el.value == 14) ? true : false"
                    wire:change="updateResetFacilities" label="{{__('Type')}}">
                    @foreach ($propertyTypes as $type)
                    <option value="{{ $type->id }}">{{trans($type->name)}}</option>
                    @endforeach
                </x-input.select>

                <x-input.select model="property.property_purpose_id" label="{{__('Purpose')}}">
                    @foreach ($purposes as $psp)
                    <option value="{{ $psp->id }}">{{trans($psp->name)}}</option>
                    @endforeach
                </x-input.select>

                <x-input.text model="property.price" min="0" type="number" step="0.01" label="{{__('Price (Lakhs)')}}" />

                <x-input.select wire:change="updateTownships" model="selectedLocation.region" label="{{__('Region')}}">
                    @foreach ($regions as $region)
                    @php
                    // split string by last space
                    $reg=preg_split("/\s+(?=\S*+$)/", $region->name);
                    @endphp
                    {{-- <option value="{{ $region->id }}">{{ trans($reg[0] ?? '') . ' ' . trans($reg[1] ?? '') }}</option> --}}
                    <option value="{{ $region->id }}">{{ trans($reg[0] ?? '')}}</option>
                    @endforeach
                </x-input.select>

                <x-input.select model="selectedLocation.township" label="{{__('Township')}}">
                    @foreach ($townships as $township)
                    <option value="{{ $township->id }}">{{trans($township->name)}}</option>
                    @endforeach
                </x-input.select>


                <div class="md:pt-8">
                    <x-input.checkbox model="property.installment" value="yes" label="{{__('Installment Plan')}}" />
                </div>

                <div x-show="!hide" x-transition.duration.500ms>
                    <x-input.text model="property.parking" min="0" type="number" label="{{__('No. of Parking')}}" />
                </div>

                <div x-show="!hide" x-transition.duration.500ms>
                    <x-input.text model="property.beds" min="0" type="number" label="{{__('No. of bed rooms')}}" />
                </div>

                <div x-show="!hide" x-transition.duration.500ms>
                    <x-input.text model="property.baths" min="0" type="number" label="{{__('No. of baths')}}" />
                </div>

                <x-input.select wire:change="updateTownships" model="area.type" label="{{__('Area')}}">
                    <option value="acre">{{ __('Acre') }}</option>
                    <option value="square_feet">{{ __('Square Feet') }}</option>
                    <option value="square_meters">{{ __('Square Meters') }}</option>
                    <option value="length_width">{{ __('Length x Width') }}</option>
                </x-input.select>

                @if (!empty($area['type']))

                @if ($area['type'] == 'length_width')
                <x-input.text label="Length with unit" model="area.length_width.0" />
                <x-input.text label="Width with unit" model="area.length_width.1" />
                @else
                <x-input.text model="area.{{$area['type']}}" label="{{Str::of($area['type'])->replace('_', ' ')}}" />
                @endif

                @endif

                @if (!empty($categories))
                <div class="col-span-3">
                    <label class="label">{{ __('Choose Facilities') }}</label>
                    <input type="text" id="f_search" onkeyup="searchFacilities()" placeholder="{{__('Filter facilities ..')}}"
                        title="{{__('Type in a facility name')}}">

                    <div id="facilities" class="grid w-full grid-cols-2 p-2 mt-2 overflow-y-auto bg-white border rounded max-h-64">
                        @foreach ($categories as $cat)
                        <x-input.checkbox model="selectedFacilities" value="{{$cat->id}}" label="{{$cat->name}}" />
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="flex justify-end w-full col-span-3 lg:justify-start">
                    <x-notices />

                    <button wire:loading.attr="disabled" wire:target="{{$createMode ? 'createItem' : 'saveItem'}}" type="submit"
                        class="right-0 mt-2 mb-4 cursor-pointer md:mb-0 btn bg-gradient-to-r blue-gradient disabled:bg-logo-blue-dark md:float-left">
                        <span wire:loading.remove wire:target="{{$createMode ? 'createItem' : 'saveItem'}}" class="flex items-center justify-center">
                            {{ $createMode ? __('Create Property') : __('Update Property') }}
                        </span>

                        <span wire:loading wire:target="{{$createMode ? 'createItem' : 'saveItem'}}" class="flex items-center justify-center gap-2">
                            <x-loading-indicator :color-class="'text-white'" />
                            {{__("Saving ..")}}
                        </span>
                    </button>
                </div>
            </div>
        </div>

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>
        <script>
            function searchFacilities() {
            var input, filter, div, label, a, i, txtValue;
            input = document.getElementById("f_search");
            filter = input.value.toUpperCase();
            div = document.getElementById("facilities");
            label = div.getElementsByTagName("label");
            for (i = 0; i < label.length; i++) {
                span = label[i].getElementsByTagName("span")[0];
                txtValue = span.textContent || span.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    label[i].style.display = "";
                } else {
                    label[i].style.display = "none";
                }
            }
        }
        </script>
        @endpush

</form>