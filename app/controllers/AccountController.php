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
	public function createAccount($username, $password, $email, $firstNm, $lastNm, $dob, $gender){
		$loginCtrl = new LoginController();
		$userCtrl = new UserController();
		$userDataCtrl = new UserDataController();

		//check and insert into LoginController
		$createdLogin = $loginCtrl->createLogin($username, $password);

		//check and insert into UserController
		$createdUser = $userCtrl->insertDocument($username, false, $email, $firstNm, $lastNm, $gender, $dob);

		//check and insert UserDataController
		$createdUserData = $userDataCtrl->insertDocument($username);

		//check if every op completed successfully
		$success = $createdLogin && $createdUser && $createdUserData;

		return $success;
	}

	/**
	 * deletes an account by deleting traces of a user from the appropriate collections
	 * 		- login
	 *		- user
	 *		- user_data
	 */
	public function deleteAccount($username){
		$success = true;		
		$success = $success && Login::where('username', '=', "$username")->delete();
		$success = $success && User::where('username', '=', "$username")->delete();
		$success = $success && UserData::where('username', '=', "$username")->delete();

		//if false, we should have some sort of rollback, mongodb seems to support transactions
		//idea: hold the result of getDocumentsWhere and reinsert if $success is false

		return $success;
	}

	public function isUnique($attr, $value){
		switch($attr){
			case "username":
				return Login::where("$attr", '=', "$value")->count() < 1 ? 'true' : 'false';

			case "email":
				return User::where("$attr", '=', "$value")->count() < 1 ? 'true' : 'false';

			default: return 'false';
		}
	}
}

?>