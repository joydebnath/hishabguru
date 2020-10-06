<?php

namespace App\Services\Expense;

use App\Models\OtherExpenseItem;
use App\Models\PaymentHistory;
use Carbon\Carbon;

class OtherExpenseService
{
    public function attachExpenseItems($expense, $products): void
    {
        foreach ($products as $product) {
            OtherExpenseItem::create($this->getItemFillable($product, $expense));
        }
    }

    public function getItemFillable($product, $expense): array
    {
        return [
            'other_expense_id' => $expense->id,
            'name' => $product['name'],
            'quantity' => intval($product['quantity']),
            'buying_unit_cost' => doubleval($product['buying_unit_cost']),
            'tax_rate' => isset($product['tax_rate']) ? doubleval($product['tax_rate']) : null,
            'total' => doubleval($product['total_buying_cost']),
            'description' => isset($product['description']) ? $product['description'] : null,
        ];
    }

    public function attachPaymentHistory($expense, $payment, $userId)
    {
        PaymentHistory::create($this->getPaymentHistoryFillable($expense, $payment, $userId));
        $expense->update([
            'total_due' => abs($expense->total_amount - doubleval($payment['amount']))
        ]);
    }

    public function getPaymentHistoryFillable($expense, $payment, $userId): array
    {
        return [
            'payable_id' => $expense->id,
            'payable_type' => 'other-expenses',
            'amount' => $payment['amount'],
            'payment_date' => Carbon::createFromFormat('d/m/Y', $payment['payment_date']),
            'payment_note' => isset($payment['payment_note']) ? $payment['payment_note'] : null,
            'record_entered_by' => $userId,
        ];
    }

    public function updateTotalDue($expense, $paymentHistories): void
    {
        $totalPaid = $paymentHistories ? collect($paymentHistories)->sum('amount') : 0;

        $expense->update([
            'total_due' => abs($expense->total_amount - $totalPaid)
        ]);
    }

    public function syncItems($expense, $items)
    {
        //find new items
        //find items that are deleted
        //delete items
        //updateOrCreate
        $oldItems = collect($expense->items)->toArray();
        return ['o' => $oldItems, 'n' => $items];
//        foreach ($items as $item) {
//            OtherExpenseItem::updateOrCreate(
//                ['id' => $item['id']],
//                $this->getItemFillable($item, $expense)
//            );
//        }
    }
}
