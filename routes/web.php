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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/user', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/excel', 'HomeController@import')->name('excel');
// bright import
Route::get('/import_excel', 'ImportExcelController@index');
Route::post('/import_excel/import', 'ImportExcelController@import');

Route::get('/export_excel', 'ExportExcelController@index');
Route::post('/export_excel/export', 'ExportExcelController@export');
// 
Route::get('/user_manage', 'HomeController@user_manage')->name('user_manage');

Route::get('/image_upload', 'ImageUploadController@index');
Route::post('/image_upload/upload', 'ImageUploadController@upload')->name('imageupload.upload');


Route::resource('user', 'UserTableController');
Route::resource('assets', 'AssetController');
Route::resource('asset-check', 'AssetCheckController');
