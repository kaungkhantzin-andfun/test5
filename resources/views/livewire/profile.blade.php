<div x-data="{showModal: false}">

    {{-- Profile info --}}
    @if (!$isSavedPage)
    <div class="py-6 bg-blue-50">
        <div class="container items-center justify-center gap-4 px-4 mx-auto space-y-4 lg:grid lg:grid-cols-4 xl:px-0">
            <div class="space-y-3">
                <img class="object-cover w-48 h-48 mx-auto border-4 border-white rounded-full shadow-md"
                    src="{{ $user->profile_photo_url ?: asset('assets/images/nia.jpg') }}" alt="{{ $user->name }}" />

                @if (!$isSavedPage)
                <a @click.prevent="showModal = true" href="#" class="flex items-center gap-2 mx-auto bg-gradient-to-r blue-gradient btn w-max">
                    <x-icon.icon path="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    {{ __('Send Message') }}
                </a>
                @endif
            </div>

            <div class="col-span-3 space-y-3">
                <header>
                    <h1 class="text-xl">
                        {{ $user->name }}
                    </h1>
                </header>

                {{-- Contact Info --}}
                <div class="flex flex-col justify-between w-full text-sm lg:items-center lg:flex-row">
                    @if (!empty($user->phone))
                    <span class="flex items-center gap-2">
                        <x-icon.icon
                            path="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        <a href="tel:{{$user->phone}}">{{$user->phone}}</a>
                    </span>
                    @endif
                    @if (!empty($user->address))
                    <span class="flex items-center gap-2">
                        <x-icon.icon path="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                            path2="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        {{$user->address}}
                    </span>
                    @endif
                </div>

                <div>{!! $user->about !!}</div>
            </div>
        </div>
    </div>
    @endif

    {{-- User's properties --}}
    <livewire:realtime-filter :user="$user" :is-saved-page="$isSavedPage" />

    @if (!$isSavedPage)
    <div x-show="showModal == true" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/60">
        <div @click.away="showModal = false" class="relative w-full p-4 mx-2 bg-white rounded shadow-2xl sm:max-w-md">

            <a href="#" @click.prevent="showModal = false" class="absolute p-0.5 text-white bg-red-600 rounded-full -right-2 -top-2">
                <x-icon.icon path="M6 18L18 6M6 6l12 12" />
            </a>

            <h3 class="mb-2 h3">{{ __('To ' . $user->name) }}</h3>

            <livewire:contact-form :agent="$user" />
        </div>
    </div>
    @endif

</div>