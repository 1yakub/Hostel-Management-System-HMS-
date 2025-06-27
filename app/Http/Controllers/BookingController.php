<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['guest', 'room'])->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        $guests = Guest::all();
        return view('bookings.create', compact('rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_ids' => 'required|array',
            'guest_ids.*' => 'exists:guests,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $room = Room::findOrFail($request->room_id);

        // Calculate total days
        $checkIn = \Carbon\Carbon::parse($request->check_in_date);
        $checkOut = \Carbon\Carbon::parse($request->check_out_date);
        $days = $checkIn->diffInDays($checkOut);

        // Create the main booking with the first guest
        $booking = Booking::create([
            'guest_id' => $validated['guest_ids'][0], // Primary guest
            'room_id' => $validated['room_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'status' => 'active',
            'total_amount' => $room->price_per_night * $days
        ]);

        // Create additional guest bookings if any
        foreach (array_slice($validated['guest_ids'], 1) as $additionalGuestId) {
            Booking::create([
                'guest_id' => $additionalGuestId,
                'room_id' => $validated['room_id'],
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'status' => 'active',
                'total_amount' => 0 // Only primary guest pays
            ]);
        }

        // Update room status
        $room->update(['status' => 'occupied']);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking created successfully');
    }

    public function show(Booking $booking)
    {
        $booking->load(['guest', 'room']);
        return view('bookings.show', compact('booking'));
    }

    public function checkout(Booking $booking)
    {
        $booking->update(['status' => 'completed']);
        $booking->room->update(['status' => 'available']);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Guest checked out successfully');
    }
}
