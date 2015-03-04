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
        templateUrl: 'views/altViews/product_pitch.html',
        controller: 'HomePageController'
      })
      
      <!---->
      .when('/catalogue/:type', {
        templateUrl: 'views/catalogue_list.html',
        controller: 'CatalogueController'
      })
      .when('/catalogue/:type/:attr', {
        templateUrl: 'views/catalogue_item.html',
        controller: 'CatalogueController'
      })

      <!---->
      .when('/profile', {
        templateUrl: 'views/profile.html'
      })
      .when('/signup', {
        templateUrl: 'views/signup.html'
      })
      .when('/login', {
        templateUrl: 'views/login.html'
      })
      .otherwise({
        redirectTo: '/'
      });
  });
