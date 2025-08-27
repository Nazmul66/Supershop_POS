<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateUnitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;  // By Default false but make this true
        return true; // Set to true to allow all authorized users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'unit' => ['required', 'unique:units,unit', 'max:255'],
            'short_name' => ['required', 'max:255'],
            'status' => ['required', 'int'],
        ];
    }


    public function messages(): array
    {
        return [
            'unit.required' => 'Please fill up unit',
            'unit.max' => 'Character might be 255',
            'unit.unique' => 'Character might be unique',
            'short_name.required' => 'Please fill up short name',
            'short_name.max' => 'Character might be 255',
        ];
    }
}
