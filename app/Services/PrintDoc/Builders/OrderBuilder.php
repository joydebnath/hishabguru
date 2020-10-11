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
        $this->order = Order::with('contact', 'products', 'tenant')->findOrFail($orderId);
        $this->pdfBuilder =
            ExtendedInvoice::make('Order')
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
            ->sequence($this->order->order_number)
            ->serialNumberFormat('{SEQUENCE}')
            ->seller($this->printService->contact($this->order->contact))
            ->buyer($this->printService->contact($this->order->contact)) // Business
            ->date(Carbon::parse($this->order->create_date))
            ->addDeliveryDate($this->order->delivery_date ? Carbon::parse($this->order->delivery_date) : null)
            ->logo('https://i.pinimg.com/originals/33/b8/69/33b869f90619e81763dbf1fccc896d8d.jpg');
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
        $this->pdfBuilder->filename($this->order->order_number)->save('public');

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
}
