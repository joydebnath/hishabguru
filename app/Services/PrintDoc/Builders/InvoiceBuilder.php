<?php


namespace App\Services\PrintDoc\Builders;


use App\Models\Invoice;
use App\Services\PrintDoc\ExtendedInvoice;
use App\Services\PrintDoc\PrintDocService;
use Carbon\Carbon;

class InvoiceBuilder implements PDFBuilder
{
    protected $pdfBuilder, $invoice, $printService;

    public function __construct($invoiceId)
    {
        $this->printService = new PrintDocService();
        $this->invoice = Invoice::with('contact', 'products', 'tenant.imageable')->findOrFail($invoiceId);
        $this->pdfBuilder =
            ExtendedInvoice::make('Invoice')
                ->dateFormat('d/m/Y')
                ->currencySymbol($this->invoice->tenant->currency_of_operation)
                ->currencyCode($this->invoice->tenant->currency_of_operation)
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
            ->sequence($this->invoice->invoice_number)
            ->serialNumberFormat('{SEQUENCE}')
            ->buyer($this->printService->contact($this->invoice->contact))
            ->seller($this->printService->tenant($this->invoice->tenant))
            ->date(Carbon::parse($this->invoice->issue_date))

            ->addDueDate($this->invoice->due_date ? Carbon::parse($this->invoice->due_date) : Carbon::now()->addDays(14));

        if ($this->invoice->tenant->imageable) {
            $source = $this->invoice->tenant->imageable->source;
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
        if ($this->invoice->note) {
            $this->pdfBuilder->addMessage($this->invoice->note);
        }
//        $this->pdfBuilder->addDeliveryDetails($deliveryDetails);
    }

    public function generatePDF()
    {
        $this->pdfBuilder->filename($this->invoice->invoice_number);

        return $this->pdfBuilder->download();
    }

    public function streamPDF()
    {
        $this->pdfBuilder->filename($this->invoice->invoice_number);

        return $this->pdfBuilder->stream();
    }

    private function getProducts()
    {
        return collect($this->invoice->products)->map(function ($product) {
            $pivot = collect($product->pivot);
            return (new ProductBuilder([
                'name' => $product->name,
                'code' => $product->code,
                'price_per_unit' => doubleval($product->selling_unit_price),
                'quantity' => doubleval($pivot->get('quantity', 0)),
                'discount' => doubleval($pivot->get('discount', 0)),
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
