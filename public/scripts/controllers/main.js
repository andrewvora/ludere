'use strict';

/**
 * @ngdoc controllers
 * @name HomePageController
 * @description
 * # seenByMeApp
 *
 * Controller for the default view for the app
 */

appModule.controller('HomePageController', ['$scope', 'serverFactory', function($scope, serverFactory){
	$scope.serverMessage = serverFactory.getServerMessage()
							.success(function(data){
								$scope.serverMessage = data;
							})
							.error(function(error){});
}]);