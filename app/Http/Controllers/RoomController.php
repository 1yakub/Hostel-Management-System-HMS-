<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance'
        ]);

        Room::create($validated);
        return redirect()->route('rooms.index')->with('success', 'Room created successfully');
    }

    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $room->id,
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status' => 'required|in:available,occupied,maintenance'
        ]);

        $room->update($validated);
        return redirect()->route('rooms.show', $room)->with('success', 'Room updated successfully');
    }

    public function destroy(Room $room)
    {
        if ($room->bookings()->where('status', 'active')->exists()) {
            return back()->with('error', 'Cannot delete room with active bookings');
        }

        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully');
    }
}
