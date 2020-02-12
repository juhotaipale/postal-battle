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

Route::post('auth', 'Auth\LoginController@login');

Route::group(['middleware' => ['auth']], function () {
    Route::get('game', 'GameController@index');
    Route::get('game/create', 'GameController@create');
    Route::get('game/{game}', 'GameController@show');
    Route::post('game/{game}/join', 'GameController@join');
    Route::post('game/{game}/begin', 'GameController@begin');
});
