<?php
require_once APPLICATION_PATH . '/controllers/AssociationsController.php';

class AjaxUsersAssos extends Starter
{
    function __construct() {
        $this->init();
    }

    private function init()
    {
    	$assos = new AssociationsController();
        $a_data = $assos->getAssociationsByAdherent($_POST['adherent']);
        
		$a_output['response_code'] 		= 0 ;
		$a_output['response_message'] 	= "" ;
		$a_output['response_data']      = $a_data ;

		// output
		echo json_encode($a_output);
		exit() ;

    }
}
?>
