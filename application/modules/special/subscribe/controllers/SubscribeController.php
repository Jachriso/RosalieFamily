<?php
require_once APPLICATION_PATH . '/controllers/!locked/AuthController.php';
require_once APPLICATION_PATH . '/controllers/!locked/UserController.php';
require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';

class Subscribe extends Starter
{
	public $a_fields = array();
	private $s_page = 'index.php';
	private $name;

	function __construct() {
        $this->init();
    }

    private function init()
    {
    	global $starter;
        $this->name = strtolower(get_class($this));
    	$auth = new AuthController();
		$user = new UserController();
		$a_errors = array();
    	if(isset($_SESSION['user_info'])){
    		header("Location:" . $starter->HTTP_ROOT);
			exit();
		}

    	if(isset($_GET["reload"]) && isset($_POST['user_email'])){

			$a_data_query = array(
				'user_email' => array($_POST['user_email'],PDO::PARAM_STR),
			);
			$s_query ="
				SELECT user_id, user_firstname
				FROM admin_users
				WHERE user_email = :user_email
				AND archive = 0
				AND online = 1
				AND user_valid = 0
				AND user_brutforce < 3";

			$a_data_user = $starter->database->prepare_query($s_query, $a_data_query);
			if(!$a_data_user){	
				$a_output['response_code'] = 1 ;
				$a_output['response_errors'] = array($starter->_get_lexique("Pour certaines raisons, votre compte est inactif. Veuillez contacter le support afin que nous puissions vous aider."));
				$a_output['response_message'] = array($starter->_get_lexique("Pour certaines raisons, votre compte est inactif. Veuillez contacter le support afin que nous puissions vous aider."));
			}else{
				$s_token_email = bin2hex(random_bytes(32));
				
				$a_data_query = array(
					'user_email' => array($_POST['user_email'], PDO::PARAM_STR),
					'user_token' => array($s_token_email, PDO::PARAM_STR),
				);
				$_POST['user_fname'] = $a_data_user['user_firstname'];
				$s_query = "
					UPDATE admin_users
					SET user_token = :user_token
					WHERE user_email = :user_email
					AND archive = 0" ;
								
				$starter->database->prepare_query($s_query,$a_data_query);
				require_once LIBRARY_PATH . '/phpmailer/class.phpmailer.php' ;
						
				$link_token = $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . 'confirm/' . $s_token_email;

				$email = new EmailSender();
				$a_data_email = array(
					'tpl' => dirname(__FILE__) . '/../views/email/subscribe.php',
					'action' => "subscribe",
					'destinataire' => $_POST['user_email'],
					'link' => $link_token,
					'subject' => $starter->_get_lexique("Votre inscription &agrave; Rosalie"),
				);
				
				$sender_email = $email->sendEmail($a_data_email);
				
				$a_output['response_code'] = 0 ;
				$a_output['response_errors'] = array($starter->_get_lexique("Un email d'activation vient de vous être envoyé."));
				$a_output['response_message'] = $starter->_get_lexique("Un email d'activation vient de vous être envoyé.");
			}
			echo json_encode($a_output);
			exit ;
		}elseif($starter->s_level1 == "confirm"){

    		$a_data = array();
    		$a_errors = array();

    		$a_data = $auth->getUserByToken($_GET['confirm']);

			if(!$a_data || count($a_data) == 0)
			{
				$_SESSION['WARNING'] = array(
					'type' => 'error',
					'title' => $starter->_get_lexique('Votre inscription.'),
					'content' => array($starter->_get_lexique("Nous sommes désolés, le lien que vous avez suivi semble être invalide. Si vous avez demandé plusieurs fois l'envoi d'un message, veuillez noter que seul le lien le plus récent sera actif. Avez-vous vérifié le dernier message que vous avez reçu ? Si le problème persiste, n'hésitez pas à nous joindre directement via notre formulaire de contact. Nous sommes là pour vous aider.")
					),
				);
			}
			else
			{
				$auth->updateUserToken($a_data['user_id']);
			}
			// rel files
			$s_rel_id = "confirm";
			$this->s_page = 'confirm.php';
    	}else{
    		$starter->cache  = $starter->mods['subscribe']['cache'];

			$this->a_fields = array(
				"fields" => array(
					'user_lname'	=> array(
						"group" 		=> 1,
						"field"			=> "user_lname",
						"type"			=> "text",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"label"			=> $starter->_get_lexique("Nom"),
						"placeholder"	=> $starter->_get_lexique("35 caractères maximum"),
						"error_label"	=> $starter->_get_lexique("Saisie du nom incorrecte"),
						"verif"			=> array("mandatory"),
						"onkeydown"		=> "alpha+",
						"maxlength"		=> 35,
						//"ismaxlength"	=> true,
					),
					'user_fname'	=> array(
						"group" 		=> 1,
						"field"			=> "user_fname",
						"type"			=> "text",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"label"			=>	$starter->_get_lexique("Prénom"),
						"placeholder"	=>	$starter->_get_lexique("35 caractères maximum"),
						"error_label"	=>	$starter->_get_lexique("Saisie du prénom incorrecte"),
						"verif"			=>	array("mandatory"),
						"onkeydown"		=> "alpha+",
						"maxlength"		=>	35,
						//"ismaxlength"	=> true,
					),
					/*'user_mobile'	=> array(
						"group" 		=> 1,
						"field"			=> "user_mobile",
						"type"			=> "text",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"label"			=>	$starter->_get_lexique("Numéro de portable :"),
						"placeholder"	=>	$starter->_get_lexique("Indiquez au moins un numéro"),
						"error_label"	=>	$starter->_get_lexique("Saisie du numéro de portable incorrecte."),
						"verif"			=>	array("mandatory"),
						"preg_pattern"	=>	$starter->preg_pattern_tel,
						"maxlength"		=>	10,
						"oninput"		=> "tel",
						"datalinked"	=> "user_phone"
					),
					'user_phone'	=> array(
						"group" 		=> 1,
						"field"			=> "user_phone",
						"type"			=> "text",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"label"			=>	$starter->_get_lexique("Numéro fixe (facultatif) :"),
						"placeholder"	=>	$starter->_get_lexique("Indiquez au moins un numéro"),
						"error_label"	=>	$starter->_get_lexique("Saisie du numéro de téléphone incorrecte."),
						"verif"			=>	array("mandatory"),
						"preg_pattern"	=>	$starter->preg_pattern_tel,
						"maxlength"		=>	10,
						"oninput"		=> "tel",
						"datalinked"	=> "user_mobile"
					),*/
					'user_email'	=> array(
						"group" 		=> 1,
						"field"			=> "user_email",
						"type"			=> "text",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"verif"			=>	array("mandatory"),
						"label"			=>	$starter->_get_lexique("Email"),
						"maxlength"		=>	255,
						"error_label"	=>	$starter->_get_lexique("Saisie de l'e-mail incorrecte"),
						"placeholder"	=>	$starter->_get_lexique("adresse@domaine.com"),
						"error_label_already"	=>	$starter->_get_lexique("Un compte relié à cet email existe déjà."),
						"preg_pattern"	=>	$starter->preg_pattern_email,
						"check_method"	=>	'already',
						"check_data"	=> 	array("table"	=> "admin_users", "key"=>"user_id"),
						"db_field"		=>	'user_email'
					),
					/*'user_email_confirm'	=>	
						array("type"=>"text",
							"type"=>"text",
							"verif"			=>	array("mandatory"),
							"label"			=>	$starter->_get_lexique("Confirmer votre e-mail"),
							"maxlength"		=>	255,
							"error_label"	=>	$starter->_get_lexique("Confirmation incorrecte"),
							"preg_pattern"	=>	$starter->preg_pattern_email,
							"check_method"	=>	'match',
							"check_option" 	=>	'user_email'
						),*/
					'password'	=> array(
						"group" 		=> 3,
						"field"			=> "password",
						"type"			=> "password",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"verif"			=>	array("mandatory"),
						"label"			=>	$starter->_get_lexique('Mot de passe'),
						"error_label"	=>	$starter->_get_lexique("Mot de passe trop faible"),
						"options"		=> array("tooltip")
					),
					'password_confirm'	=> array(
						"group" 		=> 3,
						"field"			=> "password_confirm",
						"type"			=> "password",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"verif"			=>	array("mandatory"),
						"label"			=>	$starter->_get_lexique('Confirmation'),
						"error_label"	=>	$starter->_get_lexique('Confirmation du mot de passe incorrecte'),
						"check_method"	=>	'match',
						"check_option" 	=>	'password'
					),
					
					/*'user_cgu'	=> 
						array(
							"type"			=> "checkbox",
							"verif"			=>	array("mandatory"),
							"label"			=>	'',
							"error_label"	=>	$starter->_get_lexique("Vous devez accepter les conditions générales d'utilisation."),
						),*/
				)
			);

			$auth->getAuth();

			require_once APPLICATION_PATH . '/modules/menu/controllers/index.php' ;
			$a_footer_menu = array();
  
			//content
			if($starter->utils->is__countable($_POST) && count($_POST) > 0)
			{	
				require_once LIBRARY_PATH . '/form_checker.class.php' ;

				$starter->checkForm = new form_checker($this->a_fields['fields']);

				// output
				if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0 || intval($_POST['zxcvbn']) < 4)
				{
					if(intval($_POST['zxcvbn']) < 4)
					{
						$starter->checkForm->a_errors['password'] = $this->a_fields['fields']['password']['error_label'];
						$starter->checkForm->a_errors['password_confirm'] = $this->a_fields['fields']['password_confirm']['error_label'];
					}
					$_SESSION['WARNING'] = array(
						'type' => 'error',
						'title' => $starter->_get_lexique('Votre inscription.'),
						'content' => $starter->checkForm->a_errors 
					);
				}
				else
				{
					$a_data_user = $auth->addUser();
					if($starter->isSendinblue){
						require_once(LIBRARY_PATH . '/sendinblue/vendor/autoload.php');
						//ADD CONTACT TO SENDINBLUE
						$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', $starter->sdbApiKey);
						$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', $starter->sdbApiKey);

						$apiInstance = new SendinBlue\Client\Api\AccountApi(
						    new GuzzleHttp\Client(),
						    $config
						);

						try {
						    $result = $apiInstance->getAccount();
						    print_r($result);
						} catch (Exception $e) {
						    echo 'Exception when calling AccountApi->getAccount: ', $e->getMessage(), PHP_EOL;
						}
					}

					$link_token = $starter->HTTP_ROOT . $starter->s_lang . '/confirm/' . $a_data_user['s_token_email'];

					$email = new EmailSender();
					$a_data_email = array(
						'tpl' => dirname(__FILE__) . '/../views/email/subscribe.php',
						'action' => "subscribe",
						'destinataire' => $_POST['user_email'],
						'link' => $link_token,
						'subject' => $starter->_get_lexique("Votre inscription"),
					);
					
					$sender_email = $email->sendEmail($a_data_email);

					$email_admin = new EmailSender();
					$a_data_email = array(
						'tpl' => dirname(__FILE__) . '/../views/email/subscribe_demand.php',
						'action' => "subscribe-demand",
						'destinataire' => $starter->mailer['contact'][0],
						'subject' => $starter->_get_lexique("Nouvelle inscription"),
						'EMAIL' => $_POST['user_email'],
						'PRENOM' => $_POST['user_fname'],
						'NOM' => $_POST['user_lname'],
					);
					
					$sender_email_admin = $email_admin->sendEmail($a_data_email);
				
					$_SESSION['WARNING'] = array(
						'type' => "success",
						'title' => $starter->_get_lexique('Votre inscription.'),
						'content' =>  array($starter->_get_lexique("Votre inscription est quasiment terminée ! Vous devez la confirmer afin que votre association puisse la valider. Cliquez sur le lien envoyé par email pour activer votre compte. N'oubliez pas de vérifier vos courriers indésirables si vous ne le trouvez pas !"))
					);
					header('Location:' . $starter->HTTP_ROOT . $starter->s_lang );
					exit();
				}
			}
			// rel files
			$s_rel_id = "subscribe";
			$this->s_page = 'index.php';
		}
		$this->view();
    }

    
    public function view(){
    	global $starter;

		// CSS
		$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "templates/".$starter->s_template."/modules/special/".$this->name."/css/main.css");
			
		// JS
		$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "!locked/js/sha1.min.js");
		$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "templates/".$starter->s_template."/modules/special/$this->name/js/main.js");
		
		// VIEWS
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/head.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/head.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/header.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/header.php' ;
		$starter->a_include_pages[]  = '/modules/menu/views/' . (is_file(APPLICATION_PATH .'/modules/menu/views/' . $starter->s_template . '/' . $starter->s_display. '/index.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/index.php' ;
		
		$starter->a_include_pages[]  = '/modules/special/'.$this->name.'/views/' . (is_file(APPLICATION_PATH .'/modules/special/'.$this->name.'/views/' . $starter->s_template . '/' . $starter->s_display . '/'.$this->s_page) ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/'.$this->s_page ;
		
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/modals.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/modals.php' ;
		
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/foot.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/foot.php' ;
    }
}
?>