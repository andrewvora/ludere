<?php

class AccountController extends \BaseController {
	
	/**
	 * creates a new user account by inserting into appropriate collections
	 *
	 * parameters should be the ones needed for:
	 *		- LoginController.insertDocument
	 *		- UserController.insertDocument
	 *		- UserDataController.insertDocument
	 */
	public function createAccount($username, $isAdmin, $joinDate, $email, $firstName, $lastName, $gender, $birthday){
		$loginCtrl = new LoginController();
		$userCtrl = new UserController();
		$userDataCtrl = new UserDataController();

		//check and insert into LoginController

		//check and insert into UserController

		//check and insert UserDataController

	}

	/**
	 * deletes an account by deleting traces of a user from the appropriate collections
	 * 		- login
	 *		- user
	 *		- user_data
	 */
	public function deleteAccount($username){
		$loginCtrl = new LoginController();
		$userCtrl = new UserController();
		$userDataCtrl = new UserDataController();

		$success = true;
		$condArr = array('username', '=', "$username");
		
		$success = $success && $loginCtrl->getDocumentsWhere( 0, $condArr )->delete();
		$success = $success && $userCtrl->getDocumentsWhere( 0, $condArr )->delete();
		$success = $success && $userDataCtrl->getDocumentsWhere( 0, $condArr )->delete();

		//if false, we should have some sort of rollback, mongodb seems to support transactions
		//idea: hold the result of getDocumentsWhere and reinsert if $success is false

		return $success;
	}
}

?>