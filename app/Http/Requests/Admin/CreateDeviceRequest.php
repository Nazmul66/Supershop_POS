<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeviceRequest extends FormRequest
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
            'branch_id' => ['required',],
            'device_code' => ['required','unique:devices,device_code'],
            'device_name' => ['required', 'unique:devices,device_name', 'max:255'],
            'ip_address' => ['nullable','ip'],
            'last_active_at' => ['nullable'],
            'is_online' => ['nullable'],
            'status' => ['required','boolean'],
        ];
    }


    public function messages(): array
    {
        return [
            'branch_id.required' => 'Please select a branch.',
            'device_code.required' => 'The device code field is required.',
            'device_name.required' => 'The device name field is required.',
            'device_name.unique' => 'The device name has already been registered.',
            'device_code.unique' => 'This device code has already been registered.',
            'device_name.max' => 'The device name may not be greater than 255 characters.',
            'ip_address.ip' => 'Please enter a valid IP address.',
            'status.required' => 'Please select a device status.',
            'status.boolean' => 'Invalid device status selected.',
        ];
    }
}
