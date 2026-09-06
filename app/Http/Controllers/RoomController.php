<?php

namespace App\Http\Controllers;

use App\Http\Requests\Desk\RoomRequest;
use App\Models\Room;
use App\Support\Availability;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Room::class, 'room');
    }

    public function index()
    {
        return view('rooms.index', ['rooms' => Room::all()]);
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(RoomRequest $request)
    {
        $room = Room::create($request->validated());

        return redirect()->route('rooms.show', $room)->with('success', 'Room '.$room->room_number.' added.');
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(RoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return redirect()->route('rooms.show', $room)->with('success', 'Room '.$room->room_number.' updated.');
    }

    public function destroy(Room $room)
    {
        if ($room->bookings()->whereIn('status', Availability::HOLDING_STATUSES)->exists()) {
            return back()->with('error', 'This room has an active booking and cannot be deleted.');
        }

        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted.');
    }
}
