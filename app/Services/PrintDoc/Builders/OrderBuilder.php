<?php


namespace App\Services\PrintDoc\Builders;


use App\Models\Order;
use App\Services\PrintDoc\ExtendedInvoice;
use App\Services\PrintDoc\PrintDocService;
use Carbon\Carbon;

class OrderBuilder implements PDFBuilder
{
    protected $pdfBuilder, $order, $printService;

    public function __construct($orderId)
    {
        $this->printService = new PrintDocService();
        $this->order = Order::with('contact', 'products', 'tenant.imageable')->findOrFail($orderId);
        $this->pdfBuilder =
            ExtendedInvoice::make('Order')
                ->dateFormat('d/m/Y')
                ->currencySymbol($this->order->tenant->currency_of_operation)
                ->currencyCode($this->order->tenant->currency_of_operation)
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
            ->sequence($this->order->order_number)
            ->serialNumberFormat('{SEQUENCE}')
            ->buyer($this->printService->contact($this->order->contact))
            ->seller($this->printService->tenant($this->order->tenant))
            ->date(Carbon::parse($this->order->create_date))
            ->addDeliveryDate($this->order->delivery_date ? Carbon::parse($this->order->delivery_date) : null);

        if ($this->order->tenant->imageable) {
            $source = $this->order->tenant->imageable->source;
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
        if ($this->order->note) {
            $this->pdfBuilder->notes($this->order->note);
        }
        //delivery
    }

    public function generatePDF()
    {
        $this->pdfBuilder->filename($this->order->order_number);

        return $this->pdfBuilder->download();
    }

    public function streamPDF()
    {
        $this->pdfBuilder->filename($this->order->order_number);

        return $this->pdfBuilder->stream();
    }

    private function getProducts()
    {
        return collect($this->order->products)->map(function ($product) {
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
