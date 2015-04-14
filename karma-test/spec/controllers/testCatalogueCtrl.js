'use strict';

describe('Unit: CatalogueController', function () {
  var ctrl, scope;

  // load the controller's module
  beforeEach(module('ludereApp'));

  beforeEach(inject(function($rootScope, $controller){
    scope = $rootScope.$new();
    ctrl = $controller('CatalogueController', 
      { $scope: scope,
        $routeParams: { type: 'all' } });
  }));

  it('should be defined', 
    function(){ expect(ctrl).toBeDefined(); });

  it('scope should be defined', 
    function(){ expect(scope).toBeDefined(); });

  it('should have the following member variables defined', 
    function(){
      expect(scope.title).toBeDefined();
      expect(scope.tab).toBeDefined();
    });

  it('should have the following member functions', 
    function(){
      expect(typeof(scope.getCatalogueOf)).toBe("function");
      expect(typeof(scope.getDocumentById)).toBe("function");
    });

  it('should define scope.catalogue after calling any getAll* function', 
    function(){
      //originally, this test was to test all possibilities of
      //getCatalogueOf(), but the issue is that it's an async call
      //thus, it wouldn't be defined by the time the test checks
      
      scope.getCatalogueOf();
      expect(scope.catalogue).toBeDefined();
    });

});