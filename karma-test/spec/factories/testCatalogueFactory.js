'use strict';

describe('Factory: catalogueFactory', function(){
	var factory;

	beforeEach(function(){
	    module('ludereApp');
	    
	    inject(function(catalogueFactory){
	      factory = catalogueFactory;
	    });
	});

	it('should have the following functions', function(){
		expect(typeof(factory.getAllCatalogueItems)).toEqual(typeof(function(){}));
		expect(typeof(factory.getAllTvShows)).toEqual(typeof(function(){}));
		expect(typeof(factory.getAllMovies)).toEqual(typeof(function(){}));
		expect(typeof(factory.getAllWebSeries)).toEqual(typeof(function(){}));
		expect(typeof(factory.getAllUsers)).toEqual(typeof(function(){}));
		expect(typeof(factory.getCatalogueItem)).toEqual(typeof(function(){}));
		expect(typeof(factory.getCatalogueItems)).toEqual(typeof(function(){}));
		expect(typeof(factory.getRandomItem)).toEqual(typeof(function(){}));
	});	
});