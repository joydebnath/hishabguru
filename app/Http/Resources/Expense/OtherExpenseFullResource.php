<?php

namespace App\Http\Resources\Expense;

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
            'products' => self::items($this->items),
            'payment_history_count' => collect($this->payable)->count(),
            'total_due' => $this->total_due
        ];
    }

    private static function items($items)
    {
        return collect($items)->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'buying_unit_cost' => doubleval($item->get('buying_unit_cost', null)),
                'quantity' => doubleval($item->get('quantity', null)),
                'description' => $item->get('description', null),
                'tax_rate' => doubleval($item->get('tax_rate', null)),
                'total_buying_cost' => doubleval($item->get('total', null)),
                'edit' => false
            ];
        });
    }
}
