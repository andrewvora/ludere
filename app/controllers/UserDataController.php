<?php

class UserDataController extends \BaseController {

	/**
	 * Display a listing of the User Data.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Return the full Users collection
		return Users::all()->toJson();
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
	 * --Instanciated in method--
	 * Boolean $isVerified
	 * String $picture    -URL to stored image
	 * String $about
	 * int $numFriends
	 * String[] $friends  -users referenced by ID
	 * String[] $friendRequests
	 * String[] $blockedUsers -users referenced by ID
	 * Object[] $awards    -badges and stuff
	 * int $totalAmountWatched
	 * String[] $catalogueItems -catalogue items by ID
	 * String[] $favorites -catalogue items by ID
	 *
	 * @return Response
	 */
	public function insertDocument($username, $isAdmin, $joinDate, $email, $fName, $lName, $gender, $birthday)
	{
		$userData = new Users;

		//from input
		$userData->username = $username;
		$userData->isAdmin = $isAdmin;
		$userData->joinDate = $joinDate;
		$userData->email = $email;
		$userData->fName = $fName;
		$userData->lName = $lName;
		$userData->gender = $gender;
		$userData->birthday = $birthday;

		//presetting some empty/0 values that will be updated
		$userData->isVerified = false;
		$userData->picture = '';
		$userData->about = "Something about yourself.";
		$userData->friends = '';
		$userData->friendRequests = '';
		$userData->blockeduseres = '';
		$userData->awards = '';
		$userData->totalAmountWatched = 0;
		$userData->catalogueItems = '';
		$userData->favorites = '';

		$userData->save();
	}


	/**
	 * Destroy a User Data document in Users collection.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */
	public function destroyDocument($id)
	{
		//Will take in an id, and destroy the Document with that id
		$userData = Users::find($id);
		$userData->delete();
		//Maybe add a check to make sure it deletes here?
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
		$userData = Users::find($id);
		return  $userData;
	}


	/**
	 * Append a document with a new attribute
	 *
	 * @param  String  $id      -id of document to append
	 * @param  String  $aName   -name of new attribute
	 * @param  String  $aData   -data of new attribute
	 *
	 * @return Boolean $success
	 */
	public function appendDocument($id,$aName,$aData)
	{
		$userData = Users::find($id);
		$userData->$aName = $aData;
		$userData->save();
	}

}