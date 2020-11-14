<?php

namespace App\Services\ImportData;

use App\Models\Product;
use App\Models\ProductCategory;

class StoreProduct implements Importable
{

    public function import($records)
    {
        foreach ($records as $record) {
            Product::create($this->parseData($record));
        }
        return response(['message' => 'Products imported successfully'], 201);
    }

    private function parseData($record)
    {
        return [
            'name' => trim($record['Full Name']),
            'code' => trim($record['Code']),
            'product_category_id' => $this->findProductCategoryId($record['Category Name'], $record['tenant_id']),
            'buying_unit_cost' => trim($record['Buying Cost']),
            'selling_unit_price' => trim($record['Selling Price']),
            'quantity' => trim($record['Quantity']),
            'tax_rate' => trim($record['Tax Rate']),
            'is_sellable' => $this->isSellable($record['Do you sell it? (Y/N)']),
            'is_purchasable' => $this->isPurchasable($record['Do you buy it? (Y/N)']),
            'description' => trim($record['Description']),
            'tenant_id' => trim($record['tenant_id'])
        ];
    }

    private function isSellable($value)
    {
        if ($value) {
            $toLower = strtolower(trim($value));
            $possibleAnswers = ['y', 'yes', 't', 'true'];
            return in_array($toLower, $possibleAnswers);
        }
        return false;
    }

    private function isPurchasable($value)
    {
        if ($value) {
            $toLower = strtolower(trim($value));
            $possibleAnswers = ['y', 'yes', 't', 'true'];
            return in_array($toLower, $possibleAnswers);
        }
        return false;
    }

    private function findProductCategoryId($value, $tenantId)
    {
        $category = ProductCategory::firstOrCreate(
            ['name' => trim($value), 'tenant_id' => $tenantId]
        );
        return $category->id;
    }
}
