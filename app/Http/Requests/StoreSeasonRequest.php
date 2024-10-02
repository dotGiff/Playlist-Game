<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeasonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'season_name' => ['required', 'string'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'round_name' => ['required', 'string'],
            'round_category' => ['required', 'string'],
            'round_description' => ['required', 'string'],
        ];
    }
}
