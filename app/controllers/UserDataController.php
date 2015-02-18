<?php

class UserDataController extends \BaseController {

	/**
	 * Display a listing of the User Data.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Return the full users collection
		return User::all()->toJson();
	}


	/**
	 * Show the form for creating a new User Data set.
	 *
	 * @param String $username
	 * @param Boolean $isAdmin
	 * @param String $joinDate   -formatted date string
	 * @param String $email
	 * @param String $fName
	 * @param String $lName
	 * @param String $gender
	 * @param String $birthday   -formatted date string
	 * 
	 * --Instantiated in method--
	 * Boolean $isVerified
	 * String $picture    		-url to stored image
	 * String $about
	 * int $numFriends
	 * String[] $friends  		-users referenced by ID
	 * String[] $friendRequests
	 * String[] $blockedUsers 	-users referenced by ID
	 * Object[] $awards    		-badges and stuff
	 * int $totalAmountWatched
	 * String[] $catalogueItems -catalogue items by ID
	 * String[] $favorites 		-catalogue items by ID
	 *
	 * @return true if saved successfully
	 */
	public function insertDocument($id,$metric,$value)
	{
		$userData = User::find($id);
		$userData->$metric = $value;

		return $userData->save();
	}

	/**
	 * Clears the collection
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyEverything()
	{
		return DB::collection('users')->delete();
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
		$userData = User::find($id);
		return $userData->delete();
	}


	/**
	 * Return a User Data document found by ID.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */
	public function getDocument($id)
	{
		//Will take in an id, and return a document
		$userData = User::find($id);
		return $userData;
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
		return parent::getDocumentsWhereTemplate("User", $numDocs, $queryArr);
	}


	/**
	 * Append a document with a new attribute
	 *
	 * @param  String  $id      -id of document to append
	 * @param  String  $newAttr -name of new attribute
	 * @param  String  $value   -data of new attribute
	 *
	 * @return true if saved successfully
	 */
	public function appendDocument($id,$newAttr,$value)
	{
		$userData = User::find($id);
		$userData->$newAttr = $value;
		return $userData->save();
	}

}