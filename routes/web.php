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
  });
  Auth::routes();

  Route::get('/dashboard', 'DashboardController@index');

  Route::post('/{username}/addexpense', 'DashboardController@store');

  Route::get('/search', 'AddFriendController@index');

  Route::post('/search/addfriend', 'AddFriendController@addFriend');

  Route::post('/search', 'AddFriendController@index');
