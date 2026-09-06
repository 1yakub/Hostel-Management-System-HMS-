<?php

namespace App\Http\Requests;

use App\Models\Room;
use App\Support\Availability;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/** A guest asks for a bed from the public site: one room, dates from tomorrow, room still free. */
class RequestBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'check_in_date' => ['required', 'date', 'after:today'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                if (! Availability::isRoomFree($this->room(), $this->input('check_in_date'), $this->input('check_out_date'))) {
                    $validator->errors()->add('room_id', 'That bed was taken for those dates a moment ago. Please pick another.');
                }
            },
        ];
    }

    public function room(): Room
    {
        return Room::findOrFail($this->integer('room_id'));
    }
}
