<?php

namespace App\Services\Copy;

use App\Enums\Address\Addressable;
use App\Enums\Address\AddressType;
use App\Enums\Contact\ContactDetailsType;
use App\Models\Address;
use App\Models\ContactDetail;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderDeliveryDetails;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use UnexpectedValueException;

class CopyQuotationService implements ICopyService
{
    public function store($type, $quotation, $userId)
    {
        if ($type === 'orders') {
            return $this->copyToOrder($quotation, $userId);
        } elseif ($type === 'invoices') {
            return $this->copyToInvoice($quotation, $userId);
        }
        throw new UnexpectedValueException('Can not copy quotation to ' . $type);
    }

    private function copyToOrder(Model $quotation, $userId)
    {
        $storable = [
            'order_number' => $this->generateOrderNumber($quotation->tenant_id),
            'reference_number' => $quotation->quotation_number,
            'status' => 'draft',
            'create_date' => Carbon::today(),
            'total_amount' => $quotation->total_amount,
            'sub_total' => $quotation->sub_total,
            'total_tax' => $quotation->total_tax,
            'tenant_id' => $quotation->tenant_id,
            'contact_id' => $quotation->contact_id,
            'created_by' => $userId,
            'note' => $quotation->note,
        ];

        $order = Order::create($storable);

        foreach ($quotation->products as $product) {
            $order->products()->attach($product->id, [
                'quantity' => $product->pivot->quantity,
                'discount' => $product->pivot->discount,
                'tax_rate' => $product->pivot->tax_rate,
                'total' => $product->pivot->total,
            ]);
        }

        $deliveryDetails = $this->getDeliveryDetails($quotation->contact_id, $order->id);

        OrderDeliveryDetails::create($deliveryDetails);

        return $order;
    }

    private function copyToInvoice(Model $quotation, $userId)
    {
        $storable = [
            'invoice_number' => $this->generateInvoiceNumber($quotation->tenant_id),
            'reference_number' => $quotation->quotation_number,
            'status' => 'draft',
            'issue_date' => Carbon::today(),
            'total_amount' => $quotation->total_amount,
            'total_due' => $quotation->total_amount,
            'sub_total' => $quotation->sub_total,
            'total_tax' => $quotation->total_tax,
            'tenant_id' => $quotation->tenant_id,
            'contact_id' => $quotation->contact_id,
            'created_by' => $userId,
            'note' => $quotation->note,
        ];

        $invoice = Invoice::create($storable);

        foreach ($quotation->products as $product) {
            $invoice->products()->attach($product['id'], [
                'quantity' => $product->pivot->quantity,
                'discount' => $product->pivot->discount,
                'tax_rate' => $product->pivot->tax_rate,
                'total' => $product->pivot->total,
            ]);
        }

        return $invoice;
    }

    /**
     * @param $contactId
     * @param $order
     * @return array
     */
    private function getDeliveryDetails($contactId, $orderId): array
    {
        $address =
            Address::where('addressable_id', $contactId)
                ->where('addressable_type', Addressable::CONTACT)
                ->where('address_type', AddressType::HOME)
                ->first();

        $contactNumber =
            ContactDetail::where('contact_id', $contactId)
                ->where('key', ContactDetailsType::MOBILE)
                ->first();

        $deliveryDetails = [
            'order_id' => $orderId,
            'address' => $address ? $address->formatted_address : null,
            'contact_number' => $contactNumber ? $contactNumber->value : null
        ];

        return $deliveryDetails;
    }

    private function generateOrderNumber($tenantId)
    {
//        $order = Order::where('tenant_id',$tenantId)->last();
        return 'ORD-' . Carbon::now()->timestamp;
    }

    private function generateInvoiceNumber($tenantId)
    {
//        $invoice = Invoice::where('tenant_id',$tenantId)->last();
        return 'INV-' . Carbon::now()->timestamp;
    }
}
