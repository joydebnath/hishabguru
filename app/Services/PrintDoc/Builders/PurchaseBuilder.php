<?php


namespace App\Services\PrintDoc\Builders;


use App\Models\Purchase;
use App\Services\PrintDoc\ExtendedInvoice;
use App\Services\PrintDoc\PrintDocService;
use Carbon\Carbon;

class PurchaseBuilder implements PDFBuilder
{
    protected $pdfBuilder, $purchase, $printService;
    public function __construct($purchaseId)
    {
        $this->printService = new PrintDocService();
        $this->purchase = Purchase::with('contact', 'products', 'tenant')->findOrFail($purchaseId);
        $this->pdfBuilder =
            ExtendedInvoice::make('Purchase')
                ->dateFormat('d/m/Y')
                ->currencySymbol('BDT')
                ->currencyCode('BDT')
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
            ->sequence($this->purchase->purchase_number)
            ->serialNumberFormat('{SEQUENCE}')
            ->seller($this->printService->contact($this->purchase->contact))
            ->buyer($this->printService->contact($this->purchase->contact)) // Business
            ->date(Carbon::parse($this->purchase->create_date))
            ->addDeliveryDate($this->purchase->delivery_date ? Carbon::parse($this->purchase->delivery_date) : null)
            ->logo('https://i.pinimg.com/originals/33/b8/69/33b869f90619e81763dbf1fccc896d8d.jpg');
    }

    public function buildProductsTable()
    {
        $this->pdfBuilder->addItems($this->getProducts());
    }

    public function buildFooter()
    {
        if ($this->purchase->note) {
            $this->pdfBuilder->notes($this->purchase->note);
        }
        //delivery
    }

    public function generatePDF()
    {
        $this->pdfBuilder->filename($this->purchase->purchase_number)->save('public');

        return $this->pdfBuilder->stream();
    }

    private function getProducts()
    {
        return collect($this->purchase->products)->map(function ($product) {
            $pivot = collect($product->pivot);
            return (new ProductBuilder([
                'name' => $product->name,
                'price_per_unit' => doubleval($pivot->get('buying_unit_cost', 0)),
                'discount' => doubleval($pivot->get('discount', 0)),
                'quantity' => doubleval($pivot->get('quantity', 0)),
                'tax_rate' => doubleval($pivot->get('tax_rate', 0)),
            ]))->apply();
        })->toArray();
    }
}
