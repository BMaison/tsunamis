<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My page title</title>
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Boostrap dépend de Jquery -->
		<script	src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 
		<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
		<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
		<script type="text/javascript" src="carte_leaflet.js"></script>
		<link rel="stylesheet" href="style.css">
	</head>
	
	<body>
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
		
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="">Tsunami Power</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="#">Home</a></li>
					<li><a href="#">Tsunami</a></li>
					<li><a href="#">Historique</a></li>
					<li><a href="contact.html">Contact</a></li>
				</ul>
			</div>
		</nav>
		
		<div style ="height:500px;" class="container">
		<!--<div class="thumbnail" id="cadre">
			<img src="large.jpeg" alt="tsunami">
		</div> -->
			<div class="col-xs-6 col-sm-3">
				<form action="" method="GET">
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Pays" type="text" name="pays" id="pays" value="<?php if(isset($_GET['pays'])){echo $_GET['pays'];}else{echo "";}?>" >
					</div>
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Ville" type="text" name="ville" id="ville" value="<?php if(isset($_GET['ville'])){echo $_GET['ville'];}else{echo "";}?>">
					</div>
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Magnitude minimale" type="text" name="minmag" id="minmag" value="<?php if(isset($_GET['minmag'])){echo $_GET['minmag'];}else{echo "";}?>">
					</div>
					<button type="submit" class="btn btn-default">Rechercher</button>
				</form>
			</div>
		
			<div class="col-xs-12 col-md-8">			
				<div id="mymap" style="position: absolute;top: 0;left: 0;width: 100%;height: 500px;"></div>
			</div>
		</div>
		
		<!-- footer-->
		<div class="well well-sm">Copyright Tsunami Power</div>
	</body>
</html>