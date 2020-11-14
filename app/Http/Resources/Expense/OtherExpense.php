<?php

namespace App\Http\Resources\Expense;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OtherExpense extends JsonResource
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
            'expense_number' => $this->expense_number,
            'reference_number' => $this->reference_number,
            'issue_date' => Carbon::parse($this->issue_date)->format('d/m/y'),
            'due_date' => $this->due_date ? Carbon::parse($this->due_date)->format('d/m/y') : null,
            'status' => $this->status,
            'total_amount' => number_format($this->total_amount, 2),
            'total_due' => number_format($this->total_due, 2),
        ];
    }
}
