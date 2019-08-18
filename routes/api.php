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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('products', 'BrandsController@index');
Route::get('products/{brands}','BrandsController@show');
Route::post('products','BrandsController@store');
Route::patch('products/{brands}','BrandsController@update');
Route::delete('products/{brands}','BrandsController@destroy');

Route::get('credits', 'CreditController@index');
Route::get('credits/{credit}','CreditController@show');
Route::post('credits','CreditController@store');
Route::patch('credits/{credit}','CreditController@update');
Route::delete('credits/{credit}','CreditController@destroy');
