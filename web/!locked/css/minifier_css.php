<?php
/* system */
ini_set('display_errors', 'off');
@session_start();

/* headers */
if(isset($_GET['id']) && $_GET['id'] == 'default')
{
	header("Expires: Mon, 01 Jan 1999 00:00:00 GMT"); 
	header("Pragma: no-cache");
	header('Edge-Control: no-store');
	header('Edge-Control: bypass-cache');
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
}
else header("Expires: " . date("D, j M Y", strtotime("+1 week")) . " 02:00:00 GMT");
header("Content-type: text/css");

/* init */
$a_files = array();

if(isset($_SESSION['rel']['css']) && is_array($_SESSION['rel']['css']) && $starter->utils->is__countable($_SESSION['rel']['css']) && count($_SESSION['rel']['css']) > 0) 
{
	$a_files = $_SESSION['rel']['css'] ;
	foreach($a_files as $key => $val)
	{
		readfile(dirname(__FILE__) . '/../' . str_replace('http://' . $_SERVER['SERVER_NAME'], '', $val['href']));
	}
}
?>
