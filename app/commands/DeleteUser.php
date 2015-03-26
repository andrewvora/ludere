<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DeleteUser extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:DeleteUser';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Deletes documents of the given username from all collections.';

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
		$accountCtrl = new AccountController();
		$username = $this->argument('usernm');
		$deleted = $accountCtrl->deleteAccount($username);
		if($deleted){
			$this->info("$username has been deleted from the database.");
		}
		else {
			$this->info("Deletion of $username failed.");
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('usernm', InputArgument::REQUIRED, 'The username to delete.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
