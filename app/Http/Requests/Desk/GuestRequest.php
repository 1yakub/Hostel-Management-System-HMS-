<?php

namespace App\Http\Requests\Desk;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'id_number' => ['required', 'string', 'max:50', Rule::unique('guests', 'id_number')->ignore($this->route('guest'))],
        ];
    }
}
