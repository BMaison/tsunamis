<?php
include('simple_html_dom.php'); // librairie pour parser le html

// on récupère l'url du dernier séisme
$html = file_get_html('http://ptwc.weather.gov/ptwc/index.php');

// parcours les liens hypertextes dans la page html
foreach($html->find('a') as $element){
	//echo $element->href."<br>";
	if (substr($element->href, 0, 15) == "/ptwc/text.php?"){
		$url = $element->href;
		break ;
	}		
}

// concatènation pour forger l'url du dernier séisme
$urlInfo =  'http://ptwc.weather.gov'.$url;
// $urlInfo =  'http://ptwc.weather.gov/ptwc/text.php?id=pacific.TIBPAC.2017.03.05.2254';
//echo $urlInfo;
// url de test
//$urlInfo =  'http://ptwc.weather.gov/ptwc/text.php?id=pacific.TIBPAC.2017.02.10.1412';
//$urlInfo = 'http://ptwc.weather.gov/ptwc/text.php?id=hawaii.TIBHWX.2017.02.17.1537';
//$urlInfo = 'http://ptwc.weather.gov/ptwc/text.php?id=hawaii.TIBHWX.2017.02.10.1412';

// on récupère les informations du dernier séisme via son url
$content = file_get_contents($urlInfo); 

function trouver_ma_chaine($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

// on extrait dans le fichier les caractères entre origin et evaluation
$content = trouver_ma_chaine($content, 'PARAMETERS', 'EVALUATION'); 
//echo $content;
//$tab = explode("-", $content);

$tab = explode(" ", $content);
$i = 0;

// on recherche la longitude et lattitude
foreach ($tab as &$tabvaleur) {
    if (trim($tabvaleur) == 'NORTH'){
		$longitude = $tab[$i-1];
	} 
	
	if (trim($tabvaleur) == 'EAST'){
		$lattitude = $tab[$i-1];		
	}
	
	if (trim($tabvaleur) == 'WEST'){
		$lattitude = $tab[$i-1];		
	}
	if (trim($tabvaleur) == 'SOUTH'){
		$longitude = $tab[$i-1];		
	}
	if (trim($tabvaleur) == 'MAGNITUDE'){
		$magnitude = $tab[$i+4];		
	}
	if (trim($tabvaleur) == 'DEPTH'){
		$depth = $tab[$i+4];		
	}
	//echo $tabvaleur."aaaa";
	$i = $i +1;
}
//echo $longitude. "-". $lattitude ;

$tab2 = explode("-", $content);

?>

<html>
	<head>
		<meta charset="utf-8">
		<title>Tsunami Power</title>
		
		<link rel="icon" type="image/png" href="logo.png" />
		
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
		<script type="text/javascript" src="testAlert.js"></script>
		<link rel="stylesheet" href="style.css">
		
		<!-- Dependance Openlayers -->
		<script src="http://dev.openlayers.org/OpenLayers.js"></script>	
		
		<!-- D3.js -->
		<script src="http://d3js.org/d3.v3.min.js"></script>
		
		<script>
		$(document).ready(function(){
			// Recuperation du nombre d'habitant par ville 
			/*var wms = new OpenLayers.Layer.WMS( "Population Count",
			"http://sedac.ciesin.columbia.edu/geoserver/wms",
			{layers: 'gpw-v4:gpw-v4-population-count_2005'}	); 
			alert(wms.div);	console.log(wms);*/	
			ptwc(<?php echo $longitude . "," . $lattitude ?>)
			//initialise la carte
			// init_carte_empty()
			//initialize('cuba','la-habana','0.002');
			
			$("#recherche").click(function(){
				
				// On supprime la carte
				$( "#mymap" ).remove();
				
				// Création de la nouvelle carte
				$( ".inner" ).append("<div id=\"mymap\" class=\"la-carte\" style=\"position: absolute;top: 0;left: 0;width: 100%;height: 500px;\"></div>");
				
				var pays=$('#pays').val();
				var ville=$('#ville').val();
				var minmag=$('#minmag').val();
				
				//Vérification du formulaire
				if(!pays){alert('Veuillez entrer un pays'); exit;}
				if(!ville){alert('Veuillez entrer une ville'); exit;}
				if(!minmag){alert('Veuillez entrer une magnitude minimale'); exit;}
				
				// jeu de test				
				//initialize('cuba','la-habana','0.002');
				
				initialize(pays,ville,minmag);
			});
		});
		
		</script>
	</head>	
	<body>		
		<nav class="navbar navbar-default">
			<div class="container-fluid" style="padding:0px;">
				<div class="navbar-header"><img src="logo.png" alt="Tsunami predict" height="45px" /></div>
				<ul class="nav navbar-nav">
					<li class=""><a href="index.php">Séismes</a></li>
					 <li class="active"><a href="alerte.php">Alerte</a></li>
					<!--<li><a href="#">Historique</a></li> -->
				</ul>
			</div>
		</nav>		
		<div style ="height:500px;" class="container">
			<div class="col-xs-6 col-sm-3">				
					<strong><u> Informations : </u></strong>
					<?php
					//echo $longitude. "-". $lattitude ;
					$cpt=0;
					$lengthTab = count($tab2);
					foreach ($tab2 as &$value) {
						//echo $value.'fff<br>';
						if($cpt == 0){
							
							//récupère le dernier mot de l'indice suivant du tableau
							$lastWord =  substr($tab2[$cpt+1],strrpos(trim($tab2[$cpt+1]),' ')) ;
							// supprime le mot récupèrer 
							$text = str_replace($lastWord, '', $tab2[$cpt+1]);
							echo "<div style='margin-bottom:7px'><u>".ucfirst(strtolower(trim($value))) . "</u> : " . $text.'</div>';
						
						}elseif ($cpt < $lengthTab-2){
							
							// récupère le dernier mot de la phrase qui correspond au libellé
							$Word =  substr($value,strrpos(trim($value),' ')) ;
							// récupère le dernier mot de la phrase pour le suppromer
							$lastWord =  substr($tab2[$cpt+1],strrpos(trim($tab2[$cpt+1]),' ')) ;
							$text = str_replace($lastWord, '', $tab2[$cpt+1]);					

							echo "<div style='margin-bottom:7px'><u>".ucfirst(strtolower(trim($Word))) . "</u> : " . $text.'</div>';
							
						}elseif ($cpt == $lengthTab-1){
							// affiche le dernier mot récupèrer ainsi que sa valeur
							echo "<div style='margin-bottom:7px'><u>".ucfirst(strtolower(trim($lastWord))) . "</u> : " . $tab2[$cpt].'</div>';
						}
						
						$cpt = $cpt +1;
					}
					if ($magnitude > 6 && $depth < 10){
						echo "<div class='alert alert-danger'>Alerte</div>";
					}
					else{
						echo "<div class='alert alert-success'>Pas d'alerte</div>";
					}
					//echo $tabvaleur."aaaa";
					?>
			</div>		
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
