function initialize() {

	var tabCoord=[[46.079722, 6.401389],[45,6],[47.466702,0.7],[43.787222,-1.403056],[46.53972,2.43028]]

	var point = new L.LatLng(18, -72);

	// Définition des options de la carte
	var options =	{
		center: point,
		zoom: 5
	};
	var map = new L.Map('mymap', options);
	
	// Ajout d'un fond de carte OpenStreetMap
	var url = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'; 
	var osm = new L.TileLayer(url, {maxZoom: 18}); 
	map.addLayer(osm);
	
	var marker = new L.Marker(point);
	map.addLayer(marker); 
	
	var circle = L.circle([18, -72], 500000, {
		color: 'red',
		fillColor: '#f03',
		fillOpacity: 0.5
	}).addTo(map);
	circle.bindPopup("Zone Caraïbes");

	// Définition d'une symbologie
	var myStyle = {
		"color": "#9932CC",
		"weight": 3,
		"opacity": 0.85
	};
}