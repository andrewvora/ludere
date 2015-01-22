'use strict';

/**
 * @ngdoc overview
 * @name seenByMeApp
 * @description
 * # seenByMeApp
 *
 * Main module of the application.
 */
angular
  .module('seenByMe', [
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch'
  ])
  .config(function ($routeProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'MainCtrl'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
