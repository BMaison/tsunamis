function initialize() {

	var markers = [[17, -75],[15,-76],[17.5,-70],[10,-62],[12,-80]]

	var centre = new L.LatLng(18, -72);

	// Définition des options de la carte
	var options =	{
		center: centre,
		zoom: 4
	};
	var map = new L.Map('mymap', options);
	
	// Ajout d'un fond de carte OpenStreetMap
	var url = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'; 
	var osm = new L.TileLayer(url, {maxZoom: 18}); 
	map.addLayer(osm);
	
	var marker = new L.Marker(centre);
	map.addLayer(marker); 
	marker.bindPopup("Centre");
	
	var circle = L.circle([18, -72], 1500000, {
		color: 'blue',
		fillColor: 'blue',
		fillOpacity: 0.2
	}).addTo(map);
	circle.bindPopup("Zone Caraïbes");

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