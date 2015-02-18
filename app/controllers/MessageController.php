<?php

class MessageController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//return all documents in the messages collection
		return Message::all()->toJson();
	}

	public function insertDocument($sender, $receiver, $dateSent, $dateReceived, $subject, $content, $isSeen){
		$message = new Message();

		$message->sender = $sender;
		$message->receiver = $receiver;
		$message->dateSent = $dateSent;
		$message->dateReceived = $dateReceived;
		$message->subject = $subject;
		$message->content = $content;
		$message->isSeen = $isSeen;

		return $message->save();
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
		$messageToDelete = Message::find($id);
		return $messageToDelete->delete();
	}

	/**
	 * Clears the collection
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyEverything(){
		return DB::collection('messages')->delete();
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
		return parent::getDocumentsWhereTemplate("Message", $numDocs, $queryArr);
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
		$docToAppend = Message::find($id);
		$docToAppend->$newAttr = $value;
		return $docToAppend->save();
	}

}
