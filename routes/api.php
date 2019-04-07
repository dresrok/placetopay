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

Route::namespace('Api')->group(function () {
    Route::post('ptp/payment', 'PlaceToPayController@store')->name('api.ptp.store');
    Route::get('ptp/payment/attempts/{payment}', 'PlaceToPayController@getAttempts')->name('api.ptp.attempts');
});
