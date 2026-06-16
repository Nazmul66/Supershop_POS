<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdminRoleRequest extends FormRequest
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
                'branch_name'   => ['required', 'array'],
                'branch_name.*' => ['exists:branches,id'],
                
                'device_name'   => ['required', 'array'],
                'device_name.*' => ['exists:devices,id'],
                'name'         => ['required', 'string', 'unique:admins,name', 'max:255'],
                'email'        => ['required', 'unique:admins,email', 'email', 'max:255'],
                'phone'        => ['required', 'regex:/^[0-9]{11,15}$/'],
                'password'     => [
                    'required',
                    'string', 
                    'min:8', 
                    'regex:/[a-z]/',    // Must contain at least one lowercase letter
                    'regex:/[A-Z]/',    // Must contain at least one uppercase letter
                    'regex:/[0-9]/',    // Must contain at least one number
                    'regex:/[@$!%*?&#]/' // Must contain a special character
                ],        
                'roles' => [
                    'required', 
                    'array', 
                    'exists:roles,name' // Ensure each role exists in the database
                ],
        ];
    }

    public function messages(): array
    {
        return [
            'branch_name.required' => 'The Branch name field is required.',
            'device_name.unique'   => 'This Device name is already in use.',
            'name.required'     => 'The name field is required.',
            'name.unique'       => 'This name is already in use.',
            'email.required'    => 'The email field is required.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'This email is already in use.',
            'password.required' => 'The password field is required.',
            'password.min'      => 'The password must be at least 8 characters.',
            'password.regex'    => 'The password must include uppercase, lowercase, numbers, and special characters.',
            'roles.required'    => 'Please assign at least one role.',
            'roles.exists'      => 'One or more of the selected roles are invalid.',
        ];
    }
}
