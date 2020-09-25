<?php

namespace App\Http\Requests\Business;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
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
            'contact_id' => 'nullable|numeric|required_unless:status,draft',
            'tenant_id' => 'numeric|required',
            'create_date' => 'required',
            'delivery_date' => 'nullable',
            'delivery_instructions' => 'nullable|string',
            'delivery_address' => 'nullable|string',
            'delivery_contact_number' => 'nullable|string',
            'products' => 'nullable|required_unless:status,draft',
            'order_number' => 'required|string',
            'reference_number' => 'nullable|string',
            'status' => 'required|string',
            'created_by' => 'nullable|numeric',
            'approved_by' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric|required_unless:status,draft',
            'total_tax' => 'nullable|numeric|required_unless:status,draft',
            'sub_total' => 'nullable|numeric|required_unless:status,draft',
        ];
    }

    protected function prepareForValidation()
    {

        $this->merge([
            'created_by' => Auth::id(),
            'total_amount' => isset($this->total_amount) ? doubleval($this->total_amount) : null,
            'total_tax' => isset($this->total_tax) ? doubleval($this->total_tax) : null,
            'sub_total' => isset($this->sub_total) ? doubleval($this->sub_total) : null,
            'create_date' => $this->create_date ? Carbon::createFromFormat('d/m/Y', $this->create_date) : null,
            'delivery_date' => $this->delivery_date ? Carbon::createFromFormat('d/m/Y', $this->delivery_date) : null,
        ]);
    }
}
