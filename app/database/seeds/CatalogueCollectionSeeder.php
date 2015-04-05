<?php

/*
 * Seeds the 'users' collection with random users using:
 * omdbapi.com/
 */

class CatalogueCollectionSeeder extends Seeder {
	public function run(){
		//clear the current database
		$catCtrl = new CatalogueController();
		$catCtrl->destroyEverything();

		//run the population command
		Artisan::call('command:PopulateCatalogue');
	}


}