<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BookingRequest;
use Illuminate\Support\Facades\Auth;

class AdminBookingRequests extends Component
{
    public function delete($id)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403);
        }

        $booking = BookingRequest::findOrFail($id);
        $booking->delete(); // или soft delete, если используешь SoftDeletes

        $this->dispatch('bookingDeleted');
    }

    public function render()
    {
        // Загружаем заявки с связанными данными
        $bookings = BookingRequest::with(['user.userInfo', 'service', 'promocode'])
            ->orderBy('date', 'desc')
            ->get();

        return view('livewire.admin-booking-requests', compact('bookings'));
    }
}
