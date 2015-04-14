appModule.controller('UserDataController', 
	function($scope, accountFactory, userDataFactory){
		$scope.userData;

		var renderPieChart = function(obj){
			var chartEl = document.getElementById('ratioChart');
			var width = chartEl.parentElement.offsetWidth;
			var height = width * 0.550;
			var radius = height/2;
			var color = d3.scale.category20c();

			//get the labels and values
			var data = [];
			for(var item in obj){
				data.push({'label': item, 'value': obj[item] });
			}

			var chart = d3.select('#ratioChart').append("svg:svg")
				.data([data])
				.attr("width", '75%')
				.attr("height", '75%')
				.attr('viewBox','0 0 '+Math.min(width,height)+' '+Math.min(width,height))
				.attr('preserveAspectRatio','xMinYMin')
				.append("svg:g")
				.attr("transform", "translate(" + Math.min(width,height) / 2 + "," + Math.min(width,height) / 2 + ")");

			var pieChart = d3.layout.pie().value(function(data){ return data.value; });
			var arc = d3.svg.arc().outerRadius(radius);

			var arcs = chart.selectAll("g.slice").data(pieChart).enter().append("svg:g").attr("class", "slice");
			arcs.append("svg:path")
			    .attr("fill", function(d, i){
			        return color(i);
			    })
			    .attr("d", function (d) {
			        return arc(d);
			    });

			//append labels
			arcs.append("svg:text").attr("transform", function(d){
						d.innerRadius = 0;
						d.outerRadius = radius;
			    return "translate(" + arc.centroid(d) + ")";})
			.attr("text-anchor", "middle")
			.text( function(d, i) {
			    return data[i].label;}
			)
			.style("font-size","0.85em");

			//append values
			arcs.append("svg:text").attr("transform", function(d){
						d.innerRadius = 0;
						d.outerRadius = radius;
			    return "translate(" + arc.centroid(d) + ")";})
			.attr("text-anchor", "middle")
			.text( function(d, i) {
			    return data[i].value * 100 + '%';}
			).attr('dy', 15)
			.style("font-size","0.75em");
		};

		/**
 		 * Get the user data for the current user
		 */
		$scope.getUserData = function(callback){
			userDataFactory.getUser(accountFactory.currentUser())
			.success(function(data){
				callback(data);
				$scope.userData = data;
			})
			.error(function(error){
				if(DEBUG) console.log(error);
			});
		};

		/**
 		 * Given that user data is provided, render the appropriate charts
		 */
		$scope.renderUserData = function(data){
			if(DEBUG) console.log(data);

			renderPieChart(data.genreRatios);
		};

		$scope.init = function(){
			if(!accountFactory.currentUser()){
				accountFactory.getCurrentUser()
				.success(function(data){
					accountFactory.setCurrentUser(data);
					$scope.currentUser = data;
					$scope.getUserData($scope.renderUserData);
				})
				.error(function(error){
					if(DEBUG) console.log(error);
				});
			}
			else {
				$scope.getUserData($scope.renderUserData);
			}
		}

		$scope.init();
	}
);