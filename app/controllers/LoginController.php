<?php 

class LoginController extends \BaseController {

	/** 
	 * Show the form for creating a new resource.
	 * @param String username
	 * @param String password
	 *
	 * @return bool/String success or error message(s)
	 */
	public function create($username,$password)
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
		else{
			return false;
		}
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
		$toLogin = Login::where('username','=',$username)->take(1)->get();
		
		if (sizeof($toLogin) < 1) {
			return false;			
		}
		
		//creating laravel session (cookie)
		if(Hash::check("$password", $toLogin[0]->passwordHash)){
			Session::regenerate();
			Session::push('username',$username);
			Session::push('username.loggedIn', true);
			
			return true;
		}
	}

	/**
	 * Checks if the user with the given username is logged in
	 *
	 * @param String username
	 * 
	 * @return boolean if user is logged in
	 */
	public function isLoggedIn($username){
		Session::regenerate();

		$user = Session::get('username');

		if($user[0] == $username && $user['loggedIn'][0] == 1){
			return true;
		}
		else return false;
	}

	/**
	 * Process logging out and ending the user's session
	 * 
	 * @return boolean if logout is successful
	 */
	public function doLogout(){
		Session::regenerate();

		if(Session::all() != null){
			Session::flush();
			return true;
		}
		else
			return false;
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
		$login = Login::find($id);
		$didDel = $login->delete();
		
		//check to make sure it was deleted
		if($didDel && is_null(Login::find($id)))
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
