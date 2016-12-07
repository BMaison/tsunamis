function initialize(pays, ville, minmag) {		
	//console.log(pays + " " + ville + " " + minmag);		
	request = new XMLHttpRequest();
	var result;
	// haiti port-au-prince
	fetch('https://nominatim.openstreetmap.org/search?q='+pays+'/'+ville+'&format=json').then(
		function(response){
		response.json().then(function(data){
				seisme(data, minmag); 
			})		
		}
	)	
}

// Recupere les seismes
function seisme(data, minmag) {	
	if(document.getElementById("rayon").value == ""){
		document.getElementById("rayon").value = 1500;
	}
	fetch('https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&minmagnitude='+minmag+'&latitude='+data[0].lat+'&longitude='+data[0].lon+'&maxradiuskm='+document.getElementById("rayon").value).then(
		function(response){
		response.json().then(function(dataSeisme){			
				init_carte(data, dataSeisme);
			})		
		}
	)
}

//Affichage de la carte avec seismes
function init_carte(data, dataSeisme) {
		
		longitude = data[0].lon; 
		lattitude = data[0].lat; 
		
		//console.log(dataSeisme);
		//console.log(dataSeisme.features[0]); //affiche le  premier seisme
			
		var point = new L.LatLng(lattitude, longitude);

		// Définition des options de la carte
		var options =	{
			center: point,
			zoom: 4
		};
		var map = new L.Map('mymap', options);

		// Ajout d'un fond de carte OpenStreetMap
		var url = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'; 
		var osm = new L.TileLayer(url, {maxZoom: 18}); 
		map.addLayer(osm);

		var marker = new L.Marker(point);
		map.addLayer(marker); 
				
		var circle = L.circle([lattitude, longitude], document.getElementById("rayon").value*1000, {
			color: 'blue',
			fillColor: 'blue',
			fillOpacity: 0.2
		}).addTo(map);	

		// Définition d'une symbologie
		var myStyle = {
			"color": "#9932CC",
			"weight": 3,
			"opacity": 0.85
		};
		
		// Définition d'une symbologie
	var stylepoints = {	
		radius: 3, 
		color: "red", 
		fillOpacity: 0.85
		};

	for (i=0; i < dataSeisme.features.length; i++) {		
		var lng = dataSeisme.features[i].geometry.coordinates[0];
		var lat = dataSeisme.features[i].geometry.coordinates[1];
		var markerLocation = new L.LatLng(lat, lng);
		var temp = new L.CircleMarker(markerLocation,stylepoints);
        map.addLayer(temp);
	}
}

//Affichage de la carte vide
function init_carte_empty() {
	
		var point = new L.LatLng(18, -72);
		
		var map = L.map('mymap').setView([18, -72], 4);
		
		var osm = new L.TileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18}).addTo(map); 
		map.addLayer(osm);

		var marker = new L.Marker(point);
		map.addLayer(marker); 
		marker.bindPopup("Centre");
		
		var circle = L.circle([18, -72], 1500000, {
			color: 'blue',
			fillColor: 'blue',
			fillOpacity: 0.2
		}).addTo(map);
		circle.bindPopup("Zone Caraïbes");

		// Définition d'une symbologie
		var myStyle = {
			"color": "#9932CC",
			"weight": 3,
			"opacity": 0.85
		};

		// Add an SVG element to Leaflet’s overlay pane
		var svg = d3.select(map.getPanes().overlayPane).append("svg"),
			g = svg.append("g").attr("class", "leaflet-zoom-hide");
			
		d3.json("rectangle.json", function(geoShape) {
		
		//  create a d3.geo.path to convert GeoJSON to SVG
		var transform = d3.geo.transform({point: projectPoint}),
            	path = d3.geo.path().projection(transform);
 
		// create path elements for each of the features
		d3_features = g.selectAll("path")
			.data(geoShape.features)
			.enter().append("path");

		map.on("viewreset", reset);

		reset();

		// fit the SVG element to leaflet's map layer
		function reset() {
        
			bounds = path.bounds(geoShape);

			var topLeft = bounds[0],
				bottomRight = bounds[1];

			svg .attr("width", bottomRight[0] - topLeft[0])
				.attr("height", bottomRight[1] - topLeft[1])
				.style("left", topLeft[0] + "px")
				.style("top", topLeft[1] + "px");

			g .attr("transform", "translate(" + -topLeft[0] + "," 
			                                  + -topLeft[1] + ")");

			// initialize the path data	
			d3_features.attr("d", path)
				.style("fill-opacity", 0.7)
				.attr('fill','blue');
		} 

		// Use Leaflet to implement a D3 geometric transformation.
		function projectPoint(x, y) {
			var point = map.latLngToLayerPoint(new L.LatLng(y, x));
			this.stream.point(point.x, point.y);
		}
	})		
}



