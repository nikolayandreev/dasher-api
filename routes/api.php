<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::namespace('Api')
    ->group(function () {
        Route::POST('/login', 'AuthController@login');
        Route::POST('/register', 'AuthController@register');
        Route::DELETE('/logout', 'AuthController@logout');
        Route::POST('/password/forgot-password', 'PasswordsController@forgotPassword');
        Route::POST('/password/check', 'PasswordsController@hashCheck');
        Route::POST('/password/reset-password', 'PasswordsController@resetPassword');
    });


Route::middleware('auth:sanctum')
    ->namespace('Api')
    ->group(function () {
        Route::GET('user', 'AuthController@user');
    });

