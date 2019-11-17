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

Route::group(['middleware' => 'api'], function () {
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/signup', 'Auth\RegisterController@register');
});

Route::group([
    'middleware' => 'auth:api'
], function () {

    Route::post('/logout', 'Auth\LoginController@logout');
    Route::get('/user/current', 'Auth\UserController@current');
    Route::get('/posts', 'PostController@index');
    Route::post('/post', 'PostController@create');
    Route::get('/post/{slug}', 'PostController@get');
    Route::put('/post/{id}', 'PostController@update');
    Route::delete('/post/{id}', 'PostController@delete');
});
