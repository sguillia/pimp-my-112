<?php

// TODO : show error if request was already responded to

require("auth.php");
check_auth();

if (isset($_GET['id']))
	$id = $_GET['id'];
else if ($argc == 2)
{
	echo "[SOURCE is ARGV]\n";
	$id = $argv{1};
}
else
{
    exit("Erreur : pas d'ID reçu ! (ID attendu via GET ou argv -- mauvais lien)");
}

if (!ctype_digit($id))
    exit("L'id n'est pas un nombre !");

require("Private/sql.php");

$reponse = $bdd->query("SELECT * FROM requests WHERE ID='$id'");

if (!($data = $reponse->fetch()))
    exit("ID inexistant");

if (isset($_GET['geoloc_success']))
{
	echo "OK! Rien à faire! -- ID deja valide";
}
if (isset($_GET['geoloc_success']))
{
    exit("Localisation réussie et transmise à l'opérateur !");
}

if ($data['do_geoloc'])
{
?>
<html>
<head>
<title>Urgences police/pompiers</title>


<script>

var coord = null;

function show(errmsg)
{
    document.getElementById('show').innerHTML = errmsg;
}

var options = {
  enableHighAccuracy: true,
  timeout: 5000,
  maximumAge: 0
};

function getLocation() {
    show("Localisation en cours...");
    if (navigator && navigator.geolocation)
    {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);
    }
    else
    { 
        show("Impossible de localiser.");
    }
}

function successCallback(position)
{
    show("Localisation réussie ! Envoi en cours à l'opérateur...");
    //var mapUrl = "http://maps.google.com/maps/api/staticmap?center=";
    var serverUrl = "receive_coord.php?id="+<?php echo "$id"; ?>+"&coord=";
    coord = position.coords.latitude + ',' + position.coords.longitude;
    window.location = serverUrl + coord;
    //mapUrl = mapUrl + coord;
    //mapUrl = mapUrl + '&zoom=15&size=512x512&maptype=roadmap&sensor=false';
    //var imgElement = document.getElementById('static-map');
    //imgElement.src = mapUrl;
}

function errorCallback()
{
    show("Erreur lors de la localisation. GPS activé ?");
}

function locate()
{
    show("Chargement en cours...");
    getLocation();
}

</script>

</head>
<body onload="locate();">

<p id="show"></p>

<div id="map">
<img id="static-map" src="">
</div>

</body>
</html>
<?php
}
else if ($data['do_picture'])
{
?>
Prise de photo
<?php
}
else
{
echo "Rien à faire ! -- ID deja valide";
}
?>
