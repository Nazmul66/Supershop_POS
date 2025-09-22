<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreatePayrollRequest extends FormRequest
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
            'employee_id'       => ['required', 'integer'],
            'basic_salary'      => ['required', 'numeric'],
            'hra_allow'         => ['required', 'numeric'],
            'conveyance'        => ['required', 'numeric'],
            'medical_allow'     => ['required', 'numeric'],
            'bonus'             => ['required', 'numeric'],
            'provident_fund'    => ['required', 'numeric'],
            'professional_tax'  => ['required', 'numeric'],
            'tds'               => ['required', 'numeric'],
            'loan_others'       => ['required', 'numeric'],
        ];
    }


}
