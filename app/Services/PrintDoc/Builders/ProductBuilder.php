<?php

namespace App\Services\PrintDoc\Builders;

use LaravelDaily\Invoices\Classes\InvoiceItem;

class ProductBuilder
{
    protected $product, $invoiceItem;

    public function __construct(array $product)
    {
        $this->product = $product;
        $this->invoiceItem = new InvoiceItem();
    }

    public function apply()
    {
        foreach ($this->product as $method => $param) {
            if (method_exists($this, $method) && $param !== null) {
                call_user_func_array([$this, $method], [$param]);
            }
        }
        return $this->invoiceItem;
    }

    public function name(string $name)
    {
        $this->invoiceItem->title($name);
    }

    public function price_per_unit(float $quantity)
    {
        $this->invoiceItem->pricePerUnit($quantity);
    }

    public function quantity(int $quantity)
    {
        $this->invoiceItem->quantity($quantity);
    }

    public function discount(float $discount)
    {
        $this->invoiceItem->discountByPercent($discount);
    }

    public function tax_rate(float $taxRate)
    {
        $this->invoiceItem->taxByPercent($taxRate);
    }
}
