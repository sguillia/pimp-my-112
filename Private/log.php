<?php

date_default_timezone_set('Europe/Paris');

function logtxt($text)
{
	$head = "Log from IP '".$_SERVER['REMOTE_ADDR']."' at timestamp '".time()."'";
	$path = __DIR__.'/log.txt';
	$ret = file_put_contents($path, $head."\n".$text."\n\n", FILE_APPEND);
	if ($ret === false)
	{
		echo "[logtxt] Failed to write log";
	}
}

?>
