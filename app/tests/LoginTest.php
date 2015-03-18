<?php

class LoginTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testLoginValidationAndAction()
	{
		$loginC = new LoginController();
		
		$username = "theangelatte";
		$password = '1523screwthat';
		$value = $loginC->create($username,$password);

		$doingLogin = $loginC->doLogin($username,$password);

		$isLogged = $loginC->isLoggedIn($username);

		$logout = $loginC->doLogout();

		$toDelete = $loginC->getDocumentsWhere(1, array('username', '=', $username));
		$soonGone = $toDelete[0]['_id'];
		$goodbye = $loginC->destroyDocument($soonGone);

		//separate lines for troubleshooting
		$this->assertTrue($value && $goodbye && $doingLogin && $isLogged && $logout);
	}

}

?>
