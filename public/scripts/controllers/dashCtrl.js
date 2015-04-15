appModule.controller('DashController', 
	['$scope', '$routeParams', 'accountFactory',  'userFactory', 'catalogueFactory',
	function($scope, $routeParams, accountFactory, userFactory, catalogueFactory){
		$scope.user = {};
		$scope.isCurrentUser;
		$scope.currentUser;

		$scope.randItem;

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
		
		$scope.setRandItem = function(){
			catalogueFactory.getRandomItem()
			.success(function(data){
				$scope.randItem = data;
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		}

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
						console.log(data);
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
			$scope.setRandItem();
		};

		$scope.init();
	}]);