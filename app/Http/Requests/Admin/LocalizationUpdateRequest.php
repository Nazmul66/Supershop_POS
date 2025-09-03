<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LocalizationUpdateRequest extends FormRequest
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
            // Timezone (must exist in your config list)
            'timeZone' => ['nullable', 'string'],

            // Date format
            'date_format' => ['nullable', 'string'],

            // Time format
            'time_format' => ['nullable', 'string'],

            // Starting month
            'month_format' => ['nullable', 'string'],

            // Currency
            'currency_name' => ['nullable', 'string'],

            // Currency Symbol
            'currency_symbol' => ['nullable', 'string'],

            // Country Restriction (0 or 1 only)
            'restrict_country' => ['nullable', 'in:0,1'],

            // Allowed Files (like png,jpg,jpeg,webp)
            'allow_files' => ['nullable', 'string'],

            // File size (must be integer, min 1, max 100 maybe)
            'file_size' => ['nullable', 'integer'], // MB
        ];
    }

    public function messages(): array
    {
        return [
            'timeZone.required' => 'Please select a timezone.',
            'date_format.in' => 'Invalid date format selected.',
            'time_format.in' => 'Invalid time format selected.',
            'month_format.in' => 'Invalid month selected.',
            'currency_name.in' => 'Please select a valid currency.',
            'currency_symbol.in' => 'Please select a valid currency symbol.',
            'restrict_country.in' => 'Select either Allow or Deny for country restriction.',
            'allow_files.regex' => 'Allowed files must be comma-separated without spaces (e.g., png,jpg,jpeg,webp).',
            'file_size.integer' => 'File size must be a number.',
            'file_size.max' => 'File size cannot exceed 5120 MB (5 GB).',
        ];
    }
}
