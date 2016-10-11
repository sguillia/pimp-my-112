<?php
error_reporting(E_ALL);
require('auth.php');

if (isset($_SESSION['auth']))
{
	header('Location: index.php');
	exit();
}
if (isset($_POST['pw']))
{
	$last = file_get_contents('Private/time.txt');
	$time = time();
	if ($last === false)
	{
		echo "-- Time err -- go to index manually --";
		//exit();
	}
	else
	{
		if ($time - $last < 5)
		{
			echo "Wait -- try again in 5 seconds...<br><a href='login.php'>Retour</a>";
			exit();
			//sleep(10 - ($time - $last));
		}
	}
	file_put_contents("Private/time.txt", $time);
	if (auth($_POST['pw']))
	{
		$_SESSION['auth'] = true;
		header('Location: index.php');
		exit(1);
	}
	else
		$fail = true;
}
?>
<html>
<head>
<title>Login</title>
<!-- // -->
<meta name="robots" content="noindex">
<!-- // -->
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
</head>
<body>
<?php if (isset($fail)){echo "<span style='color: red;'>Fail</span><br>"; } ?>
<form method="POST">
<p>Login to 112 app</p>
<p>
<input type="password" name="pw" id="password" autofocus>
<input type="submit" value="Ok">
</p>
</form>
</body>
</html>
