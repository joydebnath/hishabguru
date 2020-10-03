<?php

namespace App\Http\Requests\Payment;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'payment_date' => 'required',
            'payable_type' => 'required|string',
            'payable_id' => 'required|numeric',
            'payment_note' => 'nullable|string',
            'record_entered_by' => 'nullable|numeric',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'record_entered_by' => $this->record_entered_by ? $this->record_entered_by : Auth::id(),
            'payment_date' => $this->payment_date ? Carbon::createFromFormat('d/m/Y', $this->payment_date) : null,
        ]);
    }
}
