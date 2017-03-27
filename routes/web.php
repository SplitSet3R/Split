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


  Route::post('/{username}/add', 'DashboardController@store');

  Route::get('profile/{profile_name}','ProfileController@index');
  Route::post('/{username}/addexpense', 'DashboardController@store');

  Route::get('/friends', 'FriendsController@index');

  //TODO please implement the controller for this BE. Feel free to change the URIs if needed.

  // This route goes to the search user page
  Route::get('/search', 'SearchController@index');
  Route::post('/search', 'SearchController@search');
  Route::post('search/addfriend', 'AjaxController@addfriend');

  Route::get('/debug', function() {
      return view('debug');
    });
