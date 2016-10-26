function initialize(pays, ville) {		
	
	request = new XMLHttpRequest();
	var minmag = document.getElementById("minmag").value; 
	
	console.log(pays + " " + ville + " " + minmag)
	
	var result;
	// haiti port-au-prince
	fetch('https://nominatim.openstreetmap.org/search?q='+pays+'/'+ville+'&format=json').then(
		function(response){
		response.json().then(function(data){
				init_carte(data);
			})		
		}
	)	
}

function init_carte(data) {
		
		longitude = data[0].lon; 
		lattitude = data[0].lat; 
		
		console.log(longitude);
		console.log(lattitude);
		
		var markers = [[17, -75],[15,-76],[17.5,-70],[10,-62],[12,-80]]
		//var tabCoord=[[46.079722, 6.401389],[45,6],[47.466702,0.7],[43.787222,-1.403056],[46.53972,2.43028]]

		var point = new L.LatLng(lattitude, longitude);

		// Définition des options de la carte
		var options =	{
			center: point,
			zoom: 4
		};
		var map = new L.Map('mymap', options);
		
		// Ajout d'un fond de carte OpenStreetMap
		var url = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'; 
		var osm = new L.TileLayer(url, {maxZoom: 18}); 
		map.addLayer(osm);
		
		var marker = new L.Marker(point);
		map.addLayer(marker); 
		marker.bindPopup("Centre");
		
		var circle = L.circle([lattitude, longitude], 1500000, {
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
		
		// Définition d'une symbologie
	var stylepoints = {	
		radius: 3, 
		color: "red", 
		fillOpacity: 0.85
		};

	for (i=0; i < markers.length; i++) {
		var lat = markers[i][0];
		var lng = markers[i][1];
		var markerLocation = new L.LatLng(lat, lng);
		var temp = new L.CircleMarker(markerLocation,stylepoints);
        map.addLayer(temp);
	}
}