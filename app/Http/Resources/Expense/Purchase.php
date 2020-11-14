<?php

namespace App\Http\Resources\Expense;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Purchase extends JsonResource
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
            'purchase_order_number' => $this->purchase_order_number,
            'reference_number' => $this->reference_number,
            'supplier_name' => isset($this->contact) ? $this->contact->name : null,
            'create_date' => $this->create_date ? Carbon::parse($this->create_date)->format('d/m/y') : null,
            'delivery_date' => $this->delivery_date ? Carbon::parse($this->delivery_date)->format('d/m/y') : null,
            'status' => $this->status,
            'total_amount' => number_format($this->total_amount, 2)
        ];
    }
}
