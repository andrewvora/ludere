<?php

class ControllersTest extends TestCase {
	/*DATA METHODS====================================*/

	/**
	 * Returns an instance of the requested $className
	 */
	public function getInstanceOf($className){
		switch($className){
			case "CatalogueController":
				return new CatalogueController();
			case "BadgeController":
				return new BadgeController();
			case "CharacterController":
				return new CharacterController();
			case "CompanyController":
				return new CompanyController();
			case "AccountController":
				return new AccountController();
			case "MessageController":
				return new MessageController();
			case "PersonController":
				return new PersonController();
			case "UserDataContrller":
				return new UserDataController();
		}
	}

	/**
	 * Provides an array of data used in a Catalogue document
	 */
	public function getCatalogueTestData(){
		return array(
			'show', //type
			'deleteme1993getmeajobatcrunchyroll', //title
			'nope', //picture
			[], //videos
			'1994', //years
			'TV-14', //guidanceRating
			'A date in time', //releaseDate
			'22 min', //duration
			'Comedy', //genres
			'Courtney Cox', //people
			'Stuff and words.', //plotShort
			'Long Stuff and words, to the sky and infinity and beyond, but there\'s a snack in my boot.', //plotLong
			'USA', //countryOfOrigin
			'Some big stuff' //awards
		);
	}
	
	/**
	 * Provides an array of data used in a Badge document
	 */
	public function getBadgeTestData(){
		return array(
				"N/A", //image 
				"LoserBadge1234Hax", //name
				"Condition format to be defined", //condition
				2 //numAwards given
			);
	}

	/**
	 * Provides an array of data used in a Character document
	 */
	public function getCharacterTestData(){
		return array(
			'N/A',
			'Eggy Junior III',
			[],
			[],
			[],
			'Some sort of description'
		);
	}

	/**
	 * Provides an array of data used in a Company document
	 */
	public function getCompanyTestData(){
		return array(
			'N/A',
			'SuperExclusiveMovieStudio',
			'Licensing',
			['filmography']
		);
	}

	/**
	 * Provides an array of data used in a Message document
	 */
	public function getMessageTestData(){
		return array(
			'sender',
			'receiver',
			'dateSent',
			'dateReceived',
			'subject',
			'content',
			'isSeen'
		);
	}

	/**
	 * Provides an array of data used in a Person document
	 */
	public function getPersonTestData(){
		$currentDate = date("m.d.y");
		return array(
			'N/A',
			'Andrew',
			'Vorakrajangthiti',
			"$currentDate",
			'A loser.',
			[],
			[],
			'Co-lead developer, I think.',
			[]
		);
	}

	/**
	 * Provides an array of data used in an Account document
	 */
	public function getAccountTestData(){
		return array(		);
	}

	/**
	 * Provides an array of data used in a UserData document
	 */
	public function getUserDataTestData(){
		return array();
	}

	/*PROVIDER METHODS====================================*/
	/**
	 * Provider function for test data used in testGetDocumentsWhere
	 */
	public function providerTestGetDocumentsWhere(){
		$title = $this->getCatalogueTestData()[1];
		return array(
				array(0, array('title', "=", $title)), //returns 1 result
				array(1, array('title', "=", "dfsfsfsfdsf")), //returns empty array
				array(1, array('title', "=", $title)), //return 1 result
			);
	}

	/**
	 * Provider function for test data used in testGetDocumentsWhere
	 */
	public function providerTestGetDocumentsWhereNull(){
		$title = $this->getCatalogueTestData()[1];
		return array(
				array(0, array('title')), //returns null
				array(0, array()), //returns null
				array(100, array(0, array())), //returns null
				array(-5, array('title', "=", $title)), //returns null
				array(-1, array()), //return null
			);
	}

	/**
	 * Provider function for test data used in testControllersInsertFindAppendDelete
	 */
	public function providerTestControllersInsertFindAppendDelete(){
		return array(
				array('CatalogueController', 'title', $this->getCatalogueTestData(), 1),
				array('BadgeController', 'name', $this->getBadgeTestData(), 1),
				array('CharacterController', 'name', $this->getCharacterTestData(), 1),
				array('CompanyController', 'name', $this->getCompanyTestData(), 1),
				array('MessageController', 'sender', $this->getMessageTestData(), 0),
				array('PersonController', 'firstName', $this->getPersonTestData(), 1)
			);
	}

	/*TESTS METHODS====================================*/
	/**
	 * @dataProvider providerTestGetDocumentsWhere
	 *
	 * Test that GetDocumentsWhere returns something in appropriate cases
	 */
	public function testGetDocumentsWhere($numDocs, $arr){
		$title = $this->getCatalogueTestData()[1];

		$catControl = new CatalogueController();

		//insert the document to be tested
		$insertResult = call_user_func_array(array($catControl, "insertDocument"), $this->getCatalogueTestData());

		//the method we're testing
		$result = $catControl->getDocumentsWhere($numDocs, $arr);

		$this->assertNotNull($result);

		//find and delete the actual document
		$findResult = $catControl->getDocumentsWhere(1, array('title', '=', $title));
		$id = $findResult[0]["_id"];
		$destroyResult = $catControl->destroyDocument($id);
	}

	/**
	 * @dataProvider providerTestGetDocumentsWhereNull
	 *
	 * Test that GetDocumentsWhereNull returns null in appropriate cases
	 */
	public function testGetDocumentsWhereNull($numDocs, $arr){
		$title = $this->getCatalogueTestData()[1];
		$catControl = new CatalogueController();

		//insert the document to be tested
		$insertResult = call_user_func_array(array($catControl, "insertDocument"), $this->getCatalogueTestData());

		//the method we're testing
		$result = $catControl->getDocumentsWhere($numDocs, $arr);

		$this->assertNull($result);

		//find and delete the actual document
		$findResult = $catControl->getDocumentsWhere(1, array('title', '=', $title));
		$id = $findResult[0]["_id"];
		$destroyResult = $catControl->destroyDocument($id);
	}	

	/**
	 * Tests the following controller functions:
	 *		- insertDocument
	 *		- getDocumentsWhere
	 *		- appendDocument
	 *		- destroyDocument
	 * And stores the operation's result values to assertTrue.
	 * If so, that means every operation completed successfully.
	 * Otherwise, delete the offending record.
	 *
	 * @dataProvider providerTestControllersInsertFindAppendDelete
	 */
	public function testControllersInsertFindAppendDelete($ctrl, $attr, $dataArr, $dataArrIndex){
		$controller = $this->getInstanceOf($ctrl);

		$insertResult = call_user_func_array(array($controller, "insertDocument"), $dataArr);
		$findResult = $controller->getDocumentsWhere(1, array("$attr", '=', $dataArr[$dataArrIndex]));
		$id = $findResult[0]["_id"];
		$appendResult = $controller->appendDocument($id, 'delete', true);		
		$destroyResult = $controller->destroyDocument($id);

		$assertCondition = $insertResult && $findResult && $appendResult && $destroyResult; 
		$this->assertTrue($assertCondition);

		//ensure deletion
		if(!$assertCondition){
			$findResult->delete();
		}
	}
}

?>