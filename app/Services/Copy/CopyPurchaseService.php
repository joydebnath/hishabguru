<?php

namespace App\Services\Copy;

use App\Models\Bill;
use Carbon\Carbon;

class CopyPurchaseService implements ICopyService
{
    public function store($type, $purchaseOrder, $userId)
    {
        if ($type === 'invoices') {
            return $this->copyToBill($purchaseOrder, $userId);
        }
        throw new \UnexpectedValueException('Can not copy purchase order to ' . $type);
    }

    private function copyToBill($purchaseOrder, $userId)
    {
        $storable = [
            'bill_number' => $this->generateBillNumber($purchaseOrder->tenant_id),
            'reference_number' => $purchaseOrder->purchase_order_number,
            'status' => 'draft',
            'issue_date' => Carbon::today(),
            'total_amount' => $purchaseOrder->total_amount,
            'total_due' => $purchaseOrder->total_amount,
            'sub_total' => $purchaseOrder->sub_total,
            'total_tax' => $purchaseOrder->total_tax,
            'tenant_id' => $purchaseOrder->tenant_id,
            'contact_id' => $purchaseOrder->contact_id,
            'created_by' => $userId,
            'note' => $purchaseOrder->note,
        ];

        $bill = Bill::create($storable);

        foreach ($purchaseOrder->products as $product) {
            $bill->products()->attach($product['id'], [
                'quantity' => $product->pivot->quantity,
                'buying_unit_cost' => $product->pivot->buying_unit_cost,
                'tax_rate' => $product->pivot->tax_rate,
                'total' => $product->pivot->total
            ]);
        }

        return $bill;
    }

    private function generateBillNumber($tenantId)
    {
//        $invoice = Invoice::where('tenant_id',$tenantId)->last();
        return 'BIL-' . Carbon::now()->timestamp;
    }
}
