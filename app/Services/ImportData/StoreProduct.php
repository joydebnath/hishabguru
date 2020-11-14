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
            'name' => trim($record['Name']),
            'code' => trim($record['Code']),
            'product_category_id' => $this->findProductCategoryId($record['Category Name'], $record['tenant_id']),
            'buying_unit_cost' => $this->getDoubleValue($record['Buying Cost']),
            'selling_unit_price' => $this->getDoubleValue($record['Selling Price']),
            'quantity' => trim($record['Quantity']),
            'tax_rate' => $this->getDoubleValue($record['Tax Rate']),
            'is_sellable' => $this->isSellable($record['Do you sell it? (Y/N)']),
            'is_purchasable' => $this->isPurchasable($record['Do you buy it? (Y/N)']),
            'description' => trim($record['Description']),
            'tenant_id' => trim($record['tenant_id'])
        ];
    }

    private function getDoubleValue($value)
    {
        $value = trim($value);
        return $value ? doubleval($value) : 0;
    }

    private function isSellable($value)
    {
        $value = trim($value);
        if ($value) {
            $toLower = strtolower($value);
            $possibleAnswers = ['y', 'yes', 't', 'true'];
            return in_array($toLower, $possibleAnswers);
        }
        return false;
    }

    private function isPurchasable($value)
    {
        $value = trim($value);
        if ($value) {
            $toLower = strtolower($value);
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
