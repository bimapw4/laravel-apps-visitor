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

Route::get('/', function () {
    return redirect(url('login'));
}); 

Route::get('/login', "LoginController@index")->name('login')->middleware('guest');
Route::get('/logout', "LoginController@logout")->name('login.logout');
Route::resource('/login', "LoginController")->name('*','login')->middleware('guest');
Route::resource('/dashboard', "DashboardController")->name('*','dashboard')->middleware('auth');

