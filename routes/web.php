<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/login', function () {
    return view('welcome');
})->name('login');

Route::get('/login', 'LoginController@showLoginForm')->name('login');
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout')->name('logout');


Route::prefix('/dashboard')
     ->name('admin.')
     ->namespace('Dashboard')
    ->middleware('auth:admin')
     ->group(function () {
         Route::get('/', 'DashboardController@index')->name('home');
     });

Route::get('/', function () {
    return view('welcome');
});
