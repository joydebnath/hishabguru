<?php

namespace App\Http\Controllers\Product;

use App\Filters\Products\ProductCategoriesFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCategoryRequest;
use App\Http\Resources\Product\ProductCategoryCollection;
use App\Models\ProductCategory;
use App\Http\Resources\Product\ProductCategory as CategoryResource;
use Exception;

class ProductCategoriesController extends Controller
{
    public function index(ProductCategoriesFilter $filters)
    {
        return new ProductCategoryCollection(ProductCategory::filter($filters)->paginate());
    }

    public function store(ProductCategoryRequest $request)
    {
        try {
            $productCategory = ProductCategory::create($request->validated());
            return new CategoryResource($productCategory);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function show(ProductCategory $productCategory)
    {
        return new CategoryResource($productCategory);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        try {
            $productCategory->update($request->validated());
            return new CategoryResource($productCategory->fresh('parent_category'));
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function destroy(ProductCategory $productCategory)
    {
        try {
            $productCategory->delete();
            return response(['message' => 'Product category is deleted!']);
        } catch (Exception $exception) {
            return response(['message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
