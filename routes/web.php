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

Auth::routes();

Route::get('/', 'PagesController@welcome');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/@/dashboard', 'PagesController@index')->name('home');
    Route::get('/@/{any}', 'PagesController@index')->where('any', '.*');
});


