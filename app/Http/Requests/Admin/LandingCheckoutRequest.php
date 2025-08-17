<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LandingCheckoutRequest extends FormRequest
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
            'full_name' => ['required', 'string', 'max:255'],
            // 'email'     => ['nullable','email', 'max:255'],
            'phone'     => ['required', 'regex:/^0\d{10}$/'],
            'address'   => ['required', 'string', 'max: 412'],
        ];
    }


    public function messages(): array
    {
        return [
            'full_name.required' => 'অনুগ্রহ করে আপনার পুরো নাম লিখুন।',
            'phone.required'     => 'অনুগ্রহ করে আপনার মোবাইল নাম্বার লিখুন।',
            'phone.digits'       => 'মোবাইল নাম্বার অবশ্যই ১১ সংখ্যার হতে হবে।',
            'address.required'   => 'অনুগ্রহ করে আপনার ঠিকানা লিখুন।',
        ];
    }
}
