<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';
require_once APPLICATION_PATH . '/controllers/AdherentsController.php';
require_once APPLICATION_PATH . '/controllers/AssociationsController.php';
require_once APPLICATION_PATH . '/controllers/CovoituragesController.php';
require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';

class Covoiturage extends Covoiturages
{
    public $s_include_page = '';
    public $views = true;
    public $a_output = array();

	function __construct() {
        $this->init();
    }
    private function init()
    {
    	global $starter;

		if(!isset($_SESSION['user_info'])){
    		header("Location:" . $starter->HTTP_ROOT .$starter->s_lang . '/' . $starter->mods['subscribe']['referer'] );
			exit();
    	}else{
			
			$covoiturage = new CovoituragesController();
			$adherent = new AdherentsController();
			$a_data = $covoiturage->getResaByRef($_GET['ref']);
			
	        $covoiturage->validCovoiturage($a_data);
			$a_data = $covoiturage->getResaByRef($_GET['ref']);

			$associations = new AssociationsController(); 
			$list_assos = $associations->getAssociations();
			foreach($list_assos AS $key => $val){
				$assoc[$val['association_id']."_1"] = $val['association_label'] . " : " . $val['association_address'] . ", " . $val['association_zip'] . " "  . $val['association_city'];
				if(!empty($val['association_address2']) && !empty($val['association_zip2']) && !empty($val['association_city2']))
					$assoc[$val['association_id']."_2"] = $val['association_label'] . " : " . $val['association_address2'] . ", " . $val['association_zip2'] . " "  . $val['association_city2'];
			}

	        if($a_data['covoiturage_type'] == 1){ 
	        	$_cond_email = $a_data['user_email'];
	        	$_cond_firstname = $a_data['user_firstname'];
	        	$_passager_email = $a_data['resa_user_email'];
	        	$_passager_firstname = $a_data['resa_user_firstname'];
	        	$_passager_id = $a_data['covoiturage_adherent'];
	        	$_parent_id = $a_data['resa_user_id'];
	        }else{
	        	$_cond_email = $a_data['resa_user_email'];
	        	$_cond_firstname = $a_data['resa_user_firstname'];
	        	$_passager_email = $a_data['user_email'];
	        	$_passager_firstname = $a_data['user_firstname'];
	        	$_passager_id = $a_data['covoiturage_adherent'];
	        	$_parent_id = $a_data['user_id'];
	        }
	        $_adherent = $adherent->getAdherent($_passager_id);

	        /*if($a_data['valid_cond'] && $a_data['valid_passager']){
		        $email = new EmailSender();
	        	$a_data_email = array(
					'tpl' => dirname(__FILE__) . '/../../../views/email/covoit-confirmation-cond.php',
					'action' => "covoit-confirmation-cond",
					'destinataire' => $_cond_email,
					'subject' => "🌟". $starter->_get_lexique('Bonne nouvelle, le passager a confirmé l’accompagnement') . " 👍",
					//'PRENOM' => $_cond_firstname,
					//'PRENOMCHILD' => $_adherent['adherent_fname'],
					//'DESTINATION' => $assoc[$a_data['covoiturage_add_end']],
					//'ADDRSTART' => $_adherent['user_address'],
					//'JOUR' => $a_data['covoiturage_date'],
				);
				$sender_email = $email->sendEmail($a_data_email);
			
				$a_data_email = array(
					'tpl' => dirname(__FILE__) . '/../../../views/email/covoit-confirmation.php',
					'action' => "covoit-confirmation",
					'destinataire' => $_passager_email,
					'subject' => "🌟" . $starter->_get_lexique('Bonne nouvelle, le conducteur a confirmé l’accompagnement') . " 🚗✅",
					//'PRENOM' => $_passager_firstname,
					//'PRENOMCHILD' => $_adherent['adherent_fname'],
					//'DESTINATION' => $assoc[$a_data['covoiturage_add_end']],
					//'NAME' => $_cond_firstname,
					//'ADDRSTART' => $_adherent['user_address'],
					//'JOUR' => $a_data['covoiturage_date'],
				);
				$sender_email = $email->sendEmail($a_data_email);

	        }else{*/

				if (($a_data['covoiturage_type'] == 2 && $a_data["user_id"] == $_SESSION['user_info']['user_id']) || ($a_data['covoiturage_type'] == 1 && $a_data['resa_user_id'] == $_SESSION['user_info']['user_id'])){
					$email = new EmailSender();
					
					$a_data_email = array(
						'tpl' => dirname(__FILE__) . '/../../../views/email/covoit-confirmation-cond.php',
						'action' => "covoit-confirmation-cond",
						'destinataire' => $_cond_email,
						'subject' => "🌟". $starter->_get_lexique('Ton covoiturage est confirmé ! En route avec Rosalie Family'),
						'PRENOM' => $_cond_firstname,
						'PRENOMCHILD' => $_adherent['adherent_fname'],
						'DESTINATION' => $assoc[$a_data['covoiturage_add_end']],
						'CONFIRMATION' => $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['validation']['referer'] . ".html?ref=". $_GET['ref'],
						'ADDRSTART' => $_adherent['user_address'],
						'JOUR' => $a_data['covoiturage_date'],
						'NAME' => $_cond_firstname,
					);
					$sender_email = $email->sendEmail($a_data_email);
		        }else{
		        	$email = new EmailSender();

					$a_data_email = array(
						'tpl' => dirname(__FILE__) . '/../../../views/email/covoit-confirmation.php',
						'action' => "covoit-confirmation",
						'destinataire' => $_passager_email,
						'subject' => "🌟" . $starter->_get_lexique('Ton covoiturage est confirmé ! En route avec Rosalie Family'),
						'PRENOM' => $_passager_firstname,
						'PRENOMCHILD' => $_adherent['adherent_fname'],
						'DESTINATION' => $assoc[$a_data['covoiturage_add_end']],
						'CONFIRMATION' => $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['validation']['referer'] . ".html?ref=". $_GET['ref'],
						'NAME' => $_cond_firstname,
						'ADDRSTART' => $_adherent['user_address'],
						'JOUR' => $a_data['covoiturage_date'],
					);
					$sender_email = $email->sendEmail($a_data_email);
		        }
	        //}
	        if(isset($_GET['inline'])){
	        	$_SESSION['WARNING'] = array(
					'type' => 'success',
					'title' => $starter->_get_lexique('Votre réservation.'),
					'content' => array($starter->_get_lexique('Bravo, vous avez validé le trajet !'))
				);

	    		header("Location:" . $starter->HTTP_ROOT .$starter->s_lang . '/' . $starter->mods['covoiturages']['referer']  . '/' . $starter->mods['covoiturages']['modules']['mes-covoiturages']['referer'] );
				exit();
	        }
			$this->view();

		}
    }

    public function view($json = false){
    	global $starter;
    	
		// VIEWS		
    	
    	$this->s_include_page = '/modules/special/covoiturages/views/' . (is_file(APPLICATION_PATH .'/modules/special/covoiturages/views/' . $starter->s_display. '/validation.php') ? $starter->s_display : 'default') . '/validation.php';
	    	

    }
}
?>