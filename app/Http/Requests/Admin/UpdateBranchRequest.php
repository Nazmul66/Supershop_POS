<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBranchRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'name' => [
                'required',
                'max:255',
                Rule::unique('branches', 'name')->ignore($id),
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Please fill up Branch name',
            'name.max' => 'Character might be 255 word',
            'name.unique' => 'Character might be unique',
        ];
    }
}
