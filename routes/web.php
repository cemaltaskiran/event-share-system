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

Route::get('/', 'EventController@showIndex')->name('homepage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home.index');

Route::prefix('organizer')->group(function() {

    Route::group(['middleware' => 'organizer-guest'], function(){
        // Register
        Route::get('/register', 'Auth\Organizer\RegisterController@showRegisterForm')->name('organizer.register');
        Route::post('/register', 'Auth\Organizer\RegisterController@create')->name('organizer.register.submit');

        // Login
        Route::get('/login', 'Auth\Organizer\LoginController@showLoginForm')->name('organizer.login');
        Route::post('/login', 'Auth\Organizer\LoginController@login')->name('organizer.login.submit');

        // Password Reset
        Route::get('/password/reset', 'Auth\Organizer\ForgotPasswordController@showLinkRequestForm')->name('organizer.email');
        Route::post('/password/email', 'Auth\Organizer\ForgotPasswordController@sendResetLinkEmail')->name('organizer.email.submit');
        Route::get('/password/reset/{token}', 'Auth\Organizer\ResetPasswordController@showResetForm')->name('organizer.reset');
        Route::post('/password/reset', 'Auth\Organizer\ResetPasswordController@reset')->name('organizer.reset.submit');
    });

    Route::group(['middleware' => 'organizer-auth'], function(){
        // Logout
        Route::post('/logout', 'Auth\Organizer\LoginController@logout')->name('organizer.logout');

        // Homepage
        Route::get('', 'OrganizerController@index')->name('organizer.index');
    });



});


Route::group(['middleware' => ['role:admin']], function()
{
    // Events
    Route::get('/home/events', 'EventController@displayEvents')->name('event.index');
    Route::get('/home/create-event', 'EventController@showCreateForm')->name('event.create');
    Route::post('/home/post-event', 'EventController@store')->name('event.post');
    Route::get('/home/update-event/{id}', 'EventController@showUpdateForm')->name('event.update');
    Route::post('/home/update-event-submit/{id}', 'EventController@update')->name('event.update.submit');
    Route::post('/home/delete-event/{id}', 'EventController@destroy')->name('event.delete');
    // Categories
    Route::get('/home/categories', 'CategoryController@displayCategories')->name('category.index');
    Route::get('/home/create-category', 'CategoryController@showCreateForm')->name('category.create');
    Route::post('/home/post-category', 'CategoryController@store')->name('category.post');
    Route::get('/home/update-category/{id}', 'CategoryController@showUpdateForm')->name('category.update');
    Route::post('/home/update-category-submit/{id}', 'CategoryController@update')->name('category.update.submit');
    Route::post('/home/delete-category/{id}', 'CategoryController@destroy')->name('category.delete');

});

Route::get('/event/{id}', 'EventController@profile')->where('id', '[0-9]+')->name('event.profile');
