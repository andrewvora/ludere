<?php

require_once('ControllerDummyData.php');

class UserControllerTest extends TestCase {
	/**
	 * Create a user and catalogue item using the dummy data
	 */
	public function addUserAndCatalogueItem(){
		$userCtrl = new UserController();
		$catCtrl = new CatalogueController();
		$arr = getUserTestData();
		$catArr = getCatalogueTestData();

		//add the dummy user
		$userCtrl->insertDocument($arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6]);

		//add the dummy catalogue item
		$catCtrl->insertDocument($catArr[0], $catArr[1], $catArr[2], $catArr[3], $catArr[4], $catArr[5], $catArr[6], $catArr[7], $catArr[8], $catArr[9], $catArr[10], $catArr[11], $catArr[12], $catArr[13] );
	}

	/**
	 * Remove the dummy user and catalogue item
	 */
	public function deleteUserAndCatalogueItem(){
		$userCtrl = new UserController();
		$catCtrl = new CatalogueController();
		$arr = getUserTestData();
		$catArr = getCatalogueTestData();

		//clean up
		$userDeleted = $userCtrl->deleteUser($arr[0]);
		$catItemDeleted = Catalogue::where('title', '=', $catArr[1])->delete();
	}

	public function testUserCanAddRemoveCatalogueItemsToTheirList() {
		$userCtrl = new UserController();
		$catCtrl = new CatalogueController();
		$arr = getUserTestData();
		$catArr = getCatalogueTestData();

		//add the dummy user and catalogue item
		$this->addUserAndCatalogueItem();

		//add something to their catalogue
		$catItem = Catalogue::where('title', '=', $catArr[1])->firstOrFail();
		$addToList = $userCtrl->updateUserCatalogueItem($arr[0], $catItem['_id'], 0.5, 'watching', 1) == 'true' ? true : false;

		//check that it exists
		$userCat = $userCtrl->getUser($arr[0])->catalogueItems;
		$exists = $userCat[$catItem['_id']] != NULL;

		//remove the item from the user's list
		$removedFromList = $userCtrl->removeFromUserCatalogue($arr[0], $catItem['_id']);

		//check that it's not there
		$userCat = $userCtrl->getUser($arr[0])->catalogueItems;
		$wasRemoved = $userCtrl->inUserCatalogue($arr[0], $catItem['_id']) == 'false' ? true : false;

		// clean up
		$this->deleteUserAndCatalogueItem();
		
		// verify results
		$this->assertTrue($addToList && $exists && $removedFromList && $wasRemoved);
	}

	public function testUserCanUpdateCatalogueItemsInTheirList() {
		$userCtrl = new UserController();
		$catCtrl = new CatalogueController();
		$arr = getUserTestData();
		$catArr = getCatalogueTestData();

		//add the dummy user and catalogue item
		$this->addUserAndCatalogueItem();

		//add something to their catalogue
		$catItem = Catalogue::where('title', '=', $catArr[1])->firstOrFail();
		$updateOp = $userCtrl->updateUserCatalogueItem($arr[0], $catItem['_id'], 0.5, 'watching', 1) == 'true' ? true : false;

		//check that the values are updated
		$userCtrl->updateUserCatalogueItem($arr[0], $catItem['_id'], 0.25, 'completed', 12);
		$userCat = $userCtrl->getUser($arr[0])->catalogueItems;

		if($userCat[$catItem['_id']] != null){
			$updated = $userCat[$catItem['_id']]['rating'] == 0.25;
		}

		//clean up
		$this->deleteUserAndCatalogueItem();

		$this->assertTrue($updateOp && $updated);
	}

	public function testUserCanAddCatalogueItemsToTheirFavorites(){
		$userCtrl = new UserController();
		$catCtrl = new CatalogueController();
		$arr = getUserTestData();
		$catArr = getCatalogueTestData();

		//add the dummy user and catalogue item
		$this->addUserAndCatalogueItem();

		//get the document
		$catItem = Catalogue::where('title', '=', $catArr[1])->firstOrFail();

		$added = $userCtrl->addToUserFavorites($arr[0], $catItem['_id']) == 'true' ? true : false;
		$verified = $userCtrl->inUserFavorites($arr[0], $catItem['_id']) == 'true' ? true : false;

		//clean up
		$this->deleteUserAndCatalogueItem();

		$this->assertTrue($added && $verified);
	}

	public function testUserCanRemoveCatalogueItemsFromTheirFavorites(){
		$userCtrl = new UserController();
		$catCtrl = new CatalogueController();
		$arr = getUserTestData();
		$catArr = getCatalogueTestData();

		//add the dummy user and catalogue item
		$this->addUserAndCatalogueItem();

		//get the document
		$catItem = Catalogue::where('title', '=', $catArr[1])->firstOrFail();

		$added = $userCtrl->addToUserFavorites($arr[0], $catItem['_id']) == 'true' ? true : false;
		$removed = $userCtrl->removeFromUserFavorites($arr[0], $catItem['_id']) == 'true' ? true : false;
		$verified = $userCtrl->inUserFavorites($arr[0], $catItem['_id']) == 'true' ? false : true;

		//clean up
		$this->deleteUserAndCatalogueItem();

		$this->assertTrue($removed && $verified);
	}
}

?>