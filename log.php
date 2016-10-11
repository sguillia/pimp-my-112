<?php
require("auth.php");
check_auth();
?><pre><?php
$ret = readfile("Private/log.txt");
if ($ret === false)
	echo "Failed to read log";
?></pre>
