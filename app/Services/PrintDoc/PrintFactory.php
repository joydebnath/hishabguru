<?php


namespace App\Services\PrintDoc;


use App\Services\PrintDoc\Builders\BillBuilder;
use App\Services\PrintDoc\Builders\InvoiceBuilder;
use App\Services\PrintDoc\Builders\OrderBuilder;
use App\Services\PrintDoc\Builders\PDFBuilder;
use App\Services\PrintDoc\Builders\PurchaseBuilder;
use App\Services\PrintDoc\Builders\QuotationBuilder;

class PrintFactory
{
    public static function getEngineer($type, $id): PDFBuilder
    {
        $map = [
            'quotation' => new QuotationBuilder($id),
            'order' => new OrderBuilder($id),
            'invoice' => new InvoiceBuilder($id),
            'purchase' => new PurchaseBuilder($id),
            'bill' => new BillBuilder($id),
        ];

        return $map[$type];
    }
}
