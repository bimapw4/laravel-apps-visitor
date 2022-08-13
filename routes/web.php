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

// Route::get('/login', 'auth\LoginController@index');

// Route::get('/', 'dashboard\IndexController@index'); 

Route::resource('/login', "LoginController");
Route::resource('/dashboard', "DashboardController");

