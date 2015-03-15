'use strict';

appModule.controller('CatalogueController', ['$scope', '$routeParams', 'serverFactory', function($scope, $routeParams, serverFactory){
	/* Controller Members
	 ---------------------------------*/
	$scope.catalogue;
	$scope.catalogueItem;
	$scope.title = "";
	$scope.tab = "description";
	$scope.category;

	/* External API Calls
	 ---------------------------------*/
	$scope.getCatalogueOf = function(){
		$scope.catalogue = {};
		var params = $routeParams;

		//assign the appropriate value to category
		switch(params.type){
			case "all":
			case "movies":
			case "series":
			case "web":
				$scope.category = 0;
				break;

			case "people":
				$scope.category = 1;
				break;

			case "companies":
				$scope.category = 2;
				break;

			case "users":
				$scope.category = 3;
				break;
		}

		//call the appropriate method and set title
		switch(params.type){
			case "all":
				getAllCatalogueItems();
				$scope.title = "All Items";
				break;
			case "movies":
				getAllMovies();
				$scope.title = "All Movies";
				break;
			case "series":
				getAllTvShows();
				$scope.title = "All TV Series";
				break;
			case "web":
				getAllWebSeries();
				$scope.title = "All Web Series";
				break;
			case "companies":
				$scope.title = "All Companies";
				break;

			case "people":
				$scope.title = "All People";
				break;

			case "users":
				$scope.title = "All Users";
				break;
		}
	};

	$scope.getDocumentById = function(){
		var params = $routeParams;
		switch(params.type){
			case "item":
				serverFactory.getCatalogueItem(params.attr)
				.success(function(data){
					$scope.catalogueItem = data;
				})
				.error(function(error){});	
				break;
		}
	}

	/* Explicit API Calls
	 ---------------------------------*/
	var getAllCatalogueItems = function(){
		serverFactory.getAllCatalogueItems()
			.success(function(data){
				$scope.catalogue = data;
			})
			.error(function(error){});
	};

	var getAllMovies = function(){
		serverFactory.getAllMovies()
			.success(function(data){
				$scope.catalogue = data;
			})
			.error(function(error){});
	};

	var getAllTvShows = function(){
		serverFactory.getAllTvShows()
			.success(function(data){
				$scope.catalogue = data;
			})
			.error(function(error){});
	};

	var getAllWebSeries = function(){
		serverFactory.getAllWebSeries()
			.success(function(data){
				$scope.catalogue = data;
			})
			.error(function(error){});
	}

	var getAllUsers = function(){
		//the behavior for this will be different
		//will define later
	};
}]);