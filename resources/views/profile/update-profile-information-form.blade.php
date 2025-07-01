<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Profile Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Update your account\'s profile information and email address.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Profile Photo -->
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div x-data="{photoName: null, photoPreview: null, editing: false}" class="col-span-6">
            <!-- Profile Photo File -->
            <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

            <x-label for="photo" value="{{ __('Photo') }}" />

            <!-- Current Profile Photo -->
            <div class="flex justify-between mt-2" x-show="! photoPreview">
                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="object-cover w-20 h-20 rounded-full">
                <div x-show="editing == true" id="editor"></div>
            </div>


            <!-- New Profile Photo Preview -->
            <div class="mt-2" x-show="photoPreview">
                <span class="block w-20 h-20 rounded-full"
                    x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                </span>
            </div>

            <x-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('Select A New Photo') }}
            </x-secondary-button>

            @if ($this->user->profile_photo_path)
            {{-- <x-secondary-button x-show="editing == false" @click="editing = true; editPhoto()" type="button" class="mt-2 mr-2">
                {{ __('Edit Photo') }}
            </x-secondary-button>

            <x-secondary-button x-show="editing == true" @click="editing = false;" type="button" class="mt-2 mr-2 done-editing">
                {{ __('Done Editing') }}
            </x-secondary-button> --}}

            <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                {{ __('Remove Photo') }}
            </x-secondary-button>
            @endif

            <x-input-error for="photo" class="mt-2" />
        </div>

        {{-- @push('scripts')
        <link rel="stylesheet" href="{{asset('assets/css/croppie.min.css')}}">
        <script src="{{asset('assets/js/croppie.min.js')}}"></script>
        <script>
            function editPhoto() {
                        var el = document.getElementById('editor');
                        var vanilla = new Croppie(el, {
                            viewport: { width: 100, height: 100, type: 'circle' },
                            boundary: { width: 200, height: 200 },
                        });
                        vanilla.bind({
                            url: '{{ $this->user->profile_photo_url }}',
                        });

                        document.querySelector('.done-editing').addEventListener('click', function (ev) {
                            vanilla.result({
                                type: 'blob'
                            }).then(function (blob) {
                                document.querySelector('.profile-photo').value = window.URL.createObjectURL(blob);
                            });
                        });
                    }

                    $('.vanilla-rotate').on('click', function (ev) {
                        vanilla.rotate(parseInt($(this).data('deg')));
                    });
        </script>
        @endpush --}}
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <x-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.name" autocomplete="name" />
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" type="email" class="block w-full mt-1" wire:model.defer="state.email" />
            <x-input-error for="email" class="mt-2" />
        </div>

        <!-- Edit more -->
        <div class="col-span-6  btn bg-gradient-to-r blue-gradient sm:col-span-4 w-max">
            <x-icon.icon :class="'w-6 h-6 mr-3'"
                :path="'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'" />
            <a href="{{LaravelLocalization::localizeUrl('/user') . '/' . Auth::user()->id . '/edit'}}">
                {{__('Edit More')}}
            </a>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>