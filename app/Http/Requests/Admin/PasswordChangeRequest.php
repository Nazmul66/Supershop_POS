<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;  // By Default false but make this true
        return true; // Set to true to allow all authorized users
    }


    public function rules(): array
    {
        return [
            'current_pass' => 'required',
            'new_pass' => [
                'string', 
                'min:8', 
                'regex:/[a-z]/',    // Must contain at least one lowercase letter
                'regex:/[A-Z]/',    // Must contain at least one uppercase letter
                'regex:/[0-9]/',    // Must contain at least one number
                'regex:/[@$!%*?&#]/' // Must contain a special character
            ],
            'confirm_pass' => [
                'same:new_pass', // Ensure it matches the new password
            ], 
        ];
    }


    public function messages(): array
    {
        return [
            'new_pass.required'    => 'The new password field is required.',
            'new_pass.string'      => 'The new password must be a valid string.',
            'new_pass.min'         => 'The new password must be at least 8 characters long.',
            'new_pass.regex'       => 'The new password must include at least one lowercase letter, one uppercase letter, one number, and one special character.',
            'confirm_pass.required' => 'The confirm password field is required.',
            'confirm_pass.same'     => 'The confirm password must match the new password.',
        ];
    }
}
