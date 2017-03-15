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
//echo $urlInfo;
// url de test
//$urlInfo =  'http://ptwc.weather.gov/ptwc/text.php?id=pacific.TIBPAC.2017.02.10.1412';
//$urlInfo = 'http://ptwc.weather.gov/ptwc/text.php?id=hawaii.TIBHWX.2017.02.17.1537';
//$urlInfo = 'http://ptwc.weather.gov/ptwc/text.php?id=hawaii.TIBHWX.2017.02.10.1412';


// on récupère les informations du dernier séisme via son url
$content = file_get_contents($urlInfo); 
$debut = file_get_contents($urlInfo); 

function trouver_ma_chaine($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
// on extrait dans le fichier les caractères entre CENTER EWA BEACH HI et 2017

$debut = trouver_ma_chaine($debut, 'CENTER EWA BEACH HI', '2017'); //
$debut_tab = explode(" ",$debut);
$heure = $debut_tab[1];
$heure_type = $debut[2];
$mois=$debut_tab[6];
//echo $mois;
$j=0;
foreach ($debut_tab as &$val_jourmois) {
	if (trim($val_jourmois) == 'SAT'||'SUN'||'MON'||'TUE'||'WED'||'THU'||'FRI'){
		//$jour = $tab[$j-1];
		echo $jour
	} 
	
	if (trim($val_jourmois) == 'JAN'||'FEB'||'MAR'||'APR'||'MAI'||'JUN'||'JUL'||'AUG'||'SEP'||'OCT'||'NOV'||'DEC'){
		//$mois = $tab[$j-1];
	}
$j=$j+1;
	
echo $val_jourmois;

}
echo $mois;
echo $jour;
$jour = $debut_tab[6];
$mois = $debut_tab[8];
$annee = $debut_tab[9];
// echo "$debut 2017";
//echo $heure;
//echo $jour;


//switch($debut[2])

// on extrait dans le fichier les caractères entre origin et evaluation
$content = trouver_ma_chaine($content, 'ORIGIN', 'EVALUATION'); 
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
	
	
	//echo $tabvaleur."aaaa";
	$i = $i +1;
}
//echo $longitude. "-". $lattitude ;

?>
<!DOCTYPE html>

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
		<script type="text/javascript" src="test.js"></script>
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
					<li class="active"><a href="index.html">Séismes</a></li>
					<!-- <li><a href="#">Tsunami</a></li>
					<li><a href="#">Historique</a></li> -->
				</ul>
			</div>
		</nav>		
		<div style ="height:500px;" class="container">
			<div class="col-xs-6 col-sm-3">				
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Pays" type="text" name="pays" id="pays">
					</div>
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Ville" type="text" name="ville" id="ville">
					</div>
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Magnitude minimale (1 - 10)" type="text" name="minmag" id="minmag">
					</div>
					<div class="form-group">
						<input class="form-control input-sm" placeholder="Rayon du cercle (en km)" type="text" name="rayon" id="rayon">
					</div>
					<button id="recherche" type="submit" class="btn btn-default" style="float:right">Rechercher</button>				
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

<!-- JavaScript pour google-analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-88422583-1', 'auto');
  ga('send', 'pageview');
</script>