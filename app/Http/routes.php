<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');

//Login routes
Route::get('login', 'Auth\AuthController@getlogin');
Route::post('login', 'Auth\AuthController@postlogin');

Route::get('logout', 'Auth\AuthController@getlogout');


// ADMIN ALLOWED ROUTES
Route::group(['middleware' => ['auth', 'admin']], function()
{
	//Login routes
	Route::get('user/create', 'Auth\AuthController@getregister');
	Route::post('user', 'Auth\AuthController@postregister');

	Route::resource('user', 'UserController', ['only' => ['index', 'show', 'edit'/*, 'update'*/, 'destroy']]);
});

/*Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/
