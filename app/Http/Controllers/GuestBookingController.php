<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestBookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->latest()->get();
        return view('guest.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $availableRooms = Room::where('status', 'available')
            ->orderBy('room_type')
            ->get()
            ->groupBy('room_type');

        if ($availableRooms->isEmpty()) {
            return back()->with('error', 'No rooms are available at the moment.');
        }

        return view('guest.bookings.create', compact('availableRooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $room = Room::findOrFail($validated['room_id']);

        // Calculate number of nights
        $checkIn = \Carbon\Carbon::parse($validated['check_in_date']);
        $checkOut = \Carbon\Carbon::parse($validated['check_out_date']);
        $nights = $checkIn->diffInDays($checkOut);


        $user_id = Auth::id();

        // Create booking
        $booking = Booking::create([
            'room_id' => $room->id,
            'guest_id' => $user_id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_amount' => $room->price_per_night * $nights,
            'status' => 'active'
        ]);

        $booking->save();

        return redirect()->route('guest.bookings')
            ->with('success', 'Booking created successfully! We will confirm your booking shortly.');
    }
}
