<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateNoteRequest extends FormRequest
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
            'title'           => 'required|string|max:255',
            'tag'             => 'required|string|max:100',
            'priority'        => 'required|string',
            'important'       => 'required|integer',
            'description'     => 'required|string',
            'assign_user_id'  => 'required|integer',
            // 'assign_user_id'  => 'required|integer|exists:users,id',
            'priority_status' => 'required|integer',
            'status'          => 'required|string|max:50',
        ];
    }


    public function messages(): array
    {
        return [
            'title.required'           => 'Please provide a title for the note.',
            'tag.required'             => 'Please enter at least one tag.',
            'priority.required'        => 'Priority level is required.',
            'priority.integer'         => 'Priority must be a valid number.',
            'description.required'     => 'A description is required to proceed.',
            'important.integer'        => 'The important field must be a valid number (0 or 1).',
            'assign_user_id.required'  => 'You must assign this note to a user.',
            'assign_user_id.integer'   => 'Assigned user ID must be a valid number.',
            // 'assign_user_id.exists'    => 'The selected user does not exist in our system.',
            'priority_status.required' => 'Priority status is required.',
            'priority_status.integer'  => 'Priority status must be a valid number.',
            'status.required'          => 'Please set the current status of this note.',
            'status.string'            => 'Status must be a valid text value.',
        ];
    }
}
