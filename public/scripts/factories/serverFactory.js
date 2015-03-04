'use strict';

/**
 * @ngdoc factories
 * @name serverFactory
 * @description
 * # seenByMeApp
 *
 * Angular factory for making HTTP requests to the backend server
 */

appModule.factory('serverFactory', ['$http', '$q', function($http, $q){
	var serverFactory = {};

	//
	serverFactory.getAllCatalogueItems = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/all"
		});
	};

	serverFactory.getAllTvShows = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/series"
		});
	};

	serverFactory.getAllMovies = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/movie"
		});
	};

	serverFactory.getAllWebSeries = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/web"
		});
	};

	serverFactory.getCatalogueItem = function(id){
		return $http({
			method: 'GET',
			url: server_url + "catalogue/item/" + id
		});
	};

	return serverFactory;
}]);