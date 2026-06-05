<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';
require_once APPLICATION_PATH . '/controllers/AdherentsController.php';
require_once APPLICATION_PATH . '/controllers/AssociationsController.php';
require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';

class Profil extends Profils
{
    public $s_include_page = '';
    public $views = false;
    public $a_output = array();

	function __construct() {
        $this->init();
    }
    private function init()
    {
    	global $starter;
		
		$s_token = htmlentities($starter->s_level3);
		if(!empty($s_token)){
			$adherent = new AdherentsController();
			$a_data = $adherent->getAdherentByToken($s_token);

			if(!$a_data)
			{
				$_SESSION['WARNING'] = array(
					'type' => 'error',
					'title' => $starter->_get_lexique("Validation d'un adhérent"),
					'content' => array($starter->_get_lexique("Ce lien est invalide. Veuillez vous rapprocher de votre webmaster.")) 
				);
			}
			else
			{
				$adherent->updateAdherentValid($a_data['adasso_id']);

		    	$email = new EmailSender();
				$to = $a_data["user_email"];
				$a_data_email = array(
					'tpl' => dirname(__FILE__) . '/../../../views/email/adherent_confirmation.php',
					'action' => "adherent-confirmation",
					'destinataire' => $to,
					'subject' => $starter->_get_lexique("Votre inscription est validée") . " ✅",
					'PRENOM' => $a_data["user_firstname"],
					'ASSO' => $a_data["association_label"],
					'CONFIRMATION' => $starter->HTTP_ROOT,
				);

				$sender_email = $email->sendEmail($a_data_email);

				$_SESSION['WARNING'] = array(
					'type' => 'success',
					'title' => $starter->_get_lexique("Validation d'un adhérent"),
					'content' => array($starter->_get_lexique("L'adhérent a bien été validé. Un mail de confirmation lui a été envoyé.")) 
				);
			}
		}else{
			$_SESSION['WARNING'] = array(
				'type' => 'error',
				'title' => $starter->_get_lexique("Validation d'un adhérent"),
				'content' => array($starter->_get_lexique("Ce lien est invalide. Veuillez vous rapprocher de votre webmaster.")) 
			);
		}
        
		$this->view();		
    }

    public function view($json = false){
    	global $starter;
    	
		// VIEWS
		$this->s_include_page = '/modules/special/profil/views/' . (is_file(APPLICATION_PATH .'/modules/special/profil/views/' . $starter->s_display. '/validation.php') ? $starter->s_display : 'default') . '/validation.php';
    }
}
?>