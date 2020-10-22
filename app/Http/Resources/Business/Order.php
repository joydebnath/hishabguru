<?php

namespace App\Http\Resources\Business;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'order_number' => $this->order_number,
            'reference_number' => $this->reference_number,
            'customer_name' => isset($this->contact) ? $this->contact->name : null,
            'create_date' => $this->create_date ? Carbon::parse($this->create_date)->format('d/m/Y') : null,
            'delivery_date' => $this->delivery_date ? Carbon::parse($this->delivery_date)->format('d/m/Y') : null,
            'status' => $this->status,
            'total_amount' => number_format($this->total_amount,2)
        ];
    }
}
