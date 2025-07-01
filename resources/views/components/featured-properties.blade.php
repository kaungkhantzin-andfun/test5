<div class="py-20 px-4">
    <div class="container mx-auto">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-12">
            <div class="mb-4 lg:mb-0">
                <h2 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight">
                    {{ __('Recent Properties for Buy') }}
                </h2>
            </div>

            <a href="{{ LaravelLocalization::localizeUrl('/properties') }}"
                class="group flex items-center space-x-3 hover:opacity-90 transition-opacity">
                <div class="bg-blue-100 p-3 rounded-full group-hover:bg-blue-200 transition-colors">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="text-right">
                    <div class="text-lg text-gray-600 font-medium">ALL PROPERTIES</div>
                    <div class="text-blue-600 font-bold text-xl">FOR BUY</div>
                </div>
            </a>
        </div>

        <div class="grid gap-6 md:gap-8 lg:gap-10 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($featuredProperties->take(8) as $property)
                <livewire:property-card :key="time() . $property->id" :property="$property" layout="featured" :show-uploader="true"
                    :saved-property-ids="$savedPropertyIds" :compare-ids="$compareIds" />
            @endforeach
        </div>
    </div>
