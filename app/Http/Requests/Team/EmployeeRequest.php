<?php

namespace App\Http\Requests\Team;

use App\Enums\Address\Addressable;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'tenant_id' => 'required|numeric',
            'name' => 'required|string',
            'mobile' => 'string|required',
            'phone' => 'string|nullable',
            'employee_id' => 'string|nullable',
            'job_title' => 'string|nullable',
            'currently_working' => 'string|nullable',
            'email' => 'email|nullable',
            'address_line_1' => 'required|string',
            'address_line_2' => 'string|nullable',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'note' => 'string|nullable',
            'address_type' => 'required|string',
            'addressable_type' => 'required|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'addressable_type' => Addressable::CONTACT
        ]);
    }
}
