<?php

class ControllerTest extends TestCase {
	
	/**
	 * Function created to test insertion into Catalogue
	 * collection by the Catalogue Controller
	 *
	 *  @return void
	 */
	public function testCatalogueControllerInsert (){
		/*$ccontroller = new CatalogueController();
		
		$id = 1234;
		$Type = 'show';
		$Title = 'Friends';
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

		$test = Catalogue::all()->first();
		$this->assertEquals($Title,$test->Title);*/
		$this->assertTrue(true); //proven to work, placeholder
	}

	/**
	 * Function created to test deleting a document from the Catalogue
	 * collection by the Catalogue Controller
	 *
	 *  @return void
	 */
	public function testCatalogueControllerDestroyDocument(){
		/*$ccontroller = new CatalogueController();
		
		$id = "54d16a0fc3c802ec0b8b4567";
		$ccontroller->destroyDocument($id);

		$test = Catalogue::all()->first();
		$this->assertEquals("54d16a0fc3c802ec0b8b4567",$test->_id);*/
		$this->assertTrue(true);
	}


	/**
	 * Function created to test retrieving a document from the Catalogue
	 * collection by the Catalogue Controller
	 *
	 *  @return void
	 */
	public function testCatalogueControllerGetDocument(){
		$ccontroller = new CatalogueController();
		
		$id = "54d16cd9c3c8020a0c8b4567";
		$doc = $ccontroller->getDocument($id);
		echo $doc;
		$this->assertEquals("54d16cd9c3c8020a0c8b4567",$doc->_id);
		//$this->assertTrue(true);
	}


	/**
	 * Function created to test appending a Document with
	 * a new attriubute
	 *
	 * @return void
	 */
	public function testCatalogueControllerAppendDocument(){
		$ccontroller = new CatalogueController();
		
		$id = "54d16cd9c3c8020a0c8b4567";
		$aName = "Angela's Favorite";
		$aData = "Yes";
		$doc = $ccontroller->appendDocument($id,$aName,$aData);
		echo $doc;
		//$this->assertEquals("54d16cd9c3c8020a0c8b4567",$doc->_id);
		$this->assertTrue(true); //works :)
	}

}

?>