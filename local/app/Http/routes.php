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
/*Authentication*/
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController'
]);
/*End: Authentication*/

/*Dashboard*/
Route::get('dashboard', [
    'as' => 'dashboard', 
    'uses' => 'DashboardController@index'
]);
/*End: Dashboard*/

/*User*/
Route::resource('user', 'UserController');
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
/*End: User*/

/*Requests*/
Route::resource('request', 'RequestController', [
    'except' => ['update']
]);
Route::get('request/view/{request_status}', 
[
    'as' => 'request.index', 
    'uses' => 'RequestController@index'
]);
Route::get('request/update/{request_id})', 
[
    'as' => 'request.update', 
    'uses' => 'RequestController@update'
]);
/*End: Requests*/

/*Attachments*/
Route::get('download/{attachment_code}', ['as' => 'download', 'uses' => 'AttachmentController@download']);
/*End: Attachments*/