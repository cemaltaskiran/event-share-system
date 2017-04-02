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
    return view('pages.home', ['title' => 'Anasayfa']);
});
/*
Route::get('login', function () {
    return view('pages.login', ['title' => 'Giriş Yap']);
});

Route::get('register', function () {
    return view('pages.register', ['title' => 'Üye ol']);
});
*/
Auth::routes();

Route::get('/home', 'HomeController@index');
