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
    return view('pages.home');
})->name('homepage');

Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('/dashboard/edit', function () {
    return view('dashboard.edit');
})->name('dashboard.edit');

Route::get('/dashboard/attended-events', function () {
    return view('dashboard.attended-events');
})->name('dashboard.attended-events');

Route::get('/dashboard/iterests', function () {
    return view('dashboard.interests');
})->name('dashboard.interests');
