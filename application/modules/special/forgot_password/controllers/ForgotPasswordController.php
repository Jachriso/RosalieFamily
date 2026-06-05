<?php
require_once APPLICATION_PATH . '/controllers/!locked/AuthController.php';
require_once APPLICATION_PATH . '/controllers/!locked/UserController.php';
require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';

class ForgotPassword extends Starter
{
	private $a_output = array();
	private $s_include_page;
	public $uniqPass;
	public $a_fields;

	function __construct() {
        $this->init();
    }

    private function init()
    {
    	global $starter;
		
		$auth = new AuthController();
    	
    	if($starter->s_level2 == 'reset'){
    		//init vars
			$a_data = array();
			$a_errors = array();
			$a_footer_menu = array();
			$s_reset = htmlentities($starter->s_level3);
			$this->s_include_page = 'reset.php';

			//content
			if(!empty($s_reset)){
				$a_data = $auth->getUserByTokenPWD($s_reset);
					
				if(!$a_data)
				{
					$_SESSION['WARNING'] = array(
						'type' => 'error',
						'title' => $starter->_get_lexique("Renouvellement de mot de passe"),
						'content' => array($starter->_get_lexique("Ce lien est invalide. Veuillez vous rapprocher de votre webmaster.")) 
					);
				}
				else
				{
					$this->uniqPass = $auth->updateUserPwd($a_data['user_id']);
				}
			}else{
				$_SESSION['WARNING'] = array(
					'type' => 'error',
					'title' => $starter->_get_lexique("Renouvellement de mot de passe"),
					'content' => array($starter->_get_lexique("Ce lien est invalide. Veuillez vous rapprocher de votre webmaster.")) 
				);
			}
			// OUTPUT

			// rel files
			$s_rel_id = "resetpwd";
			$this->view();

    	}else{
	    	//init vars
			$a_data = array();
			$a_errors = array();
			$this->s_include_page = 'index.php';
			$this->a_fields = array(	
				'user_email'	=> 
					array(
						"champ"			=> "user_email",
						"type"			=> "text",
						"verif"			=> array("mandatory"),
						"label"			=> $starter->_get_lexique('Veuillez indiquer votre adresse e-mail') . ' : ',
						"default_value"	=>	$starter->_get_lexique('E-mail'),
						"maxlength"		=> 255,
						"error_label"	=> $starter->_get_lexique("Saisie de l'e-mail incorrecte"),
						"preg_pattern"	=> $starter->preg_pattern_email,
						"check_method"	=> 'exist',
						"check_data"	=> array("table"	=>	"admin_users"),
						"db_field"		=> 'user_email'
					),
			);
			//content
			if($starter->utils->is__countable($_POST) && count($_POST) > 0 ){
				require_once LIBRARY_PATH . '/form_checker.class.php' ;
				$starter->checkForm = new form_checker($this->a_fields);

				// output
				if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0)
				{
					$this->a_output['response_code'] = 1 ;
					$this->a_output['response_errors'] = $starter->checkForm->a_errors;
					$this->a_output['response_message'] = $starter->_get_lexique("Saisie de l'e-mail incorrecte");
				}
				else
				{
					if($starter->isApi)
					{
						$_data = array();
						$_data['user_email'] = $_POST['user_email'];
									
						// CRL code
						$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getUser', $_data);
						$a_data = $curlApiRequest;
					}else{
						$user = new UserController();
						$a_data = $user->getUserByEmail($_POST['user_email']);
					}

					if(!$a_data)
					{
						$this->a_output['response_code'] = 1 ;
						$this->a_output['response_errors'] = array("user_email" => $starter->_get_lexique("Saisie de l'e-mail incorrecte"));
						$this->a_output['response_message'] = $starter->_get_lexique("Saisie de l'e-mail incorrecte");
					}		
					else{
						$PWDLINK 				= strtolower($starter->utils->generateRandomString(32));
						
						if($starter->isApi)
						{
							$_data = array();
							$_data['user_forgotpwd'] = $PWDLINK;
							$_data['user_forgotpwd_date'] = date("Y-m-d H:i:s");
							$_data['user_id'] = intval($a_data['user_id']);
							$_data['modify'] = date("Y-m-d H:i:s");
										
							// CRL code
							$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=updatePWDRequest', $_data);
						}else{
							$a_data = $auth->updateUserForgotPassword($PWDLINK, $a_data['user_id']);
						}

						$email = new EmailSender();
						$a_data_email = array(
							'tpl' => dirname(__FILE__) . '/../views/email/index.php',
							'action' => "forgot_pass",
							'destinataire' => $_POST['user_email'],
							'link' => $PWDLINK,
							'subject' => ($starter->_get_lexique("Renouvellement de votre mot de passe")),
						);
						
						$sender_email = $email->sendEmail($a_data_email);
						
						$s_html = '<div class="overlay_container">' . $sender_email['response_message'] . '</div>';

						$this->a_output['response_message'] = $s_html ;
						//$a_output['response_code'] = 0 ;
					}
				}
				
				// output
				$this->view(true);
			}
			else
			{
	    		$this->view();
				// VIEWS
			}
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
			
			$starter->a_include_pages[]  = '/modules/special/forgot_password/views/' . (is_file(APPLICATION_PATH .'/modules/special/forgot_password/views/' . $starter->s_template . '/' . $starter->s_display . '/' . $this->s_include_page) ? $starter->s_display : 'default') . '/' . $this->s_include_page ;
	    	
	    	$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/foot.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/foot.php' ;
	    	
		}
    }
}
?>
