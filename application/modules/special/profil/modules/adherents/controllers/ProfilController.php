<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';
require_once APPLICATION_PATH . '/controllers/AdherentsController.php';
require_once APPLICATION_PATH . '/controllers/AssociationsController.php';
require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';

class Profil extends Profils
{
	public $a_fields = array();
    public $a_data = array();
    public $a_data_asso = array();
    public $s_include_page = '';
    public $associations = '';

	function __construct() {
        $this->init();
    }
    private function init()
    {
    	global $starter;

		$users = new UsersController(); 

		$associations = new AssociationsController(); 
		$this->associations = $associations->getAssociations();

		$adherents = new AdherentsController();
		$a_data = $adherents->getAdherents($_SESSION['user_info']['user_id']);
	
		foreach ($a_data AS $key => $val) {
			if(!isset($this->a_data[$val['adherent_id']]) ){
				$this->a_data[$val['adherent_id']] = $val;
				$this->a_data_asso[$val['adherent_id']] = $val;
			}
			$this->a_data[$val['adherent_id']]['assos'][] = $val['asso'];
			$this->a_data_asso[$val['adherent_id']]['assos'][] = array(
				'asso' => $val['asso'],
				'valid'=> $val['_valid'],
			);
		}
		$this->a_fields = $adherents->newAdherent();

		if($starter->utils->is__countable($_POST) && count($_POST) > 0) 
		{	
			require_once LIBRARY_PATH . '/form_checker.class.php' ;

			$starter->checkForm = new form_checker($this->a_fields['fields']);

			if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0){
				
				$_SESSION['WARNING'] = array(
					'type' => 'error',
					'title' => $starter->_get_lexique('Votre enfant'),
					'content' => $starter->checkForm->a_errors 
				);
			}
			else
			{
				$_a_data = $adherents->getAdherents($_SESSION['user_info']['user_id']);
				$a_data = array();
				foreach ($_a_data AS $key => $val) {
					if(!isset($a_data[$val['adherent_id']])){
						$a_data[$val['adherent_id']] = $val;
						$a_data[$val['adherent_id']]["assos"][] = $val['asso'];
					}else
						$a_data[$val['adherent_id']]["assos"][] = $val['asso'];
				}
				for($i=1;$i<=$_POST['adherents'];$i++){
							print_r($a_data[$_POST['adherent_ref_'.$i]]);
					if(isset($a_data[$_POST['adherent_ref_'.$i]])){
						$adherents->updateAdherent($_POST['adherent_ref_'.$i], $i);
						foreach ($_POST['asso_'.$i] AS $key => $val) {
							if(!in_array($val,$a_data[$_POST['adherent_ref_'.$i]]["assos"])){
								$token = strtolower($starter->utils->generateRandomString(32));
								$email_admin = new EmailSender();
								$to = $this->associations[$val]["association_email"];
								$a_data_email = array(
									'tpl' => dirname(__FILE__) . '/../../../views/email/adherent_demand.php',
									'action' => "adherent-demand",
									'destinataire' => $to,
									'subject' => $starter->_get_lexique("Rosalie Family - Validation d'un membre") . " - " . $_POST['adherent_fname_'.$i] . " " . $_POST['adherent_lname_'.$i],
									'EMAIL' => $_SESSION['user_info']["user_email"],
									'PRENOM' => $_SESSION['user_info']["user_fname"],
									'STRUCTURE' => $this->associations[$val]["association_label"],
									'NAME' => $_SESSION['user_info']["user_lname"],
									'PRENOMCHILD' => $_POST['adherent_fname_'.$i] . " " . $_POST['adherent_lname_'.$i],
									'CONFIRMATION' => $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'] . '/' . $starter->mods['profil']['modules']['validation']['referer'] . '/' . $token, 
								);
								$adherents->addAdherentAssos($_POST['adherent_ref_'.$i], $val, $token);

								$sender_email_admin = $email_admin->sendEmail($a_data_email);
								
							}
						}
					}else{
	        			$_id = $adherents->addAdherent($i);
						foreach ($_POST['asso_'.$i] AS $key => $val) {
							$token = strtolower($starter->utils->generateRandomString(32));
							$email_admin = new EmailSender();
							$to = $this->associations[$val]["association_email"];
							$a_data_email = array(
								'tpl' => dirname(__FILE__) . '/../../../views/email/adherent_demand.php',
								'action' => "adherent-demand",
								'destinataire' => $to,
								'subject' => $starter->_get_lexique("Rosalie Family - Validation d'un membre") . " - " . $_POST['adherent_fname_'.$i] . " " . $_POST['adherent_lname_'.$i],
								'EMAIL' => $_SESSION['user_info']["user_email"],
								'PRENOM' => $_SESSION['user_info']["user_fname"],
								'STRUCTURE' => $this->associations[$val]["association_label"],
								'NAME' => $_SESSION['user_info']["user_lname"],
								'PRENOMCHILD' => $_POST['adherent_fname_'.$i] . " " . $_POST['adherent_lname_'.$i],
								'CONFIRMATION' => $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'] . '/' . $starter->mods['profil']['modules']['validation']['referer'] . '/' . $token, 
							);
							$adherents->addAdherentAssos($_id, $val, $token);

							$sender_email_admin = $email_admin->sendEmail($a_data_email);
							
						}
					}
        		}

				//$_SESSION['user_info']['user_lastname'] = htmlentities($_POST['user_lastname']);
				//$_SESSION['user_info']['user_firstname'] = htmlentities($_POST['user_firstname']);
				
				$_SESSION['WARNING'] = array(
					'type' => 'success',
					'title' => $starter->_get_lexique('Votre enfant.'),
					'content' => array($_POST['adherents'] > 1 ? $starter->_get_lexique("Vos enfants sont bien enregistrés et la demande de validation est transmise aux structures") : $starter->_get_lexique("Votre enfant est bien enregistré et la demande de validation est transmise aux structures")), 
				);

				header('Location:' . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer']);
				exit();
			}
		}

        //CSS
		//$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "!locked/lib/dropzone/css/dropzone.css");
        //$starter->a_css[] = array( "rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "/!locked/lib/photon-geocoder-autocomplete/css/photon-geocoder-autocomplete.min.css");
		$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "!locked/lib/dropzone/css/dropzone.css?ver=0.0.1");
		
        //JS
		$starter->a_js[] 	= array('src' => $starter->HTTP_ROOT . '/!locked/lib/jquery/js/jquery-ui.min.js');
		$starter->a_js[] 	= array("src" => $starter->HTTP_ROOT . "!locked/lib/dropzone/js/dropzone.js");
        //$starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "/!locked/lib/photon-geocoder-autocomplete/js/photon-geocoder-autocomplete.min.js");
        $starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "templates/" . $starter->s_template . "/modules/special/profil/js/main.js");
        $starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "templates/" . $starter->s_template . "/modules/special/adherents/js/main.js?ver=0.0.2");

		$this->s_include_page = '/modules/special/profil/views/' . (is_file(APPLICATION_PATH .'/modules/special/profil/views/' . $starter->s_display. '/adherents.php') ? $starter->s_display : 'default') . '/adherents.php';

		// rel files
		$s_rel_id = $starter->mods['profil']['modules']['adherents']['rel'];
	}
}
?>