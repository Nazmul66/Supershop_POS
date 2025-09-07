<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'site_name'   => ['required', 'string', 'max:255'],
            'email'       => ['required', 'email', 'max:255'],
            'phone'       => ['required', 'string', 'max:20'],
            'fax'         => ['nullable', 'string', 'max:50'],
            'website'     => ['nullable', 'url', 'max:255'],
        
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'icon'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'favicon'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'dark_logo'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        
            'address'     => ['nullable', 'string', 'max:500'],
            'country_id'  => ['nullable', 'integer'],
            'state_id'    => ['nullable', 'integer'],
            'city_id'     => ['nullable', 'integer'],
            'postal_code' => ['nullable', 'string', 'max:20'],
        ];
    }
}
