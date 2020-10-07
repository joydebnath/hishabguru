<?php

namespace App\Http\Resources\Business;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Invoice extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_number' => $this->invoice_number,
            'reference_number' => $this->reference_number,
            'customer_name' => isset($this->contact) ? $this->contact->name : null,
            'issue_date' => $this->issue_date ? Carbon::parse($this->issue_date)->format('d/m/Y') : null,
            'due_date' => $this->due_date ? Carbon::parse($this->due_date)->format('d/m/Y') : null,
            'status' => $this->status,
            'total_amount' => $this->total_amount
        ];
    }
}
