appModule.controller('DashController', 
	['$scope', '$routeParams', 'accountFactory',  'userFactory', 'catalogueFactory',
	function($scope, $routeParams, accountFactory, userFactory, catalogueFactory){
		$scope.user = {};
		$scope.isCurrentUser;
		$scope.currentUser;

		$scope.randItem;
		$scope.userRecent;
		$scope.catRecent;

		$scope.showInfo = function(id){
			var el = document.getElementById(""+id);
			el.style.visibility = "visible";
		}

		$scope.hideInfo = function(id){
			var el = document.getElementById(""+id);
			el.style.visibility = "hidden";
		};

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
					var i = 0;
					for(var item in $scope.userRecent){
						if($scope.userRecent[item] != undefined){
							$scope.userRecent[item].title = catItem[i]['title'];
							$scope.userRecent[item].picture = catItem[i]['picture'];
							$scope.userRecent[item].plotShort = catItem[i]['plotShort'];
							i++;
						}
						else{
							if(DEBUG) console.log("userRecent item undefined");

							$scope.userRecent[item].title = "Unknown";
							$scope.userRecent[item].picture = "http://placehold.it/500x500";

							i++;
						}
					}

				})
				.error(function(error){
					if(DEBUG) console.log(error);
				});
			
				
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		}

		$scope.setCatalogueRecent = function(max){
			catalogueFactory.getRecentUpdate()
			.success(function(data){
				var i = 0;
				$scope.catRecent = {};
				for(var d in data){
					if(i >= 0 && i < max){
						$scope.catRecent[d] = data[d];
						//console.log(d,data[d]['lastAdd']);
						i++;
					}
					else
						break;
					
				}
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
						$scope.setUserRecent($scope.user.name,3);
					})
					.error(function(error){
						if(DEBUG) console.log(error);
					});
				})
				.error(function(error){
					if(DEBUG) console.log(error);
				});
			}//end-if
			$scope.setCatalogueRecent(6);
			$scope.checkViewer();
			$scope.setRandItem();
		};

		$scope.init();
	}]);