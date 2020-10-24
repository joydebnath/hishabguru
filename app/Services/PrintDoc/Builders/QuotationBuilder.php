<?php


namespace App\Services\PrintDoc\Builders;


use App\Models\Quotation;
use App\Services\PrintDoc\ExtendedInvoice;
use App\Services\PrintDoc\PrintDocService;
use Carbon\Carbon;

class QuotationBuilder implements PDFBuilder
{
    protected $pdfBuilder, $quotation, $printService;

    public function __construct($quotationId)
    {
        $this->printService = new PrintDocService();
        $this->quotation = Quotation::with('contact', 'products', 'tenant.imageable')->findOrFail($quotationId);
        $this->pdfBuilder =
            ExtendedInvoice::make('Quotation')
                ->dateFormat('d/m/Y')
                ->currencySymbol($this->quotation->tenant->currency_of_operation)
                ->currencyCode($this->quotation->tenant->currency_of_operation)
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

    public function download()
    {
        $this->builderHeader();

        $this->buildProductsTable();

        $this->buildFooter();

        return $this->generatePDF();
    }

    public function builderHeader()
    {
        $this->pdfBuilder
            ->sequence($this->quotation->quotation_number)
            ->serialNumberFormat('{SEQUENCE}')
            ->buyer($this->printService->contact($this->quotation->contact))
            ->seller($this->printService->tenant($this->quotation->tenant))
            ->date(Carbon::parse($this->quotation->create_date))
            ->addExpiryDate($this->quotation->expiry_date ? Carbon::parse($this->quotation->expiry_date) : null);

        if ($this->quotation->tenant->imageable) {
            $source = $this->quotation->tenant->imageable->source;
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
        if ($this->quotation->note) {
            $this->pdfBuilder->notes($this->quotation->note);
        }
    }

    public function generatePDF()
    {
        $this->pdfBuilder->filename($this->quotation->id . '-' . $this->quotation->quotation_number);

        return $this->pdfBuilder->download();
    }

    public function streamPDF()
    {
        $this->pdfBuilder->filename($this->quotation->id . '-' . $this->quotation->quotation_number);

        return $this->pdfBuilder->stream();
    }

    private function getProducts()
    {
        return collect($this->quotation->products)->map(function ($product) {
            $pivot = collect($product->pivot);
            return (new ProductBuilder([
                'name' => $product->name,
                'price_per_unit' => doubleval($product->selling_unit_price),
                'discount' => doubleval($pivot->get('discount', 0)),
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
