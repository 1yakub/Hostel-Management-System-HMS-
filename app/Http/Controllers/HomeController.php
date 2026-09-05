<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Support\Availability;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $roomTypes = Room::query()
            ->orderBy('price_per_night')
            ->get()
            ->groupBy('room_type')
            ->map(fn ($rooms) => [
                'name' => $rooms->first()->room_type,
                'description' => $rooms->first()->description,
                'image' => $rooms->first()->featured_image,
                'capacity' => $rooms->max('capacity'),
                'price' => $rooms->min('price_per_night'),
                'count' => $rooms->count(),
                'amenities' => collect($rooms->first()->amenities ?? [])->take(4),
            ])
            ->values();

        return view('welcome', [
            'roomTypes' => $roomTypes,
            'faq' => config('hms.faq'),
            'tonight' => Availability::freeRoomCountForNight(now()->toDateString()),
        ]);
    }

    public function availability(Request $request): View
    {
        $validated = $request->validate([
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $rooms = Availability::roomsFreeBetween(
            $validated['check_in'],
            $validated['check_out'],
            (int) $validated['guests'],
        );

        $nights = \Carbon\Carbon::parse($validated['check_in'])->diffInDays($validated['check_out']);

        return view('availability', [
            'rooms' => $rooms,
            'nights' => $nights,
            'search' => $validated,
        ]);
    }
}
