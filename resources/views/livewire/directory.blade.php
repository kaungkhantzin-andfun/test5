<div class="min-h-screen">

    <div class="sticky top-0 z-10 py-4 bg-gradient-to-tr blue-gradient">
        <div class="container flex flex-col items-center justify-between gap-2 px-4 mx-auto xl:px-0 md:flex-row">
            <header class="flex flex-col gap-1 text-center md:text-left">
                <h1 class="text-white h3">{{__('seo.directory.h1')}}</h1>
                <h2 class="text-xs text-white md:text-sm lg:text-base xl:text-lg">{{__('seo.directory.h2')}}</h2>
            </header>

            <div class="flex items-center w-full h-10 overflow-hidden border border-white rounded-lg md:w-1/2">
                <x-icon.solid-icon class="relative w-10 h-full px-2 rounded-l bg-gradient-to-r blue-gradient"
                    path="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />

                <input wire:model="keyword" class="h-full -ml-1 text-sm text-gray-800 sm:text-base"
                    placeholder="{{__('Search by name, phone, email, address...')}}" type="text">
            </div>
        </div>
    </div>

    <div class="container grid gap-4 px-4 mx-auto my-4 xl:px-0 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @forelse ($users as $user)
        <article class="relative p-4 mt-24 space-y-4 border rounded shadow">
            <a class="block object-cover w-40 h-40 mx-auto mb-4 transition-all border-2 border-white rounded-full shadow-md shrink-0 -mt-28 hover:shadow-xl"
                href="{{LaravelLocalization::localizeUrl('/real-estate-agents/' . $user->slug)}}">
                @if ($user->profile_photo_path != null)
                <img class="object-cover w-40 h-40 mx-auto overflow-hidden transition-all border-2 border-white rounded-full shadow-md hover:shadow-xl"
                    src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                @else
                <img class="object-cover w-40 h-40 mx-auto overflow-hidden transition-all border-2 border-white rounded-full shadow-md hover:shadow-xl"
                    src="{{ asset('assets/images/nia.jpg') }}" alt="No image available" />
                @endif
            </a>

            <div>
                <h2 class="h3 text-logo-blue">
                    <a href="{{LaravelLocalization::localizeUrl('/real-estate-agents/'. $user->slug)}}">
                        {{ Str::limit($user->name, 50) }} </a>
                </h2>

                <p>{!! $user->shortAbout !!}</p>
            </div>

            <div class="space-y-1">
                @if (!empty($user->phone))
                <span class="flex items-center gap-2">
                    <x-icon.solid-icon class="text-logo-blue" addClass="true"
                        path="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                    <a href="tel:{{$user->phone}}">{{$user->phone}}</a>
                </span>
                @endif
                @if (!empty($user->address))
                <span class="flex items-center gap-2">
                    <x-icon.solid-icon class="text-logo-green" addClass="true"
                        path="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" />
                    {{$user->address}}
                </span>
                @endif
            </div>

            <ul class="flex flex-col space-y-1">
                @if ($user->properties_count > 0)
                <li class="flex items-center gap-1">
                    <span class="font-bold text-logo-green">{{number_format($user->properties_count)}}</span>
                    {{__('Properties Uploaded')}}
                </li>
                @endif
            </ul>

        </article>
        @empty

        @endforelse
    </div>

    <div class="container mx-auto my-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        {{$users->links() }}
    </div>


</div>