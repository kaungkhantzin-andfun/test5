<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingsList extends Component
{
    public $bookings;
    public $editingBookingId;
    public $editedBookingData = [
        'check_in_date' => '',
        'check_out_date' => '',
        'number_of_guests' => '',
    ];
    public $totalBookings;
    public $pendingBookings;
    public $confirmedBookings;
    public $rejectedBookings;

    public function mount()
    {
        $this->bookings = Booking::where('user_id', Auth::user()->id)->get();
        $this->totalBookings = $this->bookings->count();
        $this->pendingBookings = $this->bookings->where('status', 'pending')->count();
        $this->confirmedBookings = $this->bookings->where('status', 'confirmed')->count();
        $this->rejectedBookings = $this->bookings->where('status', 'rejected')->count();
    }

    public function render()
    {
        return view('livewire.bookings-list');
    }

    public function editBooking($bookingId)
    {
        $this->editingBookingId = $bookingId;
        $booking = Booking::find($bookingId);
        $this->editedBookingData = [
            'check_in_date' => $booking->check_in_date,
            'check_out_date' => $booking->check_out_date,
            'number_of_guests' => $booking->number_of_guests,
        ];
    }

    public function updateBooking($bookingId)
    {
        $booking = Booking::find($bookingId);
        $booking->update($this->editedBookingData);
        $this->editingBookingId = null;
        $this->bookings = Booking::where('user_id', Auth::user()->id)->get();
    }

    public function cancelEdit()
    {
        $this->editingBookingId = null;
    }
}
