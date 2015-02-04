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
	public function insertDocument($Type, $Title, $Picture, $Years, $GuidenceRating, $ReleaseDate, $Duration, $Genres, $People, $PlotShort, $PlotLong, $CountryOfOrigin, $Awards)
	{
		//Will take the parameters, and make a Document in the Catalogue Collection
		$catalogueItem = new Catalogue;

		$catalogueItem->type = $Type; 
		$catalogueItem->title = $Title;
		$catalogueItem->picture = $Picture;
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

		$catalogueItem->save(); 
	}

	public function destroyEverything(){
		DB::collection('catalogue')->delete();
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 *
	 * @return Response
	 */
	public function destroyDocument($id)
	{
		//Will take in an id, and destroy the Document with that id
		$catalogueItem = Catalogue::find($id);
		$catalogueItem->delete();
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
		$catalogueItem = Catalogue::find($id);
		$catalogueItem->$aName = $aData;
		$catalogueItem->save();
	}
}
