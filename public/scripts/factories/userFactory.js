appModule.factory('userFactory', function($http, $q, $upload){
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

	userFactory.getFromUserCatalogue = function(username, itemId){
		return $http({
			method: 'GET',
			url: server_url + escape('user/'+username+'/list/get/'+itemId)
		});
	}

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
	};

	userFactory.updateProfile = function(username, email, firstName, lastName, gender, birthday, about, city, state, province, country){
		var paramStr = email + '/' + firstName + '/' + lastName + '/' + gender
		+ '/' + birthday + '/' + about + '/' + city + '/' + state + '/' + province + '/' + country;
		return $http({
			method: 'PUT',
			url: server_url + escape('user/update/profile/detailed/'+paramStr)
		});
	};

	userFactory.getProfilePicture = function(username){
		return $http({
			method: 'GET',
			url: server_url + escape('user/' + username + '/picture')
		});
	};

	return userFactory;
});