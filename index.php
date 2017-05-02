<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Tsunami Power</title>
		
		<link rel="icon" type="image/png" href="images/logo.png" />
		
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

		<!-- Boostrap dépend de Jquery -->

		<script	src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
 
		<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
		
		<link rel="stylesheet" href="style/style.css">
		<link rel="stylesheet" href="style/d3.slider.css"/>  
<style>

html{
	background-color:#C3D5ED;	
	margin-left:80px;
	margin-right:80px;	
}
body{
	background-color:#AEC3DD;
}
#input{
	float:left;
	width:200px;
	height:500px;
	margin-left:-15px;
	background-color:#9BB1CE;
	padding:5px;
}
#contenu{
	margin-left:185px;
	background-color:#FFF8DC;
	width:900px;
	height:500px;
	position: absolute;
	margin-right:90px;
}
    
    text {
      fill: white;
    }
    
    svg {
      position: relative;
    }
    
    path {
      fill: red;
      fill-opacity: .2;
    }
    
    path:hover {
      fill: brown;
      fill-opacity: .7;
    }
    
    #map {
      position: absolute;
      height: 100%;
      width: 100%;
      background-color: #333;
    }
  </style>
		<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
		<script type="text/javascript" src="js/carte_leaflet_accueil.js"></script>
	    <script type="text/javascript" src="js/carte_leaflet.js"></script>
		<script type="text/javascript" src="js/leaflet-heat.js"></script>
		
		<!-- Dependance Openlayers -->
		<script src="http://dev.openlayers.org/OpenLayers.js"></script>	
		
		<!-- D3.js -->
		<script src="http://d3js.org/d3.v3.min.js"></script>
		
		<script src="js/d3.slider.js"></script>

		<script>
		$(document).ready(function(){

		//initialise la carte
			init_carte_empty()
			//initialize('cuba','la-habana','0.002');
			
			$("#recherche").click(function(){
				// On supprime la carte
				$( "#mymap" ).remove();
				
				// Création de la nouvelle carte
				$( ".inner" ).append("<div id=\"mymap\" class=\"la-carte\" style=\"position: absolute;top: 0;left: 0;width: 100%;height: 500px;\"></div>");
				
				if(document.getElementById("rayon").value == ""){
					document.getElementById("rayon").value = 1500;
				}

				init_carte();
				
				/*var pays=$('#pays').val();
				var ville=$('#ville').val();
				var minmag=$('#minmag').val();
				
				//Vérification du formulaire
				if(!pays){alert('Veuillez entrer un pays'); exit;}
				if(!ville){alert('Veuillez entrer une ville'); exit;}
				if(!minmag){alert('Veuillez entrer une magnitude minimale'); exit;}
				
				initialize(pays,ville,minmag);*/
			});
		});
		</script>
	</head>	
	<body>		
		<nav class="navbar navbar-default">
			<div class="container-fluid" style="padding:0px;">
				<div class="navbar-header"><img src="images/logo.png" alt="Tsunami predict" height="45px" /></div>
				<ul class="nav navbar-nav">
					<li class="active"><a href="index.php">Séismes</a></li>
					<li class="active"><a href='24H.html'>24H</a></li>
					<li class="active"><a href="heatmap.html">Heatmap</a></li>
					<li class="active"><a href="cartodb.html">Animation</a></li>
					<li class="active"><a href="INDEX2.php">Alerte</a></li>
					

				</ul>
			</div>
		</nav>		
		<div style ="height:500px;" class="container">
			<form method="get" action="formulaire.php" autocomplete="off">
				<div class="col-xs-6 col-sm-3">				
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Pays" type="text" name="pays" id="pays" value="<?php if(isset($_GET['pays'])){echo $_GET['pays'];}else{echo "cuba";}?>">
					</div>
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Ville" type="text" name="ville" id="ville" value="<?php if(isset($_GET['ville'])){echo $_GET['ville'];}else{echo "la havane";}?>">
					</div>
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Magnitude minimale (1 - 10)" type="text" name="minmag" id="minmag" value="<?php if(isset($_GET['minmag'])){echo $_GET['minmag'];}else{echo "1";}?>">
					</div>
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Rayon du cercle (en km)" type="text" name="rayon" id="rayon" value="<?php if(isset($_GET['rayon'])){echo $_GET['rayon'];}else{echo "";}?>">
					</div>
					<!--<div class="form-group">
						Date : <span id="slideranneemin">1980</span>, <span id="slideranneemax">2000</span>
						<div id="sliderannee"></div>
					</div>
					<script>
						d3.select('#sliderannee').call(d3.slider().axis(true).value( [ 1980, 2000 ] ).min(1970).max(2017).step(1).on("slide", function(evt, value) {
							d3.select('#slideranneemin').text(value[ 0 ]);
							d3.select('#slideranneemax').text(value[ 1 ]);
						}));
					</script>-->
					<button id="recherche" type="submit" class="btn btn-default" style="float:right">Rechercher</button>			
				</div>		
			</form>
				<?php 
					if(isset($_GET['rayon'])){
						$host = 'localhost';
						$username = 'postgres'; 
						$password = '21242184';   
						$database= 'risques';
								
						//$db=pg_connect("host="+$host+" user="+$username+" password="+$password+" dbname="+$database) || die ("Connexion impossible");

						$db=pg_connect("host=localhost user=postgres dbname=risques password=21242184") || die ("Connexion impossible");
						//print('select latitude,longitude from seismes where magnitude >='.$_GET['minmag'].'');
						$query = 'select latitude,longitude from seismes where magnitude >='.$_GET['minmag'].'';
						
						$result = pg_query($query);
						//print($result);
						$data=array();
						 for ($x = 0; $x < pg_num_rows($result); $x++) {
        						$data[] = pg_fetch_assoc($result);
    							}						
						$data=json_encode($data);
						echo $data;
						//pg_close($db);
						
						/*echo "".$_GET['pays']."";
						echo "".$_GET['ville']."";
						echo "".$_GET['minmag']."";
						echo "".$_GET['rayon']."";*/
						
						/*$i = 0;
						echo '<table>';
						while ($row = pg_fetch_row($result)) 
						{
							echo '<tr>';
							$count = count($row);
							$y = 0;
							while ($y < $count)
							{
								$c_row = current($row);
								echo '<td>' . $c_row . '</td>';
								next($row);
								$y = $y + 1;
							}
							echo '</tr>';
							$i = $i + 1;
						}
						pg_free_result($result);

						echo '</table>';*/
					}
					else{}
				?>
				
			<div class="col-xs-12 col-md-8">
				<div class="inner">			
					<div id="mymap" class="la-carte" style="position: absolute;top: 0;left: 0;width: 100%;height: 500px;"></div>

				</div>
			</div>
		</div>		
		<!-- footer-->
		<div class="well well-sm">Copyright Tsunami Power</div>
	</body>
</html>