<?php

class AccountController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Insert a new document
	 *
	 * @param String $id 			- unique resource identifier by Mongo
	 * @param String $username
	 * @param String $passwordHash 	- the hashed password
	 * @param String $key 			- the salt used to hash the password
	 * @param String $email
	 * @param int $numAttempts
	 * @param String $lastLogin		- formatted date string
	 *
	 * @return Boolean $success
	 */
	public function insertDocument($id, $username, $passwordHash, $key, $email, $numAttempts, $lastLogin) {
		


	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
