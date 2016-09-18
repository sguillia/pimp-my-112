<?php

require("../../Private/sql.php");

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
