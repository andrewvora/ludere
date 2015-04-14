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

	$scope.inputContent = {};
	$scope.inputContent.statuses = ['Watching','Plan to Watch','Completed'];
	$scope.inputContent.ratings = ['1 - :(', '2', '3', '4', '5', '6', '7', '8', '9', '10 - :D', '']
	
	$scope.showOptions;
	$scope.itemStatus;
	$scope.itemEpsWatched;
	$scope.itemRating;
	$scope.removeBtn;
	$scope.removeBtnClk;
	$scope.submitBtnTxt;

	$scope.addToListTxt;
	$scope.favBtnTxt;

	/* List Manipulating funcitons
	 ---------------------------------*/
	var updateUserCatalogue = function(){
		userFactory.updateUserCatalogueItem(accountFactory.currentUser(), $scope.catalogueItem._id,
			 $scope.itemRating === '' ? 
			 '-1' : 
			 $scope.inputContent.ratings.indexOf($scope.itemRating) + 1, 
			 $scope.itemStatus, $scope.itemEpsWatched
		)

		.success(function(data){
			$scope.isInUserCatalogue();
			$scope.toggleOptions();
		})
		.error(function(error){
			if(DEBUG) console.log(error);
		});
	};

	var removeFromUserFavorites = function(){
		userFactory.removeFromUserFavorites(accountFactory.currentUser(), $scope.catalogueItem._id)
		.success(function(data){
			$scope.isInUserFavorites();
		})
		.error(function(error){
			if(DEBUG) console.log(error);
		});
	};

	var addToUserFavorites = function(){
		userFactory.addToUserFavorites(accountFactory.currentUser(), $scope.catalogueItem._id)
		.success(function(data){
			$scope.isInUserFavorites();
		})
		.error(function(error){
			if(DEBUG) console.log(error);
		});	
	};

	var getCatalogueItem = function(id){
		catalogueFactory.getCatalogueItem(id)
		.success(function(data){
			$scope.catalogueItem = data;
			init();
		})
		.error(function(error){});	
	};


	$scope.isInUserFavorites = function(){
		userFactory.inUserFavorites(accountFactory.currentUser(), $scope.catalogueItem._id)
		.success(function(data){
			$scope.favBtnTxt = data === "true" ? "Favorited" : "Favorite";
		})
		.error(function(error){
			if(DEBUG) console.log(error);
		});
	};

	$scope.isInUserCatalogue = function(){
		userFactory.inUserCatalogue(accountFactory.currentUser(), $scope.catalogueItem._id)
		.success(function(data){
			$scope.addToListTxt = data === "true" ? "Edit" : "Add";
			$scope.removeBtn = data === "true";
			$scope.removeBtnClk = data === "false";
			$scope.submitBtnTxt = data === "true" ? "Update" : "Add";
			$scope.itemEpsWatched = 0;

			if(data === "true") userFactory.getFromUserCatalogue(accountFactory.currentUser(), $scope.catalogueItem._id)
			.success(function(data){
				$scope.itemStatus = data.status;
				$scope.itemRating = data.rating === '' ? '' : $scope.inputContent.ratings[data.rating - 1];
				$scope.itemEpsWatched = parseInt(data.episodesWatched);
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		})
		.error(function(error){
			if(DEBUG) console.log(error);
		});
	};

	$scope.removeCheck = function(toggle){
		$scope.removeBtnClk = !$scope.removeBtnClk;
		if(toggle == 'yes'){
			$scope.toggleOptions();
		}
	};
	
	$scope.toggleOptions = function(){
		$scope.showOptions = !$scope.showOptions;
	};

	$scope.updateUserList = function(){
		if(!$scope.itemStatus){
			alert("Please set required fields");
			return;
		}

		if($scope.addToListTxt === 'Edit'){
			updateUserCatalogue();
		}
		else {
			userFactory.addToUserCatalogue(accountFactory.currentUser(), $scope.catalogueItem._id,
			 $scope.itemRating || -1, $scope.itemStatus, $scope.itemEpsWatched || 0)
			
			.success(function(data){
				$scope.isInUserCatalogue();
				$scope.toggleOptions();
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		}
	};

	$scope.removeFromUserList = function(){
		userFactory.removeFromUserCatalogue(accountFactory.currentUser(), $scope.catalogueItem._id)
		.success(function(data){
			removeFromUserFavorites();
			$scope.isInUserCatalogue();
			$scope.toggleOptions();
			$scope.removeCheck();
		})
		.error(function(error){
			if(DEBUG) console.log(error);
		});
	};

	$scope.updateUserFavorites = function(){
		if($scope.favBtnTxt === "Favorited"){
			removeFromUserFavorites();
		}
		else {
			addToUserFavorites();
		}
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
				getCatalogueItem(params.attr);
				break;
		}
	};

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
		catalogueFactory.getAllUsers()
		.success(function(data){
			$scope.catalogue = data;
		})
		.error(function(error){});
	};

	/* Initialization
	 ---------------------------------*/
	 var init = function(){
	 	if(!accountFactory.currentUser()){
	 		accountFactory.getCurrentUser()
	 		.success(function(data){
	 			accountFactory.setCurrentUser(data);
	 			$scope.isInUserFavorites();
	 			$scope.isInUserCatalogue();
	 		})
	 		.error(function(error){
	 			if(DEBUG) console.log(error);
	 		});
	 	}
	 	else {
	 		$scope.isInUserFavorites();
	 	}
	 };


	$scope.getDocumentById();

}]);