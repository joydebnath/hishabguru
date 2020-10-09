<?php

namespace App\Http\Requests\Contact;

use App\Enums\Address\Addressable;
use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        $rules = [
            'tenant_id' => 'required|numeric',
            'name' => 'required|string',
            'mobile' => 'string|required',
            'phone' => 'string|nullable',
            'email' => 'email|nullable',
            'address_line_1' => 'required|string',
            'address_line_2' => 'string|nullable',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'note' => 'string|nullable',
            'address_type' => 'string',
            'addressable_type' => 'string',
        ];

        $rules = $this->appendRulesBasedOnHTTPMethod($rules);

        return $rules;
    }

    private function appendRulesBasedOnHTTPMethod($rules)
    {
        if ($this->isMethod('POST')) {
            $rules['address_type'] = 'required|' . $rules['address_type'];
        } else {
            $rules['address_type'] = $rules['address_type'] . '|nullable';
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'addressable_type' => Addressable::CONTACT
        ]);
    }
}
