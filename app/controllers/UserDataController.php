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
		return UserData::all()->toJson();
	}


	/**
	 * Show the form for creating a new UserData document.
	 *
	 * @param String $username
	 *
	 * @return true if saved successfully
	 */
	public function insertDocument($username)
	{
		$userData = new UserData();
		$userData->username = $username;
		return $userData->save();
	}

	/**
	 * Clears the collection
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyEverything()
	{
		return DB::collection('user_data')->delete();
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
		$userData = UserData::find($id);
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
		$userData = UserData::find($id);
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
		return parent::getDocumentsWhereTemplate("UserData", $numDocs, $queryArr);
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
		$userData = UserData::find($id);
		$userData->$newAttr = $value;
		return $userData->save();
	}

	/**
	 * Updates the total time the user has spent for watching
	 * series, web series, movies, and all of the above
	 * @param String $username -the user to be updated
	 * @return true if sucessful
	 */
	public function updateTotalTimesFor($username){

	}

	/**
	 * Updates the ratio between catalogue item genres in terms of 
	 * the items in the user's catalogue
	 * @param String $username -the user to be updated
	 * @return true if sucessful
	 */
	public function updateGenreRatioFor($username){

	}

	/**
	 * Updates the activity across a period of time
	 * @param String $username -the user to be updated
	 * @return true if sucessful
	 */
	public function updateListActivityFor($username){

	}

	/**
	 * Updates the user data for the users in the user_data_queue collection
	 * @param int $numUsers 	-the number of users to update, 0 for all.
	 * @return number of users whose data was updated
	 */
	public function update($numUsers){
		if($numUsers < 0) return 0;

		$users = $numUsers == 0 ? UserDataQueue::all() : UserDataQueue::all()->take($numUsers)->get();

		foreach($users as $user){
			$username = $user->username;
			$this->updateTotalTimesFor($username);
			$this->updateGenreRatioFor($username);
			$this->updateListActivityFor($username);
		}
	}

}