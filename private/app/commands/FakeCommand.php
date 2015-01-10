<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FakeCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fake';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate fake data';

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
		$i=0;
		while($i <= mt_rand(1000,1005000)){
			$faker = Faker\Factory::create();
			try{
				$u = new User;
				$u->email = $faker->freeEmail;
				$u->password = '';
				$u->display_name = $faker->userName;
				$u->save();
			}catch(Exception $e){

			}
			$i++;
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
		);
	}

}
