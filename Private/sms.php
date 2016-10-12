<?php

require_once(__DIR__."/log.php");

$ret = file_get_contents(__DIR__."/smsenable.txt");

if ($ret === false)
{
	$msg = "[!] Failed to retrieve smsenable.txt";
	echo $msg;
	logtxt($msg);
}

if ($ret == "1" || $ret == "1\n")
{
	require_once(__DIR__."/../../../Private/112/sms.php");
}
else
{
	function sms($to, $body)
	{
		$msg =  "Sms are disabled. Faking function.\n";
		echo $msg;
		return ($msg);
	}
}

?>
