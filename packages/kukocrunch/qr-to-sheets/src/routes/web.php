<?php


Route::get('/', 'Kukocrunch\Qrtosheets\Http\Controllers\InformationController@index')->name('home');
Route::post('generate', 'Kukocrunch\Qrtosheets\Http\Controllers\InformationController@generate')->name('generate');
Route::get('scan-qr', 'Kukocrunch\Qrtosheets\Http\Controllers\InformationController@scanner')->name('scan');
Route::post('add-qr',  'Kukocrunch\Qrtosheets\Http\Controllers\InformationController@saveQrToSheets')->name("AddQR");