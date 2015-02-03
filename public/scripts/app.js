'use strict';

/**
 * @ngdoc overview
 * @name appModule
 * @description
 * # seenByMeApp
 *
 * Main module of the application.
 */
var appModule = angular.module('seenByMe', [
    'ngCookies',
    'ngResource',
    'ngRoute',
    'ngSanitize',
    'ngTouch'
  ])
  .config(function ($routeProvider, $locationProvider) {
    $routeProvider
      .when('/', {
        templateUrl: 'views/main.html',
        controller: 'HomePageController'
      })
      .otherwise({
        redirectTo: '/'
      });

      $locationProvider.html5Mode(true);
  });
