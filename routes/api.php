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

Route::group(['namespace'=>'Api', 'prefix'=>'height_predictor'], function () {
    Route::post('predict', 'PredictController@predict');
    Route::get('models', 'PredictController@modelsList');
    Route::get('sources', 'PredictController@sourceList');
});
