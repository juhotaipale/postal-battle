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

Route::get('/', 'GameController@index')->name('index');
Route::get('game/{game}', 'GameController@show')->name('game');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('game/{game}/demo', 'GameController@demo')->name('demo');
