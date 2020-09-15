<?php

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::create([
            'name'=>'Salwar',
            'tenant_id'=>2
        ]);
        ProductCategory::create([
            'name'=>'Kurti',
            'tenant_id'=>2
        ]);
        ProductCategory::create([
            'name'=>'Tops',
            'tenant_id'=>2
        ]);
    }
}
