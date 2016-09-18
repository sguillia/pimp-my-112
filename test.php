<?php

$arr = Array("key"=>"value");

//extract($arr, EXTR_PREFIX_ALL, "foo");
extract($arr);

$list = get_defined_vars();
foreach($list as $key=>$name)
	echo $key."\n";

?>
