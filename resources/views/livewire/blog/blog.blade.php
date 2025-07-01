<div>
    <div class="sticky top-0 z-10 mb-6 bg-gradient-to-tr blue-gradient">
        <div class="container flex flex-col items-center justify-between gap-2 px-4 mx-auto xl:px-0 md:flex-row">
            <h1 class="my-4 font-bold h1">{{__('Myanmar Real Estate Knowledge')}}</h1>

            <div class="flex items-center w-full h-10 overflow-hidden border border-white rounded-lg md:w-1/2">
                <x-icon.solid-icon class="relative w-10 h-full px-2 rounded-l bg-gradient-to-r blue-gradient"
                    path="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />

                <input wire:model="keyword" class="h-full -ml-1 text-sm text-gray-800 sm:text-base"
                    placeholder="{{!empty($categories) ? __('Search category ..') : __('Search blog ..')}}" type="text">
            </div>
        </div>
    </div>

    <div class="container grid grid-cols-1 gap-4 mb-8 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($blogs as $blog)
        <x-blog-card :blog="$blog" />
        @empty
        <div class="flex items-center justify-center col-span-3">
            <h1 class="text-3xl font-bold text-center">{{ __('No blogs found') }}</h1>
        </div>
        @endforelse

        <div class="md:col-span-2 lg:col-span-3">
            {{ $blogs->links() }}
        </div>
    </div>
</div>