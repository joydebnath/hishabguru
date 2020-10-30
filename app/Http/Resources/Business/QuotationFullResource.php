<?php

namespace App\Http\Resources\Business;

use Illuminate\Http\Resources\Json\JsonResource;

class QuotationFullResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contact' => isset($this->contact) ? ['id' => $this->contact->id, 'name' => $this->contact->name] : null,
            'contact_id' => $this->contact_id,
            'quotation_number' => $this->quotation_number,
            'reference_number' => $this->reference_number,
            'payment_condition' => $this->payment_condition,
            'minimum_payment_amount' => $this->minimum_payment_amount,
            'note' => $this->note,
            'status' => $this->status,
            'read_only' => $this->status !== 'draft',
            'create_date' => $this->create_date,
            'expiry_date' => $this->expiry_date,
            'products' => self::products($this->products),
            'copied' => $this->getCopiedLinks(),
        ];
    }

    protected static function products($products)
    {
        return collect($products)->map(function ($product) {
            $pivot = collect($product->pivot);
            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'selling_unit_price' => doubleval($product->selling_unit_price),
                'profit' => self::getProfitPercentage(
                    doubleval($pivot->get('total', 0)),
                    doubleval($product->buying_unit_cost),
                    doubleval($pivot->get('quantity', 0))
                ),
                'quantity' => doubleval($pivot->get('quantity', 0)),
                'discount' => doubleval($pivot->get('discount', 0)),
                'tax_rate' => doubleval($pivot->get('tax_rate', 0)),
                'total_selling_cost' => doubleval($pivot->get('total', 0)),
                'edit' => false
            ];
        });
    }

    private static function getProfitPercentage($total_selling_price, $buying_price, $quantity)
    {
        $total_buying_cost = $buying_price * $quantity;
        return round((($total_selling_price - $total_buying_cost) / $total_buying_cost) * 100, 2);
    }

    private function getCopiedLinks()
    {
        $copied = [];
        $order = collect($this->orders)->first();
        $invoice = collect(collect($this->invoices)->first())->get('id', null);

        if (collect($order)->isNotEmpty()) {
            $temp = collect($order)->get('invoices');
            $inv = collect($temp)->first();

            if ($inv) {
                $copied['invoice'] = '/@/invoices/' . collect($inv)->get('id');
            }

            $copied['order'] = '/@/orders/' . collect($order)->get('id');
        }

        if ($invoice !== null) {
            $copied['invoice'] = '/@/invoices/' . $invoice;
        }

        return $copied;
    }
}
