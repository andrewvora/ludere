'use strict';

/* Catalogue Item Directives
 *----------------------------*/
var itemDir = 'views/items/itemTabs/';
var settingsDir = 'views/user/settingsTabs/';
var userDir = 'views/user/profileTabs/';

appModule.directive('itemDescription', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: itemDir+'item-description.html'
	};
});

appModule.directive('itemFilmography', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: itemDir+'item-filmography.html'
	};
});

appModule.directive('itemPeople', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: itemDir+'item-people.html'
	};
});

appModule.directive('itemPhotos', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: itemDir+'item-photos.html'
	};
});

appModule.directive('itemPopularity', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: itemDir+'item-popularity.html'
	};
});

appModule.directive('itemReport', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: itemDir+'item-report.html'
	};
});

appModule.directive('itemVideos', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: itemDir+'item-videos.html'
	};
});

appModule.directive('itemAddtolist', function(){
	return{
		restrict: 'E',
		scope: {
			catalogueItem: '=item',
			show: '=show'
		},
		templateUrl: 'views/items/item-addtolist.html'
	};
});

appModule.directive('itemRemovefromlist', function(){
	return{
		restrict: 'E',
		scope: {
			catalogueItem: '=item',
			show: '=show'
		},
		templateUrl: 'views/items/item-removefromlist.html'
	};
});

appModule.directive('itemAddtofav', function(){
	return{
		restrict: 'E',
		scope: {
			catalogueItem: '=item',
			show: '=show'
		},
		templateUrl: 'views/items/item-addtofav.html'
	};
});

appModule.directive('itemRemovefromfav', function(){
	return{
		restrict: 'E',
		scope: {
			catalogueItem: '=item',
			show: '=show'
		},
		templateUrl: 'views/items/item-removefromfav.html'
	};
});

/* User Setting Directives
 *----------------------------*/
appModule.directive('settingsOverview', function(){
	return {
		restrict: 'E',
		scope: {
			user: '=user'
		},
		templateUrl: settingsDir+'settings-overview.html'
	};
});

appModule.directive('settingsEmail', function(){
	return {
		restrict: 'E',
		scope: {
			user: '=user'
		},
		templateUrl: settingsDir+'settings-email.html'
	};
});

appModule.directive('settingsPrivacy', function(){
	return {
		restrict: 'E',
		scope: {
			user: '=user'
		},
		templateUrl: settingsDir+'settings-privacy.html'
	};
});

/* User Profile Directives
 *----------------------------*/
appModule.directive('userLists', function(){
	return {
		restrict: 'E',
		scope: {
			user: '=user'
		},
		templateUrl: userDir+'user-lists.html'
	};
});

appModule.directive('userStats', function(){
	return {
		restrict: 'E',
		scope: {
			user: '=user'
		},
		templateUrl: userDir+'user-stats.html'
	};
});