<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateUserData extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:UpdateUserData';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Updates the data for users in the user_data_queue collection.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$numUsers = $this->option('numUsers');


	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('numUsers', null, InputOption::VALUE_OPTIONAL, 'Number of documents to update.', null),
		);
	}

}
