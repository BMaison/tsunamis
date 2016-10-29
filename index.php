<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My page title</title>
		<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
		<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
		<script type="text/javascript" src="carte_leaflet.js"></script>
		<link rel="stylesheet" href="style.css">
	</head>
	<?php 	
	if(isset($_GET['pays'])){		
		$pays = $_GET['pays'];
		$ville = $_GET['ville'];
		$minmag = $_GET['minmag'];		
		echo '<body onload=initialize("'.$pays.'","'.$ville.'","'.$minmag.'");>' ; 
		
	}else{ 
		echo '<body onload=init_carte_empty()>' ; 	
	}
	?>	
		<div id="entete">
			<button class="button">Home</button>
			<button class="button">Seisme</button>
			<button class="button">Historique</button>
			<button class="button">Contact</button>
		</div>
		<div id="main">
			<div id="input">
				<form action="" method="GET">
					Pays: <input type="text" name="pays" id="pays" value="" ><br>
					ville:<input type="text" name="ville" id="ville" value=""><br>
					Minmagnitude: <input type="text" name="minmag" id="minmag" value=""><br>			
					<input type="submit" value="Rechercher">
				</form>
			</div>
			<div id="contenu">			
				<div id="mymap" style="position: absolute;top: 0;left: 0;width: 900px;height: 500px;"></div>
			</div>
		</div>
		<div id="footer">copy right tsunami power</div>
	</body>
</html>