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
  if(Auth::guest()) {
    return redirect('/login');
  } else {
    return redirect('/home');
  }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/clients', 'ClientsController@index')->name('clients');
Route::get('/sync', 'SyncController@index')->name('sync-logs');
Route::get('/sync/request', 'SyncController@request')->name('sync-new-request');
Route::get('/sync/request/devices', 'SyncController@updateDevices')->name('sync-update-devices');
Route::get('/sync/request/actualize', 'SyncController@actualizeDevices')->name('sync-actualize-devices');

