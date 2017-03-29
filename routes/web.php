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

  /* AddExpenseController */
  Route::get('/dashboard', 'AddExpenseController@index');
  Route::get('/addExpense', 'AddExpenseController@index');
  Route::post('/{username}/add', 'AddExpenseController@store');
  Route::post('/{username}/addexpense', 'AddExpenseController@store');

  /* ProfileController */

 // Route::get('profile/{profile_name}','ProfileController@index');


  /* TableListController */
  Route::get('/tableList', 'TableListController@index');




  Route::get('/friends', 'FriendController@index');


  Route::get('profile/{profile_name}','ProfileController@index');
  Route::post('/{username}/addexpense', 'DashboardController@store');



  /* FriendController */
  //Route::get('/friends/search', 'FriendsController@search_view');

  //TODO please implement the controller for this BE. Feel free to change the URIs if needed.

  /* statisticsController */
  Route::get('/statistics', 'StatisticsController@index');

  /* SearchController */
  // This route goes to the search user page
  Route::get('/search', 'SearchController@index');
  Route::post('/search', 'SearchController@search');

  /* AjaxController */
  Route::post('search/addfriend', 'AjaxController@addfriend');
