<?php 
/*******************************************/
//INIT VARS
/*******************************************/
require_once dirname( __FILE__ ) . '/Constants.php' ;
	
/******************************************/
//REQUIRES
/******************************************/

// run application
require_once SYSTEM_PATH . '/Starter.php' ;

$starter = new Starter();

if($starter->bdebug ) {
	ini_set("display_errors", "on");
	error_reporting(E_ALL);
}
// security vars
if($starter->utils->is__countable($_POST) && count($_POST) > 0) {
	foreach($_POST as $key => $val){
		$starter->_special_POST[$key] = ($val);
		if(!is_array($val)){
			$_POST[$key] 	= stripslashes($_POST[$key]);
			$_POST[$key] 	= trim($_POST[$key]);
		}
	}
}
if($starter->utils->is__countable($_GET) && count($_GET) > 0) {
	foreach($_GET as $key => $val){
		$starter->_special_GET[$key] = ($val);
		if(!is_array($val)){
			$_GET[$key] 	= stripslashes($_GET[$key]);
			$_GET[$key] 	= trim($_GET[$key]);
		}
	}
}
// detecting device
if($starter->s_device)
	require_once LIBRARY_PATH . "/categorizr/categorizr.php";

// redirection
require_once SYSTEM_PATH . '/Redirections.php' ;

require_once SYSTEM_PATH . "/FrontBuilder.php";	

if(isset($_SESSION['WARNING'])) 
	unset($_SESSION['WARNING']);

if(isset($starter->token) && !empty($starter->token))
	$_SESSION['token'] = $starter->token;
?>