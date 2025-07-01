<x-dashboard.table-wrapper :data="$packages">
    <x-slot name="header">

        <th class="user_th">{{ __('Name') }}</th>
        <th class="user_th">{{ __('Credit') }}</th>
        <th class="user_th">{{ __('Price') }}</th>
        <th class="user_th">{{ __('Discount') }}</th>
        <th class="user_th">{{ __('Actions') }}</th>

    </x-slot>

    @forelse ($packages as $package)
    <tr>
        <td class="user_td">{{$package->name}}</td>
        <td class="user_td">{{$package->credit}}</td>
        <td class="user_td">{{$package->price}}</td>
        <td class="user_td">{{$package->discount}}</td>
        <td class="user_td">
            <p class="flex gap-4">
                <a href="{{LaravelLocalization::localizeUrl('/dashboard/packages/' . $package->id . '/edit')}}"
                    class="text-gray-600 hover:text-gray-900 tooltip">
                    <x-icon.icon
                        path="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    <span class="tooltiptext">{{ __('Edit') }}</span>
                </a>
                <span x-data="{sure: false}" class="tooltip">
                    <a wire:click="delItem({{$package->id}})" x-show="sure" @click.away="sure=false"
                        class="text-red-600 cursor-pointer hover:text-red-900" href="#"> Sure? </a>
                    <a x-show="!sure" @click="sure = true" class="text-red-600 cursor-pointer hover:text-red-900" href="#">
                        <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                    </a>
                    <span class="tooltiptext">{{ __('Delete') }}</span>
                </span>
            </p>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="8" class="p-8 text-center">
            <p>{{ __('No package found!') }}</p>
        </td>
    </tr>
    @endforelse

</x-dashboard.table-wrapper>