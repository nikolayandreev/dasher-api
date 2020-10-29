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

Route::namespace('Api\Auth')
     ->group(function () {
         Route::POST('login', 'AuthController@login');
         Route::POST('register', 'AuthController@register');
         Route::POST('password/forgot-password', 'PasswordsController@forgotPassword');
         Route::POST('password/check', 'PasswordsController@hashCheck');
         Route::POST('password/reset-password', 'PasswordsController@resetPassword');
     });


Route::middleware('auth:sanctum')
     ->namespace('Api')
     ->group(function () {
         Route::namespace('Auth')->group(function () {
             Route::GET('user', 'AuthController@user');
             Route::DELETE('logout', 'AuthController@logout');
         });

         Route::GET('/subscriptions/init', 'SubscriptionsController@init');
         Route::POST('/subscriptions', 'SubscriptionsController@store');

         Route::namespace('Cruds')->group(function () {
             Route::resource('services', 'ServicesController')->except([
                 'create', 'show',
             ]);

             Route::resource('services', 'ServicesController')->only(['index', 'store', 'update', 'destroy']);
             Route::resource('service-categories', 'ServiceCategoriesController')
                  ->only('index', 'store', 'update', 'destroy');

             Route::GET('clients/{vendor}/grid', 'ClientsController@index');
             Route::resource('clients', 'ClientsController')->only('show', 'store', 'update', 'destroy');
         });


         Route::GET('areas', 'CoreController@areas');

         Route::namespace('Vendors')->group(function () {
             Route::POST('/vendor', 'VendorsController@store');
             Route::POST('/vendor/schedule', 'VendorsController@storeSchedule');
             Route::GET('/vendor/{id}/schedule', 'VendorsController@showSchedule');
             Route::GET('/vendor/{id}', 'VendorsController@show');
             Route::POST('/vendor/employee/invite', 'Api\Vendors\VendorsController@inviteEmployee');
             Route::GET('/addresses/{vendor_id}', 'VendorsController@addresses');
         });
     });

