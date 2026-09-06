<?php

namespace App\Http\Controllers;

use App\Http\Requests\Desk\StoreBookingRequest;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Support\Availability;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Booking::class, 'booking');
    }

    public function index()
    {
        return view('bookings.index', ['bookings' => Booking::with(['guest', 'room'])->get()]);
    }

    public function create()
    {
        return view('bookings.create', [
            'rooms' => Room::where('status', '!=', 'maintenance')->get(),
            'guests' => Guest::orderBy('name')->get(),
        ]);
    }

    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();
        $room = $request->room();
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
                    'total_amount' => $i === 0 ? $room->price_per_night * $nights : 0,
                ]);
                $primary ??= $created;
            }

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
        $this->authorize('update', $booking);

        DB::transaction(function () use ($booking) {
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
