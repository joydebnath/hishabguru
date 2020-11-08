<?php

namespace App\Http\Resources\Statistics;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceDue extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $dueDate = Carbon::parse($this->due_date);
        return [
            'id' => $this->id,
            'date' => Carbon::parse($this->issue_date)->format('d/m/y'),
            'type' => 'Invoice',
            'number' => $this->invoice_number,
            'due_date' => $dueDate->format('d/m/y'),
            'total_due' => $this->total_due,
            'total_amount' => $this->total_amount,
            'total_amount_formatted' => number_format($this->total_amount,2),
            'total_tax' => $this->total_tax,
            'sub_total' => $this->sub_total,
            'status' => $this->status,
            'contact_name' => collect($this->contact)->get('name','Name not provided'),
            'is_overdue' => $dueDate->lessThanOrEqualTo(Carbon::today())
        ];
    }
}
