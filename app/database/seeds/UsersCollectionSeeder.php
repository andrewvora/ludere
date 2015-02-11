<?php

/*
 * Seeds the 'users' collection with random users using:
 * randomuser.me/
 */

class UsersCollectionSeeder extends Seeder {
	public function run(){
		$userCtrl = new UserDataController();
		$userCtrl->destroyEverything();

		for($i = 0; $i < 30; $i++){
			$url = "http://api.randomuser.me/?results=1&format=json";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			$result = curl_exec($ch);
			curl_close($ch);

			$result = json_decode($result);
			
			$userCtrl->insertDocument(
				$result->results[0]->user->username, 
				False, 
				date("Y/m/d"), 
				$result->results[0]->user->email, 
				$result->results[0]->user->name->first, 
				$result->results[0]->user->name->last, 
				$result->results[0]->user->gender, 
				$result->results[0]->user->dob,
				$result->results[0]->seed
				);
		}
	}
}