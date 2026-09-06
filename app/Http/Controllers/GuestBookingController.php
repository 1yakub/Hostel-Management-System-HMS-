<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestBookingRequest;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/** A signed in guest's own bookings under /my. Every query is scoped to the current user. */
class GuestBookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()->with('room')->latest('check_in_date')->get();

        return view('guest.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $availableRooms = Room::where('status', 'available')
            ->orderBy('room_type')
            ->orderBy('room_number')
            ->get()
            ->groupBy('room_type');

        if ($availableRooms->isEmpty()) {
            return redirect()->route('home')->with('error', 'No beds are open for requests at the moment.');
        }

        return view('guest.bookings.create', compact('availableRooms'));
    }

    public function store(RequestBookingRequest $request)
    {
        $validated = $request->validated();
        $room = $request->room();
        $nights = Carbon::parse($validated['check_in_date'])->diffInDays($validated['check_out_date']);

        Booking::create([
            'room_id' => $room->id,
            'guest_id' => Guest::forUser($request->user())->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_amount' => $room->price_per_night * $nights,
            'status' => 'active',
        ]);

        return redirect()->route('guest.bookings')
            ->with('success', 'Your request is in. The bed is held for you; pay at the desk when you arrive.');
    }
}
