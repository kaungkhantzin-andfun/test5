<div class="{{ $mainClass }}">
    <form x-data="{
        search: '{{ $searchTerm }}',
        selectedType: '{{ $selectedType }}',
        selectedPurpose: '{{ $selectedPurpose }}',
        selectedRegion: '{{ $selectedRegion }}',
        isOpen: false
    }" 
    wire:submit.prevent="search" 
    class="bg-white p-4 rounded-xl shadow-lg flex flex-col md:flex-row items-center gap-4 w-full">
        <!-- Location Input with Search -->
        <div class="relative flex-1 w-full" x-data="{ isOpen: $data.isOpen, search: $data.search }" @click.away="isOpen = false">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                
            </div>
            <input 
                type="text" 
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="{{ trans('Search location...') }}"
                x-model="search"
                @focus="isOpen = true"
                wire:model.debounce.300ms="searchTerm"
                @keydown.escape.window="isOpen = false"
                value="{{ $searchTerm }}"
            >
            <!-- Dropdown -->
            <div 
                x-show="isOpen" 
                class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg max-h-60 overflow-auto"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
            >
                @if(count($filteredRegions) === 0)
                    <div class="px-4 py-2 text-gray-500">No locations found</div>
                @else
                    @foreach($filteredRegions as $region)
                        @php
                            $reg = preg_split("/\s+(?=\S*+$)/", $region->name);
                            $displayName = trans($reg[0] ?? '') . ' ' . trans($reg[1] ?? '');
                        @endphp
                        <button 
                            type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100"
                            wire:click="selectRegion('{{ $region->slug }}')"
                            @click="isOpen = false; search = '{{ $displayName }}'"
                        >
                            {{ $displayName }}
                        </button>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Type Input -->
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-icon.icon path="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" class="w-5 h-5 text-gray-400" />
            </div>
            <select wire:model="selectedType" 
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                x-model="selectedType">
                <option value="properties">{{ trans('Select Type') }}</option>
                @foreach ($propertyTypes as $type)
                    <option value="{{ $type->slug }}">{{ trans($type->name) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Purpose Input -->
        <div class="relative flex-1 w-full">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-icon.icon path="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" class="w-5 h-5 text-gray-400" />
            </div>
            <select wire:model="selectedPurpose" 
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                x-model="selectedPurpose">
                <option value="all-purposes">{{ trans('Select Purpose') }}</option>
                @foreach ($purposes as $psp)
                    <option value="{{ $psp->slug }}">{{ trans($psp->name) }}</option>
                @endforeach
            </select>
        </div>

        <!-- Search Button -->
        <button type="submit" class="w-full md:w-auto px-6 py-3 bg-[#FCFE04] text-gray-800 rounded-lg hover:bg-[#e6e600] transition-colors flex items-center justify-center gap-2">
            <x-icon.icon path="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" class="w-5 h-5" />
            {{ trans('Search') }}
        </button>

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
    </form>
</div>