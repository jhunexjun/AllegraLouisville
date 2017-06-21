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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/showUsers', 'UsersController@index')->name('showUsers');
Route::get('/dealers', 'DealerController@index')->name('dealers');
Route::post('/addDealer', 'DealerController@addDealer');

Route::get('/sales', 'SalesController@getSalesData');
Route::get('/service', 'ServiceController@getServiceData');
