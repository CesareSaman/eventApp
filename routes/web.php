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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Route::resource('event', 'EventController');

Auth::routes(['verify' => true]);

Route::get('/notif', function (){
    \App\Models\User::find(22)->notify(new \App\Notifications\EventCreatedNotification());
    return 'Done';
});
