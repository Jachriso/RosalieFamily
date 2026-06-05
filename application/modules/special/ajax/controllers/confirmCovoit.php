<?php
require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';
require_once APPLICATION_PATH . '/controllers/UsersController.php';
require_once APPLICATION_PATH . '/controllers/CovoituragesController.php';
require_once APPLICATION_PATH . '/controllers/AssociationsController.php';

class AjaxCovoit extends Starter
{
    public $a_data = array();

    function __construct() {
        $this->init();
    }

    private function init()
    {
        global $starter;
        
        $covoiturage = new CovoituragesController();
        $a_data = $covoiturage->getResaByRef($_POST['ref']);
    	$covoiturage->updateTrajet();

        $associations = new AssociationsController(); 
        $list_assos = $associations->getAssociations();
        foreach($list_assos AS $key => $val){
            $assoc[$val['association_id']."_1"] = $val['association_label'] . " : " . $val['association_address'] . ", " . $val['association_zip'] . " "  . $val['association_city'];
            if(!empty($val['association_address2']) && !empty($val['association_zip2']) && !empty($val['association_city2']))
                $assoc[$val['association_id']."_2"] = $val['association_label'] . " : " . $val['association_address2'] . ", " . $val['association_zip2'] . " "  . $val['association_city2'];
        }

        $email = new EmailSender();
        $a_data_email = array(
            'tpl' => dirname(__FILE__) . '/../../covoiturages/views/email/confirm-trajet.php',
            'action' => "confirm-trajet",
            'destinataire' => $a_data['user_email'],
            'subject' => $a_data['user_firstname'] . " " . $starter->_get_lexique('est bien arriv&eacute;(e) &agrave; destination !'),
            'PRENOM' => $_SESSION['user_info']['user_fname'],
            'PRENOMCHILD' => $a_data['user_firstname'],
            'DESTINATION' => $assoc[$a_data['covoiturage_add_end']],
        );
        
        $sender_email = $email->sendEmail($a_data_email);
                        
        $a_output['response_code'] 		= 0 ;
		$a_output['response_message'] 	= "" ;
		$a_output['response_data']      = $a_data ;

		// output
		echo json_encode($a_output);
		exit() ;

    }
}
?>