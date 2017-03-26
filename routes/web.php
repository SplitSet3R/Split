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
      return view('welcome');
  })->middleware('guest');
  Auth::routes();

  Route::get('/dashboard', 'DashboardController@index');

  Route::post('/{username}/addexpense', 'DashboardController@store');

  Route::get('/friends', 'FriendsController@index');

  //TODO please implement the controller for this BE. Feel free to change the URIs if needed.

  // This route goes to the search user page
  // Route::get('/search', '[BackendController]');

  // This route is an ajax request where the authenticated user invites a user as a friend
  // Route::post('/search/addfriend', '[BackendController]');

  // A post request that returns all users matched with the given search query
  // Route::post('/search', '[BackendController]');
