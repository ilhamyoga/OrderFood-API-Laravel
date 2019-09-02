<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('restaurant','RestaurantController@show');
Route::post('restaurant','RestaurantController@create');
Route::put('/restaurant/{id}','RestaurantController@update');
Route::delete('/restaurant/{id}','RestaurantController@delete');

Route::get('food','FoodController@show');
Route::get('/food/{id}','FoodController@getByRestaurant');
Route::post('food','FoodController@create');
Route::put('/food/{id}','FoodController@update');
Route::delete('/food/{id}','FoodController@delete');

Route::get('order','OrderController@show');
Route::get('order/{id}','OrderController@getByRestaurant');
Route::post('order','OrderController@create');
Route::put('/order/{id}','OrderController@update');
Route::delete('/order/{id}','OrderController@delete');

Route::get('cart/{id}','CartController@getByOrder');
Route::post('cart','CartController@create');
Route::put('/cart/{id}','CartController@update');
Route::delete('/cart/{id}','CartController@delete');

Route::get('transaction/{id}','TransactionController@getByRestaurant');
Route::post('transaction','TransactionController@create');
Route::delete('/transaction/{id}','TransactionController@delete');
