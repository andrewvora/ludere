'use strict';

appModule.controller('CatalogueController', ['$scope', '$routeParams', 'catalogueFactory', 'accountFactory', 'userFactory', 
	function($scope, $routeParams, catalogueFactory, accountFactory, userFactory){
	/* Controller Members
	 ---------------------------------*/
	$scope.catalogue;
	$scope.catalogueItem;
	$scope.title = "";
	$scope.tab = "description";
	$scope.category;

	$scope.statuses = ['Watching','Plan to Watch','Completed'];
	$scope.ratings = ['10 - The Best!', '9', '8', '7', '6', '5', '4', '3', '2', '1 - The Worst...']
	
	$scope.uRating;
	$scope.uEpCnt;
	$scope.uStatus;

	$scope.show;
	$scope.added;
	$scope.faved;

	/* List Manipulating funcitons
	 ---------------------------------*/
	$scope.showCorrectAOut = function(){
		if($scope.added == true){
			$scope.show = 'unList';
		}
		else{
			$scope.show = 'toList';
		}
	}

	$scope.showCorrectFOut = function(){
		if($scope.faved == true){
			$scope.show = 'unFav';
		}
		else{
			$scope.show = 'toFav';
		}
	}

	$scope.actionToUserList = function(){
		//console.log("Tried to add to list");
		accountFactory.getCurrentUser()
		.success(function(username){
			userFactory.inUserCatalogue(username,$scope.catalogueItem._id)
			.success(function(inUserCat){
				//console.log(data);
				if(inUserCat == 'true' && $scope.show == "unList"){
					//console.log("Already in user catalogue");
					userFactory.removeFromUserCatalogue(username,$scope.catalogueItem._id)
					.success(function(data){
						//console.log(data);
						if(data == 'true'){
							$scope.added = false;
						}
						else{
							$scope.added = true;
							//console.log("remove failed");
						}

					})
					.error(function(error){
						console.log(error);
					});
				}
				else if(inUserCat == 'false' && $scope.show == "toList"){
					//console.log("Not in user catalogue");
					userFactory.addToUserCatalogue(username,$scope.catalogueItem._id,$scope.uRating,$scope.uStatus,$scope.uEpCnt)
					.success(function(data){
						//console.log(data);
						if(data === 'true'){
							$scope.added = true;

						}
						else{
							$scope.added = false;
						}

					})
					.error(function(error){
						console.log(error);

					});
				}
				else{
					
				}
			})
			.error(function(error){
				console.log(error);

			});
		})
		.error(function(error){
			console.log(error);
		});
	};

	$scope.actionToUserFavs = function(){
		console.log("Tried to add to favs");
		accountFactory.getCurrentUser()
		.success(function(username){
			userFactory.inUserFavorites(username,$scope.catalogueItem._id)
			.success(function(isInFav){
				console.log($scope.show);
				if(isInFav == 'true' && $scope.show == 'unFav'){
					//console.log("Already in user favs");
					userFactory.removeFromUserFavorites(username,$scope.catalogueItem._id)
					.success(function(data){
						console.log(data);
						if(data === 'true'){
							$scope.faved = false;

						}
						else{
							$scope.faved = true;
						}
						
					})
					.error(function(error){
						console.log(error);

					});
				}
				else if(isInFav == 'false' && $scope.show == 'toFav'){
					//console.log("Not in user favs");
					userFactory.addToUserFavorites(username,$scope.catalogueItem._id)
					.success(function(data){
						//console.log(data);
						if(data === 'true'){
							$scope.faved = true;

						}
						else{
							$scope.faved = false;
						}
						
					})
					.error(function(error){
						console.log(error);

					});
				}
				else{
					console.log("Probably pressed yes button more than once without page refresh...");
					//console.log("got here by data = " + isInFav + "and show = " + $scope.show);
				}
			})
			.error(function(error){
				console.log(error);

			});
		})
		.error(function(error){
			console.log(error);
		});
	};


	/* External API Calls
	 ---------------------------------*/
	$scope.getCatalogueOf = function(){
		$scope.catalogue = {};
		var params = $routeParams;

		//assign the appropriate value to category
		switch(params.type){
			case "all":
			case "movies":
			case "series":
			case "web":
				$scope.category = 0;
				break;

			case "people":
				$scope.category = 1;
				break;

			case "companies":
				$scope.category = 2;
				break;

			case "users":
				$scope.category = 3;
				break;
		}

		//call the appropriate method and set title
		switch(params.type){
			case "all":
				getAllCatalogueItems();
				$scope.title = "All Items";
				break;
			case "movies":
				getAllMovies();
				$scope.title = "All Movies";
				break;
			case "series":
				getAllTvShows();
				$scope.title = "All TV Series";
				break;
			case "web":
				getAllWebSeries();
				$scope.title = "All Web Series";
				break;
			case "companies":
				$scope.title = "All Companies";
				break;

			case "people":
				$scope.title = "All People";
				break;

			case "users":
				$scope.title = "All Users";
				break;
		}
	};

	$scope.getDocumentById = function(){
		var params = $routeParams;
		switch(params.type){
			case "item":
				catalogueFactory.getCatalogueItem(params.attr)
				.success(function(data){
					$scope.catalogueItem = data;

					accountFactory.getCurrentUser()
					.success(function(username){
						userFactory.inUserCatalogue(username,$scope.catalogueItem._id)
						.success(function(data){
							console.log("data in initial test ");
							console.log(data);
							if(data == 'true'){
								$scope.added = true;
							}
							else{
								$scope.added = false;
							}
						})
						.error(function(error){
							console.log(error);

						});

						userFactory.inUserFavorites(username,$scope.catalogueItem._id)
						.success(function(data){
							console.log(data)
							if(data == 'true'){
								$scope.faved = true;
							}
							else{
								$scope.faved = false;
							}							
						})
						.error(function(error){
							console.log(error);

						});
					})
					.error(function(error){
						console.log(error);
					});
				})
				.error(function(error){});	
				break;
		}
	}

	/* Explicit API Calls
	 ---------------------------------*/
	var getAllCatalogueItems = function(){
		catalogueFactory.getAllCatalogueItems()
			.success(function(data){
				$scope.catalogue = data;
			})
			.error(function(error){});
	};

	var getAllMovies = function(){
		catalogueFactory.getAllMovies()
			.success(function(data){
				$scope.catalogue = data;
			})
			.error(function(error){});
	};

	var getAllTvShows = function(){
		catalogueFactory.getAllTvShows()
			.success(function(data){
				$scope.catalogue = data;
			})
			.error(function(error){});
	};

	var getAllWebSeries = function(){
		catalogueFactory.getAllWebSeries()
			.success(function(data){
				$scope.catalogue = data;
			})
			.error(function(error){});
	}

	var getAllUsers = function(){
		//the behavior for this will be different
		//will define later
	};

}]);