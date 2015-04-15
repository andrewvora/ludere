'use strict';

describe('Directive: mailPopup', function () {
   var element, $httpBackend;

  // load the controller's module
  beforeEach(function(){
      module('ludereApp');
      element = angular.element('<mail-popup/>');
      inject(function($compile, $rootScope, $injector){
      	$httpBackend = $injector.get('$httpBackend');
      	$httpBackend.whenGET('views/common/mail-popup.html').respond(200, '');

      	var scope = $rootScope.$new();
        $compile(element)(scope);
        scope.$digest();
      });
    }
  );

  it('should have a view', function(){
  	expect(element.text()).toEqual("");
  });

});