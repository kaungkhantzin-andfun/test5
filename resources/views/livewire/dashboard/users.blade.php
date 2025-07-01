<x-dashboard.table-wrapper :data="$users">
    <x-slot name="header">

        <th class="user_th">{{ __('User') }}</th>
        <th class="user_th">{{ __('Phone') }}</th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('role')" role="button" href="#">
                {{ __('Role') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" field="role" />
            </a>
        </th>
        <th class="user_th">{{ __('Service Region') }}</th>
        <th class="user_th">{{ __('Service Townships') }}</th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('featured')" role="button" href="#">
                {{ __('Featured') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" field="featured" />
            </a>
        </th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('partner')" role="button" href="#">
                {{ __('Partner') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" field="partner" />
            </a>
        </th>
        <th class="user_th">{{ __('Actions') }}</th>

    </x-slot>

    <x-slot name="tableTop">
        <div class="flex gap-4">
            <a href="#" wire:click="exportUsers" class="flex gap-2 bg-gradient-to-r blue-gradient btn">
                {{__('Export Users')}}
                <x-icon.icon path="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </a>
            <a wire:click.prevent="$set('showImportForm', true)" href="#" class="flex gap-2 bg-gradient-to-r blue-gradient btn">
                {{__('Import Users')}}
                <x-icon.icon path="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
            </a>

            @if ($showImportForm)
            <form wire:submit.prevent="importUsers" class="flex items-center gap-4">
                <x-input.file model="file" />

                <button wire:target="importUsers" wire:loading.attr="disabled"
                    class="bg-gray-200 btn disabled:opacity-70 disabled:cursor-not-allowed">
                    <x-loading-indicator />
                    <span wire:target="importUsers" wire:loading.remove>{{__('Import Users')}}</span>
                    <span wire:target="importUsers" wire:loading>{{__('Importing')}}</span>
                </button>
            </form>
            @endif
        </div>

    </x-slot>

    @forelse ($users as $user)
    <tr>
        <td class="user_td">
            <div class="flex items-center">
                <div class="w-10 h-10 shrink-0">
                    @if ($user->profile_photo_path)
                    <img class="object-cover w-10 h-10 rounded-full" src="{{Storage::url($user->profile_photo_path)}}" />
                    @else
                    <x-icon.icon class="w-10 h-10"
                        path="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    @endif

                </div>

                <div class="ml-4">
                    <div class="text-sm font-medium leading-5 text-gray-900">{{$user->name}}</div>
                    <div class="text-sm leading-5 text-gray-500">{{$user->email}}</div>
                </div>
            </div>
        </td>
        <td class="user_td">{{$user->phone}}</td>
        <td class="user_td">{{$user->role == 'remwdstate20' ? 'Admin' : Str::ucfirst($user->role)}}
        </td>
        <td class="user_td">{{$user->location ? $user->location->name : ''}}</td>
        <td class="user_td">
            @if ($user->location)
            @php
            // returns boolean if empty
            $userTownships = unserialize($user->service_township_id);
            @endphp
            @foreach (App\Models\Location::whereIn('id', is_bool($userTownships) ? [] :
            $userTownships)->get() as $township)
            {{$township->name}}{{$loop->last ? '' : ','}}
            @endforeach
            @endif
        </td>
        <td class="p-0 user_td"><span class='inline-flex px-2 py-1 text-xs font-semibold {{$user->featured ? ' bg-green-600 text-white'
                : 'bg-red-600 text-white' }} rounded-full'>{{$user->featured ? $user->featured->format('d-M-y') : 'No'}}</span>
        </td>
        <td class="p-0 user_td"><span class='inline-flex px-2 py-1 text-xs font-semibold {{$user->partner ? ' bg-green-600 text-white'
                : 'bg-red-600 text-white' }} rounded-full'>{{$user->partner ? $user->partner->format('d-M-y') : 'No'}}</span>
        </td>
        <td class="user_td">
            <p class="flex space-x-4">
                {{-- <a href="{{LaravelLocalization::localizeUrl('/dashboard/users/' . $user->id . '/edit')}}" --}} <a
                    href="{{LaravelLocalization::localizeUrl('/user/' . $user->id . '/edit')}}" class="text-gray-600 hover:text-gray-900 tooltip">
                    <x-icon.icon
                        path="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    <span class="tooltiptext">{{ __('Edit') }}</span>
                </a>

                @if ($user->two_factor_secret != null)
                <span x-data="{sure: false}" class="tooltip">
                    <a x-show="sure" @click.away="sure=false" @click="sure=false" class="text-green-600 cursor-pointer hover:text-green-900"
                        wire:click="disableTwoFactor({{$user->id}})" href="#"> Sure? </a>
                    <a x-show="!sure" @click="sure = true" href="#" class="text-blue-600 hover:text-blue-900 tooltip">
                        <x-icon.solid-icon
                            path="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                    </a>
                    <span class="tooltiptext">{{ __('Disable Two Factor') }}</span>
                </span>
                @endif

                <x-delete-button :del-id="$del_id" :item-id="$user->id" />
            </p>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="8" class="p-8 text-center">
            <p>{{ __('No user found!') }}</p>
        </td>
    </tr>
    @endforelse

</x-dashboard.table-wrapper>