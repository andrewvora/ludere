'use strict';

describe('Factory: accountFactory', function(){
	var factory;

	beforeEach(function(){
	    module('ludereApp');
	    
	    inject(function(accountFactory){
	      factory = accountFactory;
	    });
	});

	it('should have functions for setting and getting current user', function(){
		expect(typeof(factory.currentUser)).toEqual(typeof(function(){}));
		expect(typeof(factory.setCurrentUser)).toEqual(typeof(function(){}));
	});	

	it('should set the user just fine', function(){
		factory.setCurrentUser('BumpOfChicken');
		expect(factory.currentUser()).toBe('BumpOfChicken');
	});	

	it('should have the following functions', function(){
		expect(typeof(factory.createAccount)).toEqual(typeof(function(){}));
		expect(typeof(factory.login)).toEqual(typeof(function(){}));
		expect(typeof(factory.logout)).toEqual(typeof(function(){}));
		expect(typeof(factory.isLoggedIn)).toEqual(typeof(function(){}));
		expect(typeof(factory.getCurrentUser)).toEqual(typeof(function(){}));
		expect(typeof(factory.isUnique)).toEqual(typeof(function(){}));
	})
});