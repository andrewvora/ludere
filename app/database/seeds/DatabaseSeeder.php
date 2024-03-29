<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('CatalogueCollectionSeeder');
		$this->call('UsersCollectionSeeder');
		
		$this->command->info('Seeding complete.');
	}
}
