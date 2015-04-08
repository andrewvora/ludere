<?php

class CatalogueController extends \BaseController {

	/**
	 * Display a listing of the Catalogue Collection.
	 *
	 * @return Catalogue
	 */
	public function index()
	{
		//Return the full Catalogue collection
		return Catalogue::all()->toJson();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @param String $type 				- series, movie, etc
	 * @param String $title
	 * @param String $picture			- Poster, etc, (c) imdb
	 * @param String[] $videos
	 * @param String $years
	 * @param String $guidanceRating
	 * @param String $releaseDate
	 * @param String $duration
	 * @param String $genres
	 * @param int[] $people 			- int array of ids of Documents from People Collection
	 * @param String $plotShort			- condensed version of plot, (c) imdb
	 * @param String $plotLong			- extended version of plot (c) imdb
	 * @param String $countryOfOrigin
	 * @param String $awards
	 *
	 * @return Boolean $success
	 */
	public function insertDocument($type, $title, $picture, $video, $years, $guidancerating, $releasedate, $duration, $genres, $people, $plotshort, $plotlong, $countryoforigin, $awards, $numEpisodes = 0)
	{
		//Will take the parameters, and make a Document in the Catalogue Collection
		$catalogueItem = new Catalogue();

		$catalogueItem->type = $type; 
		$catalogueItem->title = $title;
		$catalogueItem->picture = $picture;
		$catalogueItem->video = $video;
		$catalogueItem->years = $years;
		$catalogueItem->guidanceRating = $guidancerating;
		$catalogueItem->releaseDate = $releasedate;
		$catalogueItem->duration = $duration;
		$catalogueItem->genres = $genres;
		$catalogueItem->people = $people; 
		$catalogueItem->plotShort = $plotshort;
		$catalogueItem->plotLong = $plotlong;
		$catalogueItem->countryOfOrigin = $countryoforigin;
		$catalogueItem->awards = $awards;
		$catalogueItem->episodes = $numEpisodes;

		return $catalogueItem->save(); 
	}

	/**
	 * Clears the collection
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyEverything(){
		return DB::collection('catalogue')->delete();
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
		$catalogueItem = Catalogue::find($id);
		return $catalogueItem->delete();
		//Maybe add a check to make sure it deletes here?
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 *
	 * @return Catalogue Document
	 */
	public function getDocument($id)
	{
		//Will take in an id, and return a document
		return Catalogue::find($id);
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
		return parent::getDocumentsWhereTemplate("Catalogue", $numDocs, $queryArr);
	}


	/**
	 * Append a document with a new attribute
	 *
	 * @param  String  $id      -id of document to append
	 * @param  String  $newAttr   -name of new attribute
	 * @param  String  $value   -data of new attribute
	 */
	public function appendDocument($id,$newAttr,$value)
	{
		$catalogueItem = Catalogue::find($id);
		$catalogueItem->$newAttr = $value;
		return $catalogueItem->save();
	}
}
