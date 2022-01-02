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
Route::get('/', 'EventController@list' )->name('homepage');

Route::get('/about', function(){return view('pages.about');});
Route::get('/contact', function(){return view('pages.contact');});

// Authentication
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Events
Route::get('createEvent', 'EventController@showCreateForm');
Route::get('events', 'EventController@list');
Route::get('event/{event_id}', 'EventController@show')->name('event');
Route::put('event/{event_id}', 'EventController@update')->name('updateEvent');
Route::delete('event/{event_id}', 'EventController@delete');
Route::get('event/{event_id}/update', 'EventController@showUpdateForm');
Route::get('event', 'EventController@search');      // Search
Route::post('event', 'EventController@create')->name('createEvent');

// Event API
Route::post('/api/event/{event_id}/attend', 'EventController@join')->name('joinEvent');
Route::delete('/api/event/{event_id}/attend', 'EventController@leave')->name('leaveEvent');
Route::post('/api/event/{event_id}/kick', 'EventController@kick'); // TODO A7
Route::post('/api/event/{event_id}/invite', 'EventController@invite'); // TODO A7

// Admin
Route::get('/admin', 'AdministratorController@home'); // TODO: A7

// Users
Route::get('user/{user_id}', 'UserController@show');
Route::put('user/{user_id}', 'UserController@update')->name('updateUser');
Route::get('user/{user_id}/update', 'UserController@showUpdateForm'); 
Route::get('user/{user_id}/profile_pic', 'UserController@getImage');

// Comments TODO: Controller
Route::post('api/event/{event_id}/comment', 'CommentController@create');
Route::put('api/comment/{comment_id}', 'CommentController@update');
Route::delete('api/comment/{comment_id}', 'CommentController@delete');

// Posts TODO: Controller
Route::post('api/event/{event_id}/post', 'PostController@create');
Route::put('api/post/{post_id}', 'PostController@update');
Route::delete('api/post/{post_id}', 'PostController@delete');

// Images
Route::get('image/event/{id}', 'EventController@getImage');

/*// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');*/