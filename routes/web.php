<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', 'BatteryController@index')->name('battery.index');
Route::get('/battery', 'BatteryController@index')->name('battery.index');

Route::get('/battery/{battery}/charging/create', 'ChargingController@create')->name('charging.create');
Route::post('/battery/{battery}/charging', 'ChargingController@store')->name('charging.store');