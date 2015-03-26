<?php

//tests account related ops
class AccountOpsTest extends TestCase {

	public function getAccountSpoofData(){
		$username = "billyjoedidcocaine";
		$password = "hackmeimsolame";
		$email = "fake@faker.gov";
		$firstNm = "billy";
		$lastNm = "joedidcocaine";
		$dob = "0/0/0 1:00:00:00";
		$gender = "gay";

		return array($username, $password, $email, $firstNm, $lastNm, $dob, $gender);
	}

	/**
	 * Tests that the AccountController verifies if an attribute's value is unique
	 */
	public function isUnique($username, $email){
		$accountCtrl = new AccountController();

		//test uniqueness for emails
		$isEmailUnique = $accountCtrl->isUnique('email', $email) == 'true' ? true : false;
		$this->assertFalse($isEmailUnique);

		//test uniqueness for usernames
		$isUsernameUnique = $accountCtrl->isUnique('username', $username) == 'true' ? true : false;
		$this->assertFalse($isUsernameUnique);
	}

	/**
	 * Verifies that the account creation and account deletion methods work
	 */
	public function testAccountCreationAndDeletion(){
		$attr = $this->getAccountSpoofData();
		$accountCtrl = new AccountController();

		//create an account
		$createdAccount = $accountCtrl->createAccount($attr[0], $attr[1], $attr[2], $attr[3], $attr[4], $attr[5], $attr[6]);

		$this->isUnique($attr[0], $attr[2]);

		//delete an account
		$deletedAccount = $accountCtrl->deleteAccount($attr[0]);

		$this->assertTrue($createdAccount && $deletedAccount);	
	}

}

?>