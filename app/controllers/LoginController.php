<?php

class LoginController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function showLogin()
	{
		
		return View::make('login');
	}

	/** Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	public function doLogin()
	{
		
	}

	/**
	 * Clears the collection
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyEverything(){
		return DB::collection('login')->delete();
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

	/**
	 * Checks if the user with the given username is logged in
	 */
	public function isLoggedIn($username){
		session_start();

		if(isset($_SESSION['username'])){
			return $_SESSION['username']['loggedIn'];
		}
		else return false;
	}
}
