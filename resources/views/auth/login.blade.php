<x-app-layout>

    <div x-data="{normal: $persist(false)}"
        class="flex relative flex-col items-center min-h-[calc(100vh-180px)] overflow-hidden bg-indigo-50 justify-center">

        <div class="absolute inset-0 z-0 hidden bg-blue-100 rounded-full sm:flex w-96 h-96 -left-20 -top-20 md:-top-32 lg:-top-36">
        </div>

        <img class="absolute bottom-0 right-0 hidden sm:block w-44 lg:w-52 lg:right-10 xl:right-20" src="{{asset('assets/images/trees.svg')}}"
            alt="Vector image of a tree">

        <div x-show="!normal" x-transition.duration.300ms
            class="relative z-10 w-full p-6 space-y-4 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">

            <a href="{{LaravelLocalization::localizeUrl('/login/google')}}" class="text-white bg-red-600 !w-full btn">
                <i class="mr-3 fa-lg fab fa-google"></i>
                {{__('Login with Google')}}
            </a>

            <a href="{{LaravelLocalization::localizeUrl('/login/fb')}}" class="text-white bg-gradient-to-b to-[#0062E0] from-[#19AFFF] !w-full btn">
                <i class="mr-3 fa-lg fab fa-facebook-square"></i>
                {{__('Login with Facebook')}}
            </a>

            <a href="{{LaravelLocalization::localizeUrl('/login/linkedin')}}" class="text-white !w-full btn bg-[#0077b5]">
                <i class="mr-3 fa-lg fab fa-linkedin"></i>
                {{__('Login with LinkedIn')}}
            </a>

            <a href="{{LaravelLocalization::localizeUrl('/login/twitter')}}" class="text-white !w-full btn bg-[#1da1f1]">
                <i class="mr-3 fa-lg fab fa-twitter"></i>
                {{__('Login with Twitter')}}
            </a>

        </div>


        <a @click="normal = ! normal" class="relative justify-center mt-4 rounded bg-gradient-to-r blue-gradient" href="#">
            <span x-show="!normal" class="gap-1 btn">
                <x-icon.icon
                    path="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                {{__('Normal Login')}}
            </span>
            <span x-show="normal" class="gap-1 btn">
                <i class="mr-3 fa-lg fab fa-facebook-square"></i>
                {{__('Social Login')}}
            </span>
        </a>

        <div x-show="normal" x-transition.duration.300ms
            class="relative z-10 w-full px-6 py-4 mt-4 space-y-4 overflow-hidden bg-white shadow-md sm:max-w-md sm:rounded-lg">

            <x-validation-errors />

            <form method="POST" class="space-y-4 " action="{{ route('login') }}">
                @csrf

                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div x-data="{ passwordType: true }">

                    <x-label for="password" value="{{ __('Password') }}" />
                    <div class="relative flex items-center w-full">
                        <input id="password" name="password" class="block w-full mt-1 rounded-md shadow-sm form-input"
                            :type="passwordType ? 'password' : 'text'" required autocomplete="current-password" placeholder="Type your password..">

                        <a @click.prevent="passwordType = !passwordType" href="#" class="absolute right-5">
                            <x-icon.icon x-show="passwordType" path="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                path2="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                            <x-icon.icon x-show="!passwordType"
                                path="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </a>

                        @error('password') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="block">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end">
                    @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 underline hover:text-gray-900"
                        href="{{LaravelLocalization::localizeUrl(route('password.request'))}}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif

                    <x-button class="ml-4">
                        {{ __('Login') }}
                    </x-button>
                </div>
            </form>

            @if (Route::has('register'))
            <p class="mt-8 text-sm text-center">
                {{ __("Don't have an account?") }}
                <a href="{{LaravelLocalization::localizeUrl(route('register'))}}" class="text-sm font-bold text-logo-blue">{{ __("Register here!")
                    }}</a>
            </p>
            @endif
        </div>

    </div>
</x-app-layout>