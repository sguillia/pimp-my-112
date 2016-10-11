<?php

date_default_timezone_set('Europe/Paris');

require("../../Private/112/sql.php");

try
{
	$bdd = new PDO($bdd_str, $bdd_user, $bdd_pass);
}
catch (Exception $e)
{
	die('DB error : ' . $e->getMessage());
	exit();
}

unset($bdd_pass);

?>
