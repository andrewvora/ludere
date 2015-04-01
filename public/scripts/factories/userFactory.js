appModule.factory('userFactory', ['$http', '$q', function($http, $q){
	var userFactory = {};

	userFactory.getUser = function(username){
		return $http({
			method: 'GET',
			url: server_url + escape('user/' + username)
		});
	};

	return userFactory;
}]);