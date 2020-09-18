<?php

namespace App\Http\Controllers\Lookup;

use App\Filters\Products\ProductsFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductLookupCollection;
use App\Models\Product;
use Exception;

class ProductLookupController extends Controller
{
    public function index(ProductsFilter $filters)
    {
        try {
            return new ProductLookupCollection(Product::filter($filters)->limit(15)->get());
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], intval($exception->getCode()));
        }
    }
}
