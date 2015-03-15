'use strict';

describe('Unit: NavBarController', function () {
  var ctrl, scope, location;

  // load the controller's module
  beforeEach(module('seenByMe'));

  beforeEach(inject(function($rootScope, $location, $controller){
    scope = $rootScope.$new();
    location = $location;
    ctrl = $controller('NavBarController', { $scope: scope, $location: location });
  }));

  it('should be an actual controller', 
    function(){ expect(ctrl).toBeDefined(); });

  it('scope should be defined', function(){ expect(scope).toBeDefined(); });

  it('has a function for determining the active route', 
    function(){ 
      expect(scope.isActive).toBeDefined(); 
      expect(typeof(scope.isActive)).toBe("function");
    });

  it('s function for determining the active route should return true if passed the current route',
    function(){ 
      expect(scope.isActive(location.path())).toBe(true); 
    });
});