<?php

namespace App\Http\Requests\Business;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuotationRequest extends FormRequest
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
            'expiry_date' => 'nullable',
            'note' => 'nullable|string',
            'payment_condition' => 'nullable|string|required_unless:status,draft',
            'products' => 'nullable|required_unless:status,draft',
            'quotation_number' => 'required|string',
            'reference_number' => 'nullable|string',
            'status' => 'required|string',
            'created_by' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric|required_unless:status,draft',
            'total_tax' => 'nullable|numeric|required_unless:status,draft',
            'sub_total' => 'nullable|numeric|required_unless:status,draft',
            'minimum_payment_amount' => 'nullable|numeric|required_if:payment_condition,partial',
        ];
    }

    protected function prepareForValidation()
    {

        $this->merge([
            'created_by' => Auth::id(),
            'total_amount' => isset($this->total_amount) ? doubleval($this->total_amount) : null,
            'total_tax' => isset($this->total_tax) ? doubleval($this->total_tax) : null,
            'sub_total' => isset($this->sub_total) ? doubleval($this->sub_total) : null,
            'minimum_payment_amount' => isset($this->minimum_payment_amount) ? doubleval($this->minimum_payment_amount) : null,
            'create_date' => $this->create_date ? Carbon::parse($this->create_date) : null,
            'expiry_date' => $this->expiry_date ? Carbon::parse($this->expiry_date) : null,
        ]);
    }
}
