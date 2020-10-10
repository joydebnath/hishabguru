<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

Route::get('/', 'GuestPageController@index');
Route::get('/almost-there', 'GuestPageController@welcome');
Route::get('/is-void-account', 'GuestPageController@hasNoTenacy');
Route::get('/print', 'PrintDoc\PrintController@show');

Route::group(['middleware' => ['auth','verified']], function () {
    Route::get('/init', 'Setup\InventoryController@create');
    Route::post('/init', 'Setup\InventoryController@store');
    Route::get('/@/dashboard', 'PagesController@index')->name('home');
    Route::get('/@/{any}', 'PagesController@index')->where('any', '.*');
});


