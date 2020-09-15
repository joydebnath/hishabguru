<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $cost = $faker->numberBetween(400,2500);
    return [
        'name' =>$faker->domainWord,
        'code' =>ucwords($faker->randomLetter. $faker->randomLetter . '-' .$faker->numberBetween(1000,5000)),
        'tenant_id'=> 2,
        'product_category_id' => rand(1,3),
        'buying_unit_cost' => $cost,
        'selling_unit_price' => ($cost + ($cost*0.25)),
        'quantity' => $faker->numberBetween(10,50),
        'tax_rate' => 0,
        'description' => $faker->paragraph
    ];
});
