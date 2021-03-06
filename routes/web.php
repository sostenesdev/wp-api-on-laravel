<?php

use APP\Http\Controllers\WpApi\AuthController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('get-token','App\Http\Controllers\WpApi\AuthController@getToken');
//Route::get('get-token',[AuthController::class, 'getToken'])->name('get-token');
Route::get('process-token','App\Http\Controllers\WpApi\AuthController@processToken');
Route::get('get-user-token','App\Http\Controllers\WpApi\AuthController@getUserToken');
Route::get('get-access-token','App\Http\Controllers\WpApi\AuthController@getAccessToken');
Route::get('posts','App\Http\Controllers\WpApi\PostController@all')->name('wpapi.posts');
Route::get('posts','App\Http\Controllers\WpApi\PostController@insert')->name('wpapi.posts.insert');
