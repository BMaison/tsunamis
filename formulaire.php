<html>
	<head>
		<meta http-equiv="Content-Type"content="text/html; charset=UTF-8" />
		<?php
			$db=pg_connect("host=localhost user=postgres dbname=risques password=21242184") || die ("Connexion impossible");
			$query = 'select latitude,longitude from seismes where magnitude = '.$_GET['minmag'].'';
			$result = pg_query($query);

			if($_GET['pays']=="" || $_GET['ville']=="" || $_GET['minmag']=="" || $_GET['rayon']==""){
				print "pas bien rempli";
				echo "<meta http-equiv='refresh'; URL=index.php;charset=UTF-8'>";
			//si ok meta vers index si non nouveau ,  meta passer les parametre de lurl pour pas tout retzpper 
			}
			else{
				echo'<meta http-equiv="refresh" content="0; url=index.php?pays='.$_GET['pays'].'&ville='.$_GET['ville'].'&minmag='.$_GET['minmag'].'&rayon='.$_GET['rayon'].'">';
			}
		?>
	</head>

	<body>
	</body>
</html>