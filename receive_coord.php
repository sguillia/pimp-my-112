<?php

require("auth.php");
check_auth();

if (!isset($_GET['id']))
    exit("Erreur : pas d'ID reçu !");

$id = $_GET['id'];

if (!ctype_digit($id))
    exit("L'id n'est pas un nombre !");

require("Private/sql.php");

$reponse = $bdd->query("SELECT * FROM requests WHERE ID='$id'");

if (!($data = $reponse->fetch()))
    exit("ID inexistant");

if ($data['do_geoloc'])
{
	if (!isset($_GET['coord']))
		exit("Erreur : pas de coordonnées reçues !");
	$coord = $_GET['coord'];
	$query = "UPDATE requests SET do_geoloc=false, coord=:coord WHERE ID='$id'";
	$sth = $bdd->prepare($query);
	if ($sth->execute(array(':coord' => $coord)))
	{
		header("Location: client.php?id=".$id."&geoloc_success");
		exit();
	}
	else
		exit("Erreur lors de la mise à jour de la DB");
}

?>
