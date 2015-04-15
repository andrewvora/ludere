'use strict';

/* App Constants ------------------------------------ */
var server_res_url = "http://192.168.56.101/app/";
var server_url = "http://192.168.56.101/app/index.php/";
var DEBUG = true;
var util = {};

var getDate = function(dtStr){
	var dt = dtStr.split(/[- :]/);
	console.log(dtStr, dt);
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

util.renderAlert = function(greeting, msg, alertClass){
	var el = document.getElementById('main-content').firstChild;

	//create the elements for the alert
	var closeBtn = document.createElement('button');
	closeBtn.setAttribute('type', 'button');
	closeBtn.setAttribute('class', 'close');
	closeBtn.setAttribute('data-dismiss', 'alert');
	closeBtn.setAttribute('aria-label', 'Close');
	closeBtn.innerHTML = "<span aria-hidden='true'>&times;</span>";

	var alertDiv = document.createElement('div');
	alertDiv.setAttribute('class', 'alert ' + alertClass + ' alert-dismissable');
	alertDiv.setAttribute('role', 'alert');

	var gotchaEl = document.createElement('strong');
	gotchaEl.innerHTML = greeting;

	//add the elements in appropriate order
	alertDiv.appendChild(closeBtn);
	alertDiv.appendChild(gotchaEl);
	alertDiv.innerHTML += " " + msg;

	//make sure it's the first element in the view
	el.appendChild(alertDiv);
	el.insertBefore(alertDiv, el.firstChild);
};
