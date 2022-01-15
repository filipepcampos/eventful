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

// Static Pages
Route::get('/', function () { return view('pages.home'); } )->name('homepage');
Route::get('about', function(){return view('pages.about');});
Route::get('contact', function(){return view('pages.contact');});

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Events
Route::get('createEvent', 'EventController@showCreateForm')->name('createEventForm');
Route::get('event', 'EventController@search');
Route::post('event', 'EventController@create')->name('createEvent');
Route::get('event/{event_id}', 'EventController@show')->name('event');
Route::put('event/{event_id}', 'EventController@update')->name('updateEvent');
Route::delete('event/{event_id}', 'EventController@delete');
Route::get('event/{event_id}/update', 'EventController@showUpdateForm')->name('updateEventForm');
Route::get('events', 'EventController@list')->name('events');
Route::get('event/{event_id}/image', 'EventController@getImage');

Route::post('event/{event_id}/attend', 'EventController@join')->name('joinEvent');
Route::delete('event/{event_id}/attend', 'EventController@leave')->name('leaveEvent');

// Event API
Route::delete('api/event/{event_id}/kick', 'EventController@kick');
Route::post('api/event/{event_id}/invite', 'EventController@invite');
Route::post('api/event/{event_id}/post', 'PostController@store');

// Post API
Route::delete('api/post/{post_id}', 'PostController@delete');
Route::put('api/post/{post_id}', 'PostController@update');

// Admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function(){
    Route::get('/', 'AdministratorController@home')->name('admin');
    Route::get('users', 'AdministratorController@users')->name('adminUserList');
    Route::get('reports', function () { return view('pages.reports'); });
});
Route::put('api/user/{user_id}/block', 'AdministratorController@blockUser')->middleware('admin');
Route::put('api/user/{user_id}/unblock', 'AdministratorController@unblockUser')->middleware('admin');

// Users
Route::get('user/{user_id}', 'UserController@show')->name('user');
Route::put('user/{user_id}', 'UserController@update')->name('updateUser');
Route::get('user/{user_id}/update', 'UserController@showUpdateForm')->name('updateUserForm'); 
Route::get('user/{user_id}/profile_pic', 'UserController@getImage')->name('userImage');
//      Notifications
Route::post('api/user/{user_id}/markNotificationAsRead', 'UserController@markNotificationAsRead')->name('markNotificationAsRead'); // TODO A7?

// Invites
Route::put('api/invite/{invite_id}/accept', 'InviteController@accept');
Route::delete('api/invite/{invite_id}/reject', 'InviteController@reject');

// Requests
Route::post('api/event/{event_id}/request', 'RequestController@send');
Route::put('api/request/{request_id}/accept', 'RequestController@accept');
Route::delete('api/request/{request_id}/reject', 'RequestController@reject');

// Comment API
Route::post('api/event/{event_id}/comment', 'CommentController@store');
Route::delete('api/comment/{comment_id}', 'CommentController@destroy');
Route::post('api/comment/{comment_id}/rating', 'CommentController@addRating');

// Unblock Appeal API
Route::post('api/unblockAppeal', 'UnblockAppealController@create');