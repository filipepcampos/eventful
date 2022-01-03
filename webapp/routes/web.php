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

// Homepage
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
Route::post('event', 'EventController@create')->name('createEvent');
Route::get('event/{event_id}', 'EventController@show')->name('event');
Route::put('event/{event_id}', 'EventController@update')->name('updateEvent');
Route::delete('event/{event_id}', 'EventController@delete');
Route::get('event/{event_id}/update', 'EventController@showUpdateForm')->name('updateEventForm');

Route::get('events', 'EventController@list')->name('events');
Route::get('event', 'EventController@search');      // Search
Route::get('event/{event_id}/image', 'EventController@getImage');
Route::post('event/{event_id}/attend', 'EventController@join')->name('joinEvent');
Route::delete('event/{event_id}/attend', 'EventController@leave')->name('leaveEvent');

// Event API
Route::post('api/event/{event_id}/kick', 'EventController@kick'); // TODO A7
Route::post('api/event/{event_id}/invite', 'EventController@invite'); // TODO A7

// Admin
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function(){
    Route::get('/', 'AdministratorController@home')->name('admin'); // TODO: A7
    Route::get('users', 'AdministratorController@users')->name('adminUserList');
    Route::get('reports', function () { return view('pages.reports'); });
});
Route::post('api/user/{user_id}/block', 'AdministratorController@blockUser')->middleware('admin');
Route::post('api/user/{user_id}/unblock', 'AdministratorController@unblockUser')->middleware('admin');

// Users
Route::get('user/{user_id}', 'UserController@show')->name('user');
Route::put('user/{user_id}', 'UserController@update')->name('updateUser');
Route::get('user/{user_id}/update', 'UserController@showUpdateForm')->name('updateUserForm'); 
Route::get('user/{user_id}/profile_pic', 'UserController@getImage')->name('userImage');

// Invites
Route::put('api/invite/{invite_id}/accept', 'InviteController@accept');
Route::delete('api/invite/{invite_id}/reject', 'InviteController@reject');

// Requests
Route::post('api/event/{event_id}/request', 'RequestController@send');
Route::put('api/request/{request_id}/accept', 'RequestController@accept');
Route::delete('api/request/{request_id}/reject', 'RequestController@reject');

// Comments TODO: Controller
Route::post('api/event/{event_id}/comment', 'CommentController@create');
Route::put('api/comment/{comment_id}', 'CommentController@update');
Route::delete('api/comment/{comment_id}', 'CommentController@delete');

// Posts TODO: Controller
Route::post('api/event/{event_id}/post', 'PostController@create');
Route::put('api/post/{post_id}', 'PostController@update');
Route::delete('api/post/{post_id}', 'PostController@delete');