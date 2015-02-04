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

	serverFactory.getServerMessage = function(){
		return $http({
			method: 'GET',
			url: server_url + "test"
		});
	};

	return serverFactory;
}]);