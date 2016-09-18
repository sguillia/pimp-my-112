<?php
require("Private/sql.php");

$rep = $bdd->query("SELECT * FROM requests");

echo "<pre>\n";

while(($data = $rep->fetch()))
{
	extract($data, EXTR_PREFIX_ALL, "bdd");
	echo "ID: $bdd_ID, phonenumber: $bdd_phonenumber, do_geoloc: $bdd_do_geoloc, do_picture: $bdd_do_picture, coord: $bdd_coord, timestamp: $bdd_timestamp, visited: $bdd_visited\n";
}

echo "</pre>\n";
?>
