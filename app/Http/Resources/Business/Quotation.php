<?php

namespace App\Http\Resources\Business;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Quotation extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'quotation_number' => $this->quotation_number,
            'reference_number' => $this->reference_number,
            'customer_name' => isset($this->contact) ? $this->contact->name : null,
            'create_date' => $this->create_date ? Carbon::parse($this->create_date)->format('d/m/Y') : null,
            'expiry_date' => $this->expiry_date ? Carbon::parse($this->expiry_date)->format('d/m/Y') : null,
            'status' => $this->status,
            'total_amount' => $this->total_amount
        ];
    }
}
