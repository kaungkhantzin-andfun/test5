<x-dashboard.table-wrapper :data="$locations">
    <x-slot name="header">
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('name')" role="button" href="#">
                {{ __('Region') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'name'" />
            </a>
        </th>
        <th class="user_th">{{ __('Townships') }}</th>
        <th class="user_th">{{ __('Details') }}</th>

        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('postal_code') role=" button" href="#">
                {{ __('Postal Code') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'postal_code'" />
            </a>
        </th>
        <th class="user_th">{{ __('Actions') }}</th>
    </x-slot>

    @foreach ($locations as $location)
    <tr>
        <td class="user_td">{{$location->name}}</td>
        {{-- <td class="user_td">{{\Str::slug($location->name)}}</td> --}}
        <td class="user_td">
            @foreach (App\Models\Location::where('parent_id', $location->id)->get() as $township)
            {{$township->name}}{{$loop->last ? '' : ','}}
            @endforeach
        </td>
        <td class="user_td">{!! \Str::limit($location->description, 100) !!}</td>
        <td class="user_td">{{$location->postal_code}}</td>
        <td class="p-2 user_td">
            <p class="flex justify-between gap-4">
                <a href="{{LaravelLocalization::localizeUrl('/dashboard/locations/' . $location->id . '/edit')}}"
                    class="text-gray-600 hover:text-gray-900 tooltip">
                    <x-icon.icon
                        path="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    <span class="tooltiptext">{{ __('Edit') }}</span>
                </a>
                <span x-data="{sure: false}" class="tooltip">
                    <a x-show="sure" class="text-red-600 cursor-pointer hover:text-red-900" wire:click="delCity({{$location->id}})" href="#"> Sure?
                    </a>
                    <a x-show="!sure" @click="sure = true" class="text-red-600 cursor-pointer hover:text-red-900" href="#">
                        <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                    </a>
                    <span class="tooltiptext">{{ __('Delete') }}</span>
                </span>
            </p>
        </td>
    </tr>
    @endforeach

</x-dashboard.table-wrapper>