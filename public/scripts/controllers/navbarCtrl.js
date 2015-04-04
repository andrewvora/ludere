'use strict';

appModule.controller('NavBarController', 
	['$scope', '$location', 'accountFactory',
	function($scope, $location, accountFactory){
		//if there's a currentUser check if they're logged in
		$scope.isLoggedIn;
		$scope.currentUser;
		$scope.myListHref = '';
		$scope.homeHref = '/';

		$scope.$on('logAction', function(event, msg){
			$scope.checkLoginStatus();
		});

		$scope.checkLoginStatus = function(){
			accountFactory.getCurrentUser()
			.success(function(data){
				if(data !== 'undefined'){
					$scope.currentUser = data;
					$scope.myListHref = '/user/' + data;
					$scope.homeHref = '/dashboard'
					
					accountFactory.isLoggedIn(data)
					.success(function(data){
						$scope.isLoggedIn = data == 'true' ? true : false;
					})
					.error(function(error){ console.log(error); });
				}
			})
			.error(function(error){ console.log(error); });
		};


		$scope.isActive = function(viewLocation){
			return $location.path() == viewLocation;
		};

		$scope.logout = function(){
			accountFactory.logout()
			.success(function(data){
				$scope.checkLoginStatus();
			})
			.error(function(error){
				console.log(error);
			});
		};

		$scope.logAction = function(){
			if($scope.isLoggedIn) {
				$scope.logout();
			}
			else {
				$location.path('/login');
			}
		};

		$scope.checkLoginStatus();
	}
]);