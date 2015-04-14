'use strict';

/* App Constants ------------------------------------ */
var server_res_url = "http://192.168.56.101/app/";
var server_url = "http://192.168.56.101/app/index.php/";
var DEBUG = true;

var getDate = function(dtStr){
	var dt = dtStr.split(/[- :]/);
	return new Date(dt[3], getMonthNum(dt[1]), dt[2], dt[4], dt[5], dt[6]);
};

var getMonthNum = function(monthNm){
	var months = {
		'Jan' : 0,
		'Feb' : 1,
		'Mar' : 2,
		'Apr' : 3,
		'May' : 4,
		'Jun' : 5,
		'Jul' : 6,
		'Aug' : 7,
		'Sep' : 8,
		'Oct' : 9,
		'Nov' : 10,
		'Dec' : 11,
	};
	return months[monthNm];
};

var getMonthNm = function(monthNum){
	var months = [
		'Jan',
		'Feb',
		'Mar',
		'Apr',
		'May',
		'Jun',
		'Jul',
		'Aug',
		'Sep',
		'Oct',
		'Nov',
		'Dec'
	];
	return months[monthNum]
}
