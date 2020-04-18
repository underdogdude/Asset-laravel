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
Route::get('/user_manage', 'HomeController@user_manage')->name('user_manage');

Route::resource('user', 'UserTableController');
Route::resource('assets', 'AssetController');
Route::resource('asset-check', 'AssetCheckController');
