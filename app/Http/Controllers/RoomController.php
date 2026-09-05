<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Support\Availability;
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
        $room = Room::create($this->validated($request));

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

    public function update(Request $request, Room $room)
    {
        $room->update($this->validated($request, $room));

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

    /**
     * One validation set for create and update. Amenities arrive as a comma separated
     * string from the form and are stored as an array. The photo path is restricted to
     * files under public/images so no external URL can be injected into the page.
     */
    private function validated(Request $request, ?Room $room = null): array
    {
        $data = $request->validate([
            'room_number' => ['required', 'string', 'max:10', 'regex:/^[A-Za-z0-9-]+$/', 'unique:rooms,room_number'.($room ? ','.$room->id : '')],
            'room_type' => ['required', 'string', 'max:50'],
            'capacity' => ['required', 'integer', 'min:1', 'max:12'],
            'price_per_night' => ['required', 'numeric', 'min:0', 'max:100000'],
            'status' => ['required', 'in:available,occupied,maintenance'],
            'description' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:255', 'regex:#^/images/[A-Za-z0-9._-]+\.(webp|jpg|jpeg|png)$#'],
            'amenities' => ['nullable', 'string', 'max:500'],
        ]);

        $data['amenities'] = collect(explode(',', (string) ($data['amenities'] ?? '')))
            ->map(fn ($a) => trim($a))
            ->filter()
            ->values()
            ->all();

        return $data;
    }
}
