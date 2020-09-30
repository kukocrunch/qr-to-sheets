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

/// QR Generation
Route::get('/', 'InformationController@index');
Route::post('generate', 'InformationController@generate');
Route::get('scan-qr', 'InformationController@scanner');
Route::post('add-qr',  'InformationController@saveQrToSheets')->name("AddQR");
