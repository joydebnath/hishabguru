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

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('/invoices', 'Invoice\InvoicesController');
    Route::resource('/products', 'Product\ProductsController');
    Route::resource('/product-categories', 'Product\ProductCategoriesController');
    Route::resource('/suppliers', 'Contact\SuppliersController');
    Route::resource('/clients', 'Contact\ClientsController');
    Route::resource('/employees', 'Team\EmployeeController');
    Route::resource('/quotations', 'Quotation\QuotationsController');
    Route::resource('/purchases', 'Expense\PurchasesController');
    Route::resource('/bills', 'Expense\BillsController');
    Route::resource('/other-expenses', 'Expense\OtherExpenseController');
    Route::resource('/orders', 'Order\OrdersController');
    Route::resource('/promo-codes', 'Promo\PromoCodesController');
    Route::resource('/tenants', 'Tenancy\TenantController');
    Route::resource('/payment-histories', 'Payment\PaymentHistoryController');
    Route::resource('/business-settings', 'Setting\BusinessSettingsController')->only('show','update');
    Route::resource('/profile-settings', 'Setting\ProfileSettingsController')->only('show','update');

    Route::get('/me', 'User\UserController@index');
    Route::get('/lookup/clients', 'Lookup\ClientLookupController@index');
    Route::get('/lookup/suppliers', 'Lookup\SupplierLookupController@index');
    Route::get('/lookup/products', 'Lookup\ProductLookupController@index');
    Route::get('/lookup/product-categories', 'Lookup\ProductLookupController@categories');
    Route::get('/print/{type}/{id}', 'PrintDoc\PrintController@show');
    Route::get('/generate-number/{type}', 'Tenancy\ReferenceNumberGenerateController@generate');

    Route::get('/client-statistics/{id}/last-twelvemonth', 'Statistics\ClientStatsController@getLastTwelvemonthCounts');
    Route::get('/client-statistics/{id}/due-invoices', 'Statistics\ClientStatsController@getDueInvoices');
    Route::get('/client-statistics/{id}/paid-invoices', 'Statistics\ClientStatsController@getPaidInvoices');
    Route::get('/supplier-statistics/{id}/last-twelvemonth', 'Statistics\SupplierStatsController@getLastTwelvemonthCounts');
    Route::get('/supplier-statistics/{id}/due-invoices', 'Statistics\SupplierStatsController@getDueInvoices');
    Route::get('/supplier-statistics/{id}/paid-invoices', 'Statistics\SupplierStatsController@getPaidInvoices');
    Route::get('/product-statistics/{id}/last-twelvemonth', 'Statistics\ProductStatsController@getLastTwelvemonthCounts');
    Route::get('/product-statistics/{id}/sell-records', 'Statistics\ProductStatsController@getSellRecords');
    Route::get('/product-statistics/{id}/purchase-records', 'Statistics\ProductStatsController@getPurchaseRecords');

    Route::post('/current-tenant', 'User\TenancyController@store');
    Route::post('/upload/image', 'File\ImageUploadController@store');

    Route::post('/copy-to', 'Transform\CopyToController@store');

    Route::patch('/change-password', 'User\UserController@update');
    Route::patch('/status/{type}/{id}', 'Status\UpdateStatusController@update');
});


