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
        templateUrl: 'views/alternate/product_pitch.html',
        controller: 'HomePageController'
      })
      .when('/dashboard/:username', {
        templateUrl: 'views/dashboard.html',
        controller: 'DashController'
      })
      .when('/list', { //directs to an advert
        templateUrl: 'views/user_list.html'
      })
      
      //CATALOGUE RELATED ROUTES
      .when('/catalogue/:type', {
        templateUrl: 'views/catalogue_list.html',
        controller: 'CatalogueController'
      })
      .when('/catalogue/:type/:attr', {
        templateUrl: 'views/items/catalogue_item.html',
        controller: 'CatalogueController'
      })

      //ACCOUNT RELATED ROUTES
      .when('/signup', {
        templateUrl: 'views/signup.html'
      })
      .when('/login', {
        templateUrl: 'views/login.html'
      })

      //USER ROUTES
      .when('/user/:username', {
        templateUrl: 'views/user/user.html'
      })
      .when('/user/:username/edit', {
        templateUrl: 'views/user/user_edit.html' 
      })
      .when('/user/:username/list', {
        templateUrl: 'views/user/user_list.html'
      })
      .when('/user/:username/settings', {
        templateUrl: 'views/user/user_settings.html'
      })

      //OTHERWISE
      .otherwise({
        redirectTo: '/404',
        templateUrl: '404.html'
      });
  });
