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
	 * Get a single user by
	 * @param 	username 	the username of the document
	 */
	public function getUser($username){
		return UserData::where('username', '=', "$username")->firstOrFail();
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
		$userCtrl = new UserController();
		$list =  $userCtrl->getUserList($username)['catalogueItems'];

		$totalMinutesWatched = 0;

		foreach($list as $item){
			$catItem = Catalogue::find($item['id']);
			$episodes = 1;

			if(!is_numeric($catItem->episodes)) $episodes = intval($catItem->episodes);
			else $episodes = $catItem->episodes;

			if($episodes == 0) $episodes = 1;

			if(is_numeric($catItem->duration)) $totalMinutesWatched += $catItem->duration * $episodes;
			else {
				$totalMinutesWatched += intval($catItem->duration);
			}
		}

		//get the user_data document with matching username
		$count = UserData::where('username','=',"$username")->count();
		if($count > 0){
			$user = UserData::where('username','=',"$username")->first();
			$user->totalMinutesWatched = $totalMinutesWatched;
			return $user->save();
		}

		return false;
	}

	/**
	 * Updates the ratio between catalogue item genres in terms of 
	 * the items in the user's catalogue
	 * @param String $username -the user to be updated
	 * @return true if sucessful
	 */
	public function updateGenreRatioFor($username){
		$userCtrl = new UserController();
		$list =  $userCtrl->getUserList($username)['catalogueItems'];

		$ratios = array();
		$numItems = count($list);

		//get a count of each occurence of a genre
		foreach($list as $item){
			$catItem = Catalogue::find($item['id']);
			$genres = explode(",", $catItem->genres);

			foreach($genres as $genre){
				$genre = trim($genre);
				if(isset($ratios[$genre])) $ratios[$genre]++;
				else $ratios[$genre] = 1;
			}
			$numItems++;
		}

		//
		foreach($ratios as $key => $value){
			$ratios[$key] = $value/$numItems;
		}

		$count = UserData::where('username','=',"$username")->count();
		if($count > 0){
			$user = UserData::where('username','=',"$username")->first();
			$user->genreRatios = $ratios;
			return $user->save();
		}
	}

	/**
	 * Updates the activity across a period of time
	 * @param String $username -the user to be updated
	 * @return true if successful
	 */
	public function updateListActivityFor($username){
		$user = User::where('username', '=', "$username")->first();
		$userData = UserData::where('username', '=', "$username")->first();

		$updateHistory = $userData->updateHistory;

		if(isset($updateHistory)){
			$updateHistory = $user->lastActivity;
		}
		else {
			$updateHistory = $user->lastActivity;
		}

		$userData->updateHistory = $updateHistory;
		return $userData->save();
	}

	/**
	 * Updates the user data for the users in the user_data_queue collection
	 * @param int $numUsers 	-the number of users to update, 0 for all.
	 * @return number of users whose data was updated
	 */
	public function update($numUsers){
		if($numUsers < 0) return 0;
		$users = $numUsers == 0 ? UDQueue::all() : UDQueue::all()->take($numUsers)->get();

		foreach($users as $user){
			$username = $user->username;
			$this->updateTotalTimesFor($username);
			$this->updateGenreRatioFor($username);
			$this->updateListActivityFor($username);
		}
	}

}