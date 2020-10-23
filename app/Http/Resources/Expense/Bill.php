<?php

namespace App\Http\Resources\Expense;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Bill extends JsonResource
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
            'bill_number' => $this->bill_number,
            'reference_number' => $this->reference_number,
            'supplier_name' => isset($this->contact) ? $this->contact->name : null,
            'issue_date' => $this->issue_date ? Carbon::parse($this->issue_date)->format('d/m/Y') : null,
            'due_date' => $this->due_date ? Carbon::parse($this->due_date)->format('d/m/Y') : null,
            'status' => $this->status,
            'total_amount' => number_format($this->total_amount, 2),
            'total_paid' => $this->total_paid,
            'total_due' => $this->total_amount,
        ];
    }
}
