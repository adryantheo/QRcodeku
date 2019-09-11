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

Route::any('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

Route::any('/admin/{page}', function () {
    return view('welcome');
})->where('any', '.*');


// Route::any('{page}', function(){return view('welcome');});
// Route::any('/admin', function(){ return view('welcome');});
// Route::get('/karyawan/{page}', function(){ return view('welcome');});
// Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');