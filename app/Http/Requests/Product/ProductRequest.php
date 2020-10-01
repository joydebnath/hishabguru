<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'code' => 'required|string',
            'tenant_id' => 'required|numeric',
            'product_category_id' => 'required|numeric',
            'buying_unit_cost' => 'numeric|nullable',
            'selling_unit_price' => 'required|numeric',
            'quantity' => 'numeric|nullable',
            'tax_rate' => 'numeric|nullable',
            'description' => 'string|nullable',
            'is_purchasable' => 'boolean|nullable',
            'is_sellable' => 'boolean|nullable',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'product_category_id' => isset($this->category['id']) ? $this->category['id'] : null,
            'tax_rate' => $this->tax ? doubleval($this->tax) : 0,
            'quantity' => $this->quantity ? intval($this->quantity) : null,
            'buying_unit_cost' => $this->buying_cost ? doubleval($this->buying_cost) : null,
            'selling_unit_price' => $this->selling_price ? doubleval($this->selling_price) : null,
        ]);
    }
}
