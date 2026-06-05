<?php
/* system */
ini_set('display_errors', 'off');
@session_start();

// init vars
$s_form_id = (isset($_GET['id']) ? htmlentities($_GET['id']) : '');

/* headers */
if($s_form_id == 'default')
{
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
	header("Pragma: no-cache");
	header('Edge-Control: no-store');
	header('Edge-Control: bypass-cache');
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
}
else header("Expires: " . date("D, j M Y", strtotime("+1 week")) . " 02:00:00 GMT");
header("Content-type: text/javascript");

/* init */
$a_files = array();
if(isset($_SESSION['rel']['js']) && is_array($_SESSION['rel']['js']) && $starter->utils->is__countable($_SESSION['rel']['js']) && count($_SESSION['rel']['js']) > 0) 
{
	$a_files = $_SESSION['rel']['js'] ;
	foreach($a_files as $key => $val)
	{
		readfile(dirname(__FILE__) . '/../../../' . str_replace($starter->HTTP_ROOT, '', $val['src']));
	}
}
?>
