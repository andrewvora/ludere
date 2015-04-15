'use strict';

describe('Unit: AuthController', function () {
  var ctrl, scope;

  // load the controller's module
  beforeEach(module('ludereApp'));

  beforeEach(inject(function($rootScope, $controller){
    scope = $rootScope.$new();
    ctrl = $controller('AuthController', 
      { $scope: scope });
  }));

  it('should have the following defined variables', function(){		
  		expect(scope.genders).toEqual(['Male', 'Female', 'Custom']);
  });
});