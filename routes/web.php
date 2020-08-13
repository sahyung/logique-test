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
    return redirect()->route('register');
});

Route::get('register', function () {
    return view('register');
})->name('register');
Route::post('register', 'AuthController@registerWeb')->name('registerWeb');
Route::get('login', function () {
    return view('login');
})->name('login');
Route::post('login', 'AuthController@loginWeb')->name('loginWeb');

Route::get('home', 'UserController@showWeb')->name('home');

Route::get('auth/reset', 'AuthController@reset')->name('api.v1.auth.reset');
Route::post('auth/reset', 'AuthController@reset')->name('api.v1.auth.reset');