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

// GET routes
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@showHomePage')->name('home_page');

Route::get('/update_password', 'HomeController@showUpdatePassword')->name('show_update_password');

Route::post('/user/credentials', 'HomeController@postCredentials')->name('update_password_api');

Route::get('/api/items', 'HomeController@getAllItems')->name('get_items_api');

Route::post('/add', 'HomeController@addNewItem')->name('add_new_item');
