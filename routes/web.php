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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/update_password', 'HomeController@update_password')->name('update_password');

Route::post('/user/credentials', 'HomeController@postCredentials')->name('update_password_api');

Route::get('/api/items', 'HomeController@api')->name('get_items_api');

Route::post('/add', 'HomeController@add_item')->name('add_items');
// Route::get('/api/add_item', 'HomeController@Store')->name('add_items');
