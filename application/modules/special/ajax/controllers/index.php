<?php
// init vars
$s_form_case 					= (isset($_GET['level2']) ? htmlentities($_GET['level2']) : '');

switch($s_form_case){
	default:
	case '':
	break;

	case 'getusers':
		require_once dirname( __FILE__ ) . '/getUsers.php';
		$users = new AjaxUsers();
	break;

	case 'getassosbyuserusers':
		require_once dirname( __FILE__ ) . '/getAssosByUser.php';
		$assos = new AjaxUsersAssos();
	break;
	
	case 'confirmcovoit':
		require_once dirname( __FILE__ ) . '/confirmCovoit.php';
		$assos = new AjaxCovoit();
	break;
}
exit();
?>
