<?php

class ControllerTest extends TestCase {
	
	/**
	 * Function created to test insertion into Catalogue
	 * collection by the Catalogue Controller
	 *
	 *  @return void
	 */
	public function testCatalogueControllerInsert (){
		$ccontroller = new CatalogueController();
		
		$Type = 'show';
		$Title = 'FriendsIsOverWhy';
		$Picture = 'nope';
		$Years = '1994';
		$GuidenceRating = 'TV-14';
		$ReleaseDate = 'A date in time';
		$Duration = '22 min';
		$Genres = 'Comedy';
		$People = 'Courtney Cox';
		$PlotShort = 'Stuff and words.';
		$PlotLong = 'Long Stuff and words';
		$CountryOfOrigin  = 'USA';
		$Awards = 'Some big stuff';
		
		$ccontroller->insertDocument($Type, $Title, $Picture, $Years, $GuidenceRating, $ReleaseDate, $Duration, $Genres, $People, $PlotShort, $PlotLong, $CountryOfOrigin, $Awards);

		$test = Catalogue::where('title', $Title)->first();
		//echo $test; //debugging
		$testPS = $test['plotShort'];
		$test = Catalogue::where('title', $Title)->delete(); //clean up yo mess!

		$this->assertEquals($PlotShort,$testPS);
	}

	
	/**
	 * Function created to test retrieving a document from the Catalogue
	 * collection by the Catalogue Controller
	 *
	 *  @return void
	 */
	public function testCatalogueControllerGetDocument(){
		$ccontroller = new CatalogueController();
		
		$docO = Catalogue::where('type', 'series')->first();
		$id = $docO['_id'];
		$title = $docO['title'];
		//echo $id; //for debugging

		$doc = $ccontroller->getDocument($id);
		//echo $doc; //for debugging
		$this->assertEquals($title,$doc['title']);
	}


	/**
	 * Function created to test appending a Document with
	 * a new attriubute
	 *
	 * @return void
	 */
	public function testCatalogueControllerAppendDocument(){
		$ccontroller = new CatalogueController();
		
		$Type = 'show';
		$Title = 'FriendsIsOverWhy';
		$Picture = 'nope';
		$Years = '1994';
		$GuidenceRating = 'TV-14';
		$ReleaseDate = 'A date in time';
		$Duration = '22 min';
		$Genres = 'Comedy';
		$People = 'Courtney Cox';
		$PlotShort = 'Stuff and words.';
		$PlotLong = 'Long Stuff and words';
		$CountryOfOrigin  = 'USA';
		$Awards = 'Some big stuff';
		
		$ccontroller->insertDocument($Type, $Title, $Picture, $Years, $GuidenceRating, $ReleaseDate, $Duration, $Genres, $People, $PlotShort, $PlotLong, $CountryOfOrigin, $Awards);
	
		$inserted = Catalogue::where('title', $Title)->first();
		$id = $inserted['_id'];
		//echo $id; //for Debugging
		$aName = "Angela's Favorite";
		$aData = "Yes";

		$doc = $ccontroller->appendDocument($id,$aName,$aData);
		$changedDoc = Catalogue::where($aName, $aData)->first();
		$docID = $changedDoc['_id'];
		//echo $docID; //for Debugging

		$inserted = Catalogue::where('_id', $id)->delete(); //clean up yo mess!

		//if the origianl doc and appended doc have the same ID, then they must be the same record
		$this->assertEquals($id,$docID); 
	}

	/**
	 * Function created to test deleting a document from the Catalogue
	 * collection by the Catalogue Controller
	 *
	 *  @return void
	 */
	public function testCatalogueControllerDestroyDocument(){
		$ccontroller = new CatalogueController();
		
		$Type = 'show';
		$Title = 'FriendsIsOverWhy';
		$Picture = 'nope';
		$Years = '1994';
		$GuidenceRating = 'TV-14';
		$ReleaseDate = 'A date in time';
		$Duration = '22 min';
		$Genres = 'Comedy';
		$People = 'Courtney Cox';
		$PlotShort = 'Stuff and words.';
		$PlotLong = 'Long Stuff and words';
		$CountryOfOrigin  = 'USA';
		$Awards = 'Some big stuff';
		
		$ccontroller->insertDocument($Type, $Title, $Picture, $Years, $GuidenceRating, $ReleaseDate, $Duration, $Genres, $People, $PlotShort, $PlotLong, $CountryOfOrigin, $Awards);
	
		$inserted = Catalogue::where('title', $Title)->first();
		$id = $inserted['_id'];

		$ccontroller->destroyDocument($id);

		//query for the deleted ID, will return NULL if it doesn't exist
		$this->assertNull(Catalogue::where('_id', $id)->first());
	}

}

?>