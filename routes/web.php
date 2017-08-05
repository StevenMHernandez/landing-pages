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

Route::get('/', 'LandingPageController@index')->name('landing_page');
Route::get('/subscription', 'SubscriptionController@index')->name('show_subscription');
Route::post('/subscription', 'SubscriptionController@create')->name('create_subscription');