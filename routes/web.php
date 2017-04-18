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
Route::get('/', 'WelcomeController@index')->middleware('guest');
Auth::routes();

/*Profile Routes*/
Route::get('profile/{profile_name}','ProfileController@index');
Route::post('profile/{profile_name}/edit', 'ProfileController@edit');

/*Dashboard Routes*/
Route::post('/{username}/addexpense', 'ExpenseController@addExpense');
Route::get('/dashboard', 'DashboardController@index');

/*Search Routes*/
Route::get('/search', 'SearchController@index');
Route::post('/search', 'SearchController@search');
Route::post('/search/addfriend', 'AjaxController@addfriend');

/*Friends Routes*/
Route::get('/friends', 'FriendController@index');
Route::post('/friends/process', 'AjaxController@processFriendRequest');
Route::post('/friends/sharedexpense', 'AjaxController@retrieveFriends');

/*Notifications routes*/
Route::get('/notifications', 'AjaxController@getNotifications');
Route::post('/notifications', 'AjaxController@updateNotifications');

/*Settle Expenses Routes*/
Route::post('/settleSharedExpense', 'SettleExpenseController@settleSharedExpense');
Route::post('/settleGroupExpense', 'SettleExpenseController@settleGroupSharedExpense');

/* Groups controller */
Route::get('/groups', 'GroupCreateController@index');
Route::post('/creategroup', 'GroupCreateController@store');
Route::post('/updateGroup','GroupCreateController@updateGroup');
Route::post('/groupDelete','GroupCreateController@deleteGroup');
