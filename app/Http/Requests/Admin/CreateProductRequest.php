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
        return [
            'name'            => ['required', 'unique:products,name', 'max:255'],
            'thumb_image'     => ['required', 'image', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'sku'             => ['required', 'unique:products,sku', 'max:155'],
            'barcode'         => ['required', 'unique:products,barcode'],
            'category_id'     => ['required', 'numeric'],
            'subCategory_id'  => ['required', 'numeric'],
            'brand_id'        => ['required', 'numeric'],
            'unit_id'         => ['required','numeric'],
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
        ];
    }
}
