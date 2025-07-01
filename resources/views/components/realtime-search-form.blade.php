@props(['url' => null, 'keyword' => null, 'selectedType' => null, 'selectedPurpose' => null, 'selectedRegion' => null,
'selectedTownship' => null, 'isHome' => false, 'types', 'regions' => null, 'townships' => null, 'purposes', 'mainClass'
=> null, 'searchWrapperClass' => null, 'inputClass' => null, 'class' => null, 'class2' => null, 'price' => ['min' =>
null, 'max' => null], 'page' => ''])

<div class="{{ $mainClass }}">
    <div x-data @keyup.enter.window="setTimeout(() => {document.querySelector('.search_btn').click()}, 500)" class="{{ $searchWrapperClass }}">

        <div class="{{ $class }}">
            <x-input.range :price="$price" />

            <select wire:model="selectedType" class="{{ $inputClass }}" id="type">
                <option value="properties">{{ trans('Select Type') }}</option>
                @foreach ($types as $type)
                {{-- We are using slug to generate h1 tag in property search result page --}}
                <option value="{{ $type->slug }}">{{ trans($type->name) }}</option>
                @endforeach
            </select>

            <select wire:model="selectedPurpose" class="{{ $inputClass }}" id="puprpose">
                <option value="all-purposes">{{ trans('Select Purpose') }}</option>
                @foreach ($purposes as $psp)
                {{-- We are using slug to generate h1 tag in property search result page --}}
                <option value="{{ $psp->slug }}">{{ trans($psp->name) }}</option>
                @endforeach
            </select>

            <select wire:model="selectedRegion" wire:change="updateTownships" class="{{ $inputClass }}" id="puprpose">
                <option value="all-regions">{{ trans('Select Region') }}</option>
                @foreach ($regions as $region)
                @php
                // split string by last space
                // ref: https://stackoverflow.com/questions/1530883/regex-to-split-a-string-only-by-the-last-whitespace-character
                $reg=preg_split("/\s+(?=\S*+$)/", $region->name);
                @endphp
                {{-- We are using slug to generate h1 tag in property search result page --}}
                <option value="{{ $region->slug }}">{{ trans($reg[0] ?? '') . ' ' . trans($reg[1] ?? '') }}</option>
                @endforeach
            </select>

            <select wire:model="selectedTownship" class="{{ $inputClass }}" id="puprpose">
                <option value="all-townships">{{ trans('Select Township') }}</option>
                @foreach ($townships as $township)
                {{-- We are using slug to generate h1 tag in property search result page --}}
                <option value="{{ $township->slug }}">{{ trans($township->name) }}</option>
                @endforeach
            </select>
        </div>

        @if ($page != 'profile')
        <div class="{{ $class2 }}">
            <input wire:model="keyword" type="text" placeholder="{{ trans('Keyword or Property ID') }}">

            @if ($isHome)
            <a href="{{$url}}" class="flex justify-center gap-2 text-white btn bg-gradient-to-r blue-gradient search_btn">
                <x-icon.icon path="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                {{ trans('Search') }}
            </a>
            @endif
        </div>
        @endif

        @if ($page == 'profile')
        <div class="col-span-2">
            <label class="label">{{__('Sorting')}}</label>
            <select wire:model="sorting" class="pr-8">
                <option value="price-asc">{{ __('Price (Low to High)') }}</option>
                <option value="price-desc">{{ __('Price (High to Low)') }}</option>
                <option value="created_at-desc">{{ __('New to Old') }}</option>
                <option value="created_at-asc">{{ __('Old to New') }}</option>
            </select>
        </div>
        @endif
    </div>
</div>