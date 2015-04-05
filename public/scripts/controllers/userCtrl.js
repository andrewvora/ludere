appModule.controller('UserController', 
	['$scope', '$routeParams', 'accountFactory',  'userFactory',
	function($scope, $routeParams, accountFactory, userFactory){
		$scope.user = {};
		$scope.userData;
		$scope.isCurrentUser;
		$scope.currentUser;

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

		/**
 		 * Update the user's profile fields
		 */
		$scope.updateUser = function(){

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
						$scope.user.name = data.username;
						$scope.user.gender = data.gender;
						//$scope.user.lastUpdated = data;
						$scope.user.location = data.country;
						$scope.user.lists = data.catalogueItems;
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
	}]);