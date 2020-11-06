<?php

namespace App\Http\Resources\Statistics;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BillPaid extends JsonResource
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
            'date' => Carbon::parse($this->issue_date)->format('d/m/y'),
            'type' => 'Bill',
            'number' => $this->bill_number,
            'due_date' => Carbon::parse($this->due_date)->format('d/m/y'),
            'total_amount' => $this->total_amount,
            'total_tax' => $this->total_tax,
            'sub_total' => $this->sub_total,
        ];
    }
}
