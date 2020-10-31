<?php

namespace App\Services\PrintDoc\Builders;

use App\Models\Bill;
use App\Services\PrintDoc\ExtendedInvoice;
use App\Services\PrintDoc\PrintDocService;
use Carbon\Carbon;

class BillBuilder implements PDFBuilder
{
    protected $pdfBuilder, $bill, $printService;

    public function __construct($billId)
    {
        $this->printService = new PrintDocService();
        $this->bill = Bill::with('contact', 'products', 'tenant.imageable')->findOrFail($billId);
        $this->pdfBuilder =
            ExtendedInvoice::make('Bill')
                ->dateFormat('d/m/Y')
                ->currencySymbol($this->bill->tenant->currency_of_operation)
                ->currencyCode($this->bill->tenant->currency_of_operation)
                ->currencyFormat('{VALUE} {SYMBOL}')
                ->currencyThousandsSeparator(',')
                ->currencyDecimalPoint('.');
    }


    public function build()
    {
        $this->builderHeader();

        $this->buildProductsTable();

        $this->buildFooter();

        return $this->generatePDF();
    }

    public function builderHeader()
    {
        $this->pdfBuilder
            ->addInvoiceNumber($this->bill->bill_number)
            ->seller($this->printService->contact($this->bill->contact))
            ->buyer($this->printService->tenant($this->bill->tenant))
            ->setStatus($this->bill->status)
            ->date(Carbon::parse($this->bill->issue_date))
            ->addDueDate($this->bill->due_date ? Carbon::parse($this->bill->due_date) : Carbon::now()->addDays(14));

        if ($this->bill->tenant->imageable) {
            $source = $this->bill->tenant->imageable->source;
            $this->pdfBuilder->logo(storage_path('app/public/' . $source));
//            $this->pdfBuilder->logo($source);
        }
    }

    public function buildProductsTable()
    {
        $this->pdfBuilder->addItems($this->getProducts());
    }

    public function buildFooter()
    {
        if ($this->bill->note) {
            $this->pdfBuilder->notes($this->bill->note);
        }
        $this->pdfBuilder->addMessage("<strong style='font-size:12px'>This is not a tax invoice</strong>");
    }


    public function generatePDF()
    {
        $this->pdfBuilder->filename($this->bill->bill_number);

        return $this->pdfBuilder->download();
    }

    public function streamPDF()
    {
        $this->pdfBuilder->filename($this->bill->bill_number);

        return $this->pdfBuilder->stream();
    }

    private function getProducts()
    {
        return collect($this->bill->products)->map(function ($product) {
            $pivot = collect($product->pivot);
            return (new ProductBuilder([
                'name' => $product->name,
                'code' => $product->code,
                'price_per_unit' => doubleval($pivot->get('buying_unit_cost', 0)),
                'quantity' => doubleval($pivot->get('quantity', 0)),
                'tax_rate' => doubleval($pivot->get('tax_rate', 0)),
            ]))->apply();
        })->toArray();
    }

    public function stream()
    {
        $this->builderHeader();

        $this->buildProductsTable();

        $this->buildFooter();

        return $this->streamPDF();
    }
}
