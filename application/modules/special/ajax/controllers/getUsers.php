<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';

class AjaxUsers extends Starter
{
    public $a_data = array();

    function __construct() {
        $this->init();
    }

    private function init()
    {
    	$users = new UsersController();
        $a_data = $users->getUsers();
        
		$a_output['response_code'] 		= 0 ;
		$a_output['response_message'] 	= "" ;
		$a_output['response_data']      = $a_data ;

		// output
		echo json_encode($a_output);
		exit() ;

    }
}
?>
