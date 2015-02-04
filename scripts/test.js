for(i = 108770; i < 108800; i++){
var id = i.toString();

var url = 'http://www.omdbapi.com/?i=tt0' + id + '&plot=short&r=json';

require('http').get(url, function(data) {
	var body = '';

	data.on('data', function(chunk){
		body += chunk;
	});

	data.on('end', function(){
		console.log(body);
	});
});

function posting(url){
require('http').post(url, function(data) {
	var error = '';

	data.on('data', function(chunk){
		error += chunk;
	});

	data.on('end', function(){
		console.log(error);
	});
});
}
