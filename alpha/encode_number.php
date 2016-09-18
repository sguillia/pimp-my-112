<?php

function is_valid_phonenumber($num)
{
	if (ctype_digit($num))
		return (TRUE);
	else
		return (FALSE);
}

if (!isset($_GET['number']))
	exit("No number received by GET method");

$do_geoloc = isset($_GET['do_geoloc']) ? "true" : 0;
$do_picture = isset($_GET['do_picture']) ? "true" : 0;

if (!$do_geoloc && !$do_picture)
	exit("Aucune case n'est cochée ! (Geoloc ou photo)");

$num = $_GET['number'];

if (!is_valid_phonenumber($num))
	exit("Invalid phone number $num");

try
{
	$bdd = new PDO('mysql:host=...;dbname=...', "...", "...");
}
catch (Exception $e)
{
	die('DB error : ' . $e->getMessage());
	exit();
}

if (!($reponse = $bdd->query("INSERT INTO hackathon_112 (phonenumber, do_geoloc, do_picture) VALUES ('$num', $do_geoloc, $do_picture)")))
	exit("Failed to insert data into DB");

$last_id = $bdd->lastInsertId();

$url_to_send = "http://.../client.php?id=".$last_id;


//echo "Ok<br>".$url_to_send;
echo "Ok";


$url1 = "Insert the API URL of the SMS sender here";
$url2 = urlencode($url_to_send);

$fullurl = $url1.$url2;
//echo "<br>".$fullurl;

// This request sends a message with the API we had
file_get_contents($fullurl);

?>
