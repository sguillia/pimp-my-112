<?php

require("auth.php");
check_auth();
require("Private/log.php");

if (isset($_GET['smsenable']))
{
	$smsenable = $_GET['smsenable'];
	if ($smsenable == "1")
	{
		$ret = file_put_contents("Private/smsenable.txt", "1");
		if ($ret === false)
		{
			echo "Enable sms failed";
			logtxt("Enable sms filed");
		}
		else
		{
			echo "Enabled sms";
			logtxt("Enabled sms");
		}
	}
	else if ($smsenable == "0")
	{
		$ret = file_put_contents("Private/smsenable.txt", "0");
		if ($ret === false)
		{
			echo "Disable sms failed";
			logtxt("disable sms filed");
		}
		else
		{
			echo "Disabled sms";
			logtxt("Disabled sms");
		}
	}
	else
	{
		echo "GET command 'smsenable' not understood";
	}
}

?>

<br>
<p><a href="index.php">Index</a></p>
