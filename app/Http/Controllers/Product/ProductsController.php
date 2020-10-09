<?php

namespace App\Http\Controllers\Product;

use App\Filters\Products\ProductsFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\Product as ProductResource;
use App\Models\InventorySite;
use App\Models\Product;
use Illuminate\Http\Request;
use Exception;

class ProductsController extends Controller
{
    public function index(ProductsFilter $filters)
    {
        try {
            return new ProductCollection(Product::filter($filters)->with('product_category')->paginate());
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());
//            $inventory = InventorySite::find($request->inventory_site_id);
//            $product->inventories()->attach($inventory->id, [
//                'total_stock' => $request->quantity,
//                'remaining_stock' => $request->remaining,
//                'reserved_stock' => 0,
//            ]);
            return new ProductResource($product);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function show(Product $product)
    {
        try {
            return new ProductResource($product);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function update(ProductRequest $request, Product $product)
    {
        try {
            $product->update($request->validated());
            return new ProductResource($product->fresh('product_category'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return response(['message' => 'Product is deleted!']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], 500);
        }
    }
}
