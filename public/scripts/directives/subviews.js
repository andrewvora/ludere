'use strict';

appModule.directive('itemDescription', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: 'views/subViews/item-description.html'
	};
});

appModule.directive('itemFilmography', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: 'views/subViews/item-filmography.html'
	};
});

appModule.directive('itemPeople', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: 'views/subViews/item-people.html'
	};
});

appModule.directive('itemPhotos', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: 'views/subViews/item-photos.html'
	};
});

appModule.directive('itemPopularity', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: 'views/subViews/item-popularity.html'
	};
});

appModule.directive('itemReport', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: 'views/subViews/item-report.html'
	};
});

appModule.directive('itemVideos', function(){
	return {
		restrict: 'E',
		scope: {
			catalogueItem: '=item'
		},
		templateUrl: 'views/subViews/item-videos.html'
	};
});