<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryRequest extends FormRequest
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
            'name' => 'string|required',
            'tenant_id' => 'numeric|required',
            'parent_id' => 'numeric|nullable',
            'note' => 'string|nullable'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'parent_id' => $this->parent_id ? intval($this->parent_id) : null,
            'tenant_id' => 2
        ]);
    }
}
