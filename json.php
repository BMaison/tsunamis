5<!--
* Auteur : Habib Ghislain Diop
* Sujet: Parser GeoJSON avec PHP
-->
<?php
// Copier le fichier dans une variable 
$json_file = file_get_contents('http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/all_month.geojson');
// Convertir le string en un objet json 
$jfo = json_decode($json_file);
// lire le titre
$title = $jfo->metadata->title;
$arr_length = count($jfo->features);
echo $arr_length;
//Stocker les données dans des variables php
//Propriétés
for($i=0;$i<$arr_length;$i++) {
$mag = $jfo->features[$i]->properties->mag;
$place = $jfo->features[$i]->properties->place;
$time = date("d-m-Y H:i:s", $jfo->features[0]->properties->time);
$updated = date("d-m-Y H:i:s", $jfo->features[0]->properties->updated);
$tz = $jfo->features[$i]->properties->tz;
$url = $jfo->features[$i]->properties->url;
$detail = $jfo->features[$i]->properties->detail;
$felt = $jfo->features[$i]->properties->felt;
$cdi = $jfo->features[$i]->properties->cdi;
$mmi = $jfo->features[$i]->properties->mmi;
$alert = $jfo->features[$i]->properties->alert;
$status = $jfo->features[$i]->properties->status;
$tsunami = $jfo->features[$i]->properties->tsunami;
$sig = $jfo->features[$i]->properties->sig;
$net = $jfo->features[$i]->properties->net;
$code = $jfo->features[$i]->properties->code;
$ids = $jfo->features[$i]->properties->ids;
$sources = $jfo->features[$i]->properties->sources;
$types = $jfo->features[$i]->properties->types;
$nst = $jfo->features[$i]->properties->nst;
$dmin = $jfo->features[$i]->properties->dmin;
$rms = $jfo->features[$i]->properties->rms;
$gap = $jfo->features[$i]->properties->gap;
$magType = $jfo->features[$i]->properties->magType;
$type = $jfo->features[$i]->properties->type;
$title_prop = $jfo->features[$i]->properties->title;

//Géométrie
$lon = $jfo->features[$i]->geometry->coordinates[0];
$lat = $jfo->features[$i]->geometry->coordinates[1];
$dep = $jfo->features[$i]->geometry->coordinates[2];

//Création de la base de données Risques naturels
/*$db=pg_connect("host=localhost user=postgres password=21242184") || die ("Connexion impossible");
if (pg_query("CREATE DATABASE Risques")) {
print ("<h2> La base de données Risques naturels a bien été créée</h2>");
} else {
    print ("<h2>Echec de la création de la base de données Risques naturels</h2>");
}*/

// Création de la table séisme avec Postgresql
$db=pg_connect("host=localhost user=postgres dbname=risques password=21242184") || die ("Connexion impossible");
/*if (pg_query("CREATE TABLE SEISMES(id SERIAL PRIMARY KEY,
             datetime text, 
             title text,
             latitude decimal, 
             longitude decimal, 
             depth decimal, 
             magnitude decimal, 
             place text, 
             updated text, 
             tz integer, 
             felt integer,
             cdi decimal,
             mmi decimal,
             alert text,
             status text,
             tsunami integer,
             sig integer,
             net text,
             code text,
             eventid text,
             sources text,
             nst integer,
             dmin decimal,
             rms decimal,
             gap decimal,
             magType text,
             type text)")) {
print ("<h2> La Table SEISMES a bien été créée</h2>");
} else {
    print ("<h2>Echec de la création de la table de données SEISMES</h2>");
}*/
$lat = !empty($lat) ? "$lat" : "null";
$lon = !empty($lon) ? "$lon" : "null";
$dep = !empty($dep) ? "$dep" : "null";
$mag = !empty($mag) ? "$mag" : "null";
$tz = !empty($tz) ? "$tz" : "null";
$felt = !empty($mmi) ? "$felt" : "null";
$cdi = !empty($cdi) ? "$cdi" : "null";
$mmi = !empty($mmi) ? "$mmi" : "null";
$tsunami = !empty($tsunami) ? "$tsunami" : "null";
$sig = !empty($sig) ? "$sig" : "null";
$nst = !empty($nst) ? "$nst" : "null";
$dmin = !empty($dmin) ? "$dmin" : "null";
$rms = !empty($rms) ? "$rms" : "null";
$gap = !empty($gap) ? "$gap" : "null";

/*print(" INSERT INTO SEISMES(datetime,title,latitude,longitude,depth,magnitude,place,updated,tz,felt,cdi,mmi,alert,status,tsunami,sig,net,code,eventid,sources,nst,dmin,rms,gap,magType,type) 
                    VALUES('$time','$title_prop','$lat','$lon','$dep','$mag','$place','$updated','$tz','$felt','$cdi','$mmi','$alert','$status','$tsunami','$sig','$net','$code','$ids','$sources','$nst','$dmin','$rms','$gap','$magType','$type')");*/
if (pg_query("INSERT INTO SEISMES(datetime,title,latitude,longitude,depth,magnitude,place,updated,tz,felt,cdi,mmi,alert,status,tsunami,sig,net,code,eventid,sources,nst,dmin,rms,gap,magType,type) 
                    VALUES('$time','$title_prop',$lat,$lon,$dep,$mag,'$place','$updated',$tz,$felt,$cdi,$mmi,'$alert','$status',$tsunami,$sig,'$net','$code','$ids','$sources',$nst,$dmin,$rms,$gap,'$magType','$type')"))
{
    echo "saved";
}
else
{
    echo "error insering data";
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Parser GeoJSON avec PHP</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="images/logo_sm.png" />
        </div><!-- header -->
        <h1 class="main_title"><?php echo $title; ?></h1>
        <div class="content">
            <ul class="ul_json clearfix">
                <li>
                    
                        <h2><?php echo 'mag = '; echo $mag; ?></h2>
                        <h2><?php echo 'place = '; echo $place; ?></h2>
                        <h2><?php echo 'time = '; echo $time; ?></h2>
                        <h2><?php echo 'updated = '; echo $updated; ?></h2>
                        <h2><?php echo 'tz = '; echo $tz; ?></h2>
                        <h2><?php echo 'felt = '; echo $felt; ?></h2>
                        <h2><?php echo 'cdi = '; echo $cdi; ?></h2>
                        <h2><?php echo 'mmi = '; echo $mmi; ?></h2>
                        <h2><?php echo 'alert = '; echo $alert; ?></h2>
                        <h2><?php echo 'status = '; echo $status; ?></h2>
                        <h2><?php echo 'tsunami = '; echo $tsunami; ?></h2>
                        <h2><?php echo 'sig = '; echo $sig; ?></h2>
                        <h2><?php echo 'net = '; echo $net; ?></h2>
                        <h2><?php echo 'code = '; echo $code; ?></h2>
                        <h2><?php echo 'ids = '; echo $ids; ?></h2> 
                        <h2><?php echo 'sources = '; echo $sources; ?></h2> 
                        <h2><?php echo 'nst = '; echo $nst; ?></h2> 
                        <h2><?php echo 'dmin = '; echo $dmin; ?></h2>
                        <h2><?php echo 'rms = '; echo $rms; ?></h2>
                        <h2><?php echo 'gap = '; echo $gap; ?></h2>
                        <h2><?php echo 'magType = '; echo $magType; ?></h2>
                        <h2><?php echo 'type = '; echo $type; ?></h2>
                        <h2><?php echo 'title = '; echo $title_prop; ?></h2>
                        <h2><?php echo 'longitude = '; echo $lon; ?></h2>
                        <h2><?php echo 'latitude = '; echo $lat; ?></h2>
                        <h2><?php echo 'depth = '; echo $dep; ?></h2>

                    
                </li>
            </ul>
        </div><!-- content -->    
        <div class="footer">
           Dev: Habib Ghislain Diop
        </div><!-- footer -->
    </div><!-- container -->
</body>
</html>
