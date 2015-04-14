<?php

class UserQueueController extends \BaseController {

	/**
	 * Display a listing of the User Data.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Return the full users collection
		return UDQueue::all()->toJson();
	}


	/**
	 * Insert a new UDQueue document if the username isn't in 
	 * the collection already.
	 *
	 * @param String $username
	 * @return true if saved successfully
	 */
	public function insertDocument($username)
	{
		if(UDQueue::where('username', '=', "$username")->count() != 0)
			return false;
		
		$entry = new UDQueue();
		$entry->username = $username;
		$entry->added = date('m/d/Y h:i:s a');
		return $entry->save();
	}

	/**
	 * Clears the collection
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyEverything()
	{
		return DB::collection('user_data_queue')->delete();
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
		$entry = UDQueue::find($id);
		return $entry->delete();
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
		$entry = UDQueue::find($id);
		return $entry;
	}
}

?>