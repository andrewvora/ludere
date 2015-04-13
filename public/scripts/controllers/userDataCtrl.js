appModule.controller('UserDataController', 
	function($scope, accountFactory, userDataFactory){
		$scope.userData;

		/**
 		 * Get the user data for the current user
		 */
		$scope.getUserData = function(callback){
			userDataFactory.getUser(accountFactory.currentUser())
			.success(function(data){
				callback(data);
				$scope.userData = data;
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		};

		/**
 		 * Given that user data is provided, render the appropriate charts
		 */
		$scope.renderUserData = function(data){

		};

		$scope.init = function(){
			if(!accountFactory.currentUser()){
				accountFactory.getCurrentUser()
				.success(function(data){
					accountFactory.setCurrentUser(data);
					$scope.currentUser = data;
					$scope.getUserData($scope.renderUserData);
				})
				.error(function(error){
					if(DEBUG) console.log(error);
				});
			}
			else {
				$scope.getUserData($scope.renderUserData);
			}
		}

		$scope.init();
	}
);