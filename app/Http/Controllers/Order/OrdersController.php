<?php

namespace App\Http\Controllers\Order;

use App\Filters\Business\OrderFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Business\OrderRequest;
use App\Http\Resources\Business\OrderCollection;
use App\Http\Resources\Business\OrderFullResource;
use App\Http\Resources\Business\Order as OrderResource;
use App\Models\CopyReference;
use App\Models\Order;
use App\Models\OrderDeliveryDetails;
use Exception;

class OrdersController extends Controller
{
    public function index(OrderFilter $filters)
    {
        try {
            return new OrderCollection(
                Order::filter($filters)->paginate()
            );
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(OrderRequest $request)
    {
        try {
            $storable = $this->getOrderFillable($request);
            $order = Order::create($storable);

            foreach ($request->products as $product) {
                $order->products()->attach($product['id'], [
                    'quantity' => $product['quantity'],
                    'discount' => $product['discount'],
                    'tax_rate' => $product['tax_rate'],
                    'total' => $product['total_selling_cost'],
                ]);
            }

            $deliveryDetails = $this->getOrderDetailsFillable($request);
            if (collect($deliveryDetails)->isNotEmpty()) {
                $deliveryDetails['order_id'] = $order->id;
                OrderDeliveryDetails::create($deliveryDetails);
            }

            return new OrderResource($order->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show(Order $order)
    {
        try {
            return new OrderFullResource($order->load('contact', 'products', 'deliveryDetails','invoices','quotation_invoices'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(OrderRequest $request, Order $order)
    {
        try {
            $storable = $this->getOrderFillable($request);
            $order->update($storable);

            $syncable = [];
            foreach ($request->products as $product) {
                $syncable[$product['id']] = [
                    'quantity' => intval($product['quantity']),
                    'discount' => doubleval($product['discount']),
                    'tax_rate' => doubleval($product['tax_rate']),
                    'total' => doubleval($product['total_selling_cost']),
                ];
            }
            $order->products()->sync($syncable);

            $deliveryDetails = $this->getOrderDetailsFillable($request);
            if (collect($deliveryDetails)->isNotEmpty()) {
                $order->deliveryDetails->update($deliveryDetails);
            }

            return new OrderResource($order->load('contact'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Order $order)
    {
        try {
            CopyReference::where('copy_to_id',$order->id)->where('copy_to_type','orders')->delete();
            $order->delete();
            return response(['message' => 'Order is deleted']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    /**
     * @param OrderRequest $request
     * @return array
     */
    private function getOrderFillable(OrderRequest $request): array
    {
        $fillable = $request->validated();
        unset($fillable['products']);
        unset($fillable['delivery_instructions']);
        unset($fillable['delivery_address']);
        unset($fillable['delivery_contact_number']);
        return $fillable;
    }

    private function getOrderDetailsFillable(OrderRequest $request): array
    {
        $fillable = [];
        $fillable['instructions'] = $request->get('delivery_instructions', null);
        $fillable['address'] = $request->get('delivery_address', null);
        $fillable['contact_number'] = $request->get('delivery_contact_number', null);

        return collect($fillable)->filter(function ($value) {
            return $value !== null;
        })->toArray();
    }
}
