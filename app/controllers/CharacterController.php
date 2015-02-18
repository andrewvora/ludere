<?php

class CharacterController extends \BaseController {

	/**
	 * Get all records of the collection
	 *
	 * @return Response
	 */
	public function index()
	{
		//return all documents in the characters collection
		return Character::all()->toJson();
	}

	/**
	 * Inserts a new document into the Character collection with the param values
	 *
	 * @param $profilePicture 	value for the corresponding attribute 
	 * @param $name 			value for the corresponding attribute
	 * @param $photos 			value for the corresponding attribute
	 * @param $persons 			value for the corresponding attribute
	 * @param $filmography 		value for the corresponding attribute
	 * @param $description 		value for the corresponding attribute
	 *
	 * @return boolean 	whether the operation succeeded
	 */
	public function insertDocument($profilePicture, $name, $photos, $persons, $filmography, $description){
		$character = new Character();
		
		$character->profilePicture = $profilePicture;
		$character->name = $name;
		$character->photos = $photos;
		$character->persons = $persons;
		$character->filmography = $filmography;
		$character->description = $description;

		return $character->save();
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
		$characterToDelete = Character::find($id);
		return $characterToDelete->delete();
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
		return parent::getDocumentsWhereTemplate("Character", $numDocs, $queryArr);
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
		$docToAppend = Character::find($id);
		$docToAppend->$newAttr = $value;
		return $docToAppend->save();
	}
}
