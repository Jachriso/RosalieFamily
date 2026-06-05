<?php
//init vars
$s_new_uri = '' ;

switch($_SERVER['REQUEST_URI'])
{

	case '/' . ($starter->b_multilang ? $starter->s_lang . '/' : '') . "home.html" :
		
		$s_new_uri  = $starter->HTTP_ROOT  ;

	break;
	
}

if(!empty($s_new_uri))
{
	header('Status: 301 Moved Permanently', false, 301); 
	header("Location:" . $s_new_uri);
	exit ;
}

?>