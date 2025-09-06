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
            [
                'required',
                'string',
                'email:rfc,dns', // Ensures a valid email format & checks domain existence
                'max:255'
            ],
            'password' => [
                'required',
                'string',
                'min:8',          // Minimum 8 characters
                'max:30',         // Maximum 30 characters
                'regex:/[a-z]/',    // Must contain at least one lowercase letter
                'regex:/[A-Z]/',    // Must contain at least one uppercase letter
                'regex:/[0-9]/',    // Must contain at least one number
                'regex:/[@$!%*?&#]/' // Must contain a special character
            ]
        ];
    }


    public function messages(): array
    {
        return [
            "email.required"    => 'The email field is required.',
            "email.email"       => 'Please enter a valid email address.',
            "email.unique"      => 'This email is already registered.',
            "password.required" => 'The password field is required.',
            "password.min"      => 'Password must be at least 8 characters long.',
            "password.max"      => 'Password cannot exceed 30 characters.',
            "password.regex"    => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
            'password.regex'    => 'The new password must include at least one lowercase letter, one uppercase letter, one number, and one special character.',
        ];
    }
}
