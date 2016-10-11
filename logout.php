<?php

require('auth.php');

unset($_SESSION['auth']);

header('Location: login.php');
exit();

?>
