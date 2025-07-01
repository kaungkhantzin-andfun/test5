<x-dashboard.table-wrapper :data="$types">
    <x-slot name="header">
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('name')" role="button" href="#">
                {{ __('Name') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'name'" />
            </a>
        </th>
        <th class="user_th">{{\Request::is('*dashboard/types/property') ? __('Facilities') : __('Sub Categories') }}
        </th>
        <th class="user_th">{{ __('Actions') }}</th>
    </x-slot>

    @foreach ($types as $type)
    <tr>
        <td class="user_td">{{$type->name}}</td>
        <td class="user_td">
            @foreach (App\Models\Category::where('parent_id', $type->id)->get() as $cat)
            {{$cat->name}}{{$loop->last ? '' : ','}}
            @endforeach
        </td>
        <td class="user_td">
            <p class="flex gap-6">
                <a href="{{LaravelLocalization::localizeUrl('/dashboard/types')}}/{{$type->of}}/{{$type->id}}/edit"
                    class="text-gray-600 hover:text-gray-900 tooltip">
                    <x-icon.icon
                        path="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    <span class="tooltiptext">{{ __('Edit') }}</span>
                </a>

                <x-delete-button :del-id="$del_id" :item-id="$type->id" />

                {{-- <span x-data="{sure: false}" class="tooltip">
                    <a x-show="sure" @click.prevent="sure = false" class="text-red-600 cursor-pointer hover:text-red-900"
                        wire:click.prevent="delType({{$type->id}})" href="#">{{__('Sure?')}}</a>
                    <a x-show="!sure" @click.prevent="sure = true" class="text-red-600 cursor-pointer hover:text-red-900" href="#">
                        <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                    </a>
                    <span class="tooltiptext">{{ __('Delete') }}</span>
                </span> --}}
            </p>
        </td>
    </tr>
    @endforeach

</x-dashboard.table-wrapper>