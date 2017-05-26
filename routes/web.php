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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/settings', 'SettingsController@index')->name('settings');
Route::post('/settings', 'SettingsController@saveSettings');

Route::get('/clients', 'ClientsController@index')->name('clients');
Route::get('/api/clients', 'ClientsController@getClients');
Route::put('/api/clients/{id}', 'ClientsController@updateClients');
