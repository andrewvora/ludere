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
	 * @param String $Type 				- series, movie, etc
	 * @param String $Title
	 * @param String $Picture			- Poster, etc, (c) imdb
	 * @param String[] $videos
	 * @param String $Years
	 * @param String $GuidenceRating
	 * @param String $ReleaseDate
	 * @param String $Duration
	 * @param String $Genres
	 * @param int[] $People 			- int array of ids of Documents from People Collection
	 * @param String $PlotShort			- condensed version of plot, (c) imdb
	 * @param String $PlotLong			- extended version of plot (c) imdb
	 * @param String $CountryOfOrigin
	 * @param String $Awards
	 *
	 * @return Boolean $success
	 */
	public function insertDocument($Type, $Title, $Picture, $video, $Years, $GuidenceRating, $ReleaseDate, $Duration, $Genres, $People, $PlotShort, $PlotLong, $CountryOfOrigin, $Awards)
	{
		//Will take the parameters, and make a Document in the Catalogue Collection
		$catalogueItem = new Catalogue();

		$catalogueItem->type = $Type; 
		$catalogueItem->title = $Title;
		$catalogueItem->picture = $Picture;
		$catalogueItem->video = $video;
		$catalogueItem->years = $Years;
		$catalogueItem->guidenceRating = $GuidenceRating;
		$catalogueItem->releaseDate = $ReleaseDate;
		$catalogueItem->duration = $Duration;
		$catalogueItem->genres = $Genres;
		$catalogueItem->people = $People; 
		$catalogueItem->plotShort = $PlotShort;
		$catalogueItem->plotLong = $PlotLong;
		$catalogueItem->countryOfOrigin = $CountryOfOrigin;
		$catalogueItem->awards = $Awards;

		return $catalogueItem->save(); 
	}

	/**
	 * Clears the collection
	 * 
	 * @return boolean 	whether or not the op was successful
	 */
	public function destroyEverything(){
		DB::collection('catalogue')->delete();
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
		$catalogueItem = Catalogue::find($id);
		return  $catalogueItem;
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
