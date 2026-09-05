<?php

namespace App\Ai\Tools;

use App\Models\Room;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class RoomTypes implements Tool
{
    public function description(): string
    {
        return 'List the room types the hostel offers with capacity, nightly price, description and amenities. Read only. Takes no arguments.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [];
    }

    public function handle(Request $request): string
    {
        $symbol = config('hms.currency_symbol');

        $lines = Room::query()
            ->orderBy('price_per_night')
            ->get()
            ->groupBy('room_type')
            ->map(function ($rooms, $type) use ($symbol) {
                $r = $rooms->first();
                $amenities = implode(', ', $r->amenities ?? []);
                return "{$type} ({$rooms->count()} in the house, sleeps {$r->capacity}, {$symbol}".number_format($r->price_per_night, 0)." a night): {$r->description} Amenities: {$amenities}.";
            })
            ->values();

        return $lines->isEmpty() ? 'No rooms are listed right now.' : $lines->implode("\n");
    }
}
