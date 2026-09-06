<?php

namespace App\Http\Requests\Desk;

use App\Models\Room;
use App\Support\Availability;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/** A desk booking: one room, one to twelve registered guests, a date range that is free. */
class StoreBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'guest_ids' => ['required', 'array', 'min:1', 'max:12'],
            'guest_ids.*' => ['integer', 'distinct', 'exists:guests,id'],
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
        ];
    }

    /** Capacity and availability checks as "after" validation rules. */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $room = $this->room();

                if (count($this->input('guest_ids', [])) > $room->capacity) {
                    $validator->errors()->add('guest_ids', "Room {$room->room_number} sleeps {$room->capacity}.");
                }

                if (! Availability::isRoomFree($room, $this->input('check_in_date'), $this->input('check_out_date'))) {
                    $validator->errors()->add('room_id', "Room {$room->room_number} is already booked for part of those dates.");
                }
            },
        ];
    }

    public function room(): Room
    {
        return Room::findOrFail($this->integer('room_id'));
    }
}
