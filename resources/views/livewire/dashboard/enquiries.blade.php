<x-dashboard.table-wrapper :data="$enquiries">
    <x-slot name="tableTop">
        <div x-data="{openModal: false}">
            <div x-show="openModal" @open-modal.window="openModal = true" x-cloak
                class="fixed inset-0 z-30 flex items-start justify-center p-8 overflow-y-scroll bg-gray-900/70">
                <div class="relative max-w-sm bg-white rounded sm:max-w-lg" @click.away="openModal = false">

                    <a href="#" @click.prevent="openModal = false" class="absolute z-10 p-0.5 text-white bg-red-600 rounded-full -right-2 -top-2">
                        <x-icon.icon path="M6 18L18 6M6 6l12 12" />
                    </a>

                    @if (is_object($modalContent))
                    @if ($modalType == 'property')
                    <livewire:property-card :key="time().$modalContent->id" layout="vertical" :show-uploader="true" :enquiry-modal="true"
                        :property="$modalContent" :saved-property-ids="$savedPropertyIds" :compare-ids="$compareIds" />
                    @else
                    <ul class="px-4 my-6 text-sm leading-7 text-left">
                        <li>{{__('Credit')}}: {{number_format($modalContent->credit)}} {{__('Points')}}</li>
                        <li>{{__('Price')}}: {{number_format($modalContent->price)}} {{__('MMK')}}</li>
                        <li>{{__('Discount')}}: {{number_format($modalContent->discount)}} %</li>
                    </ul>
                    @endif
                    @else
                    {{ $modalContent }}
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="header">
        <th class="user_th">{{ __('For') }}</th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('title')" role="button" href="#">
                {{ __('Title') }}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'title'" />
            </a>
        </th>
        <th class="user_th">{{ __('Customer Info') }}</th>
        <th class="user_th">{{ __('Message') }}</th>
        <th class="user_th">
            <a class="flex items-center" wire:click.prevent="sortBy('status')" role="button" href="#">
                {{__('Status')}}
                <x-sort-icon :sortAsc="$sortAsc" :sortField="$sortField" :field="'status'" />
            </a>
        </th>
        <th class="user_th">{{ __('Actions') }}</th>
    </x-slot>

    @forelse ($enquiries as $enquiry)
    <tr>
        <td class="user_td">
            @if (!empty($enquiry->property))
            <a class="text-blue-600 hover:underline" wire:click.prevent="showDetail({{ $enquiry->property->id }})" href="#">
                {{$enquiry->property->translation->title}}
            </a>
            @elseif(!empty($enquiry->package))
            <a class="text-blue-600 hover:underline" wire:click.prevent="showPackage({{ $enquiry->package->id }})" href="#">
                {{$enquiry->package->name}}
            </a>
            @elseif(!empty($enquiry->agent))
            {{ __('Sent from agent profile page.') }}
            @else
            {{ __("Sent from contact page.") }}
            @endif
        </td>
        <td class="user_td">{{$enquiry->title}}</td>
        <td class="space-y-2 user_td">
            <span class="flex w-full gap-1">
                <x-icon.icon class="w-4 h-4" path="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                {{$enquiry->name}}
            </span>
            <span class="flex w-full gap-1">
                <x-icon.icon class="w-4 h-4" path="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                {{$enquiry->phone}}
            </span>
            <span class="flex w-full gap-1">
                <x-icon.icon class="w-4 h-4"
                    path="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                {{$enquiry->email}}
            </span>
        </td>
        <td class="user_td">
            {{-- <a wire:click.prevent="showMessage({{ $enquiry->id }})" class="tooltip" href="#">
                <x-icon.icon :class="'w-6 h-6 mx-auto text-gray-600'" :path="'M15 12a3 3 0 11-6 0 3 3 0 016 0z'"
                    :path2="'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'" />
                <span class="tooltiptext">{{ __('View message') }}</span>
            </a> --}}
            <span class="flex w-full gap-1 mb-1 text-xs font-bold">
                <x-icon.icon class="w-4 h-4" path="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                {{$enquiry->created_at->format('d-M-y')}}
            </span>
            {{ $enquiry->message }}
        </td>
        <td class="user_td">{{$enquiry->status}}</td>
        <td class="user_td">
            <p class="flex items-center justify-between gap-3">
                @if ($enquiry->status == null || $enquiry->status != 'Done')
                <a wire:click.prevent="done({{$enquiry->id}})" class="text-green-600 tooltip" href="#">
                    <x-icon.solid-icon path="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"
                        path2="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                    <span class="tooltiptext">{{ __('Mark as done') }}</span>
                </a>
                @else
                <a wire:click.prevent="removeDone({{$enquiry->id}})" class="text-gray-600 tooltip" href="#">
                    <x-icon.icon
                        path="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                    <span class="tooltiptext">{{ __('Mark as undone') }}</span>
                </a>
                @endif

                <span x-data="{sure: false}">
                    <a x-show="sure" @click.away="sure = false" class="text-red-600 cursor-pointer hover:text-red-900"
                        wire:click="delItem({{$enquiry->id}})" href="#">
                        Sure?
                    </a>

                    <a x-show="!sure" @click="sure = true" class="text-red-600 cursor-pointer hover:text-red-900 tooltip" $enquiry"#">
                        <x-icon.solid-icon path="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" />
                        <span class="tooltiptext">{{ __('Delete') }}</span>
                    </a>
                </span>
            </p>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="p-8 text-center">
            <p>{{ __('No message yet!') }}</p>
        </td>
    </tr>
    @endforelse

</x-dashboard.table-wrapper>