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

Route::get('user/server-side', 'Api\DataTableController@userServerSide');
Route::get('asset/server-side', 'Api\DataTableController@assetServerSide');
// bright
Route::post('assetSearch/server-side', 'Api\DataTableController@assetSearchServerSide');

// 
Route::post('asset-count/server-side', 'Api\DataTableController@assetCountServerSide');
Route::post('login', 'Api\ApplicationController@login');
Route::post('addCheckAsset', 'Api\ApplicationController@addCheckAsset');
Route::get('getLocation', 'Api\ApplicationController@getLocation');
Route::post('getAssetList', 'Api\ApplicationController@getAssetList');
Route::post('getAsset', 'Api\ApplicationController@getAsset');
