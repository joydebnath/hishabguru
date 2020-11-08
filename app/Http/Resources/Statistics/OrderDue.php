<?php

namespace App\Http\Resources\Statistics;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDue extends JsonResource
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
            'date' => Carbon::parse($this->create_date)->format('d/m/y'),
            'type' => 'Order',
            'number' => $this->order_number,
            'total_due' => $this->total_due,
            'total_amount' => $this->total_amount,
            'total_amount_formatted' => number_format($this->total_amount,2),
            'total_tax' => $this->total_tax,
            'sub_total' => $this->sub_total,
            'status' => $this->status,
            'contact_name' => collect($this->contact)->get('name','Name not provided'),
        ];
    }
}
