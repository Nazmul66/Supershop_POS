<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees,email'],
            'contact_number' => ['required', 'string', 'max:255'],
            'blood_group' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'string', 'max:50'],
            'nationality' => ['required', 'integer'],
            'joining_date' => ['required', 'date'],
            'department_id' => ['required', 'integer'],
            'designation_id' => ['required', 'integer'],
            'about' => ['nullable', 'max:512'],
            'address' => ['required', 'max:255'],
            'country_id' => ['required', 'integer'],
            'state_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'zip_code' => ['required', 'integer'],
            'emergency_number_1' => ['required', 'string','max:255'],
            'emergency_relation_1' => ['required', 'string','max:255'],
            'relation_name_1' => ['required', 'string','max:255'],
            'emergency_number_2' => ['nullable', 'string','max:255'],
            'emergency_relation_2' => ['nullable', 'string','max:255'],
            'relation_name_2' => ['nullable', 'string','max:255'],
            'bank_name' => ['nullable', 'string','max:255'],
            'account_number' => ['nullable', 'integer', 'unique:employees,account_number'],
            'routing_number' => ['nullable', 'integer'],
            'branch_name' => ['nullable', 'string'],
            'status' => ['nullable', 'integer', 'in:0,1'],
        ];
    }

}
