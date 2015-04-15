'use strict';

describe('Unit: DashController', function () {
  var ctrl, scope;

  // load the controller's module
  beforeEach(module('ludereApp'));

  beforeEach(inject(function($rootScope, $controller){
    scope = $rootScope.$new();
    ctrl = $controller('DashController', 
      { $scope: scope });
  }));

  it('should have the following defined variables', function(){		
  		expect(typeof(scope.user)).toEqual(typeof({}));
  });

  it('should have the following functions', function(){
    expect(typeof(scope.checkViewer)).toEqual(typeof(function(){}));
    expect(typeof(scope.setRandItem)).toEqual(typeof(function(){}));
    expect(typeof(scope.init)).toEqual(typeof(function(){}));
  });
});