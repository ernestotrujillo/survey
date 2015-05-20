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

//Area routes
Route::get('area/filter/unit/{id}', 'AreaController@filterByUnit');
Route::resource('area', 'AreaController', ['only' => ['index']]);
//Route::controller('area/filter/unit/{id}', 'AreaController@filterbyunit');

// ADMIN ALLOWED ROUTES
Route::group(['middleware' => ['auth', 'admin']], function()
{
	//Login routes
	Route::get('user/create', 'Auth\AuthController@getregister');
	Route::post('user', 'Auth\AuthController@postregister');

	Route::get('user/ban/{id}', 'UserController@ban');
	Route::get('user/active/{id}', 'UserController@active');
	Route::get('user/role/{id}', 'UserController@filter');
	Route::resource('user', 'UserController', ['only' => ['index', 'show', 'edit'/*, 'update'*/, 'destroy']]);
});

/*Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/
