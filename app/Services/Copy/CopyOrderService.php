<?php

namespace App\Services\Copy;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;

class CopyOrderService implements ICopyService
{
    public function copyToInvoice(Model $order)
    {
        $storable = [];
        $storable['total_due'] = $order->total_due;
        $invoice = Invoice::create($storable);

        foreach ($order->products as $product) {
            $invoice->products()->attach($product['id'], [
                'quantity' => $product->quantity,
                'discount' => $product->discount,
                'tax_rate' => $product->tax_rate,
                'total' => $product->total,
            ]);
        }
    }
}
