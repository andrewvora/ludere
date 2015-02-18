<?php

class ControllersTest extends TestCase {
	
	/**
	 * Tests the CatalogueController's functions:
	 *		- insertDocument
	 *		- getDocumentsWhere
	 *		- appendDocument
	 *		- destroyDocument
	 * And stores the operation's result values to assertTrue.
	 * If so, that means every operation completed successfully.
	 * Otherwise, delete the offending record.
	 */
	public function testCatalogueControllerInsertFindAppendDelete(){
		$catControl = new CatalogueController();

		$type = 'show';
		$title = 'deleteme1993getmeajobatcrunchyroll';
		$picture = 'nope';
		$years = '1994';
		$guidenceRating = 'TV-14';
		$releaseDate = 'A date in time';
		$duration = '22 min';
		$genres = 'Comedy';
		$people = 'Courtney Cox';
		$plotShort = 'Stuff and words.';
		$plotLong = 'Long Stuff and words, to the sky and infinity and beyond, but there\'s a snack in my boot.';
		$countryOfOrigin  = 'USA';
		$awards = 'Some big stuff';

		$insertResult = $catControl->insertDocument($type, $title, $picture, $years, $guidenceRating, $releaseDate, $duration, $genres, $people, $plotShort, $plotLong, $countryOfOrigin, $awards);
		$findResult = $catControl->getDocumentsWhere(1, array('title', '=', $title));
		$id = $findResult[0]["_id"];
		$appendResult = $catControl->appendDocument($id, 'delete', true);
		$destroyResult = $catControl->destroyDocument($id);

		$assertCondition = $insertResult && $findResult && $appendResult && $destroyResult; 
		$this->assertTrue($assertCondition);
		if(!$assertCondition){
			$findResult->delete();
		}
	}

}

?>