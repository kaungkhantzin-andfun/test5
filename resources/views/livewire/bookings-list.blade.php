<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <h2 class="text-2xl font-semibold leading-tight mb-6">{{ __('My Bookings') }}</h2>

        <div class="flex flex-col lg:flex-row lg:space-x-6">
            <!-- Bookings Table -->
            <div class="w-full lg:w-3/4 mb-6 lg:mb-0">
                <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                    <div class="inline-block min-w-full border border-gray-300 rounded-md overflow-hidden">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 border-b border-gray-300 text-left font-medium text-gray-700">
                                        {{ __('Property') }}
                                    </th>
                                    <th class="px-5 py-3 border-b border-gray-300 text-left font-medium text-gray-700">
                                        {{ __('Check-in Date') }}
                                    </th>
                                    <th class="px-5 py-3 border-b border-gray-300 text-left font-medium text-gray-700">
                                        {{ __('Check-out Date') }}
                                    </th>
                                    <th class="px-5 py-3 border-b border-gray-300 text-left font-medium text-gray-700">
                                        {{ __('Number of Guests') }}
                                    </th>
                                    <th class="px-5 py-3 border-b border-gray-300 text-left font-medium text-gray-700">
                                        {{ __('Status') }}
                                    </th>
                                    <th class="px-5 py-3 border-b border-gray-300 text-left font-medium text-gray-700">
                                        {{ __('Actions') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr class="border-b border-gray-200">
                                        <td class="px-5 py-4">
                                            <div class="flex items-center">
                                                <div class="w-20 h-20 overflow-hidden rounded">
                                                    <img class="w-full h-full object-cover"
                                                        src="{{ asset('storage/' . $booking->property->images->first()->path) }}"
                                                        alt="" />
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-gray-900">{{ $booking->property->detail->first()->title }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if ($editingBookingId === $booking->id)
                                                <input type="date" wire:model="editedBookingData.check_in_date" class="w-full border border-gray-300 rounded px-2 py-1">
                                            @else
                                                <p>{{ $booking->check_in_date }}</p>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            @if ($editingBookingId === $booking->id)
                                                <input type="date" wire:model="editedBookingData.check_out_date" class="w-full border border-gray-300 rounded px-2 py-1">
                                            @else
                                                <p>{{ $booking->check_out_date }}</p>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            @if ($editingBookingId === $booking->id)
                                                <input type="number" wire:model="editedBookingData.number_of_guests" class="w-full border border-gray-300 rounded px-2 py-1">
                                            @else
                                                <p>{{ $booking->number_of_guests }}</p>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-block px-2 py-1 border border-gray-300 rounded">
                                                {{ $booking->status }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center space-x-2">
                                                @if ($editingBookingId === $booking->id)
                                                    <button wire:click="updateBooking({{ $booking->id }})" class="text-green-600 hover:text-green-800">
                                                        ✔
                                                    </button>
                                                    <button wire:click="cancelEdit" class="text-red-600 hover:text-red-800">
                                                        ✖
                                                    </button>
                                                @else
                                                    @if ($booking->status === 'pending')
                                                        <button wire:click="editBooking({{ $booking->id }})" class="text-blue-600 hover:text-blue-800">
                                                            ✏️
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="w-full lg:w-1/4 border border-gray-300 rounded-md p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Booking Stats') }}</h3>
                <div class="space-y-4">
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-700">{{ __('Total Bookings') }}</span>
                        <span class="font-medium text-gray-900">{{ $totalBookings }}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="text-gray-700">{{ __('Pending') }}</span>
                        <span class="font-medium text-gray-900">{{ $pendingBookings }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-700">{{ __('Confirmed') }}</span>
                        <span class="font-medium text-gray-900">{{ $confirmedBookings }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
