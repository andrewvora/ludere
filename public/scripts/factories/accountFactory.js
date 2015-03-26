'use strict';

/**
 * @ngdoc factories
 * @name accountFactory
 * @description
 * # seenByMeApp
 *
 * Angular factory for making HTTP requests to the backend server
 */

appModule.factory('accountFactory', ['$http', '$q', function($http, $q){
	var accountFactory = {};

	accountFactory.createAccount = function(username, password, email, firstNm, lastNm, dob, gender){
		var completeUrl = server_url + "auth/create/"
			completeUrl += username + "/";
			completeUrl += password + "/";
			completeUrl += email + "/";
			completeUrl += firstNm + "/";
			completeUrl += lastNm + "/";
			completeUrl += dob + "/";
			completeUrl += gender;

		return $http({
			method: 'POST',
			url: completeUrl
		});
	};

	accountFactory.login = function(username, password){
		return $http({
			method: 'POST',
			url: server_url + "auth/login/" + username + "/" + password
		});
	};

	accountFactory.logout = function(){
		return $http({
			method: 'POST',
			url: server_url + "auth/logout"
		});
	};

	accountFactory.isLoggedIn = function(username){
		return $http({
			method: 'GET',
			url: server_url + "auth/isLoggedIn/" + username
		});
	};

	accountFactory.getCurrentUser = function(){
		return $http({
			method: 'GET',
			url: server_url + "auth/username/current"
		});
	};

	accountFactory.isUnique = function(attr, value){
		return $http({
			method: 'GET',
			url: server_url + "auth/unique/" + attr + "/" + value
		});
	};

	return accountFactory;
}]);