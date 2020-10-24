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
        $this->purchase = Purchase::with([
            'contact',
            'products',
            'tenant' => function ($query) {
                $query->with('imageable', 'phones');
            },
            'deliverySite'
        ])->findOrFail($purchaseId);

        $this->pdfBuilder =
            ExtendedInvoice::make('Purchase')
                ->dateFormat('d/m/Y')
                ->currencySymbol($this->purchase->tenant->currency_of_operation)
                ->currencyCode($this->purchase->tenant->currency_of_operation)
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
            ->sequence($this->purchase->purchase_order_number)
            ->serialNumberFormat('{SEQUENCE}')
            ->seller($this->printService->contact($this->purchase->contact))
            ->buyer($this->printService->tenant($this->purchase->tenant))
            ->date(Carbon::parse($this->purchase->create_date))
            ->setStatus($this->purchase->status)
            ->addDeliveryDate($this->purchase->delivery_date ? Carbon::parse($this->purchase->delivery_date) : null);

        if ($this->purchase->tenant->imageable) {
            $source = $this->purchase->tenant->imageable->source;
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
        if ($this->purchase->note) {
            $this->pdfBuilder->notes($this->purchase->note);
        }

        if (($deliveryDetails = $this->purchase->deliverySite)) {
            $phone = collect($this->purchase->tenant->phones)->first();
            $this->pdfBuilder->addDeliveryDetails(
                $this->printService->delivery([
                    'delivery_address' => [
                        'name' => $deliveryDetails->name,
                        'address' => $deliveryDetails->address_line_1 . ' ' . $deliveryDetails->address_line_2 . ', ' . $deliveryDetails->city,
                        'state' => $deliveryDetails->state,
                        'postcode' => $deliveryDetails->postcode
                    ],
                    'other_details' => [
                        'phone' => $phone ? $phone->value : 'Not provided'
                    ],
                ])
            );
        }
    }

    public function generatePDF()
    {
        $this->pdfBuilder->filename($this->purchase->purchase_order_number);

        return $this->pdfBuilder->download();
    }

    public function streamPDF()
    {
        $this->pdfBuilder->filename($this->purchase->purchase_order_number);

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

    public function stream()
    {
        $this->builderHeader();

        $this->buildProductsTable();

        $this->buildFooter();

        return $this->streamPDF();
    }
}
