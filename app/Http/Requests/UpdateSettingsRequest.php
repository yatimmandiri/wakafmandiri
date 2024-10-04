<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'handphone' => ['required', 'string'],
            'facebook' => ['required', 'string'],
            'instagram' => ['required', 'string'],
            'twitter' => ['required', 'string'],
            'youtube' => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }
}
