<div class="space-y-1">
    <!-- All Properties -->
    <div x-data="{ open: false }" class="space-y-1">
        <button @click="open = !open" class="flex justify-between w-full px-3 py-2 text-base font-medium text-left text-gray-700 rounded-md hover:bg-gray-100">
            <span>{{ __('All Properties') }}</span>
            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div x-show="open" class="px-2 space-y-1">
            <a href="{{ LaravelLocalization::localizeUrl('/properties-in-myanmar') }}" 
               class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50">
                {{ __('All Properties') }}
            </a>
            @foreach ($propertyTypes as $type)
            <a href="{{ LaravelLocalization::localizeUrl('/search/' . $type->slug .'/all-purposes/all-regions/all-townships') }}" 
               class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50">
                {{ __(Str::plural($type->name)) }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- For Sale -->
    <div x-data="{ open: false }" class="space-y-1">
        <button @click="open = !open" class="flex justify-between w-full px-3 py-2 text-base font-medium text-left text-gray-700 rounded-md hover:bg-gray-100">
            <span>{{ __('For Sale') }}</span>
            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div x-show="open" class="px-2 space-y-1">
            <a href="{{ LaravelLocalization::localizeUrl('/properties-for-sale-in-myanmar') }}" 
               class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50">
                {{ __('All Properties For Sale') }}
            </a>
            @foreach ($propertyTypes as $type)
            <a href="{{ LaravelLocalization::localizeUrl('/search/' . $type->slug .'/for-sale/all-regions/all-townships') }}" 
               class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50">
                {{ __(Str::plural($type->name)) }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- For Rent -->
    <div x-data="{ open: false }" class="space-y-1">
        <button @click="open = !open" class="flex justify-between w-full px-3 py-2 text-base font-medium text-left text-gray-700 rounded-md hover:bg-gray-100">
            <span>{{ __('For Rent') }}</span>
            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div x-show="open" class="px-2 space-y-1">
            <a href="{{ LaravelLocalization::localizeUrl('/properties-for-rent-in-myanmar') }}" 
               class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50">
                {{ __('All Properties For Rent') }}
            </a>
            @foreach ($propertyTypes as $type)
            <a href="{{ LaravelLocalization::localizeUrl('/search/' . $type->slug .'/for-rent/all-regions/all-townships') }}" 
               class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50">
                {{ __(Str::plural($type->name)) }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- By Location -->
    <div x-data="{ open: false }" class="space-y-1">
        <button @click="open = !open" class="flex justify-between w-full px-3 py-2 text-base font-medium text-left text-gray-700 rounded-md hover:bg-gray-100">
            <span>{{ __('By Location') }}</span>
            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
        <div x-show="open" class="px-2 space-y-1">
            @foreach ($regions as $region)
                @php
                    $reg = preg_split("/\\s+(?=\\S*+$)/", $region->name);
                @endphp
                <a href="{{ LaravelLocalization::localizeUrl('/search/properties/all-purposes/' . $region->slug . '/all-townships') }}" 
                   class="block px-3 py-2 text-sm font-medium text-gray-600 rounded-md hover:bg-gray-50">
                    {{ trans($reg[0] ?? '') . ' ' . trans($reg[1] ?? '') }}
                </a>
            @endforeach
        </div>
    </div>
</div>
