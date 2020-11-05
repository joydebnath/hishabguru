<?php

namespace App\Http\Resources\Statistics;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductPurchase extends JsonResource
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
            'issue_date' => Carbon::parse($this->issue_date)->format('d/m/y'),
            'type' => 'Bill',
            'number' => $this->bill_number,
            'quantity' => isset($this->pivot) ? $this->pivot->quantity : null,
            'total' => isset($this->pivot) ? number_format($this->pivot->total, 2) : null,
            'buying_unit_cost' => isset($this->pivot) ? $this->pivot->buying_unit_cost : null,
            'tax_rate' => isset($this->pivot) ? $this->pivot->tax_rate : null,
        ];
    }
}
