<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Support\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['guest', 'room'])->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('status', '!=', 'maintenance')->get();
        $guests = Guest::orderBy('name')->get();

        return view('bookings.create', compact('rooms', 'guests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_ids' => ['required', 'array', 'min:1', 'max:12'],
            'guest_ids.*' => ['integer', 'distinct', 'exists:guests,id'],
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
        ]);

        $room = Room::findOrFail($validated['room_id']);

        if (count($validated['guest_ids']) > $room->capacity) {
            return back()->withInput()->withErrors(['guest_ids' => "Room {$room->room_number} sleeps {$room->capacity}."]);
        }

        if (! Availability::isRoomFree($room, $validated['check_in_date'], $validated['check_out_date'])) {
            return back()->withInput()->withErrors(['room_id' => "Room {$room->room_number} is already booked for part of those dates."]);
        }

        $nights = Carbon::parse($validated['check_in_date'])->diffInDays($validated['check_out_date']);

        $booking = DB::transaction(function () use ($validated, $room, $nights) {
            $primary = null;
            foreach ($validated['guest_ids'] as $i => $guestId) {
                $created = Booking::create([
                    'guest_id' => $guestId,
                    'room_id' => $room->id,
                    'check_in_date' => $validated['check_in_date'],
                    'check_out_date' => $validated['check_out_date'],
                    'status' => 'active',
                    // The first guest carries the bill; companions ride along at zero.
                    'total_amount' => $i === 0 ? $room->price_per_night * $nights : 0,
                ]);
                $primary ??= $created;
            }

            // Only a stay that starts today changes the room's live status.
            if (Carbon::parse($validated['check_in_date'])->isToday()) {
                $room->update(['status' => 'occupied']);
            }

            return $primary;
        });

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking created.');
    }

    public function show(Booking $booking)
    {
        $booking->load(['guest', 'room']);

        return view('bookings.show', compact('booking'));
    }

    public function checkout(Booking $booking)
    {
        DB::transaction(function () use ($booking) {
            // Every companion on the same stay checks out together.
            Booking::where('room_id', $booking->room_id)
                ->whereDate('check_in_date', $booking->check_in_date)
                ->whereDate('check_out_date', $booking->check_out_date)
                ->where('status', 'active')
                ->update(['status' => 'completed']);

            $stillOccupied = Booking::where('room_id', $booking->room_id)
                ->whereIn('status', Availability::HOLDING_STATUSES)
                ->whereDate('check_in_date', '<=', today())
                ->whereDate('check_out_date', '>', today())
                ->exists();

            if (! $stillOccupied) {
                $booking->room->update(['status' => 'available']);
            }
        });

        return redirect()->route('bookings.show', $booking)->with('success', 'Checked out. The room is free again.');
    }
}
