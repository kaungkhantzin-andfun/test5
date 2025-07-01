<div>
    @if (!empty($title))
    <div class="relative mb-6 bg-gray-900 h-28">
        <h1
            class="absolute inset-0 h-16 pt-3 mx-auto my-auto text-4xl font-extrabold text-center text-transparent bg-clip-text bg-gradient-to-b blue-gradient">
            {{ __( $title ) }}</h1>
    </div>
    @endif

    <form x-data="{accountType: '{{$user->role}}'}" wire:submit.prevent="{{$createMode ? 'createUser' : 'saveUser'}}" action="#"
        class="container grid w-full h-full grid-cols-2 gap-6 p-4 mx-auto">
        {{-- <form x-data="{accountType: 'agent'}" wire:submit.prevent="{{$createMode ? 'createUser' : 'saveUser'}}" action="#"
            class="container grid w-full h-full grid-cols-2 gap-6 p-4 mx-auto"> --}}
            @csrf
            <div class="pb-10 space-y-6">
                <div x-data="{editing: false}" class="flex flex-col items-center">
                    @if ($photo != null)
                    <img class="object-cover w-20 h-20 mt-4 rounded-full shadow-md selected-photo" src="{{$photo->temporaryUrl()}}" />
                    @elseif ($user->profile_photo_path != null)
                    <img class="object-cover w-20 h-20 mt-4 rounded-full shadow-md selected-photo"
                        src="{{Storage::url($user->profile_photo_path)}}" />
                    @endif

                    <div wire:ignore x-show="editing == true" id="editor"></div>
                    {{-- <div x-show="editing == true" id="editor"></div> --}}
                    <input wire:model="photo" wire:change="removeEditedPhoto" class="hidden" type="file" id="photo">

                    {{-- removing normal photo once the photo is added --}}
                    {{-- this tag will be clicked by javascript automatically once editing is done --}}
                    <span x-on:click="$wire.set('editedPhoto', document.querySelector('.edited-photo').innerHTML); $wire.set('photo', '')"
                        class="hidden edited-photo"></span>

                    <div class="flex mt-4 space-x-4">
                        <label class="bg-gradient-to-r blue-gradient btn" for="photo">{{__('Select A New Photo')}}</label>
                        <input x-show="editing == false" @click="editing = true; editPhoto()" value="{{ __('Edit Photo') }}" type="button"
                            class="bg-gradient-to-r blue-gradient btn" />
                        <input x-show="editing == true" @click="editing = false;" value="{{ __('Done Editing') }}" type="button"
                            class="btn btn-success done-editing" />
                        <x-icon.icon x-show="editing == true" :class="'w-12 btn btn-success rotate-left'"
                            :path="'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6'" />
                        <x-icon.icon x-show="editing == true" style="-webkit-transform: scaleX(-1); transform: scaleX(-1);"
                            :class="'w-12 btn btn-success rotate-right'" :path="'M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6'" />
                    </div>

                    {{-- @push('scripts')
                    <link rel="stylesheet" href="{{asset('assets/css/croppie.min.css')}}">
                    <script src="{{asset('assets/js/croppie.min.js')}}"></script>
                    <script>
                        // for photo editor
                        function editPhoto() {
                            var el = document.getElementById('editor');
                            var vanilla = new Croppie(el, {
                                viewport: { width: 200, height: 200, type: 'circle' },
                                boundary: { width: 300, height: 300 },
                                enableOrientation: true,
                            });
                            vanilla.bind({
                                url: document.querySelector('.selected-photo').getAttribute('src'),
                            });

                            // update photo if you upload new one
                            document.querySelector('#photo').addEventListener('change', function () { readFile(this); });

                            document.querySelector('.done-editing').addEventListener('click', function (ev) {
                                vanilla.result({
                                    type: 'base64'
                                }).then(function (imgData) {
                                    document.querySelector('.edited-photo').innerHTML = imgData;
                                    document.querySelector('.edited-photo').click();
                                    setTimeout(function () {
                                        document.querySelector('.selected-photo').setAttribute('src', imgData);
                                    }, 1000);
                                });
                            });

                            function readFile(input) {
                                if (input.files && input.files[0]) {
                                    var reader = new FileReader();

                                    reader.onload = function (e) {
                                        vanilla.bind({
                                            url: e.target.result
                                        });

                                    }

                                    reader.readAsDataURL(input.files[0]);
                                }
                            }

                            // Rotate functions
                            document.querySelector('.rotate-left').addEventListener('click', function (ev) {
                                vanilla.rotate(90);
                            });
                            document.querySelector('.rotate-right').addEventListener('click', function (ev) {
                                vanilla.rotate(-90);
                            });
                        }
                    </script>
                    @endpush --}}

                </div>
                <div class="flex items-center justify-between space-x-3">
                    <label class="w-3/12" for="role">Account Type:</label>
                    <div class="w-full">
                        <select wire:model="user.role" x-model="accountType" class="@error('user.role') border border-red-600 @enderror" id="role"
                            name="role">
                            <option value="">Select Account Type</option>
                            @auth
                            @if (Auth::user()->role === 'remwdstate20')
                            <option value="remwdstate20">Admin</option>
                            @endif
                            @endauth
                            <option value="user">Normal User</option>
                            <option value="real-estate-agent">Real Estate Agent / Company</option>
                            <optgroup label="Developers">
                                <option value="property-developer">Property Developer</option>
                                <option value="renovation-company">Renovation Company</option>
                                <option value="transportation-company">Transportation Company</option>
                            </optgroup>
                            <option value="lawyer">Lawyer</option>
                            <option value="tourism-company">Tourism Company</option>
                        </select>
                        @error('user.role') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    {{-- <div class="w-full">
                        <select wire:model="user.role" x-model="accountType" class="@error('user.role') border border-red-600 @enderror" id="role"
                            name="role">
                            <option value="">Select Account Type</option>
                            @auth
                            @if (Auth::user()->role === 'remwdstate20')
                            <option value="remwdstate20">Admin</option>
                            @endif
                            @endauth
                            <option value="user">Normal Account</option>
                            <option value="real-estate-agent">Company / Agency Account</option>
                            <option value="developer">Developer Account</option>
                        </select>
                        @error('user.role') <span class="text-red-600">{{ $message }}</span> @enderror
                        <span x-show="accountType == 'developer'" class="text-xs font-bold">(Property Developer, Renovation
                            Company, Transportation Company, Tourism Company, Lawyer)</span>
                    </div> --}}
                </div>

                <div class="flex items-center justify-between space-x-3">
                    <label class="w-3/12" for="name">Name:</label>
                    <div class="w-full">
                        <input wire:model="user.name" class="@error('user.name') border border-red-600 @enderror" type="text" name="title" id="name"
                            placeholder="Name ...">
                        @error('user.name') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between space-x-3">
                    <label class="w-3/12" for="phone">Phone:</label>
                    <div class="w-full">
                        <input wire:model="user.phone" class="@error('user.phone') border border-red-600 @enderror" type="text" id="phone"
                            name="title" placeholder="Phone ..">
                        @error('user.phone') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between space-x-3">
                    <label class="w-3/12" for="email">Email:</label>
                    <div class="w-full">
                        <input wire:model="user.email" class="@error('user.email') border border-red-600 @enderror" type="text" id="email"
                            name="title" placeholder="Email ...">
                        @error('user.email') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>
                @auth
                @if (Auth::user()->role === 'remwdstate20')
                {{-- A little security, so that if someone use dev tool to change the role to 'admin' they won't get admin rights --}}
                {{-- but we'll do backend validation too --}}
                <div class="flex items-center justify-between space-x-3">
                    <label class="w-3/12" for="credit">Credit:</label>
                    <div class="w-full">
                        <x-input.text type="number" model="user.credit" />
                    </div>
                </div>

                @endif
                @endauth

                <div x-data="{
                change: @entangle('changePassword'),
                showLabel: {{$createMode ? 'false' : 'true'}},
                passwordType: true,
            }">
                    <label x-show="showLabel" class="inline-flex items-center">
                        <input @click="change = !change" wire:model="changePassword" type="checkbox" class="checkbox" />
                        <span class="ml-2">Change password?</span>
                    </label>

                    <div x-show="change" class="flex items-center justify-between mt-4 space-x-3">
                        <label class="w-3/12" for="password">Password:</label>
                        <div class="relative w-full">
                            <input wire:model.lazy="password" class="@error('password') border border-red-600 @enderror"
                                :type="passwordType ? 'password' : 'text'" id="password" name="password" placeholder="Type your password..">

                            <a @click.prevent="passwordType = !passwordType" href="#" class="absolute right-5">
                                <x-icon.icon x-show="passwordType" :class="'h-5 w-5'" :path="'M15 12a3 3 0 11-6 0 3 3 0 016 0z'"
                                    :path2="'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'" />

                                <x-icon.icon x-show="!passwordType" :class="'h-5 w-5'"
                                    :path="'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21'" />

                            </a>

                            @error('password') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div x-show="change" class="flex items-center justify-between mt-4 space-x-3">
                        <label class="w-3/12" for="confirm">Confirm Password:</label>
                        <div class="relative w-full">
                            <input wire:model.lazy="password_confirmation" class="@error('password_confirmation') border border-red-600 @enderror"
                                :type="passwordType ? 'password' : 'text'" id="confirm" name="password" placeholder="Type your password again..">

                            <a @click.prevent="passwordType = !passwordType" href="#" class="absolute right-5">
                                <x-icon.icon x-show="passwordType" :class="'h-5 w-5'" :path="'M15 12a3 3 0 11-6 0 3 3 0 016 0z'"
                                    :path2="'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'" />

                                <x-icon.icon x-show="!passwordType" :class="'h-5 w-5'"
                                    :path="'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21'" />

                            </a>

                            @error('password_confirmation') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div style="display:none;" x-show="accountType != 'real-estate-agent'" class="text-right">
                    <input class="w-3/12 bg-gradient-to-r blue-gradient btn" type="submit" value="{{$createMode ? 'Register' : 'Update'}}">
                </div>
            </div>

            <div style="display:none;" x-show="accountType == 'real-estate-agent'" class="space-y-6">
                <div x-data="{showTownships: '{{$user->service_region_id}}'}">
                    <div>
                        <label class="w-3/12">Service Region:</label>
                        <select wire:model="user.service_region_id" wire:change="getTownships"
                            class="@error('user.service_region_id') border border-red-600 @enderror" id="service_region_id" name="service_region_id">
                            <option value="0">{{__('All Regions')}}</option>
                            @foreach ($regions as $region)
                            <option value="{{$region->id}}">{{$region->name}}</option>
                            @endforeach
                        </select>
                        @error('user.service_region_id') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div x-show="showTownships != 0" class="mt-6 space-y-2">
                        <label class="w-full mb-2 text-right">Select Service Townships:</label>

                        <div x-data="{checkAll: '{{$checkAll}}'}" class="grid grid-cols-3 gap-1">
                            <label class="inline-flex items-center">
                                <input wire:model="checkAll" type="checkbox" class="checkbox" />
                                <span class="ml-2">All Townships</span>
                            </label>
                            @forelse ($townships as $tsp)
                            <label class="inline-flex items-center">
                                <input type="checkbox" class="@error('user.service_region_id') border border-red-600 @enderror checkbox"
                                    wire:model="userTownships" value="{{$tsp->id}}" />
                                <span class="ml-2">{{$tsp->name}}</span>
                            </label>
                            @empty

                            @endforelse
                        </div>
                        @error('userTownships') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>

                </div>
                <div class="space-y-1">
                    <label class="w-3/12" for="address">Address:</label>
                    <input wire:model="user.address" class="@error('user.address') border border-red-600 @enderror" type="text" id="address"
                        name="title" placeholder="Address ...">
                    @error('user.address') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1">
                    <label class="w-3/12" for="about">About:</label>
                    <textarea wire:model="user.about" class="h-32 @error('user.about') border border-red-600 @enderror" type="text" id="about"
                        name="title" placeholder="About ...">
                </textarea>
                    @error('user.about') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="text-right">
                    <input class="w-3/12 bg-gradient-to-r blue-gradient btn" type="submit" value="{{$createMode ? 'Register' : 'Update'}}">
                </div>
            </div>
        </form>
</div>