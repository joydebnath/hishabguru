<?php

namespace App\Http\Resources\Expense;

use App\Http\Resources\Payment\PaymentHistoryCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class OtherExpenseFullResource extends JsonResource
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
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'note' => $this->note,
            'status' => $this->status,
            'read_only' => $this->status !== 'draft',
            'products' => self::items($this->items),
            'payment_histories' => $this->payable ? new PaymentHistoryCollection($this->payable) : [],
            'total_due' => $this->total_due
        ];
    }

    private static function items($items)
    {
        return collect($items)->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'buying_unit_cost' => doubleval($item->buying_unit_cost),
                'quantity' => doubleval($item->quantity),
                'description' => $item->description,
                'tax_rate' => doubleval($item->tax_rate),
                'total_buying_cost' => doubleval($item->total),
                'edit' => false
            ];
        });
    }
}
