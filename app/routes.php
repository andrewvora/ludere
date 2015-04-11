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

/** API ROUTES
 *-----------------------------------*/
//Gets the index.php page for the API documentation
Route::get('/', function(){
	return View::make('index');
});


/** ACCOUNT ROUTES
 *-----------------------------------*/
//Routes to post username and password to in order to log in and begin session
Route::put('/auth/login/{username}/{password}', function($username, $password){
	$loginCtrl = new LoginController();
	if($loginCtrl->doLogin(htmlspecialchars($username), htmlspecialchars($password))) return 'true';
	else return 'false';
});

//Logs out the user and ends any session cookies
Route::put('/auth/logout', function(){
	$loginCtrl = new LoginController();
	if($loginCtrl->doLogout()) return 'true';
	return 'false';
});

//Creates the login for the user
Route::post('/auth/create/{username}/{password}/{email}/{firstNm}/{lastNm}/{dob}/{gender}', 
	function($username, $password, $email, $firstNm, $lastNm, $dob, $gender){
		$accountCtrl = new AccountController();
		if($accountCtrl->createAccount(
			htmlspecialchars($username), 
			htmlspecialchars($password), 
			htmlspecialchars($email), 
			htmlspecialchars($firstNm), 
			htmlspecialchars($lastNm), 
			htmlspecialchars($dob), 
			htmlspecialchars($gender)
			)) return "true";
		else return "false";
	});

//Checks if the user is logged in
Route::get('/auth/isLoggedIn/{username}', 'LoginController@isLoggedIn');

//Checks if the user's email is verified
Route::get('/auth/{username}/verified', 'UserController@isVerified');

//Checks if a value is unique
Route::get('/auth/unique/{attr}/{value}', 'AccountController@isUnique');

//Gets the username from the session cookie
Route::get('/auth/username/current', 'LoginController@getUserFromSession');


/** USER ROUTES
 *-----------------------------------*/
//account/profile routes
Route::get('/user/{username}', 'UserController@getUser');
Route::put('/user/update/profile/detailed/{email}/{firstName}/{lastName}/{gender}/{birthday}/{about}/{city}/{state}/{province}/{country}', 
	'UserController@updateDocument');
Route::put('/user/update/profile/simple/{gender}/{birthday}/{about}/{city}/{state}/{province}/{country}', 
	'UserController@updateDocument');
Route::post('/user/{username}/update/profile/upload/picture', 'UserController@updatePicture');
Route::get('/user/{username}/picture', 'UserController@getPicture');

//list routes
Route::get('/user/{username}/list', 'UserController@getUserList');
Route::post('/user/{username}/list/add/{itemId}/{rating}/{status}/{epsWatched}', 'UserController@updateUserCatalogueItem');
Route::put('/user/{username}/list/update/{itemId}/{rating}/{status}/{epsWatched}', 'UserController@updateUserCatalogueItem');
Route::put('/user/{username}/list/remove/{itemId}', 'UserController@removeFromUserCatalogue');
Route::get('/user/{username}/list/exists/{itemId}', 'UserController@inUserCatalogue');
Route::get('/user/{username}/list/get/{id}', 'UserController@getFromUserCatalogue');

//favorites routes
Route::post('/user/{username}/favorites/add/{itemId}', 'UserController@addToUserFavorites');
Route::put('/user/{username}/favorites/remove/{itemId}', 'UserController@removeFromUserFavorites');
Route::get('/user/{username}/favorites/exists/{itemId}', 'UserController@inUserFavorites');


/** CATALOGUE ROUTES
 *-----------------------------------*/

//Get a random Catalogue Item
Route::get('/catalogue/rand', 'CatalogueController@getRandDocument');

//Get a specific item
Route::get('/catalogue/item/{id}', 'CatalogueController@getDocument');

//Get multiple items
Route::get('/catalogue/items/{ids}', 'CatalogueController@getDocuments');

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
			
		case 'users':
			$userCtrl = new UserController();
			$results = $userCtrl->index();
			break;
	}
	
	//check if there were any results
	return $results;
});
