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
Route::post('signUp', 'UsersController@signUp');
Route::post('signIn', 'UsersController@signIn');


Route::post('storeCategory', 'CategoryController@store');
Route::get('getCategory', 'CategoryController@index');
Route::post('updateCategory/{id}', 'CategoryController@update');
Route::get('showCategory/{id}', 'CategoryController@show');
Route::post('deleteCategory/{id}', 'CategoryController@destroy');


Route::post('storeOrder', 'OrderController@store');
Route::get('getOrder', 'OrderController@index');
Route::post('updateOrder/{id}', 'OrderController@update');
Route::get('showOrder/{id}', 'OrderController@show');
Route::post('deleteOrder/{id}', 'OrderController@destroy');


Route::post('storeProduct', 'ProductController@store');
Route::get('getProduct', 'ProductController@index');
Route::post('updateProduct/{id}', 'ProductController@update');
Route::get('showProduct/{id}', 'ProductController@show');
Route::post('deleteProduct/{id}', 'ProductController@destroy');


Route::post('storeRole', 'RoleController@store');
Route::get('getRole', 'RoleController@index');
Route::post('updateRole/{id}', 'RoleController@update');
Route::get('showRole/{id}', 'RoleController@show');
Route::post('deleteRole/{id}', 'RoleController@destroy');


Route::any('{path?}', 'CategoryController@index')->where("path", ".+");
