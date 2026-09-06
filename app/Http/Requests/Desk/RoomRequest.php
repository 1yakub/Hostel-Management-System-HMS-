<?php

namespace App\Http\Requests\Desk;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/** Create and update share one rule set; the unique check ignores the room being edited. */
class RoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        // the controller's authorizeResource decides; this request only validates input
        return true;
    }

    public function rules(): array
    {
        return [
            'room_number' => ['required', 'string', 'max:10', 'regex:/^[A-Za-z0-9-]+$/', Rule::unique('rooms', 'room_number')->ignore($this->route('room'))],
            'room_type' => ['required', 'string', 'max:50'],
            'capacity' => ['required', 'integer', 'min:1', 'max:12'],
            'price_per_night' => ['required', 'numeric', 'min:0', 'max:100000'],
            'status' => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
            'description' => ['nullable', 'string', 'max:500'],
            'featured_image' => ['nullable', 'string', 'max:255', 'regex:#^/images/[A-Za-z0-9._-]+\.(webp|jpg|jpeg|png)$#'],
            'amenities' => ['nullable', 'string', 'max:500'],
        ];
    }

    /** Amenities arrive as one comma separated line and are stored as a list. */
    public function validated($key = null, $default = null): mixed
    {
        $data = parent::validated();

        $data['amenities'] = collect(explode(',', (string) ($data['amenities'] ?? '')))
            ->map(fn ($a) => trim($a))
            ->filter()
            ->values()
            ->all();

        return $key === null ? $data : data_get($data, $key, $default);
    }
}
