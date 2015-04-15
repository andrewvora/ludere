'use strict';

describe('Factory: userDataFactory', function(){
	var factory;

	beforeEach(function(){
	    module('ludereApp');
	    
	    inject(function(userDataFactory){
	      factory = userDataFactory;
	    });
	});

	it('should have the following functions', function(){
		expect(typeof(factory.getUser)).toEqual(typeof(function(){}));
	});	
});