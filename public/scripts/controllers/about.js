'use strict';

/**
 * @ngdoc function
 * @name seenByMeApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the seenByMeApp
 */
angular.module('seenByMeApp')
  .controller('AboutCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
