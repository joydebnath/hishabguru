<?php

namespace App\Http\Requests\Expense;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PurchaseRequest extends FormRequest
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
            'note' => 'nullable|string',
            'products' => 'nullable|required_unless:status,draft',
            'purchase_order_number' => 'required|string',
            'reference_number' => 'nullable|string',
            'status' => 'required|string',
            'delivery_site_id' => 'nullable|numeric',
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
            'purchase_order_number' => $this->purchase_order_number ? strtoupper($this->purchase_order_number) : null,
            'total_amount' => isset($this->total_amount) ? doubleval($this->total_amount) : null,
            'total_tax' => isset($this->total_tax) ? doubleval($this->total_tax) : null,
            'sub_total' => isset($this->sub_total) ? doubleval($this->sub_total) : null,
            'create_date' => $this->create_date ? Carbon::createFromFormat('d/m/Y', $this->create_date) : null,
            'delivery_date' => $this->delivery_date ? Carbon::createFromFormat('d/m/Y', $this->delivery_date) : null,
            'delivery_site_id' => $this->delivery_site ? $this->delivery_site['id'] : null
        ]);
    }
}
