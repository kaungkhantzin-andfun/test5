<x-dashboard.table-wrapper :data="$properties">
    <x-slot name="tableTop">
        @if (!empty($selectedProperties))
        <div class="flex space-x-2">
            <select wire:model="selectedUser" class="pr-8 w-min">
                <option value="">{{ __('Change Owner') }}</option>
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user?->name }}</option>
                @endforeach
            </select>

            @if (!empty($selectedUser))
            <input wire:click="changeOwner" class="bg-gray-200 input" type="button" value="Change" />
            @endif
        </div>
        @endif
    </x-slot>

    <x-slot name="header">
        @if (Auth::user()->role == 'remwdstate20')
        <th class="user_th">
            <label class="flex">
                {{-- <input class="mr-2 border border-gray-300 rounded-sm" wire:model="pageSelected.{{$properties->currentPage()}}"
                    wire:click="selectPage({{$properties->currentPage()}})" type="checkbox"> --}}
                {{-- {{ __('Page') }} --}}
                {{ __('Select') }}
            </label>
        </th>
        @endif
        <th class="user_th">{{ __('Title') }}</th>
        <th class="user_th">{{ __('Image') }}</th>
        <th class="user_th">{{ __('Location') }}</th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('type_id')" role="button" href="#">
                {{ __('Type') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'type_id'" />
            </a>
        </th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('property_purpose_id')" role="button" href="#">
                {{ __('Purpose') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'property_purpose_id'" />
            </a>
        </th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('price')" role="button" href="#">
                {{ __('Price') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'price'" />
            </a>
        </th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('user_id')" role="button" href="#">
                {{ __('By') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'user_id'" />
            </a>
        </th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('stat')" role="button" href="#">
                {{ __('Views') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'stat'" />
            </a>
        </th>
        <th class="user_th">{{ __('Manage') }}</th>
    </x-slot>

    @forelse ($properties as $property)
    <tr>
        @if (Auth::user()->role == 'remwdstate20')
        <td class="text-center user_td">
            <input class="border border-gray-300 rounded-sm" wire:model="selectedProperties" value="{{" $property->id"}}" type="checkbox">
        </td>
        @endif
        <td class="user_td">
            @foreach ($property->detail as $detail)
            {{$detail->title}} <br />
            @endforeach
        </td>
        <td class="user_td">
            @php
            $img = $property->images->first();
            @endphp
            @if (!empty($img))
            <img class="object-cover w-[100px] rounded shadow" src="{{Storage::url('thumb_' . $img->path)}}">
            @endif
        </td>
        <td class="user_td">
            @php
            $tsp = $property->location->whereNotNull('parent_id')->first();
            $region = $property->location->whereNull('parent_id')->first() ?? null;
            // split string by last space
            $reg=preg_split("/\s+(?=\S*+$)/", $region?->name);
            @endphp

            <span class="flex min-w-max">{{ $tsp != null ? trans($tsp?->name) : ''}}, </span>
            <span class="flex min-w-max">{{ $reg != null ? trans($reg[0] ?? '') : '' }}</span>
        </td>
        <td class="user_td">
            {{__($property->type ? $property->type?->name : '-')}}
        </td>
        <td class="user_td">{{__($property->purpose ? $property->purpose?->name : '')}}</td>
        <td class="user_td">{{ floatval($property->price) }}</td>
        <td class="user_td">{{$property->user ? $property->user?->name : ''}}</td>
        <td class="user_td">
            {{number_format($property->stat)}}
        </td>
        <td class="border-b">
            <span class="flex flex-wrap w-40 gap-5">

                <span class="text-gray-500 tooltip hover:text-blue-600">
                    <a href="{{LaravelLocalization::localizeUrl('/dashboard/properties/' . $property->id . '/edit')}}">
                        <x-icon.solid-icon path="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                            path2="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                    </a>
                    <span class="tooltiptext">{{ __('Edit') }}</span>
                </span>

                <span class="text-gray-500 tooltip hover:text-blue-600">
                    <a href="#" wire:click.prevent="duplicateProperty({{$property->id}})">
                        <x-icon.icon
                            path="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </a>
                    <span class="tooltiptext">{{ __('Duplicate and edit') }}</span>
                </span>

                <span class="text-gray-500 tooltip hover:text-blue-600" target="_blank">
                    <a target="_blank" href="{{LaravelLocalization::localizeUrl('/properties/' . $property->id . '/' . $property->slug)}}">
                        <x-icon.icon
                            path2="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                            path="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </a>
                    <span class="tooltiptext">{{ __('View how it looks') }}</span>
                </span>

                <span class="text-gray-500 tooltip hover:text-blue-600">
                    <a href="#" wire:click.prevent="renewProperty({{$property->id}})">
                        <x-icon.solid-icon
                            path="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" />
                    </a>
                    <span class="tooltiptext">{{ __('Renew') }}</span>
                </span>

                @if ($property->featured != null)

                <span class="text-green-500 hover:text-green-600 tooltip">
                    <a wire:click.prevent="removeFeatured({{$property->id}})" href="#">
                        <x-icon.icon fill="currentColor"
                            path="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </a>
                    <span class="tooltiptext">{{ __('Remove featured') }}</span>
                </span>

                @else

                <span class="text-gray-500 tooltip hover:text-blue-600">
                    <a wire:click.prevent="feature({{$property->id}})" href="#">
                        <x-icon.icon
                            path="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </a>
                    <span class="tooltiptext">{{ __('Feature listing') }}</span>
                </span>

                @endif

                @if ($property->soldout != null)

                <span class="text-blue-500 tooltip hover:text-blue-600">
                    <a href="#" wire:click.prevent="removeSoldOut({{$property->id}})">
                        <x-icon.solid-icon
                            path="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />

                    </a>
                    <span class="tooltiptext">{{ __('Unmark as sold out') }}</span>
                </span>

                @else

                <span class="text-gray-500 tooltip hover:text-blue-600">
                    <a href="#" wire:click.prevent="soldOut({{$property->id}})">
                        <x-icon.icon path="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </a>
                    <span class="tooltiptext">{{ __('Mark as sold out') }}</span>
                </span>

                @endif

                <x-delete-button :del-id="$del_id" :item-id="$property->id" />

            </span>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="11" class="p-8 text-center">
            <p>{{ __('No properties found!') }}</p>
        </td>
    </tr>
    @endforelse

</x-dashboard.table-wrapper>