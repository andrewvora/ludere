'use strict';

appModule.controller('NavBarController',
	function($scope, $location, accountFactory, userFactory){
		//if there's a currentUser check if they're logged in
		$scope.isLoggedIn;
		$scope.currentUser;
		$scope.myListHref = '';
		$scope.homeHref = '/';
		$scope.profilePic;

		$scope.$on('logAction', function(event, msg){
			$scope.checkLoginStatus();
		});

		$scope.checkLoginStatus = function(){
			accountFactory.getCurrentUser()
			.success(function(data){
				if(data !== 'undefined'){
					$scope.currentUser = data;
					$scope.myListHref = '/user/' + data;
					$scope.homeHref = '/dashboard/'+data;
					$scope.getProfilePicture(data);
					
					accountFactory.isLoggedIn(data)
					.success(function(data){
						$scope.isLoggedIn = data == 'true' ? true : false;
					})
					.error(function(error){ 
						if(DEBUG) console.log(error); 
					});
				}
			})
			.error(function(error){ 
				if(DEBUG) console.log(error); 
			});
		};


		$scope.isActive = function(viewLocation){
			return $location.path() == viewLocation;
		};

		$scope.logout = function(){
			accountFactory.logout()
			.success(function(data){
				$scope.isLoggedIn = data === 'true' ? false : true;
				$scope.homeHref = '/';
				$scope.myListHref = '';
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		};

		$scope.logAction = function(){
			if($scope.isLoggedIn) {
				$scope.logout();
				$location.path('/');
			}
			else {
				$location.path('/login');
			}
		};

		$scope.getProfilePicture = function(username){
			userFactory.getProfilePicture(username)
			.success(function(data){
				$scope.profilePic = data;
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		};

		$scope.checkLoginStatus();
	}
);