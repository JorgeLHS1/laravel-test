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

Route::get('/', 'PlacesListController@index')->name('index');

Route::post('list', 'PlacesListController@list')->name('list');

Route::get('list', 'PlacesListController@list')->name('list');

Route::get('list-test', 'PlacesListController@listTest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('mailable', function () {
    $user = App\User::find(1);
    return new App\Mail\PostRegisteredUserEmail($user);
});

Route::get('searched-places', function () {
    if (Auth::check()) {
        return view('searched_places');
    } else {
        return redirect()->back()->withErrors('Usuário necessita estar logado!');
    }
})->name('searched-places');
