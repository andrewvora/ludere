appModule.controller('DashController', 
	['$scope', '$routeParams', 'accountFactory',  'userFactory', 'catalogueFactory',
	function($scope, $routeParams, accountFactory, userFactory, catalogueFactory){
		$scope.user = {};
		$scope.isCurrentUser;
		$scope.currentUser;

		$scope.randItem;
		$scope.userRecent;
		$scope.catRecent;

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

		$scope.setUserRecent = function(user,max){
			userFactory.getUserRecentList(user)
			.success(function(data) {
				//console.log(data);
				var i = 0;
				$scope.userRecent = {};
				for(var d in data){
					if(i >= 0 && i < max){
						$scope.userRecent[d] = data[d];
						i++;
					}
					else
						break;
				}
				//console.log($scope.userRecent);
				catalogueFactory.getCatalogueItems($scope.userRecent)
				.success(function(catItem){
					console.log($scope.userRecent,catItem);
					var i = 0;
					for(var item in $scope.userRecent){
						if($scope.userRecent[item] != undefined){
							$scope.userRecent[item].title = catItem[i]['title'];
							i++;
						}
						else{
							if(DEBUG) console.log("userRecent item undefined");

							$scope.userRecent[item].title = "Unknown";
							i++;
						}
					}

				})
				.error(function(error){
					if(DEBUG) console.log(error);
				});
				//can attach picture here when get data
				
				
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		}

		$scope.setCatalogueRecent = function(max){
			catalogueFactory.getRecentUpdate()
			.success(function(data){
				//console.log(data);
				var i = 0;
				$scope.catRecent = {};
				for(var d in data[0]){
					if(i >= 0 && i < max){
						$scope.catRecent[d] = data[0][d];
						i++;
						//console.log(i,data[0][d]['_id']);
					}
					else
						break;
					
				}
				//console.log($scope.catRecent);
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
						$scope.user.name = data.username;
						$scope.user.gender = data.gender;
						//$scope.user.lastUpdated = data;
						$scope.user.location = data.country;
						$scope.user.lists = data.catalogueItems;
						$scope.setUserRecent($scope.user.name,2);
					})
					.error(function(error){
						if(DEBUG) console.log(error);
					});
				})
				.error(function(error){
					if(DEBUG) console.log(error);
				});
			}//end-if
			$scope.setCatalogueRecent(4);
			$scope.checkViewer();
			$scope.setRandItem();
		};

		$scope.init();
	}]);