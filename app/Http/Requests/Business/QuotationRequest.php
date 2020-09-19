<?php

namespace App\Http\Requests\Business;

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
            'contact_id' => 'required_unless:status,draft',
            'create_date' => 'required',
            'expiry_date' => 'nullable',
            'note' => 'nullable',
            'payment_condition' => 'required_unless:status,draft',
            'products' => 'required_unless:status,draft',
            'quotation_number' => 'required',
            'reference_number' => 'nullable',
            'status'=> 'required',
            'created_by'=> 'numeric',
            'minimum_payment_amount'=> 'numeric|required_if:payment_condition,partial',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'created_by' => Auth::id()
        ]);
    }
}
