<?php

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

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::post('/add-to-cart.ajax', 'CartController@store')->name('cart.store');
Route::get('/{category}/filtre/{filters?}', 'ProductsController@index')->name('products.index')->where('filters', '(.*)');
Route::get('/{category}', 'ProductsController@index')->name('products.index');
Route::get('/{category}/{product}', 'ProductsController@show')->name('products.show');

