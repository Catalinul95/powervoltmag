<?php
Artisan::call('storage:link', [] );
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

Route::get('/cos-de-cumparaturi', 'CartController@index')->name('cart.index');

Route::get('/contul-meu', 'MembersController@index')->name('members.index');
Route::patch('/contul-meu', 'MembersController@update')->name('members.update');

Route::get('/{category}/filtre/{filters?}', 'ProductsController@index')->name('products.index')->where('filters', '(.*)');
Route::get('/{category}', 'ProductsController@index')->name('products.index');
Route::get('/{category}/{product}', 'ProductsController@show')->name('products.show');

