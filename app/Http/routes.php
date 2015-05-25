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
//Route::get('home', 'HomeController@index');

//Login routes
Route::get('login', 'Auth\AuthController@getlogin');
Route::post('login', 'Auth\AuthController@postlogin');

Route::get('logout', 'Auth\AuthController@getlogout');

//Area routes
Route::get('area/filter/unit/{id}', 'AreaController@filterByUnit');
Route::resource('area', 'AreaController', ['only' => ['index']]);


Route::get('profile', 'Auth\AuthController@getprofile');
Route::post('profile', 'Auth\AuthController@postprofile');
Route::post('profile/password', 'Auth\AuthController@postpassword');

Route::post('survey/user/delete/{id}', 'Survey\SurveyController@deleteSurveyUser');

// USER ALLOWED ROUTES
Route::group(['middleware' => ['auth', 'user']], function()
{
	Route::get('dashboard', 'DashboardController@userDashboard');
	Route::get('dashboard/mysurveys', 'Survey\SurveyController@mySurveyList');
	Route::get('dashboard/surveys', 'Survey\SurveyController@surveyList');

});

// MANAGER ALLOWED ROUTES
Route::group(['middleware' => ['auth', 'manager']], function()
{
	Route::get('manager', 'DashboardController@managerDashboard');
	Route::get('manager/survey/report', 'Survey\SurveyController@roleFilter');
	Route::get('manager/survey/report/unit/{unit}', 'Survey\SurveyController@roleFilter');
	Route::get('manager/survey/report/unit/{unit}/area/{area}', 'Survey\SurveyController@roleFilter');
});

// DIRECTOR ALLOWED ROUTES
Route::group(['middleware' => ['auth', 'director']], function()
{
	Route::get('director', 'DashboardController@directorDashboard');
	Route::get('director/survey/report', 'Survey\SurveyController@roleFilter');
	Route::get('director/survey/report/unit/{unit}', 'Survey\SurveyController@roleFilter');
	Route::get('director/survey/report/unit/{unit}/area/{area}', 'Survey\SurveyController@roleFilter');
});

// ADMIN ALLOWED ROUTES
Route::group(['middleware' => ['auth', 'admin']], function()
{
	Route::get('admin', 'DashboardController@adminDashboard');

	//account routes
	Route::get('user/create', 'Auth\AuthController@getregister');
	Route::post('user', 'Auth\AuthController@postregister');
	Route::get('user/edit/{id}', 'Auth\AuthController@getaccount');
	Route::post('user/edit', 'Auth\AuthController@postaccount');

	Route::get('user/ban/{id}', 'UserController@ban');
	Route::get('user/active/{id}', 'UserController@active');

	//filter routes
	Route::get('user/role/{id}', 'UserController@filter');
	Route::get('user/role/{role}/unit/{unit}', 'UserController@filter');
	Route::get('user/role/{role}/unit/{unit}/area/{area}', 'UserController@filter');

	Route::resource('user', 'UserController', ['only' => ['index', 'show', 'edit'/*, 'update'*/, 'destroy']]);

	Route::get('survey/report', 'Survey\SurveyController@answerSurvey');
	Route::get('survey/report/unit/{unit}', 'Survey\SurveyController@answerSurvey');
	Route::get('survey/report/unit/{unit}/area/{area}', 'Survey\SurveyController@answerSurvey');

    Route::get('survey/deactivate/{id}', 'Survey\SurveyController@deactivate');
    Route::get('survey/activate/{id}', 'Survey\SurveyController@activate');
    Route::resource('survey', 'Survey\SurveyController');
    Route::resource('survey/unit/{unit}', 'Survey\SurveyController');

});


/*Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);*/
