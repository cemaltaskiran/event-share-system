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

Route::prefix('/user')->group(function(){
    // Homepage
    Route::get('', 'HomeController@index')->name('user.index');

    Route::group(['middleware' => 'auth'], function(){
        // Events
        Route::get('/events', 'EventController@displayUserEvents')->name('user.event.index');
        Route::get('/create-event', 'EventController@showCreateForm')->name('user.event.create');
        Route::post('/post-event', 'EventController@store')->name('user.event.post');
        Route::get('/update-event/{id}', 'EventController@showCreatorUpdateForm')->name('user.event.update');
        Route::post('/update-event-submit/{id}', 'EventController@update')->name('user.event.update.submit');
        Route::post('/freeze-event/{id}', 'EventController@freezeByCreator')->name('user.event.freeze');
        Route::post('/unfreeze-event/{id}', 'EventController@unfreezeByCreator')->name('user.event.unfreeze');
        Route::post('/cancel-event/{id}', 'EventController@cancel')->name('user.event.cancel');
        Route::get('/joined-events', 'UserController@joinedEvents')->name('user.event.joined.index');
        Route::get('/view-event-file/{id}', 'EventController@download')->name('user.event.download');
        Route::post('/send-comment/{id}', 'EventController@sendComment')->name('user.comment.send');
        Route::get('/joiners-event/{id}', 'EventController@joiners')->name('user.event.joiners');

        // Join event
        Route::post('/join-to-event/{id}', 'EventController@joinToEvent')->name('user.event.join.submit');

        // Unjoin event
        Route::post('/unjoin-from-event/{id}', 'EventController@unjoinFromEvent')->name('user.event.unjoin.submit');

        // Send complaint
        Route::post('/complaint-event/{id}', 'ComplaintController@sendComplaintment')->name('user.complaint.send');

        // Update infos
        Route::post('/update-info', 'UserController@update')->name('user.update');
    });
});

Route::prefix('/organizer')->group(function() {

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

        // Events
        Route::get('/events', 'EventController@displayOragnizerEvents')->name('organizer.event.index');
        Route::get('/create-event', 'EventController@showCreateForm')->name('organizer.event.create');
        Route::post('/post-event', 'EventController@store')->name('organizer.event.post');
        Route::get('/update-event/{id}', 'EventController@showCreatorUpdateForm')->name('organizer.event.update');
        Route::post('/update-event-submit/{id}', 'EventController@update')->name('organizer.event.update.submit');
        Route::post('/freeze-event/{id}', 'EventController@freezeByCreator')->name('organizer.event.freeze');
        Route::post('/unfreeze-event/{id}', 'EventController@unfreezeByCreator')->name('organizer.event.unfreeze');
        Route::post('/cancel-event/{id}', 'EventController@cancel')->name('organizer.event.cancel');
        Route::get('/joiners-event/{id}', 'EventController@joiners')->name('organizer.event.joiners');

        // Update infos
        Route::post('/update-info', 'OrganizerController@update')->name('organizer.update');
    });

});

Route::prefix('/admin')->group(function(){

    Route::group(['middleware' => 'admin-guest'], function(){
        // Login
        Route::get('/login', 'Auth\Admin\LoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'Auth\Admin\LoginController@login')->name('admin.login.submit');

        // Password Reset
        Route::get('/password/reset', 'Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.email');
        Route::post('/password/email', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.email.submit');
        Route::get('/password/reset/{token}', 'Auth\Admin\ResetPasswordController@showResetForm')->name('admin.reset');
        Route::post('/password/reset', 'Auth\Admin\ResetPasswordController@reset')->name('admin.reset.submit');
    });

    Route::group(['middleware' => 'admin-auth'], function(){
        // Logout
        Route::post('/logout', 'Auth\Admin\LoginController@logout')->name('admin.logout');

        // Homepage
        Route::get('', 'AdminController@index')->name('admin.index');

        // Events
        Route::get('/events', 'EventController@displayAdminEvents')->name('admin.event.index');
        Route::get('/update-event/{id}', 'EventController@showAdminUpdateForm')->name('admin.event.update');
        Route::post('/update-event-submit/{id}', 'EventController@updateByAdmin')->name('admin.event.update.submit');
        Route::post('/delete-event/{id}', 'EventController@destroy')->name('admin.event.delete');
        Route::post('/freeze-event/{id}', 'EventController@freezeByAdmin')->name('admin.event.freeze');
        Route::post('/unfreeze-event/{id}', 'EventController@unfreezeByAdmin')->name('admin.event.unfreeze');
        Route::post('/cancel-event/{id}', 'EventController@cancelByAdmin')->name('admin.event.cancel');

        // Categories
        Route::get('/categories', 'CategoryController@displayCategories')->name('admin.category.index');
        Route::get('/create-category', 'CategoryController@showCreateForm')->name('admin.category.create');
        Route::post('/post-category', 'CategoryController@store')->name('admin.category.post');
        Route::get('/update-category/{id}', 'CategoryController@showUpdateForm')->name('admin.category.update');
        Route::post('/update-category-submit/{id}', 'CategoryController@update')->name('admin.category.update.submit');
        Route::post('/delete-category/{id}', 'CategoryController@destroy')->name('admin.category.delete');

        // Complaint Types
        Route::get('/complaint-types', 'ComplaintTypeController@index')->name('admin.complaint.type.index');
        Route::get('/create-complaint-type', 'ComplaintTypeController@create')->name('admin.complaint.type.create');
        Route::post('/post-complaint-type', 'ComplaintTypeController@store')->name('admin.complaint.type.post');
        Route::get('/update-complaint-type/{id}', 'ComplaintTypeController@edit')->name('admin.complaint.type.update');
        Route::post('/update-complaint-type-submit/{id}', 'ComplaintTypeController@update')->name('admin.complaint.type.update.submit');
        Route::post('/delete-complaint-type/{id}', 'ComplaintTypeController@destroy')->name('admin.complaint.type.delete');

        // Complaints
        Route::get('/complaints', 'ComplaintController@index')->name('admin.complaint.index');
        Route::post('/delete-complaint/{id}', 'ComplaintController@destroy')->name('admin.complaint.delete');
        Route::post('/read-complaint/{id}', 'ComplaintController@setRead')->name('admin.complaint.read');
        Route::post('/unread-complaint/{id}', 'ComplaintController@setUnread')->name('admin.complaint.unread');
    });
});

Route::get('/events', 'EventController@everything')->name('event.everything');

Route::get('/event/{id}', 'EventController@profile')->where('id', '[0-9]+')->name('event.profile');
