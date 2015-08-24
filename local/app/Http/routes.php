<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|----------------------@section('nav')
            
        @show----------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Dashboard*/
Route::get('dashboard', [
    'as' => 'dashboard', 'uses' => 'DashboardController@index'
]);
/*End: Dashboard*/

/*User*/
Route::group(['as' => 'user::'], function () {
   	Route::get('/', [
    		   'as' => 'login', 
    		   'uses' => 'UserController@login'
    		]);
   	Route::get('profile', [
    		   'as' => 'profile', 
    		   'uses' => 'UserController@profile'
    		]);
});
/*End: Requests*/

/*Requests*/
Route::group(['as' => 'request::'], function () {
    Route::get('requests/details/{QAS-123}', [
    		   'as' => 'details', 
    		   'uses' => 'RequestController@detail'
    		]);
    Route::get('requests/{pending}', [
    		   'as' => 'pending', 
    		   'uses' => 'RequestController@show'
    		]);
   	Route::get('requests/{incoming}', [
    		   'as' => 'incoming', 
    		   'uses' => 'RequestController@show'
    		]);
   	Route::get('requests/{approved}', [
    		   'as' => 'approved', 
    		   'uses' => 'RequestController@show'
    		]);
   	Route::get('requests/{denied}', [
    		   'as' => 'denied', 
    		   'uses' => 'RequestController@show'
    		]);
   	Route::get('requests/{all}', [
    		   'as' => 'all', 
    		   'uses' => 'RequestController@show'
    		]);
});
/*End: Requests*/




// Test Route
Route::get('test', 'TestController@index');

// Static Layouts

/*Route::get('/', function () {
    return view('welcome');
});
*/