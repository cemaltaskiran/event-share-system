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

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home.index');

Route::group(['middleware' => ['role:admin']], function()
{
    Route::get('/home/events', 'EventController@displayEvents')->name('event.index');
    Route::get('/home/create-event', 'EventController@showCreateForm')->name('event.create');
    Route::post('/home/post-event', 'EventController@store')->name('event.post');
    
});

Route::get('/event/{id}', 'EventController@profile')->where('id', '[0-9]+');
