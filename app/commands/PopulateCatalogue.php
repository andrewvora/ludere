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
		$epOnly = $this->option('epOnly');

		if(isset($epOnly) && $epOnly == 'true') {
			$this->info('Updating episode counts of current catalogue...');
			$this->update_episode_count();
			$this->info('Finished updating episode counts!');
		}
		else {
			$this->info("Querying the omdb API...");
			$this->query_omdb_api();

			$this->info("APIs exhausted! Please add more APIs or extend the range.");
		}
		
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
			array('epOnly', null, InputOption::VALUE_OPTIONAL, 'Only updates the episode counts of current catalogue items', null),
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

		//For now grabs 300, max imdb val at about 4600000
		$a = rand(0, 4000000);
		for($i = $a; $i <= $a + 300; $i++){
			$id = sprintf('%07d', $i);
			$url = "http://www.omdbapi.com/?i=tt$id&plot=short&r=json";

			$result = $this->curlRequest_noAuth($url);

			$result = json_decode($result);
			
			$usable = $result != null && isset($result->Type);
			$usable = $usable && strcmp($result->Type,"episode") != 0;
			$usable = $usable && strcmp($result->Type,"game") != 0;
			$usable = $usable && strcmp($result->Rated, "X") != 0;

			if($usable) {
				//define conditions to check
				$args = array(	'type'=>$result->Type,
								'title' =>$result->Title,
								'year' =>$result->Year); 

				//insert only if the count == 0 and it's not an episode
				if(count(Catalogue::where($args)->first()) == 0 ) {
					$this->info("Inserting ".$result->Title);
					
					$type = $this->map_to_type($result->Type);
					$poster = $this->get_poster_url_for($result->imdbID);

					$catCtrl->insertDocument(
						$result->Type, $result->Title, $poster, 
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
	 * Query the hummingbird api for results
	 */
	private function query_hummingbird_api(){

	}

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

	private function update_episode_count(){
		$catalogue = Catalogue::all();
		foreach($catalogue as $item){
			if($item->type != 'short' || $item->type != 'movie') {
				$epCount = $this->get_episode_count_tvrage_api($item->title);
				$item->episodes = $epCount;
				$item->save();	
				$this->info('Set '.$item->title.'->episodes to '.$epCount);
			}
			else {
				$item->episodes = 1;
				$item->save();
			}
		}
	}

	/**
	 * Get the episode count of a tv series or movie from the tvrage api
	 */
	private function get_episode_count_tvrage_api($title){
		$numEps = 0;

		//get the shows matching the title
		$url = 'http://services.tvrage.com/feeds/search.php?show='.str_replace(' ', '_',$title);
		$result = $this->curlRequest_noAuth($url);
		$result = simplexml_load_string($result);

		if(strlen($result[0]->show->name) > 0){
			$this->info('Getting episode count of '.$title);

			//take the first result's id
			$showId = $result[0]->show->showid;

			//make a new request for the episode list
			$url = 'http://services.tvrage.com/feeds/episode_list.php?sid='.$showId;
			$result = $this->curlRequest_noAuth($url);
			$result = simplexml_load_string($result);

			if(strcmp($result->name, $title) == 0) {
				//add the numEps from each season
				$seasons = $result->Episodelist->Season;
				try {
					foreach($seasons as $season){
						$numEps += count($season);
					}	
				}
				catch(Exception $e){
					echo $e->getMessage();	
				}
			}
		}
		return $numEps;
	}

	/**
	 * Get the movie poster from the tmdb api
	 */
	private function get_poster_url_for($imdbId){
		$image_url = 'http://image.tmdb.org/t/p/w500';

		$api_key = '';
		$url = 'https://api.themoviedb.org/3/find/'.$imdbId.'?api_key='.$api_key.'&external_source=imdb_id';

		$results = json_decode($this->curlRequest_noAuth($url));
		$poster_url = 'http://placehold.it/500x500';

		foreach($results as $result){
			if(isset($result[0]->poster_path)) {
				$poster_url = $image_url.$result[0]->poster_path;
				break;
			}
			else if(isset($result[0]->backdrop_path)){
				$poster_url = $image_url.$result[0]->backdrop_path;
				break;
			}
		}
		
		return $poster_url;
	}

}
