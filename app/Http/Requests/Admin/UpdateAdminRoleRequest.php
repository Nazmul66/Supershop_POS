<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRoleRequest extends FormRequest
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
        $id = $this->route('admin_role');

        return [
            'branch_name'   => ['required', 'array'],
            'branch_name.*' => ['exists:branches,id'],
            'device_name'   => ['required', 'array'],
            'device_name.*' => ['exists:devices,id'],
            'name' => [ 'required', 'string','max:255','unique:admins,name,'.$id],
            'email' => ['required', 'email','max:255','unique:admins,email,'.$id],
            'phone' => ['required','regex:/^[0-9]{11,15}$/'],
            'password' => ['nullable','string','min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/'
            ],
            'roles'   => ['required', 'array'],
            'roles.*' => ['exists:roles,name'],
        ];
    }

    public function messages(): array
    {
        return [
            'branch_name.required'   => 'Please select at least one branch.',
            'branch_name.array'      => 'Invalid branch selection.',
            'branch_name.*.exists'   => 'One or more selected branches are invalid.',

            'device_name.required'   => 'Please select at least one device.',
            'device_name.array'      => 'Invalid device selection.',
            'device_name.*.exists'   => 'One or more selected devices are invalid.',

            'name.required'          => 'The name field is required.',
            'name.unique'            => 'This name is already in use.',

            'email.required'         => 'The email field is required.',
            'email.email'            => 'Please enter a valid email address.',
            'email.unique'           => 'This email is already in use.',

            'phone.required'         => 'The phone number field is required.',
            'phone.regex'            => 'Please enter a valid phone number.',

            'password.min'           => 'Password must be at least 8 characters.',
            'password.regex'         => 'Password must contain uppercase, lowercase, number and special character.',

            'roles.required'         => 'Please assign at least one role.',
            'roles.array'            => 'Invalid role selection.',
            'roles.*.exists'         => 'One or more selected roles are invalid.',
        ];
    }
}
