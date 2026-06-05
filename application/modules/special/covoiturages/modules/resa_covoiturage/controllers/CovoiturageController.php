<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';
require_once APPLICATION_PATH . '/controllers/AdherentsController.php';
require_once APPLICATION_PATH . '/controllers/AssociationsController.php';
require_once APPLICATION_PATH . '/controllers/CovoituragesController.php';
require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';

class Covoiturage extends Covoiturages
{
	public $a_fields = array();
    public $a_data = array();
    public $s_include_page = '';
    public $views = false;
    public $a_adherent = array();
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
	        $a_data = $covoiturage->getCovoiturage();
	        
	        if($a_data == false){
	    		header("Location:" . $starter->HTTP_ROOT .$starter->s_lang . '/' . $starter->mods['covoiturages']['referer'] );
				exit();
	        }
			$user = new UsersController();
			$adherent = new AdherentsController();
	        $this->a_adherent = $adherent->getAdherents($_SESSION['user_info']['user_id']);

	        if($a_data['covoiturage_type'] == 1)
	        	$this->a_fields = $covoiturage->newResa();
	
			if($starter->utils->is__countable($_POST) && count($_POST) > 0) 
			{	
				$b_send = true;
	        	if($a_data['covoiturage_type'] == 1){
					require_once LIBRARY_PATH . '/form_checker.class.php' ;

					$starter->checkForm = new form_checker($this->a_fields['fields']);

					if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0){
						$b_send = false;
		        		$message = $starter->checkForm->a_errors;
		        		

						//$_SESSION['user_info']['user_lastname'] = htmlentities($_POST['user_lastname']);
						//$_SESSION['user_info']['user_firstname'] = htmlentities($_POST['user_firstname']);

						$s_html = '<div class="overlay_container">' . $message . '</div>';

						$this->a_output['response_code'] = 1 ;
						$this->a_output['response_message'] = $s_html ;
					}
				}
				if($b_send)
				{
	        		$a_resa = $covoiturage->getResa();
					$b_add = true;

					if($a_resa != false){
						foreach($a_resa AS $key => $val){
							if($val['adherent_id'] == $a_data['adherent'])
							$b_add = false;
						}
					}
					if($b_add){
        				$cond = $a_data['user'];
        				$passenger = $a_data['covoiturage_adherent'];
        				$parent = $_SESSION['user_info']['user_id'];
	        			

	        			$volants = $user->getVolantsByUser($parent);
	        			if(intval($volants['user_volants']) >= 2){

		        			$_ref = $covoiturage->addResa($a_data);
		        			$user->setVolants($volants,$passenger,2);

		        			$associations = new AssociationsController(); 
							$list_assos = $associations->getAssociations();
							foreach($list_assos AS $key => $val){
								$assoc[$val['association_id']."_1"] = $val['association_label'] . " : " . $val['association_address'] . ", " . $val['association_zip'] . " "  . $val['association_city'];
								if(!empty($val['association_address2']) && !empty($val['association_zip2']) && !empty($val['association_city2']))
									$assoc[$val['association_id']."_2"] = $val['association_label'] . " : " . $val['association_address2'] . ", " . $val['association_zip2'] . " "  . $val['association_city2'];
							}

		        			$volants = $user->getVolantsByUser($cond);
		        			$user->setVolants($volants,$cond,1);
		        			$message = $starter->_get_lexique('Votre réservation à bien été prises en compte.');
							$this->a_output['response_code'] = 0 ;

							$_adherent = $adherent->getAdherent($passenger);
							$_cond = $user->getUser($cond);
							$_parent = $user->getUser($parent);

		        			$email = new EmailSender();
		        			$a_data_email = array();
							if($a_data['covoiturage_type'] == 1){
								$a_data_email = array(
									'tpl' => dirname(__FILE__) . '/../../../views/email/covoit-demand-cond.php',
									'action' => "covoit-demand-cond",
									'destinataire' => $_cond['user_email'],
									'subject' => ($starter->_get_lexique("Nouvelle réservation")),
									'PRENOM' => $_cond['user_firstname'],
									'PRENOMCHILD' => $_adherent['adherent_fname'],
									'DESTINATION' => $assoc[$a_data['covoiturage_add_end']],
									'CONFIRMATION' => $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['validation']['referer'] . ".html?ref=". $_ref,
									'ADDRSTART' => $_adherent['user_address'],
									'JOUR' => $a_data['covoiturage_date'],
									'NAME' => $_parent['user_firstname'],
								);
								$sender_email = $email->sendEmail($a_data_email);
								
			        			/*$email = new EmailSender();
			        			$a_data_email = array();
								
								$a_data_email = array(
									'tpl' => dirname(__FILE__) . '/../../../views/email/covoit-demand.php',
									'action' => "covoit-demand",
									'destinataire' => $_parent['user_email'],
									'subject' => ($starter->_get_lexique("Nouvelle réservation")),
									'PRENOM' => $_parent['user_firstname'],
									'PRENOMCHILD' => $_adherent['adherent_fname'],
									'DESTINATION' => $assoc[$a_data['covoiturage_add_end']],
									'CONFIRMATION' => $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['validation']['referer'] . ".html?ref=". $_ref,
									'NAME' => $_cond["user_firstname"],
									'ADDRSTART' => $_adherent['user_address'],
									'JOUR' => $a_data['covoiturage_date'],
								);*/
							}else{
								$a_data_email = array(
									'tpl' => dirname(__FILE__) . '/../../../views/email/covoit-demand.php',
									'action' => "covoit-demand",
									'destinataire' => $_cond['user_email'],
									'subject' => ($starter->_get_lexique("Nouvelle réservation")),
									'PRENOM' => $_cond['user_firstname'],
									'PRENOMCHILD' => $_adherent['adherent_fname'],
									'DESTINATION' => $assoc[$a_data['covoiturage_add_end']],
									'CONFIRMATION' => $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['validation']['referer'] . ".html?ref=". $_ref,
									'ADDRSTART' => $_adherent['user_address'],
									'JOUR' => $a_data['covoiturage_date'],
									'NAME' => $_parent['user_firstname'],
								);
								$sender_email = $email->sendEmail($a_data_email);
								
			        			/*$email = new EmailSender();
			        			$a_data_email = array();
								
								$a_data_email = array(
									'tpl' => dirname(__FILE__) . '/../../../views/email/covoit-demand-cond.php',
									'action' => "covoit-demand-cond",
									'destinataire' => $_parent['user_email'],
									'subject' => ($starter->_get_lexique("Nouvelle réservation")),
									'PRENOM' => $_parent['user_firstname'],
									'PRENOMCHILD' => $_adherent['adherent_fname'],
									'DESTINATION' => $assoc[$a_data['covoiturage_add_end']],
									'CONFIRMATION' => $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['validation']['referer'] . ".html?ref=". $_ref,
									'NAME' => $_cond["user_firstname"],
									'ADDRSTART' => $_adherent['user_address'],
									'JOUR' => $a_data['covoiturage_date'],
								);*/
							}
							
							//$sender_email = $email->sendEmail($a_data_email);
							if($a_data['covoiturage_type'] == 1){

		        				unset($_SESSION['WARNING']);
								$s_html = '<div class="overlay_container">' . $message . '</div>';
								$this->a_output['response_message'] = $s_html ;
								$this->view(true);
							}
							else{
								$_SESSION['WARNING'] = array(
									'type' => 'success',
									'title' => $starter->_get_lexique('Votre réservation.'),
									'content' => array($message)
								);
					    		header("Location:" . $starter->HTTP_ROOT .$starter->s_lang . '/' . $starter->mods['covoiturages']['referer'] );
								exit();
							}
						}else{
	        				$message = $starter->_get_lexique("Vous n'avez pas suffisament de volants pour réserver ce trajet.");
	        				unset($_SESSION['WARNING']);
							$s_html = '<div class="overlay_container">' . $message . '</div>';
							$this->a_output['response_message'] = $s_html ;
							$this->view(true);
						}

		    		}else{
	        			$message = $starter->_get_lexique('Vous avez déjà réservé ce trajet pour cet adhérent.');
						$this->a_output['response_code'] = 1 ;
					}
	        		/*else{
		    			$covoiturage->updateResa($a_resa);
		    			$message = $starter->_get_lexique('Les modifications ont bien été prises en compte.');

		    			$email = new EmailSender();
						$a_data_email = array(
							'tpl' => dirname(__FILE__) . '/../../../views/email/index.php',
							'action' => "update-resa",
							'destinataire' => "",//$_POST['user_email'],
							'subject' => ($starter->_get_lexique("Nouvelle réservation")),
						);
						
						$sender_email = $email->sendEmail($a_data_email);
		    		}*/
	        		unset($_SESSION['WARNING']);
					//$_SESSION['user_info']['user_lastname'] = htmlentities($_POST['user_lastname']);
					//$_SESSION['user_info']['user_firstname'] = htmlentities($_POST['user_firstname']);

					$s_html = '<div class="overlay_container">' . $message . '</div>';
					$this->a_output['response_message'] = $s_html ;
				}
				// output
				$this->view(true);
			}
			else
			{
	    		if($a_data['covoiturage_type'] == 1){
					$this->view();
	    		}
				else{
		    		header("Location:" . $starter->HTTP_ROOT .$starter->s_lang . '/' . $starter->mods['covoiturages']['referer'] );
					exit();
				}
				// VIEWS
			}
	        //CSS
			
	        //JS			

			// rel files
			$s_rel_id = $starter->mods['covoiturages']['rel'];

		}
    }

    public function view($json = false){
    	global $starter;
    	if($json){
			echo json_encode($this->a_output);
			exit() ;
    	}else{
		// VIEWS
    		
    		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/head.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/head.php' ;
			
			$starter->a_include_pages[] = '/modules/special/covoiturages/views/' . (is_file(APPLICATION_PATH .'/modules/special/covoiturages/views/' . $starter->s_display. '/resa.php') ? $starter->s_display : 'default') . '/resa.php';
	    	
	    	$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/foot.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/foot.php' ;
	    	
		}
    }
}
?>