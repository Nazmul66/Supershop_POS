<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseRequest extends FormRequest
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
        $id = $this->route('warehouse');

        return [
            'warehouse'      => ['required', 'string', "max:255', 'unique:warehouses,warehouse, $id"],
            'employee_id'    => ['required', 'integer'],
            'email'          => ['required', 'string', 'email'],
            'phone'          => ['required'],
            'phone_work'     => ['required'],
            'address'        => ['required', 'string', 'max:512'],
            'city_id'        => ['required', 'integer'],
            'state_id'       => ['required', 'integer'],
            'country_id'     => ['required', 'integer'],
            'postal_code'    => ['required', 'integer'],
        ];
    }
}
