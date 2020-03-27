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

Route::get('/', 'PlacesListController@index')->name('index');

Route::post('list', 'PlacesListController@list')->name('list');

Route::get('list-test', 'PlacesListController@listTest');
