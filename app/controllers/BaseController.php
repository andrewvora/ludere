<?php

//Universal methods go here
class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Returns $numDocs documents that satisfies the query built from $queryArr
	 * If $numDocs > number of results, it just returns all the results
	 * If $numDocs == 0, it also returns all of the results
	 *
	 * @param string $collection 	the collection to apply the method to
	 * @param  int  $numDocs	the number of documents to return from the query
	 * @param  array 	$queryArr	an array of the elements to build the query
	 *
	 * @return array of documents
	 */
	public function getDocumentsWhereTemplate($collection, $numDocs, $queryArr){
		//escape if $queryArr has less than 3 arguments
		//			$numDocs < 1
		if(count($queryArr) < 3 || $numDocs < 0) return;

		$results = call_user_func_array("$collection::where", $queryArr);
		return $numDocs > 0 && count($results) <= $numDocs ? 
			$results->take($numDocs)->get() : 
			$results->get();
	}

}
