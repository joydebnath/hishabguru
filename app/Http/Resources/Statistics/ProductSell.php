<?php

namespace App\Http\Resources\Statistics;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSell extends JsonResource
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
            'type' => 'Invoice',
            'number' => $this->invoice_number,
            'quantity' => isset($this->pivot) ? $this->pivot->quantity : null,
            'total' => isset($this->pivot) ? number_format($this->pivot->total, 2) : null,
            'discount' => isset($this->pivot) ? $this->pivot->discount : null,
            'tax_rate' => isset($this->pivot) ? $this->pivot->tax_rate : null,
        ];
    }
}
