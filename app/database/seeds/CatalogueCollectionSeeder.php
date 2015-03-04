<?php

/*
 * Seeds the 'users' collection with random users using:
 * omdbapi.com/
 */

class CatalogueCollectionSeeder extends Seeder {
	public function run(){
		$catCtrl = new CatalogueController();
		$catCtrl->destroyEverything();

		for($i = 108770; $i < 108800; $i++){
			$url = "http://www.omdbapi.com/?i=tt0$i&plot=short&r=json";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			$result = curl_exec($ch);
			curl_close($ch);

			$result = json_decode($result);

			if($result != null && isset($result->Type)) { 
				$catCtrl->insertDocument(
					$result->Type, 
					$result->Title, 
					$result->Poster, 
					[],
					$result->Year, 
					$result->Rated, 
					$result->Released, 
					$result->Runtime, 
					$result->Genre, 
					[], 
					$result->Plot, 
					'', 
					$result->Country, 
					$result->Awards
				);
			}
		}
	}
}