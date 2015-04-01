appModule.controller('UserController', 
	['$scope', '$routeParams', 'accountFactory',  'userFactory',
	function($scope, $routeParams, accountFactory, userFactory){
		$scope.user = {};
		$scope.isCurrentUser;
		$scope.currentUser;

		$scope.checkViewer = function(){
			var params = $routeParams;
			if(params.username){
				accountFactory.getCurrentUser()
				.success(function(data){
					$scope.isCurrentUser = data == params.username;
					$scope.currentUser = params.username;
				})
				.error(function(error){
					if(DEBUG) console.log(error);
				});
			}
		};

		$scope.updateUser = function(){

		};

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