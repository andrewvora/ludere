<?php

class ControllerInsertTest extends TestCase {
	public function testCatalogueControllerInsert (){
		$ccontroller = new CatalogueController();
		
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
		$this->assertEquals($Title,$test->Title);
	}

	
}

?>