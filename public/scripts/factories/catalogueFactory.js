'use strict';

/**
 * @ngdoc factories
 * @name catalogueFactory
 * @description
 * # seenByMeApp
 *
 * Angular factory for making HTTP requests to the backend server
 */

appModule.factory('catalogueFactory', ['$http', '$q', function($http, $q){
	var catalogueFactory = {};

	//
	catalogueFactory.getAllCatalogueItems = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/all"
		});
	};

	catalogueFactory.getAllTvShows = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/series"
		});
	};

	catalogueFactory.getAllMovies = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/movie"
		});
	};

	catalogueFactory.getAllWebSeries = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/web"
		});
	};

	catalogueFactory.getCatalogueItem = function(id){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/item/" + id
		});
	};

	catalogueFactory.getCatalogueItems = function(ids){
		var idStr = "";
		for(var item in ids){
			idStr += item + ","
		}
		idStr = idStr.substring(0, idStr.length - 1);

		return $http({
			method: 'GET',
			url: server_url + "catalogue/items/" + idStr
		});
	};

	catalogueFactory.getRandomItem = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/rand"
		});
	};

	return catalogueFactory;
}]);