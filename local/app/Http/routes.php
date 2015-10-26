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
    'middleware' => 'auth.user', 
    'uses' => 'DashboardController@index'
]);
/*End: Dashboard*/

/*User*/
Route::resource('user', 'UserController');
Route::group(['as' => 'user.'], function () {
   	Route::get('/', [
               'as' => 'login', 
               'uses' => 'UserController@login'
            ]);
    Route::post('login', [
    		   'as' => 'login', 
    		   'uses' => 'UserController@login'
    		]);
   	Route::get('profile', [
    		   'as' => 'profile',
               'middleware' => 'auth.user', 
    		   'uses' => 'UserController@profile'
    		]);
    Route::get('logout', [
               'as' => 'logout',
               'uses' => 'UserController@logout'
            ]);
});
/*End: User*/

/*Requests*/
Route::resource('request', 'RequestController', [
    'except' => ['update'],
    'middleware' => 'auth.user'
]);
Route::get('request/view/{request_status}', 
[
    'as' => 'request.index',
    'middleware' => 'auth.user',  
    'uses' => 'RequestController@index'
]);
Route::get('request/update/{request_id})', 
[
    'as' => 'request.update',
    'middleware' => 'auth.user', 
    'uses' => 'RequestController@update'
]);
/*End: Requests*/

/*Attachments*/
Route::resource('attachment', 'AttachmentController', [
    'middleware' => 'auth.user'
]);
Route::group(['as' => 'attachment.'], function () {
    Route::get('attachment/download/{attachment_code}', [
               'as' => 'download', 
               'middleware' => 'auth.user',
               'uses' => 'AttachmentController@download'
            ]);
    Route::post('attachment/upload/', [
               'as' => 'upload', 
               'middleware' => 'auth.user',
               'uses' => 'AttachmentController@upload'
            ]);
    Route::get('attachment/delete/{attachment_code}', [
               'as' => 'delete', 
               'middleware' => 'auth.user',
               'uses' => 'AttachmentController@delete'
            ]);
});
/*End: Attachments*/

/*Mail*/
Route::group(['as' => 'mail.'], function () {
    Route::get('mail/pending/{request_id}/{user_id}', [
               'as' => 'pending', 
               'uses' => 'EmailController@send'
            ]);
});
/*End: Mail*/

/*Admin Fee*/
Route::resource('adminfee', 'AdminFeeController', [
    'middleware' => 'auth.user'
]);
/*End: Admin Fee*/