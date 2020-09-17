<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['api']], function () {
    Route::resource('/invoices','Invoice\InvoicesController');
    Route::resource('/products','Product\ProductsController');
    Route::resource('/product-categories','Product\ProductCategoriesController');
    Route::resource('/suppliers','Contact\SuppliersController');
    Route::resource('/clients','Contact\ClientsController');
    Route::resource('/quotations','Quotation\QuotationsController');
    Route::resource('/orders','Order\OrdersController');
    Route::resource('/promo-codes','Promo\PromoCodesController');

    Route::get('/me','Auth\UserController@index');
    Route::get('/filters','FiltersController@index');
    Route::get('/lookup/clients','Look\ClientLookupController@index');
    Route::get('/lookup/suppliers','Look\SupplierLookupController@index');
    Route::get('/lookup/products','Look\ProductLookupController@index');
});
