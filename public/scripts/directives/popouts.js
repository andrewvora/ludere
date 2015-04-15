
var ppDir = "views/common/";

appModule.directive('mailPopup', function(){
	return {
		restrict: 'E',
		templateUrl: ppDir+'mail-popup.html'
	};
});