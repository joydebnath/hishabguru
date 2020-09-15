<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('fake:products', function () {
    factory(App\Models\Product::class, 50)->create();
})->describe('Create Products for testing');

Artisan::command('fake:clients', function () {
    factory(App\Models\Address::class, 1)->states('home')->create();
})->describe('Create Clients for testing');

Artisan::command('fake:suppliers', function () {
    factory(App\Models\Address::class, 50)->states(['hq','supplier'])->create();
})->describe('Create Suppliers for testing');
