appModule.factory('userDataFactory', function($http, $q){
	var userDataFactory = {};

	userDataFactory.getUser = function(username){
		return $http({
			method: 'GET',
			url: server_url + 'user/' + username + '/data'
		});
	};

	return userDataFactory;
});
