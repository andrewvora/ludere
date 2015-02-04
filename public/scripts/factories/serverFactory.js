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

	serverFactory.getAllCatalogueItems = function(){
		return $http({
			method: 'GET',
			url: server_url + "catalogue"
		});
	};

	return serverFactory;
}]);