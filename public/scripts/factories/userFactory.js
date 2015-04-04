appModule.factory('userFactory', ['$http', '$q', function($http, $q){
	var userFactory = {};

	userFactory.getUser = function(username){
		return $http({
			method: 'GET',
			url: server_url + escape('user/' + username)
		});
	};

	userFactory.addToUserCatalogue = function(username, itemId, rating, status, epsWatched){
		var queryStr = 'user/'+ username +'/list/add/'+ itemId;
		queryStr += '/' + rating + '/' + status + '/' + epsWatched; 
		return $http({
			method: 'POST',
			url: server_url + escape(queryStr)
		});
	};

	userFactory.updateUserCatalogueItem = function(username, itemId, rating, status, epsWatched){
		var queryStr = 'user/'+ username +'/list/update/'+ itemId;
		queryStr += '/' + rating + '/' + status + '/' + epsWatched; 
		return $http({
			method: 'PUT',
			url: server_url + escape(queryStr)
		});
	};

	userFactory.removeFromUserCatalogue = function(username, itemId){
		return $http({
			method: 'PUT',
			url: server_url + escape('user/' + username + '/list/remove/' + itemId)
		});
	};

	userFactory.inUserCatalogue = function(username, itemId){
		return $http({
			method: 'GET',
			url: server_url + escape('user/' + username + '/list/exists/' + itemId)
		});
	};

	userFactory.addToUserFavorites = function(username, itemId){
		return $http({
			method: 'POST',
			url: server_url + escape('user/' + username + '/favorites/add/' + itemId )
		});
	};

	userFactory.removeFromUserFavorites = function(username, itemId){
		return $http({
			method: 'PUT',
			url: server_url + escape('user/' + username + '/favorites/remove/' + itemId )
		});
	};

	userFactory.inUserFavorites = function(username, itemId){
		return $http({
			method: 'GET',
			url: server_url + escape('user/' + username + '/favorites/exists/' + itemId )
		});
	}

	return userFactory;
}]);