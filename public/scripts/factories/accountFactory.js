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
		var completeUrl = "auth/create/"
			completeUrl += username + "/";
			completeUrl += password + "/";
			completeUrl += email + "/";
			completeUrl += firstNm + "/";
			completeUrl += lastNm + "/";
			completeUrl += dob + "/";
			completeUrl += gender;
		return $http({
			method: 'POST',
			url: server_url + escape(completeUrl),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		});
	};

	accountFactory.login = function(username, password){
		var url = server_url + escape("auth/login/" + username + "/" + password);
		return $http({
			method: 'PUT',
			url: url,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		});
	};

	accountFactory.logout = function(){
		return $http({
			method: 'PUT',
			url: server_url + "auth/logout",
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		});
	};

	accountFactory.isLoggedIn = function(username){
		var url = server_url + escape("auth/isLoggedIn/" + username);
		return $http({
			method: 'GET',
			url: url,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		});
	};

	accountFactory.getCurrentUser = function(){
		return $http({
			method: 'GET',
			url: server_url + escape("auth/username/current"),
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		});
	};

	accountFactory.isUnique = function(attr, value){
		var url = server_url + escape("auth/unique/" + attr + "/" + value);
		return $http({
			method: 'GET',
			url: url,
			headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		});
	};

	return accountFactory;
}]);