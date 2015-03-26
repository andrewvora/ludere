<?php

class LoginTest extends TestCase {

	/**
	 * Testing the LoginController's creation, valiation, session setting and destroying
	 * functions
	 *
	 * @return void
	 */
	public function testLoginValidationAndActionAndAccountUniqueness()
	{
		//required params
		$loginC = new LoginController();
		$accountC = new AccountController();
	
		$username = "theangelatte";
		$password = '1523screwthat';

		//check that the username is unique
		$unique = $accountC->isUnique('username', $username) == 'true' ? true : false;

		//create the login
		$value = $loginC->createLogin($username,$password);

		//log the user in and start the session
		$doingLogin = $loginC->doLogin($username,$password);

		//check if the user is logged in
		$isLogged = $loginC->isLoggedIn($username) == 'true' ? true : false;

		//check that the username is logged and callable
		$sameUsername = $loginC->getUserFromSession() == $username;

		//log the user out
		$logout = $loginC->doLogout();

		//delete the user
		$toDelete = $loginC->getDocumentsWhere(1, array('username', '=', $username));
		$soonGone = $toDelete[0]['_id'];
		$goodbye = $loginC->destroyDocument($soonGone);

		//separate lines for troubleshooting
		$this->assertTrue($sameUsername && $unique && $value && $goodbye && $doingLogin && $isLogged && $logout);
	}
}

?>
