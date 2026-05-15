<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateTerminalRequest extends FormRequest
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
            'branch_id' => ['required', 'integer'],
            'device_id' => ['required', 'integer'],
            'terminal_name' => ['required', 'unique:terminals,terminal_name', 'max:255'],
            'ip_address' => ['nullable','ip'],
            'status' => ['required','boolean'],
        ];
    }


    public function messages(): array
    {
        return [
            'branch_id.required' => 'Please select a branch.',
            'device_id.required' => 'Please select a Device.',
            'terminal_name.required' => 'The Terminal name field is required.',
            'terminal_name.unique' => 'The Terminal name has already been registered.',
            'terminal_name.max' => 'The Terminal name may not be greater than 255 characters.',
            'ip_address.ip' => 'Please enter a valid IP address.',
            'status.required' => 'Please select a device status.',
            'status.boolean' => 'Invalid device status selected.',
        ];
    }
}
