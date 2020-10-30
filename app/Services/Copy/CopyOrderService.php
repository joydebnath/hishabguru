<?php

namespace App\Services\Copy;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CopyOrderService implements ICopyService
{
    public function store($type, $order, $userId)
    {
        if ($type === 'invoices') {
            return $this->copyToInvoice($order, $userId);
        }
        throw new \UnexpectedValueException('Can not copy order to ' . $type);
    }

    public function copyToInvoice(Model $order, $userId)
    {
        $storable = [
            'invoice_number' => $this->generateInvoiceNumber($order->tenant_id),
            'reference_number' => $order->order_number,
            'status' => 'draft',
            'issue_date' => Carbon::today(),
            'total_amount' => $order->total_amount,
            'total_due' => $order->total_amount,
            'sub_total' => $order->sub_total,
            'total_tax' => $order->total_tax,
            'tenant_id' => $order->tenant_id,
            'contact_id' => $order->contact_id,
            'created_by' => $userId,
            'note' => $order->note,
        ];

        $invoice = Invoice::create($storable);

        foreach ($order->products as $product) {
            $invoice->products()->attach($product['id'], [
                'quantity' => $product->pivot->quantity,
                'discount' => $product->pivot->discount,
                'tax_rate' => $product->pivot->tax_rate,
                'total' => $product->pivot->total,
            ]);
        }

        return $invoice;
    }

    private function generateInvoiceNumber($tenantId)
    {
//        $invoice = Invoice::where('tenant_id',$tenantId)->last();
        return 'INV-' . Carbon::now()->timestamp;
    }
}
