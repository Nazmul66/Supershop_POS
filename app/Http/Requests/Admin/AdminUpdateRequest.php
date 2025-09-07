<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
            'name'        => ['required', 'string', 'max:255'],
            'username'    => ['nullable', 'string', 'max:255'],
            'phone'       => ['required', 'string', 'max:20'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'address'     => ['nullable', 'string'],
            'country_id'  => ['nullable', 'integer'],
            'state_id'    => ['nullable', 'integer'],
            'city_id'     => ['nullable', 'integer'],
            'postal_code' => ['nullable', 'integer'],
        ];
    }
}
