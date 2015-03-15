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

//Gets the index.php page for the API documentation
Route::get('/', function(){
	return View::make('index');
});

//Routes to post username and password to in order to log in and begin session
Route::post('/auth/{username}/{password}', 'LoginController@login');

//Checks if the user is logged in
Route::get('/auth/{username}/', 'LoginController@isLoggedIn');

//Get specific types of catalogue items
Route::get('/catalogue/item/{id}', 'CatalogueController@getDocument');

//Get all catalogue items for the specific type
Route::get('/catalogue/{type}', function($type){
	$results = array();
	$numResults = 0; //0 is all. x > 0 is x results 

	//get $numResults for the appropriate {type}
	//TODO: restrict from returning all documents
	//		for large databases, this will be a performance issue
	switch($type){
		case 'all':
			$catCtrl = new CatalogueController();
			$results = $catCtrl->index();
			break;

		case 'movie':
		case 'series':
		case 'web':
			$catCtrl = new CatalogueController();
			$results = $catCtrl->getDocumentsWhere($numResults, array('type','=',"$type"));
			break;

		case 'people':
			$personCtrl = new PersonController();
			$results = $personCtrl->index();
			break;

		case 'companies':
			$companyCtrl = new CompanyController();
			$results = $companyCtrl->index();
			break;
	}
	
	//check if there were any results
	return $results;
});
