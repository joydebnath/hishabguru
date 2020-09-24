<?php

namespace App\Http\Controllers\Lookup;

use App\Enums\Product\ProductStatus;
use App\Filters\Products\ProductCategoriesFilter;
use App\Filters\Products\ProductsFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductCategoryLookupCollection;
use App\Http\Resources\Product\ProductLookupCollection;
use App\Models\Product;
use App\Models\ProductCategory;
use Exception;

class ProductLookupController extends Controller
{
    public function index(ProductsFilter $filters)
    {
        try {
            return new ProductLookupCollection(Product::filter($filters)->where('status', ProductStatus::ACTIVE)->limit(15)->get());
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], intval($exception->getCode()));
        }
    }

    public function categories(ProductCategoriesFilter $filters)
    {
        try {
            return new ProductCategoryLookupCollection(ProductCategory::filter($filters)->limit(15)->get());
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], intval($exception->getCode()));
        }
    }
}
