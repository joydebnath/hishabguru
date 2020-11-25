<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('/generate-number/{type}', 'Tenancy\ReferenceNumberGenerateController@generate');
    Route::get('/client-statistics/{id}/{type}', 'Statistics\ClientStatsController@show');
    Route::get('/supplier-statistics/{id}/{type}', 'Statistics\SupplierStatsController@show');
    Route::get('/product-statistics/{id}/{type}', 'Statistics\ProductStatsController@show');
    Route::get('/dashboard-statistics/{type}', 'Home\DashboardController@show');

    Route::post('/current-tenant', 'User\TenancyController@store');
    Route::post('/upload/image', 'File\ImageUploadController@store');
    Route::post('/copy-to', 'Transform\CopyToController@store');
    Route::post('/import-data', 'ImportData\ImportController@store');

    Route::patch('/change-password', 'User\UserController@update');
    Route::patch('/status/{type}/{id}', 'Status\UpdateStatusController@update');
    Route::patch('/employees/{id}/assign-role', 'Team\EmployeeController@assignRole');
});

Route::get('/print/{type}/{id}', 'PrintDoc\PrintController@show');

Route::post('/quotation/{id}', 'PublicDoc\QuotationController@update');
Route::post('/invoice/{id}', 'PublicDoc\InvoiceController@update');
