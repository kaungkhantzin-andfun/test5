<div class="flex relative flex-col items-center min-h-[calc(100vh-180px)] overflow-hidden bg-blue-50 justify-center" x-data="{
    accountType: '{{$user->role}}',
    {{-- if you persist 'normal' here, Register.php component will not be able to override it after coming from social login --}}
    normal: {{$normal}},
}">

    <img class="absolute z-0 hidden sm:right-5 sm:w-20 md:w-28 sm:top-5 lg:right-10 sm:block md:-top-4 lg:w-40"
        src="{{ asset('assets/images/balloons.svg') }}" alt="Hot Air Balloons">

    <img class="absolute bottom-0 hidden w-32 left-5 lg:left-10 sm:block lg:w-44 xl:w-60" src="{{asset('assets/images/cabin.svg')}}"
        alt="House Cabin">

    <div x-show="!normal" x-transition.duration.300ms
        class="relative z-10 w-full p-6 space-y-4 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">

        <a href="{{LaravelLocalization::localizeUrl('/login/google')}}" class="text-white bg-red-600 !w-full btn">
            <i class="mr-3 fa-lg fab fa-google"></i>
            {{__('Register with Google')}}
        </a>

        <a href="{{LaravelLocalization::localizeUrl('/login/fb')}}" class="text-white bg-gradient-to-b to-[#0062E0] from-[#19AFFF] !w-full btn">
            <i class="mr-3 fa-lg fab fa-facebook-square"></i>
            {{__('Register with Facebook')}}
        </a>

        <a href="{{LaravelLocalization::localizeUrl('/login/linkedin')}}" class="text-white !w-full btn bg-[#0077b5]">
            <i class="mr-3 fa-lg fab fa-linkedin"></i>
            {{__('Register with LinkedIn')}}
        </a>

        <a href="{{LaravelLocalization::localizeUrl('/login/twitter')}}" class="text-white !w-full btn bg-[#1da1f1]">
            <i class="mr-3 fa-lg fab fa-twitter"></i>
            {{__('Register with Twitter')}}
        </a>

        @guest
        @if (Route::has('login'))
        <p class="text-sm text-center">
            {{ __("Already have an account?") }}
            <a href="{{ route('login') }}" class="text-sm font-bold text-logo-blue">{{ __("Login here!") }}</a>
        </p>
        @endif
        @endguest
    </div>

    @guest
    <a @click="normal = ! normal" class="relative justify-center mt-4 rounded bg-gradient-to-r blue-gradient" href="#">
        <span x-show="!normal" class="gap-1 btn">
            <x-icon.icon
                path="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            {{__('Normal Register')}}
        </span>
        <span x-show="normal" class="gap-1 btn">
            <i class="mr-3 fa-lg fab fa-facebook-square"></i>
            {{__('Social Register')}}
        </span>
    </a>
    @endguest

    @auth
    <div :class="accountType == 'real-estate-agent' ? 'mt-4' : ''" class="flex items-center justify-center text-2xl text-logo-blue-dark">
        {{__('Update Account')}}
    </div>
    @endauth

    <form x-show="normal" x-transition.duration.300ms id="custom_form" wire:submit.prevent="{{$createMode ? 'createUser' : 'saveUser'}}" action="#"
        :class="accountType == 'real-estate-agent' ? 'container grid' : 'max-w-md delay-250 w-full'"
        class="relative gap-4 p-4 mx-auto my-4 overflow-hidden transition-all duration-300 ease-in-out bg-white shadow-md md:grid-cols-5 lg:gap-6 lg:p-6 md:flex-row sm:rounded-lg">

        <div class="flex-1 space-y-4 md:col-span-2">
            @if (!empty($avatar))
            <div class="flex justify-center">
                <img src="{{$avatar}}" class="object-cover w-24 h-24 rounded-full" alt="User avatar">
            </div>
            @endif

            <div>
                <span class="label">{{__('I am a')}}</span>
                <div class="flex items-center gap-4">
                    <x-input.radio model="user.role" x-model="accountType" label="{{__('Seeker / Owner')}}" value="user" />
                    <x-input.radio model="user.role" x-model="accountType" label="{{__('Company / Agent')}}" value="real-estate-agent" />
                </div>
            </div>

            <x-input.text model="user.name" label="Name" :no-label="true" />

            <x-input.text model="user.phone" label="Phone" :no-label="true" />

            <x-input.text model="user.email" label="Email" :no-label="true" />

            <div x-data="{
                    change: {{$createMode ? 'true' : 'false'}},
                    showLabel: {{$createMode ? 'false' : 'true'}},
                    passwordType: true,
                }">
                <label x-show="showLabel" class="inline-flex items-center">
                    <input type="checkbox" class="checkbox" @click="change = !change" />
                    <span class="ml-2">{{__('Set password?')}}</span>
                </label>

                <div x-show="change" class="relative flex items-center justify-between mt-4 space-x-3">
                    <x-input.text x-bind:type="passwordType ? 'password' : 'text'" model="password" label="Password" :no-label="true" />

                    {{-- Show / hide password --}}
                    <a @click.prevent="passwordType = !passwordType" href="#" class="absolute right-3">
                        <x-icon.icon x-show="passwordType" path="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            path2="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                        <x-icon.icon x-show="!passwordType"
                            path="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </a>
                </div>

                <div x-show="change" class="relative flex items-center justify-between mt-4 space-x-3">
                    <x-input.text x-bind:type="passwordType ? 'password' : 'text'" model="password_confirmation" label="Confirm Password"
                        :no-label="true" />

                    {{-- Show / hide password --}}
                    <a @click.prevent="passwordType = !passwordType" href="#" class="absolute right-3">
                        <x-icon.icon x-show="passwordType" path="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            path2="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                        <x-icon.icon x-show="!passwordType"
                            path="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </a>
                </div>

            </div>

            <div x-show="accountType != 'real-estate-agent'" class="flex justify-end">
                <input class="btn bg-gradient-to-r blue-gradient" type="submit" value="{{__($createMode ? 'Register' : 'Update')}}">
            </div>
        </div>

        <div x-show="accountType == 'real-estate-agent'" x-transition.duration.300ms class="flex-1 space-y-4 md:col-span-3">

            <div x-data="{showTownships: '{{$user->service_region_id}}'}">
                <x-input.select model="user.service_region_id" x-model="showTownships" wire:change="getTownships" label="Service Region">
                    <option value="0">{{__('All Regions')}}</option>
                    @foreach ($regions as $region)
                    @php
                    // split string by last space
                    $reg=preg_split("/\s+(?=\S*+$)/", $region->name);
                    @endphp
                    <option value="{{ $region->id }}">{{ trans($reg[0] ?? '') . ' ' . trans($reg[1] ?? '') }}</option>
                    {{-- <option value="{{$region->id}}">{{$region->name}}</option> --}}
                    @endforeach
                </x-input.select>

                <div x-show="showTownships != 0" class="my-6">
                    <label class="label">{{__('Select Service Townships:')}}</label>

                    <div class="grid gap-1 mt-2 md:grid-cols-2 lg:grid-cols-3">
                        <label class="inline-flex items-center">
                            <input wire:model="selectAll" wire:click="checkAll" type="checkbox" class="checkbox" />
                            <span class="ml-2">{{__('All Townships')}}</span>
                        </label>
                        @forelse ($townships as $tsp)
                        <label class="inline-flex items-center">
                            <input wire:model="userTownships" value="{{$tsp->id}}" type="checkbox" class="checkbox" />
                            <span class="ml-2">{{__($tsp->name)}}</span>
                        </label>
                        @empty

                        @endforelse
                    </div>
                    @error('userTownships') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            </div>

            <x-input.text model="user.address" label="{{__('Address')}}" />

            <x-input.textarea class="h-32" model="user.about" label="{{__('About Your Business')}}" />

            <input class="btn bg-gradient-to-r blue-gradient" type="submit" value="{{__($createMode ? 'Register' : 'Update')}}">

        </div>
    </form>

</div>