'use strict';

appModule.controller('NavBarController', ['$scope', '$location', function($scope, $location){
	$scope.isActive = function(viewLocation){
		return $location.path() == viewLocation;
	};
}]);