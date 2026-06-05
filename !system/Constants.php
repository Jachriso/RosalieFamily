<?php 

/*******************************************/
//INIT VARS
/*******************************************/

	// Define application path
	defined('APPLICATION_PATH')	|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
	
	// Define application environment
	defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
	
	// Define library path
	defined('LIBRARY_PATH')	|| define('LIBRARY_PATH', realpath(dirname(__FILE__) . '/../lib'));
	
	// Define system path
	defined('SYSTEM_PATH') || define('SYSTEM_PATH', realpath(dirname(__FILE__) ));
	
	// Define system path
	defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__) . '/../web'));
?>