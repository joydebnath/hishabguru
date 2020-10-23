<?php

namespace App\Http\Resources\Product;

use App\Models\Tenant;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'count' => [
                'product_categories_count' => $this->getCategoryCount($request->get('tenant_id'))
            ],
        ];
    }

    private function getCategoryCount($tenantId)
    {
        return Tenant::find($tenantId)->product_categories()->count();
    }
}
