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
	fetch('https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&minmagnitude='+minmag+'&latitude='+data[0].lat+'&longitude='+data[0].lon+'&maxradiuskm=1500').then(
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
		marker.bindPopup("Centre");
		
		var circle = L.circle([lattitude, longitude], 1500000, {
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
}
