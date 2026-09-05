<?php

namespace App\Ai\Tools;

use App\Support\Availability;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Carbon;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class CheckAvailability implements Tool
{
    public function description(): string
    {
        return 'Check which beds and rooms are free for a date range and party size. Read only. Dates are YYYY-MM-DD.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'check_in' => $schema->string()->description('Check in date, YYYY-MM-DD')->required(),
            'check_out' => $schema->string()->description('Check out date, YYYY-MM-DD, after check in')->required(),
            'guests' => $schema->integer()->min(1)->max(12)->description('Number of guests')->required(),
        ];
    }

    public function handle(Request $request): string
    {
        $data = $request->validate([
            'check_in' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'check_out' => ['required', 'date_format:Y-m-d', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $nights = Carbon::parse($data['check_in'])->diffInDays($data['check_out']);
        if ($nights > 30) {
            return 'Stays longer than 30 nights are arranged by email, not through the site.';
        }

        $rooms = Availability::roomsFreeBetween($data['check_in'], $data['check_out'], (int) $data['guests']);

        if ($rooms->isEmpty()) {
            return "Nothing is free for {$data['check_in']} to {$data['check_out']} for {$data['guests']} guest(s). Suggest shifting the dates by a day or writing to the desk.";
        }

        $symbol = config('hms.currency_symbol');
        $lines = $rooms->groupBy('room_type')->map(function ($group, $type) use ($nights, $symbol) {
            $room = $group->first();
            $total = $room->price_per_night * $nights;
            return "{$type}: {$group->count()} free, sleeps {$room->capacity}, {$symbol}".number_format($room->price_per_night, 0)." a night, {$symbol}".number_format($total, 0)." for {$nights} night(s)";
        })->values()->implode("\n");

        return "Free for {$data['check_in']} to {$data['check_out']} ({$nights} night(s)), {$data['guests']} guest(s):\n{$lines}\nBooking is a request through the availability search on the page; payment at the desk.";
    }
}
