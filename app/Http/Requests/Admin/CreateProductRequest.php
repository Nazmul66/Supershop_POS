<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
        $discountType   = $this->input('discount_type'); // Access input directly
        $purchase_price = $this->input('purchase_price'); // Access input directly
        $selling_price  = $this->input('selling_price'); // Access input directly

        return [
            'name'            => ['required', 'unique:products,name', 'max:255'],
            'thumb_image'     => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'sku'             => ['required', 'max:155'],
            'category_id'     => ['required', 'numeric'],
            'subCategory_id'  => ['required', 'numeric'],
            'brand_id'        => ['numeric'],
            'unit_id'         => ['required','numeric'],
            'warranties_id'   => ['numeric'],
            'qty'             => ['required', 'numeric', 'min:0'],
            'alert_qty'       => ['required', 'numeric', 'min:0'],
            'short_description' => ['required', 'max: 450'],
            'long_description' => ['required'],
            'purchase_price'  => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($selling_price) {
                    if ($value >= $selling_price) {
                        $fail('The Purchase price must be greater than the Selling price.');
                    }
                },
            ],
            'selling_price' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($purchase_price) {
                    if ($value <= $purchase_price) {
                        $fail('The selling price must be greater than the purchase price.');
                    }
                },
            ],

            'discount_type' => ['in:none,amount,percent'],
            'discount_value' => [
                'nullable',
                'numeric',
                'required_if:discount_type,amount,percent',
                function ($attribute, $value, $fail) use ($discountType) {
                    if ($discountType === 'percent' && ($value < 1 || $value > 100)) {
                        $fail('The discount value must be between 1 and 100 for percent type.');
                    }
                    if ($discountType === 'amount' && $value < 0) {
                        $fail('The discount value must be greater than or equal to 0 for amount type.');
                    }
                },
            ],
            'discount_date' => [
                'nullable',
                'required_if:discount_type,amount,percent',
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'thumb_image.required' => 'Product Image is required',
            'thumb_image.image' => 'The uploaded file must be an image',
            'thumb_image.mimes' => 'The image must be a file of type: ( png, jpg, jpeg, webp )',

            'name.required' => 'Please fill up Product name',
            'name.max' => 'Character might be 255 word',
            'name.unique' => 'Character might be unique',
            'name.unique' => 'Character might be unique',

            'category_id.required' => 'Please Select the Category Name',
            'brand_id.required' => 'Please Select the Brand Name',
            'qty.required' => 'Please add product quantity',

            'discount_type.in' => 'The discount type must be one of amount, or percent.',

            'discount_value.required_if' => 'The discount value is required when a discount type is selected.',
            'discount_value.numeric' => 'The discount value must be a valid number.',
            'discount_value.*' => 'Invalid discount value for the selected discount type.',
    
            'discount_date.required_if' => 'Discount date is required when discount type is amount or percent.',

            'purchase_price.required' => 'The purchase price is required.',
            'purchase_price.numeric' => 'The purchase price must be a valid number.',

            'selling_price.required' => 'The selling price is required.',
            'selling_price.numeric' => 'The selling price must be a valid number.',

            'short_description.required' => 'Please add short description',
            'short_description.max' => 'Short description must be at least 350 character',
            'long_description.required' => 'Please add long description',
        ];
    }
}
