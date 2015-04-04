<?php

require_once('ControllerDummyData.php');

//Tests the basic functionalities of controllers: find, destroy, insert, getWhere
class GeneralControllersTest extends TestCase {
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
			case "UserController":
				return new UserController();
			case "MessageController":
				return new MessageController();
			case "PersonController":
				return new PersonController();
			case "UserDataController":
				return new UserDataController();
			case "AccountController":
				return new AccountController();
		}
	}

	/*PROVIDER METHODS====================================*/
	/**
	 * Provider function for test data used in testGetDocumentsWhere
	 */
	public function providerTestGetDocumentsWhere(){
		$title = getCatalogueTestData()[1];
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
		$title = getCatalogueTestData()[1];
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
				array('CatalogueController', 'title', getCatalogueTestData(), 1),
				array('BadgeController', 'name', getBadgeTestData(), 1),
				array('CharacterController', 'name', getCharacterTestData(), 1),
				array('CompanyController', 'name', getCompanyTestData(), 1),
				array('MessageController', 'sender', getMessageTestData(), 0),
				array('PersonController', 'firstName', getPersonTestData(), 1),
				array('UserController', 'username', getUserTestData(), 0),
				array('UserDataController', 'username', getUserDataTestData(), 0)
			);
	}

	/*TESTS METHODS====================================*/
	/**
	 * @dataProvider providerTestGetDocumentsWhere
	 *
	 * Test that GetDocumentsWhere returns something in appropriate cases
	 */
	public function testGetDocumentsWhere($numDocs, $arr){
		$title = getCatalogueTestData()[1];

		$catControl = new CatalogueController();

		//insert the document to be tested
		$insertResult = call_user_func_array(array($catControl, "insertDocument"), getCatalogueTestData());

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
		$title = getCatalogueTestData()[1];
		$catControl = new CatalogueController();

		//insert the document to be tested
		$insertResult = call_user_func_array(array($catControl, "insertDocument"), getCatalogueTestData());

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