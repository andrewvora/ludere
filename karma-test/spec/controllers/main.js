'use strict';

describe('Unit: HomePageController', function () {

  // load the controller's module
  beforeEach(module('seenByMe'));

  var ctrl, scope;

  beforeEach(inject(function($controller, $rootScope){
    scope = $rootScope.$new();
    ctrl = $controller('HomePageController', { $scope: scope });
  }));

  it('should have an array of catalogue items called $scope.catalogue', 
    function(){
      var catalogue = scope.catalogue;
      expect(catalogue).toBeDefined();
    }
  );
});
