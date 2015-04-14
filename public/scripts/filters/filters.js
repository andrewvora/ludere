
appModule.filter('monthNm', function($filter){
	return function(input){
		if(angular.isDefined(input)){
			return getMonthNm(input.getMonth());
		}
	}
});