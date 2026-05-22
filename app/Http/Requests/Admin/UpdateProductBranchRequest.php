<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductBranchRequest extends FormRequest
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
            'product_id' => [
                'required',
                'integer',
                Rule::unique('product_branches')
                    ->where(function ($query) {
                        return $query->where(
                            'branch_id',
                            $this->branch_id
                        );
                    })->ignore($this->id)
            ],
            'branch_id'        => ['required', 'integer'],
            'qty'              => ['required','integer'],
            'alert_qty'        => ['required', 'integer'],
            'purchase_price'   => ['required','integer'],
            'profit_margin'    => ['required','numeric'],
            'selling_price'    => ['required','integer'],
            'status'           => ['required','boolean'],
            'discount_type'    => ['nullable','in:none,fixed,percent'],
            'discount_date'    => ['required_if:discount_type,fixed,percent','nullable', 'string'],
            'discount_value'   => ['required_if:discount_type,fixed,percent','nullable','numeric','min:1', function ($attribute, $value, $fail) {
                    if ( $this->discount_type == 'percent') {
                        if ($value < 1 || $value > 70) {
                            $fail(
                                'Percentage discount must be between 1% to 70%.'
                            );
                        }
                    }
                }
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'product_id.required' => 'Product field is required.',
            'product_id.integer'  => 'Invalid product selected.',
            'product_id.unique'   => 'This product already exists in this branch.',
            'branch_id.required' => 'Branch field is required.',
            'branch_id.integer'  => 'Invalid branch selected.',
            'qty.required' => 'Qty field is required.',
            'qty.integer'  => 'Qty must be a number.',
            'alert_qty.required' => 'Alert qty field is required.',
            'alert_qty.integer'  => 'Alert qty must be a number.',
            'purchase_price.required' => 'Purchase price field is required.',
            'purchase_price.integer'  => 'Purchase price must be a number.',
            'profit_margin.required' => 'Profit margin field is required.',
            'profit_margin.integer'  => 'Profit margin must be a number.',
            'selling_price.required' => 'Selling price field is required.',
            'selling_price.integer'  => 'Selling price must be a number.',
            'discount_value.integer' => 'Discount value must be a number.',
            'discount_date.date' => 'Invalid discount date format.',
        ];
    }
}
