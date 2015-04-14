'use strict';

describe('Unit: HomePageController', function () {
  var ctrl, scope;

  // load the controller's module
  beforeEach(module('ludereApp'));

  beforeEach(inject(function($rootScope, $controller){
    scope = $rootScope.$new();
    ctrl = $controller('HomePageController', { $scope: scope });
  }));

  it('should be an actual controller.', 
    function(){
      expect(ctrl).toBeDefined();
    }
  );

  it('scope should be defined', 
    function(){ expect(scope).toBeDefined(); });

});
