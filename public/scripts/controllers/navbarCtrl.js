'use strict';

appModule.controller('NavBarController', ['$location', function($scope, $location){
	$scope.isActive = function(viewLocation){
				return $location.path() == viewLocation;
	};
}]);