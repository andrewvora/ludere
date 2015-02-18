<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/catalogue', 'CatalogueController@index');

//route to show login form
Route::get('/login', 'LoginController@showLogin');

//route to use login form
Route::post('/login', 'LoginController@doLogin');

