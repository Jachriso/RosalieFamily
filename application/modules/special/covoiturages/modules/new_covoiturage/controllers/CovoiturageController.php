<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';
require_once APPLICATION_PATH . '/controllers/CovoituragesController.php';
require_once APPLICATION_PATH . '/controllers/AssociationsController.php';
require_once APPLICATION_PATH . '/controllers/AdherentsController.php';
require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';

class Covoiturage extends Covoiturages
{
	public $a_fields = array();
    public $a_data = array();
    public $s_include_page = '';

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
			$users = new UsersController(); 
			$covoiturage = new CovoituragesController();
			$adherents = new AdherentsController();
			$this->a_fields = $covoiturage->newCovoiturage();

			$this->a_fields['fields']['covoiturage_adherent']['data'] = $adherents->getAdherentsActiv($_SESSION['user_info']['user_id']);

			$associations = new AssociationsController();
			if(isset($_POST['covoiturage_adherent'])) { 
				$list_assos = array();
				$list_assos = $associations->getAssociationsByAdherent($_POST['covoiturage_adherent']);
				foreach($list_assos AS $key => $val){
					$this->a_fields['fields']['covoiturage_add_end']['data'][$val['association_id']."_1"] = $val['association_label'] . ", " . $val['association_addr_label2'] . " : " . $val['association_address'] . ", " . $val['association_zip'] . " "  . $val['association_city'];
					if(!empty($val['association_address1']) && !empty($val['association_zip2']) && !empty($val['association_city2']))
						$this->a_fields['fields']['covoiturage_add_end']['data'][$val['association_id']."_2"] = $val['association_label'] . ", " . $val['association_addr_label2'] . " : " . $val['association_address2'] . ", " . $val['association_zip2'] . " "  . $val['association_city2'];
				}
			}else{
				$list_assos = array();
				$list_assos = $associations->getAssociations();
				foreach($list_assos AS $key => $val){
					$this->a_fields['fields']['covoiturage_add_end']['data'][$val['association_id']."_1"] = $val['association_label'] . ", " . $val['association_addr_label1'] . " : " . $val['association_address'] . ", " . $val['association_zip'] . " "  . $val['association_city'];
					if(!empty($val['association_address2']) && !empty($val['association_zip2']) && !empty($val['association_city2']))
						$this->a_fields['fields']['covoiturage_add_end']['data'][$val['association_id']."_2"] = $val['association_label'] . ", " . $val['association_addr_label2'] . " : " . $val['association_address2'] . ", " . $val['association_zip2'] . " "  . $val['association_city2'];
				}
			}

			$addr_user = $users->getAdresses($_SESSION['user_info']['user_id']);
		
			$this->a_fields['fields']['covoiturage_add_start']['data'][1] = $starter->_get_lexique("Domicile") /*. " : " . $addr_user['user_zipcode'] . ", " . $addr_user['user_city']*/;
			$this->a_fields['fields']['covoiturage_add_start']['data'][2] = $addr_user['user_addr2_label'] /*. " : " . $addr_user['user_zipcode2'] . ", " . $addr_user['user_city2']*/;
			
			if($starter->utils->is__countable($_POST) && count($_POST) > 0) 
			{	
				require_once LIBRARY_PATH . '/form_checker.class.php' ;

				if($_POST['covoiturage_type'] == 2){ 
					unset($this->a_fields['fields']['covoiturage_nb_places']['verif']);
					//unset($this->a_fields['fields']['covoiturage_add_start']['verif']);
				}else{
					unset($this->a_fields['fields']['covoiturage_adherent']['verif']);
				}

				$starter->checkForm = new form_checker($this->a_fields['fields']);
				if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0){
					$_SESSION['WARNING'] = array(
						'type' => 'error',
						'title' => $starter->_get_lexique('Votre Covoiturage'),
						'content' => $starter->checkForm->a_errors 
					);
				}
				else
				{
					if($this->a_data == false){
	        			$covoiturage->addCovoiturage();

	        			$email = new EmailSender();
	        			if($_POST['covoiturage_type'] == 2){ 
							$a_data_email = array(
								'tpl' => dirname(__FILE__) . '/../../../views/email/new-covoit.php',
								'action' => "new-covoit",
								'destinataire' => $_SESSION['user_info']['user_email'],
								'subject' => "🎒" . $starter->_get_lexique('Demande de trajet bien reçue par Rosalie Family !'),
								'PRENOM' => $_SESSION['user_info']['user_fname'],
								'PRENOMCHILD' => $this->a_fields['fields']['covoiturage_adherent']['data'][$_POST['covoiturage_adherent']]["adherent_fname"],
								'DESTINATION' => $this->a_fields['fields']['covoiturage_add_end']['data'][$_POST['covoiturage_add_end']],
								'JOUR' => $starter->utils->format_date('dd-mm-YYYY',$_POST['covoiturage_date']),
								'HEURE' => $_POST['covoiturage_h_end'],
							);
						}else{
							$a_data_email = array(
								'tpl' => dirname(__FILE__) . '/../../../views/email/new-covoit-cond.php',
								'action' => "new-trajet",
								'destinataire' => $_SESSION['user_info']['user_email'],
								'subject' => "🚗" . $starter->_get_lexique('Merci, parent accompagnateur ! Ton trajet est proposé à la communauté'),
								'PRENOM' => $_SESSION['user_info']['user_fname'],
								'DESTINATION' => $this->a_fields['fields']['covoiturage_add_end']['data'][$_POST['covoiturage_add_end']],
								'JOUR' => $starter->utils->format_date('dd-mm-YYYY',$_POST['covoiturage_date']),
								'HEURE' => $_POST['covoiturage_h_end'],
							);
						}
						
						$sender_email = $email->sendEmail($a_data_email);
						
						$_SESSION['WARNING'] = array(
							'type' => 'success',
							'title' => $starter->_get_lexique('Votre covoiturage.'),
							'content' => array($starter->_get_lexique('Demande de trajet bien reçue par Rosalie Family !')), 
						);

	        		}else{
	        			$covoiturage->updateCovoiturage();

						$_SESSION['WARNING'] = array(
							'type' => 'success',
							'title' => $starter->_get_lexique('Votre covoiturage.'),
							'content' => array($starter->_get_lexique('Les modifications ont bien été prises en compte.')), 
						);
	        		}

					header('Location:' . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer']);
					exit();
				}
			}
			

	        //CSS
			
	        //JS
	        $starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "templates/" . $starter->s_template . "/modules/special/covoiturages/js/main.js");

			$this->s_include_page = '/modules/special/covoiturages/views/' . (is_file(APPLICATION_PATH .'/modules/special/covoiturages/views/' . $starter->s_display. '/covoiturage.php') ? $starter->s_display : 'default') . '/covoiturage.php';

			// rel files
			$s_rel_id = $starter->mods['covoiturages']['rel'];
		}
    }
}
?>