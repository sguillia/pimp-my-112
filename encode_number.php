<?php

require("auth.php");
check_auth();
require("Private/log.php");
require("Private/sms.php");


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

$visited = "''";

if (!is_valid_phonenumber($num))
	exit("Invalid phone number $num");

logtxt("encode_number.php has passed verifications, ".
print_r($_GET, true));

require("Private/sql.php");

echo "[WARNING injection [!]]";

if (!($reponse = $bdd->query("INSERT INTO requests (phonenumber, do_geoloc, do_picture, timestamp, visited) VALUES ('$num', $do_geoloc, $do_picture, now(), $visited)")))
{
	echo "<pre>";
	print_r($bdd->errorInfo());
	echo "</pre>";
	exit("Failed to insert data into DB");
}

$last_id = $bdd->lastInsertId();

$url_to_send = "http://bilow.tk/bilow/112/client.php?id=".$last_id;


//echo "Ok<br>".$url_to_send;
echo "Ok, prepared for SMS dispatch\n";

//$url1 = "Insert the API URL of the SMS sender here";
//$url2 = urlencode($url_to_send);

//$fullurl = $url1.$url2;
//echo "<br>".$fullurl;

// This request sends a message with the API we had
//$ret = file_get_contents($fullurl);

$text="Localisation 112 : $url_to_send";

$ret = sms($num, $text);
logtxt("Sms sending has returned :\n".$ret);

//---------------- sms($num, $text);

if ($ret === false)
{
	echo "request seem to have failed ...\n";
}
else
{
	echo "Received non-false ACK\n";
}

echo "Done."

?>
