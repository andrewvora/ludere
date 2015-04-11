appModule.controller('UserController', 
	function($scope, $upload, $routeParams, accountFactory, userFactory, catalogueFactory){
		$scope.user = {};
		$scope.userData;
		$scope.isCurrentUser;
		$scope.currentUser;

		$scope.tab = "about";

		$scope.checkViewer = function(){
			var params = $routeParams;
			if(params.username){
				accountFactory.getCurrentUser()
				.success(function(data){
					$scope.currentUser = data;
					$scope.isCurrentUser = data == params.username;
				})
				.error(function(error){
					if(DEBUG) console.log(error);
				});
			}
		};

		var getCatalogueItems = function(catalogue, out){
			catalogueFactory.getCatalogueItems(catalogue)
			.success(function(data){
				switch(out){
					case "favorites":
						$scope.user.favorites = data; 
						break;
						
					case "catalogue":
						$scope.user.list = data;
						break;
				}
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		};

		/**
 		 * Update the user's profile fields
		 */
		$scope.updateUser = function(){
			userFactory.updateProfile($scope.user.name, 
				$scope.user.email, 
				$scope.user.firstName, 
				$scope.user.lastName, 
				$scope.user.gender, 
				$scope.user.dob, 
				$scope.user.about, 
				$scope.user.city || '', 
				$scope.user.state || '', 
				$scope.user.state || '', 
				$scope.user.country || '')
			.success(function(data){
				console.log(data);
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		};

		/**
		 * Update the user's profile picture
		 */
		 $scope.updateUserPicture = function($files){
		 	var file = $files[0];
			$upload.upload({
				url: server_url + 'user/' + $scope.currentUser + '/update/profile/upload/picture',
				fields: { 'uploadedFile' : $scope.myModelObj},
				file: file
			})
		 	.progress(function(event){
		 		console.log(event.loaded/event.loaded*100 + '%');
		 	})
		 	.success(function(data){
		 		if(DEBUG) console.log(data);
		 	})
		 	.error(function(error){
		 		if(DEBUG) console.log(error);
		 	});
		 };

		/**
 		 * Get the user data for the current user
		 */
		$scope.getUserData = function(){

		};

		/**
 		 * Given that user data is provided, render the appropriate charts
		 */
		$scope.renderUserData = function(){

		};

		/**
 		 * Main execution loop for the controller
		 */
		$scope.init = function(){
			var params = $routeParams;
			if(params.username){
				accountFactory.getCurrentUser()
				.success(function(username){
					userFactory.getUser(username)
					.success(function(data){
						if(DEBUG) console.log(data);
						$scope.user = data;
						$scope.user.about = 
							$scope.user.about ? data.about : data.username + " hasn't written anything about themselves, yet.";
						$scope.user.name = data.username;
						$scope.user.gender = data.gender;
						$scope.user.birthday = getDate(data.birthday);
						$scope.user.lastActivity = data.lastActivity;
						$scope.user.location = data.country;
						getCatalogueItems(data.catalogueItems, "catalogue");
						getCatalogueItems(data.favorites, "favorites");
					})
					.error(function(error){
						if(DEBUG) console.log(error);
					});
				})
				.error(function(error){
					if(DEBUG) console.log(error);
				});
			}//end-if

			$scope.checkViewer();
		};

		$scope.init();
	});