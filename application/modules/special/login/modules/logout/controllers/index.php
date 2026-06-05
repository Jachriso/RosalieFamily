<?php

foreach($_SESSION as $key => $val)
	unset($_SESSION[$key]);
unset($_SESSION['user_info']);
session_destroy();
setcookie('auth', '', time() - 3600, '/', 'localhost', false, true);
header("Location:" . $starter->HTTP_ROOT);
exit ;

?>