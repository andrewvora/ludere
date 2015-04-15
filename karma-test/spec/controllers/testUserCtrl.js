'use strict';

describe('Unit: UserController', function () {
  var ctrl, scope;

  // load the controller's module
  beforeEach(module('ludereApp'));

  beforeEach(inject(function($rootScope, $controller){
    scope = $rootScope.$new();
    ctrl = $controller('UserController', 
      { $scope: scope });
  }));

  it('should have the following defined variables', function(){   
      expect(typeof(scope.user)).toEqual(typeof({}));
  });

  it('should have the following functions', function(){
    expect(typeof(scope.showInfo)).toEqual(typeof(function(){}));
    expect(typeof(scope.hideInfo)).toEqual(typeof(function(){}));
    expect(typeof(scope.checkViewer)).toEqual(typeof(function(){}));
    expect(typeof(scope.updateUser)).toEqual(typeof(function(){}));
    expect(typeof(scope.updateUserPicture)).toEqual(typeof(function(){}));
    expect(typeof(scope.init)).toEqual(typeof(function(){}));
  });
});