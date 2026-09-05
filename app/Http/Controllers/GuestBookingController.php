<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Guest;
use App\Models\Room;
use App\Support\Availability;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class GuestBookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('room')->latest('check_in_date')->get();

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
            return redirect('/')->with('error', 'No beds are open for requests at the moment.');
        }

        return view('guest.bookings.create', compact('availableRooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'check_in_date' => ['required', 'date', 'after:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
        ]);

        $room = Room::findOrFail($validated['room_id']);

        if (! Availability::isRoomFree($room, $validated['check_in_date'], $validated['check_out_date'])) {
            return back()->withInput()->withErrors(['room_id' => 'That bed was taken for those dates a moment ago. Please pick another.']);
        }

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
