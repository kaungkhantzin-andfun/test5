<div class="{{ $mainClass }}">
    <form 
        x-data="{
            search: @entangle('searchTerm'),
            guestsOpen: false,
            adults: @entangle('adults'),
            children: @entangle('children'),
            date: @entangle('selectedDate'),
        }"
        wire:submit.prevent="search"
        class="bg-white border border-gray-300 p-4 rounded-lg shadow-sm flex flex-col md:flex-row items-center gap-4 w-full"
    >
        <!-- WHERE TO -->
        <div class="relative flex-1 w-full" x-data="{ isOpen: false, search: $data.search }" @click.away="isOpen = false">
            <label class="block mb-1 text-sm text-gray-700">{{ __('Where to?') }}</label>
            <input
                type="text"
                class="w-full border border-gray-300 rounded px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                placeholder="{{ __('Search location...') }}"
                x-model="search"
                @focus="isOpen = true"
                wire:model.debounce.300ms="searchTerm"
                @keydown.escape.window="isOpen = false"
            >

            <!-- Dropdown -->
            <div x-show="isOpen"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded shadow max-h-60 overflow-auto"
                x-transition>
                @if (count($filteredRegions) === 0)
                    <div class="px-4 py-2 text-gray-500">No locations found</div>
                @else
                    @foreach ($filteredRegions as $region)
                        @php
                            $reg = preg_split("/\s+(?=\S*+$)/", $region->name);
                            $displayName = trans($reg[0] ?? '') . ' ' . trans($reg[1] ?? '');
                        @endphp
                        <button type="button"
                            class="w-full text-left px-4 py-2 hover:bg-gray-100"
                            wire:click="selectRegion('{{ $region->slug }}')"
                            @click="
                                isOpen = false;
                                search = '{{ $displayName }}';
                                $wire.set('searchTerm', '{{ $displayName }}');
                            ">
                            {{ $displayName }}
                        </button>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- DATES -->
        <div class="flex-1 w-full">
            <label class="block mb-1 text-sm text-gray-700">{{ __('Dates') }}</label>
            <input
                type="date"
                x-model="date"
                wire:model="selectedDate"
                class="w-full border border-gray-300 rounded px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
        </div>

        <!-- GUESTS -->
        <div class="relative flex-1 w-full">
            <label class="block mb-1 text-sm text-gray-700">{{ __('Guests') }}</label>
            <button type="button"
                @click="guestsOpen = !guestsOpen"
                class="w-full border border-gray-300 rounded px-4 py-3 text-left flex justify-between items-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <span>
                    <span x-text="adults"></span> Adults,
                    <span x-text="children"></span> Children
                </span>
                <svg class="w-5 h-5 ml-2 transform" :class="guestsOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Guests Dropdown -->
            <div x-show="guestsOpen"
                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded shadow p-4"
                @click.away="guestsOpen = false"
                x-transition>
                <div class="flex justify-between items-center mb-3">
                    <span class="text-gray-700">Adults</span>
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="px-2 py-1 border border-gray-300 rounded"
                            @click="if(adults > 1) adults--; $wire.set('adults', adults)">-</button>
                        <span x-text="adults"></span>
                        <button type="button"
                            class="px-2 py-1 border border-gray-300 rounded"
                            @click="adults++; $wire.set('adults', adults)">+</button>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-700">Children</span>
                    <div class="flex items-center gap-2">
                        <button type="button"
                            class="px-2 py-1 border border-gray-300 rounded"
                            @click="if(children > 0) children--; $wire.set('children', children)">-</button>
                        <span x-text="children"></span>
                        <button type="button"
                            class="px-2 py-1 border border-gray-300 rounded"
                            @click="children++; $wire.set('children', children)">+</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEARCH BUTTON -->
        <button type="submit"
            class="w-full md:w-auto px-6 py-3 border border-gray-300 text-gray-800 rounded hover:bg-gray-100 transition">
            {{ __('Search') }}
        </button>
    </form>
</div>
