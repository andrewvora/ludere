'use strict';

/**
 * @ngdoc function
 * @name seenByMeApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the seenByMeApp
 */
angular.module('seenByMeApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
