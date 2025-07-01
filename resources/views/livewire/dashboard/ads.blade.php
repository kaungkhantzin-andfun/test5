<x-dashboard.table-wrapper :data="$ads">
    <x-slot name="header">

        <th class="user_th">{{ __('Image') }}</th>
        <th class="user_th">{{ __('Name') }}</th>
        <th class="user_th">{{ __('Placement') }}</th>
        <th class="user_th">{{ __('Link') }}</th>
        <th class="user_th">{{ __('Expiry Date') }}</th>
        <th class="user_th">{{ __('Actions') }}</th>

    </x-slot>

    @foreach ($ads as $ad)
    <tr>
        <td class="user_td">
            <img class="rounded w-36" src="{{Storage::url($ad->image->path)}}" />
        </td>
        <td class="user_td">{{$ad->name}}</td>
        <td class="user_td">{{$ad->placement}}</td>
        <td class="user_td">{{$ad->link}}</td>
        <td class="user_td">{{$ad->expiry->format('d-M-Y')}}</td>
        <td class="user_td">
            <p class="flex gap-8">
                <a href="{{LaravelLocalization::localizeUrl('/dashboard/ads/' . $ad->id . '/edit')}}"
                    class="text-gray-600 tooltip hover:text-gray-900">
                    <x-icon.icon
                        path="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    <span class="tooltiptext">{{ __('Edit') }}</span>
                </a>
                <span x-data="{sure: false}">
                    <a x-show="sure" @click="sure = false" class="text-red-600 cursor-pointer hover:text-red-900" wire:click="delItem({{$ad->id}})"
                        href="#"> Sure? </a>
                    <a x-show="!sure" @click="sure = true" @click.away="sure = false" class="text-red-600 cursor-pointer tooltip hover:text-red-900"
                        href="#">
                        <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                        <span class="tooltiptext">{{ __('Delete') }}</span>
                    </a>
                </span>
            </p>
        </td>
    </tr>
    @endforeach

</x-dashboard.table-wrapper>