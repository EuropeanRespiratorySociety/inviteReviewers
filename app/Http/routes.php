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


Route::get('/', 'ReviewersController@index' );
Route::get('api', 'ApiController@index');
Route::post('api/store', 'ApiController@store');
//Route::get('api/search/all-results', 'ApiController@searchAll');
Route::get('api/search/{query}', 'ApiController@search');
Route::get('api/contact/{query}', 'ApiController@contact');

//test route
//Route::get('api/search2/{query}', 'ApiController@search2');

Route::get('importpermissions', 'Import@importPermissions');
//Route::get('importallcontacts', 'Import@importAll');

Route::get('report', 'ReportController@index');
Route::get('impersonate/{id}', 'ReportController@impersonate');

Route::Controllers([

	'auth' => 'Auth\AuthController',
	'password'=> 'Auth\PasswordController',

	]);


