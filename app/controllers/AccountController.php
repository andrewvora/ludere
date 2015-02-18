<?php

class AccountController extends \BaseController {

	/**
	 * Insert a new document
	 *
	 * @param String $username
	 * @param String $passwordHash 	- the hashed password
	 * @param String $salt 			- the salt used to hash the password
	 * @param String $email
	 * @param int $numAttempts
	 * @param String $lastLogin		- formatted date string
	 *
	 * @return Boolean $success
	 */
	public function insertDocument($username, $passwordHash, $salt, $email, $numAttempts, $lastLogin) {
		
	}

	/**
	 * Clears the collection
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyEverything(){
		return DB::collection('characters')->delete();
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
		$accountToDelete = Account::find($id);
		return $accountToDelete->delete();
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
	public function getDocumentsWhere($numDocs, $queryArr){
		return parent::getDocumentsWhereTemplate("Account", $numDocs, $queryArr);
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
		$docToAppend = Account::find($id);
		$docToAppend->$newAttr = $value;
		return $docToAppend->save();
	}


}
