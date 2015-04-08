<?php 

class LoginController extends \BaseController {
	/** 
	 * Show the form for creating a new resource.
	 * @param String username
	 * @param String password
	 *
	 * @return bool/String success or error message(s)
	 */
	public function createLogin($username, $password)
	{
		$login = new Login();

		//validating input with Laravel Validator
		$validator = Validator::make(
		    array(
		        'username' => $username,
		        'password' => $password,
		    ),
		    array(
		        'username' => 'required|alpha_dash|unique:login,username',
		        'password' => 'required|alpha_dash|min:8',
		    )
		);
		
		//check username and again with stright PHP
		$usernameV = false;
		if($username == htmlspecialchars($username, ENT_NOQUOTES))
			$usernameV = true;
		
		//creating login doc if passed valications/checks
		if($validator->passes() && $usernameV){
			$login->username = $username;
			$login->passwordHash = Hash::make($password);
			
			//default/placeholder values
			$login->numAttempts = 0;
			$login->lastLoginDate = "";

			return $login->save();
		}
		
		return false;
	}

	/**
	 * Will attempt to process a login request
	 *
	 * @param String 	username
	 * @param String 	password
	 * 
	 * @return boolean 	result of login request
	 */
	public function doLogin($username,$password)
	{
		$loginResult = Auth::attempt(array('username' => $username, 'password' => $password), true);
		if($loginResult) return true; 
		
		return false;
	}

	/**
	 * Checks if the user with the given username is logged in
	 *
	 * @param String username
	 * 
	 * @return boolean if user is logged in
	 */
	public function isLoggedIn($username){
		if(Auth::check()){
			return "true";
		}
		return "false";
	}

	/**
	 * Gets the current user's username
	 */
	public function getUserFromSession(){
		if(Auth::check()){
			$user = Auth::user()->username;
			return $user;
		}
		return "undefined";
	}

	/**
	 * Process logging out and ending the user's session
	 * 
	 * @return boolean if logout is successful
	 */
	public function doLogout(){
		Auth::logout();
		return true;
	}


	//==GENERAL DOCUMENT MAINTENANCE =================

	/**
	 * Clears the collection
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyEverything(){
		return DB::collection('login')->delete();
	}

	/**
	 * Destroys the documents with the matching $id
	 *
	 * @param $id 	mongo hash id
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyDocument($id)
	{
		//Will take in an id, and destroy the Document with that id
		$login = Login::where('_id', '=', "$id");
		$didDel = $login->delete();
		
		//check to make sure it was deleted
		if($didDel && Login::where('_id', '=', "$id")->count() < 1)
			return true;
		
		return false;
	}

	/**
	 * Returns $numDocs documents that satisfies the query built from $queryArr
	 * If $numDocs > number of results, it just returns all the results
	 * If $numDocs == 0, it also returns all of the results
	 *
	 * @param  int  $numDocs	the number of documents to return from the query
	 * @param  array 	$queryArr	an array of the elements to build the query
	 *
	 * @return array of documents
	 */
	public function getDocumentsWhere($numDocs, $queryArr)
	{
		return parent::getDocumentsWhereTemplate("Login", $numDocs, $queryArr);
	}

	/**
	 * Append a document with a new attribute
	 *
	 * @param  String  $id      -id of document to append
	 * @param  String  $newAttr   -name of new attribute
	 * @param  String  $value   -data of new attribute
	 *
	 * @return true if saved successfully
	 */
	public function appendDocument($id,$newAttr,$value)
	{
		$docToAppend = Login::find($id);
		$docToAppend->$newAttr = $value;
		return $docToAppend->save();
	}

}
