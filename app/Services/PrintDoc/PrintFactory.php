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
        $builder = null;
        switch ($type) {
            case 'quotation':
                $builder = new QuotationBuilder($id);
                break;
            case 'order':
                $builder = new OrderBuilder($id);
                break;
            case 'invoice':
                $builder = new InvoiceBuilder($id);
                break;
            case 'purchase':
                $builder = new PurchaseBuilder($id);
                break;
            case 'bill':
                $builder = new BillBuilder($id);
                break;
            default:
                throw new \Exception('Unsupported PDF type');
        }

        return $builder;
    }
}
