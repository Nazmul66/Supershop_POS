<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDeviceRequest extends FormRequest
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
        // $id = $this->route('id');
        $id = $this->route('device');

        return [
            'branch_id' => ['required',],
            'device_code' => [
                'required',
                Rule::unique('devices', 'device_code')->ignore($id),
            ],
            'device_name' => [
                'nullable', 
                 Rule::unique('devices', 'device_name')->ignore($id),
                'max:255'],
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
            'branch_id.exists' => 'Selected branch does not exist.',
            'device_code.required' => 'The device code field is required.',
            'device_name.required' => 'The device name field is required.',
            'device_name.unique' => 'The device name has already been registered.',
            'device_code.unique' => 'This device code has already been registered.',
            'device_name.max' => 'The device name may not be greater than 255 characters.',
            'ip_address.ip' => 'Please enter a valid IP address.',
            'status.required' => 'Please select device status.',
            'status.boolean' => 'Invalid device status selected.',
        ];
    }
}
