<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PopulateCatalogue extends Command {
	/* Necessary Class Members
	 *=======================================*/

	/**
	 * The name called to run from CLI
	 * ex.) php artisan command:populateCatalogue
	 * @var string
	 */
	protected $name = 'command:PopulateCatalogue';

	/**
	 * The console command description.
	 * @var string
	 */
	protected $description = 'Populates the catalogue, people, companies, and characters collections.';

	/**
	 * Create a new command instance.
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * The command's logic
	 * @return mixed
	 */
	public function fire()
	{
		$this->info("Querying the omdb API...");
		$this->query_omdb_api();

		$this->info("APIs exhausted! Please add more APIs or extend the range.");
	}

	/**
	 * Get the console command arguments.
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

	/* Utility Methods
	 *=========================================*/
	private function curlRequest_noAuth($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	private function mapXmlToAssArr_animeEncyclopedia($xml){
		$result = array();
		$result['type'] = $xml['anime']['@attributes']['type'];
		$result['title'] = '';
		$result['picture'] = '';
		$result['video'] = '';
		$result['years'] = '';
		$result['guidanceRating'] = '';
		$result['releaseDate'] = '';
		$result['duration'] = '';
		$result['genres'] = '';
		$result['people'] = '';
		$result['plotShort'] = '';
		$result['plotLong'] = '';
		$result['countryOfOrigin'] = '';
		$result['awards'] = '';

		return $result;
	}

	private function map_to_type($type){
		switch($type){
			case "OAV":
			case "TV":
				return "series";
			case "web":
			case "series":
			case "movie":
				return $type;
		}
	}


	/* API Call Methods
	 *=========================================*/

	/**
	 * Queries the omdb API to get imdb items and insert the results
	 * into the catalogue collection
	 */
	//queries http://www.omdbapi.com
	private function query_omdb_api(){
		$catCtrl = new CatalogueController();

		for($i = rand(0, 9999999) * 100000 % 10000000; $i <= 9999999; $i++){
			$id = sprintf('%07d', $i);
			$url = "http://www.omdbapi.com/?i=tt$id&plot=short&r=json";

			$result = $this->curlRequest_noAuth($url);

			$result = json_decode($result);

			if($result != null && isset($result->Type)) {
				//define conditions to check
				$args = array(	'type'=>$result->Type,
								'title' =>$result->Title,
								'year' =>$result->Year); 

				//insert only if the count == 0
				if(count(Catalogue::where($args)->first()) == 0) {
					$catCtrl->insertDocument(
						$result->Type, $result->Title, $result->Poster, 
						[], $result->Year, $result->Rated, $result->Released, 
						$result->Runtime, $result->Genre, [], $result->Plot, 
						'', $result->Country, $result->Awards	);
				}
			}
		}
	}

	/**
	 * Queries the animenewsnetwork API to get anime titles and insert the results
	 * into the catalogue collection
	 */
	private function query_anime_encyclopedia_api(){
		$catCtrl = new CatalogueController();

		for($i = 1; $i <= 1; $i++){
			$url = "http://cdn.animenewsnetwork.com/encyclopedia/api.xml?anime=$i";

			$result = curlRequest_noAuth($url);

			//convert XML -> JSON -> array
			$result = str_replace(array("\n","\t","\r"), '', $result);
			$result = trim(str_replace('"', "'", $result));
			$result = simplexml_load_string($result);

			if($result != null && isset($result)) {
				$args = array();

				if(count(Catalogue::where($args)->first()) == 0){
					$attributes = mapXmlToAssArr_animeEncyclopedia($result);
					$catCtrl->insertDocument(
						map_to_type($attributes['type']), 
						$attributes['title'],
						$attributes['picture'],
						$attributes['video'],
						$attributes['years'],
						$attributes['guidanceRating'],
						$attributes['releaseDate'],
						$attributes['duration'],
						$attributes['genres'],
						$attributes['people'],
						$attributes['plotShort'],
						$attributes['plotLong'],
						$attributes['countryOfOrigin'],
						$attributes['awards']
					);
				} //end-if
			} //end-if
		} //end-for
	} //end query_anime_encyclopedia_api

	/**
	 * Queries themoviedb.org API for movie info
	 */
	private function query_moviedb_api(){

	}

	/**
	 * Queries thetvdb.com for series info
	 */
	private function query_tvdb_api(){

	}

}
