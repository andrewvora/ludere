'use strict';

describe('Unit: UserDataController', function () {
  var ctrl, scope;

  // load the controller's module
  beforeEach(module('ludereApp'));

  beforeEach(inject(function($rootScope, $controller){
    scope = $rootScope.$new();
    ctrl = $controller('UserDataController', 
      { $scope: scope });
  }));

  it('should have the following functions', function(){
    expect(typeof(scope.getUserData)).toEqual(typeof(function(){}));
    expect(typeof(scope.renderUserData)).toEqual(typeof(function(){}));
    expect(typeof(scope.init)).toEqual(typeof(function(){}));
  });
});