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
	$scope.catalogue = serverFactory.getAllCatalogueItems()
							.success(function(data){
								$scope.catalogue = data;
							})
							.error(function(error){});
}]);