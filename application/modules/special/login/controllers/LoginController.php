<?php
require_once APPLICATION_PATH . '/controllers/!locked/AuthController.php';
require_once APPLICATION_PATH . '/controllers/!locked/UserController.php';
require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';

class Login extends Starter
{
	public $i_brutforce = '0';
	public $a_fields = array();
	public $loginUrl = '';
	public $i_brut_force_max = 5;
	private $name;
	private $s_page = 'index.php';
	public $forgotPassword;

	function __construct() {
        $this->init();
    }

    private function init()
    {
    	global $starter;
        $this->name = strtolower(get_class($this));
    	$starter->cache  = $starter->mods['login']['cache'];

    	if(isset($_SESSION['user_info'])){
    		header("Location:" . $starter->HTTP_ROOT);
			exit();
		}

		$b_verif_valid = false;
		$b_verif = true;

		if(isset($starter->mods['forgot_password']['referer']) && $starter->s_level1 == $starter->mods['forgot_password']['referer'])
			include APPLICATION_PATH . $starter->mods['forgot_password']['path'] ;
		/*elseif(isset($starter->mods['subscribe']['referer']) && $starter->s_level1 == $starter->mods['subscribe']['referer'])
			include APPLICATION_PATH . $starter->mods['subscribe']['path'] ;*/
		elseif(isset($starter->mods['cgu']['referer']) && $starter->s_level1 == $starter->mods['cgu']['referer'])
			include APPLICATION_PATH . $starter->mods['cgu']['path'] ;
		else
		{
			$a_data = array();
			$a_errors = array();
			$this->a_fields = array(
				"fields" => array(
					'login'	=> 	array(
						"group" 		=> 0,
						"field"			=>	"login",
						"type"			=>	"text",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"dataclass"		=> "",
						"label"			=>	$starter->_get_lexique("Email"),
						"error_label"	=>	$starter->_get_lexique("Saisie du login incorrecte"),
						"verif"			=>	array("mandatory"),
					),
					'password'	=> 	array(
						"group" 		=> 0,
						"field"			=>	"password",
						"type"			=>	"password",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"dataclass"		=> "",
						"label"			=>	$starter->_get_lexique("Mot de passe"),
						"error_label"	=>	$starter->_get_lexique("Saisie du mot de passe incorrecte"),
						"verif"			=>	array("mandatory"),
					),
					'user_remember'	=> 	array(
						"group" 		=> 0,
						"field"			=>	"user_remember",
						"type"			=>	"checkbox",
						"class"			=> "col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12",
						"dataclass"		=> "",
						"label"			=>	"",
						"data"			=> array(
							"0"			=> $starter->_get_lexique("Se souvenir de moi"),
						),
					),
				),
			);
			//content
			/* ****************************** A RECODER
			

			if(isset($_COOKIE['auth'])){ 
				$auth = explode('__',$_COOKIE['auth']);
				$a_data_query = array(
					'user_id' => array($auth[0],PDO::PARAM_INT),
				);
				$s_query = "
					SELECT user_id AS id, user_login AS login, user_email AS email, user_lastname as nom,user_firstname as prenom,user_statut as statut,user_company as company,user_login, user_password 
					FROM admin_users 
					WHERE user_online = 1
					AND user_valid = 1 
					AND archive = 0 
					AND user_id = :user_id";

				$auth_user = $starter->database->prepare_query($s_query,$a_data_query);

				$key = sha1($auth_user['user_login'] . $auth_user['user_password']);

				if($key = $auth[1] && !empty($auth[0]))
				{
					$b_verif_valid = true;
					$b_verif = false;
					$_SESSION['auth'] = $auth_user;
					setcookie('auth', $auth_user['user_id'] . '__' . sha1($auth_user['user_login'] . $auth_user['user_password']), time() + 3600 * 24 * 3, '/', 'localhost', true, true);
				}else
					setcookie('auth', '', time() - 3600, '/', 'localhost', true, true);		
			}
			/* ******************************
			*/

			$auth = new AuthController();
			$a_auth = $auth->getAuth();
		
			if(($starter->utils->is__countable($_POST) && count($_POST) > 0) || $b_verif_valid || (isset($_SESSION['token']) && isset($_POST['token']) && $_POST['token'] != $_SESSION['token'])){	
				if($b_verif){ //pattern non valides
					require_once LIBRARY_PATH . '/form_checker.class.php' ;
					$starter->checkForm = new form_checker($this->a_fields);
					// output
					if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0){
						$_SESSION['WARNING'] = array(
							'type' => 'error',
							'title' => $starter->_get_lexique("Authentification"),
							'content' => array($starter->_get_lexique("Erreur d'authentification")),
							'CTA' => array(
								'title' => $starter->_get_lexique("Mot de passe oublié"),
								'type' => "modal",
								'iframe' => "iframe",
								'uri' => $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->mods['forgot_password']['referer'] . '.html',
							),
						);
					}
					else
						$b_verif_valid = true;
				}
				if($b_verif_valid)
				{
					$remember = false;
					if(isset($_POST['user_remember']) && $_POST['user_remember'])
						$remember = true;
					
					if(!isset($_SESSION['auth']))
						$auth_user = $auth->checkIdent($_POST["login"], $_POST["password"], $remember );

					if(isset($auth_user) && $auth_user != NULL ){	 //Connexion réussie
						//$d_brutforce = date('Y-m-d H:i:s');
						if($auth_user['valid'] != 1){ //compte non validé
							$_SESSION['WARNING'] = array(
								"type" => 'error',
								"title" => $starter->_get_lexique('Connexion'),
								"content" => array($starter->_get_lexique("Votre compte a bien été créé mais il n'a pas encore été activé. Un lien d'activation vous a été envoyé par email. Vérifiez bien vos courriers indésirables dans le cas où vous ne le trouveriez pas. Sinon, cliquez ci-dessous pour renvoyer le lien d'activation à") . " " . $_POST["login"]),
								"CTA" => array(
									'title' => $starter->_get_lexique('Renvoyer'),
									'type' => "sendActiv",
									'uri' => $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') .  '/' . $starter->mods['subscribe']['referer'] . '.html?reload',
									'data' => $_POST["login"]
								)
							);
						}
					 	elseif( isset($_SESSION['brutforce'])){
							$_SESSION['WARNING'] = array(
								'type' => 'error',
								'title' => $starter->_get_lexique("Authentification"),
								'content' => array($starter->_get_lexique('Votre compte est bloqué. Veuillez renouvelez votre accès')) 
							);
					 	}
						else
						{
							//unset($_SESSION['brutforce']);

							$auth->setLog($auth_user['id']);
							
							if(isset($_POST['user_remember'])) 
							{
								setcookie('auth', $auth_user['id'] . '__' . sha1($auth_user['login'] . $_POST['password']), time() + 3600 * 24 * 30, );
							}
							$_SESSION['user_info']["user_login"] 	= $auth_user['login'];
							$_SESSION['user_info']["user_email"] 	= $auth_user['email'];
							$_SESSION['user_info']["user_avatar"] 	= $auth_user['avatar'];
							$_SESSION['user_info']["user_lname"] 	= $auth_user['nom'];
							$_SESSION['user_info']["user_fname"] 	= $auth_user['prenom'];
							$_SESSION['user_info']["user_statut"] 	= $auth_user['statut'];
							$_SESSION['user_info']["user_group"]	= $auth_user['group'];
							$_SESSION['user_info']["user_rules"]	= $auth_user['rules'];
							$_SESSION['user_info']["user_asso"]		= $auth_user['asso'];
							$_SESSION['user_info']["user_id"]		= $auth_user['id'];
							//$_SESSION['PHPSESSID'] 					= $newid;
							$_SESSION['user_info']["LDAP"] 			= 0;

							if(preg_match("#admin#", $_SERVER['REQUEST_URI']) && isset( $starter->mods['dispatch']))
								header("Location: " . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['admin']['referer'] . '/' . $starter->mods['dispatch']['referer']);
							elseif(is_array($_SESSION['user_info']['user_statut']) && in_array(65,$_SESSION['user_info']['user_statut'])){
								header("Location: " . $starter->HTTP_DOMAIN . '/' . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'] );
							}
							else
								header("Location: " . $starter->HTTP_DOMAIN . '/' . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] );

							exit();
						}
					}else{
						$_a_user = $auth->getBrutforce($_POST["login"]);
						if(!$_a_user){
							
							$starter->checkForm->a_errors = array(
								$this->a_fields['fields']['login']['field'] => $this->a_fields['fields']['login']['error_label'],
								$this->a_fields['fields']['password']['field'] => $this->a_fields['fields']['password']['error_label'],
							);

							$_SESSION['WARNING'] = array(
								'type' => 'error',
								'title' => $starter->_get_lexique("Authentification"),
								'content' => array($starter->_get_lexique("Erreur d'authentification")),
								'CTA' => array(
									'title' => $starter->_get_lexique("Mot de passe oublié"),
									'type' => "modal",
									'iframe' => "iframe",
									'uri' => $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->mods['forgot_password']['referer'] . '.html',
								),
							);
						}else{
							$this->i_brutforce = intval($_a_user['user_brutforce']) + 1;

							/*if($_a_user['user_blocked'] == 1){
								$_SESSION['WARNING'] = array(
									"type" => 'error',
									"title" => $starter->_get_lexique('Connexion'),
									"content" => array($starter->_get_lexique("Votre compte a été bloqué suite à un signalement. Veuillez nous contacter à l'adresse support@kelby.fr pour en savoir plus. Nous vous répondrons dès que possible"))
								);
							}else{*/
								if($this->i_brutforce<$this->i_brut_force_max)
								{
									$auth->setBrutforce($_a_user["user_id"], $this->i_brutforce);
									$starter->checkForm->a_errors = array(
										$this->a_fields['fields']['login']['field'] => $this->a_fields['fields']['login']['error_label'],
										$this->a_fields['fields']['password']['field'] => $this->a_fields['fields']['password']['error_label'],
									);

									$_SESSION['WARNING'] = array(
										'type' => 'error',
										'title' => $starter->_get_lexique("Authentification"),
										'content' => array($starter->_get_lexique("Erreur d'authentification.")),
										'CTA' => array(
											'title' => $starter->_get_lexique("Mot de passe oublié"),
											'type' => "modal",
											'iframe' => "iframe",
											'uri' => $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->mods['forgot_password']['referer'] . '.html',
										),
									);
								}elseif($this->i_brutforce >= $this->i_brut_force_max){
									
									$PWDLINK 				= strtolower($starter->utils->generateRandomString(32));
									if($starter->isApi)
									{
										$_data = array();
										$_data['user_email'] = $_POST['user_email'];
													
										// CRL code
										$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getUser', $_data);
										$a_data = $curlApiRequest;
									}else{
										$user = new UserController();
										$a_data = $user->getUserByEmail($_POST['login']);
									}
									if(!$a_data){
										$starter->checkForm->a_errors = array(
											$this->a_fields['fields']['login']['field'] => $this->a_fields['fields']['login']['error_label'],
											$this->a_fields['fields']['password']['field'] => $this->a_fields['fields']['password']['error_label'],
										);

										$_SESSION['WARNING'] = array(
											'type' => 'error',
											'title' => $starter->_get_lexique("Authentification"),
											'content' => array($starter->_get_lexique("Erreur d'authentification.")),
											'CTA' => array(
												'title' => $starter->_get_lexique("Mot de passe oublié"),
												'type' => "modal",
												'iframe' => "iframe",
												'uri' => $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->mods['forgot_password']['referer'] . '.html',
											),
										);
									}		
									else{
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
											'tpl' => APPLICATION_PATH . '/modules/special/forgot_password/views/email/index.php',
											'action' => "forgot_pass",
											'destinataire' => $_POST['login'],
											'link' => $PWDLINK,
											'subject' => ($starter->_get_lexique("Réinitialisation du mot de passe")),
										);
										
										$sender_email = $email->sendEmail($a_data_email);
										$_SESSION['WARNING'] = array(
											"type" => 'error',
											"title" => $starter->_get_lexique('Connexion'),
											"content" => array($starter->_get_lexique("Si vous êtes le titulaire de ce compte, vous trouverez un email dans votre messagerie qui vous permettra de réinitialiser votre mot de passe et de réactiver votre compte. Si vous n'êtes pas à l'origine des échecs de connexion, penser à changer dès que possible vos différents mots de passe pour votre propre sécurité."))
										);
									}
								}
							//}
						}
					}
				}
			}
			if($starter->is_SSO){
				if( phpCAS::checkAuthentication() ){ // SI LDAP

					$cas_user_attr = phpCAS::getAttributes();

					if( $starter->utils->is__countable($cas_user_attr) && count($cas_user_attr) > 0 ){
						set_CAS_attributes($cas_user_attr);
					}
				}
			}

			$s_link = '';
			// OUTPUT
		
			// rel files
			$s_rel_id = "login";
			$this->view();
		}
    }

    public function view(){
    	global $starter;

		// CSS
		$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "templates/".$starter->s_template."/modules/special/".$this->name."/css/main.css");
			
		// JS
		$starter->a_js_out[] 	= array("src"=> "https://unpkg.com/feather-icons");

		$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "!locked/js/sha1.min.js");
		$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "templates/".$starter->s_template."/modules/special/".$this->name."/js/main.js");
		
		// VIEWS
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/head.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/head.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/header.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/header.php' ;
				
		$starter->a_include_pages[]  = '/modules/special/'.$this->name.'/views/' . (is_file(APPLICATION_PATH .'/modules/special/'.$this->name.'/views/' . $starter->s_template . '/' . $starter->s_display . '/'.$this->s_page) ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/'.$this->s_page ;
		
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/modals.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/modals.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/foot.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/foot.php' ;
    }
}
?>
