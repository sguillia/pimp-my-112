<?php

if (!isset($_GET['id']))
    exit("Erreur : pas d'ID reçu !");

$id = $_GET['id'];

if (!ctype_digit($id))
    exit("L'id n'est pas un nombre !");

try
{
    $bdd = new PDO('mysql:host=...;dbname=...', "...", "...");
}
catch (Exception $e)
{
    die('DB error : ' . $e->getMessage());
    exit();
}

$reponse = $bdd->query("SELECT * FROM hackathon_112 WHERE ID='$id'");

if (!($data = $reponse->fetch()))
    exit("ID inexistant");

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
    var serverUrl = "http://.../receive_coord.php?id="+<?php echo "$id"; ?>+"&coord=";
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
echo "Rien à faire !";
}
?>
