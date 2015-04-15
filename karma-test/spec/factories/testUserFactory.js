'use strict';

describe('Factory: userFactory', function(){
	var factory;

	beforeEach(function(){
	    module('ludereApp');
	    
	    inject(function(userFactory){
	      factory = userFactory;
	    });
	});

	it('should have the following functions', function(){
		expect(typeof(factory.getUser)).toBe(typeof(function(){}));
		expect(typeof(factory.addToUserCatalogue)).toBe(typeof(function(){}));
		expect(typeof(factory.updateUserCatalogueItem)).toBe(typeof(function(){}));
		expect(typeof(factory.getFromUserCatalogue)).toBe(typeof(function(){}));
		expect(typeof(factory.removeFromUserCatalogue)).toBe(typeof(function(){}));
		expect(typeof(factory.inUserCatalogue)).toBe(typeof(function(){}));
		expect(typeof(factory.addToUserFavorites)).toBe(typeof(function(){}));
		expect(typeof(factory.removeFromUserFavorites)).toBe(typeof(function(){}));
		expect(typeof(factory.inUserFavorites)).toBe(typeof(function(){}));
		expect(typeof(factory.updateProfile)).toBe(typeof(function(){}));
		expect(typeof(factory.getProfilePicture)).toBe(typeof(function(){}));
	});	
});