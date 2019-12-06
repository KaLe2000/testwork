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

Route::get('/', 'HomeController@index')
    ->name('index');

Route::get('/transaction/{user}', 'TransactionController@index')
    ->name('transaction');

Route::post('/trascation', 'TransactionController@store')
    ->name('transaction.new');
