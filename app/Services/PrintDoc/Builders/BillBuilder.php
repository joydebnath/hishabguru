<?php


namespace App\Services\PrintDoc\Builders;


use App\Models\Bill;

class BillBuilder implements PDFBuilder
{
    public function __construct($billId)
    {
        Bill::find($billId);
    }

    public function builderHeader()
    {
        // TODO: Implement builderHeader() method.
    }

    public function buildProductsTable()
    {
        // TODO: Implement buildProductsTable() method.
    }

    public function buildFooter()
    {
        // TODO: Implement buildFooter() method.
    }

    public function build()
    {
        // TODO: Implement build() method.
    }

    public function generatePDF()
    {
        // TODO: Implement generatePDF() method.
    }
}
