<?php
use \Firebase\JWT\JWT;

class Starter{
	
	//Config files
	protected 	$_filesystemIni 				= 'init.ini';
	protected 	$_dbIni 						= 'db.ini';
	protected 	$_modsIni 						= 'modules.ini';
	protected 	$_confIni 						= 'config.ini';
	protected 	$_confSql 						= 'config.sql';
	protected 	$_mailIni 						= 'mail.ini';
	private 	$o_mod_parser					= '';

	//Database Config
	private		$db_host						= '';
	private 	$db_login						= '';
	private 	$db_pwd							= '';
	private 	$db_name						= '';
	private 	$db_encode						= '';
	private 	$db_port						= '3306';
	public 		$db_type						= '';
	private 	$db_request						= '';	
	public	 	$db_prefixe						= '';
	public 		$database							;
	
	private 	$s_apikey						= '';
	public 		$apiWordpressUri				= '';

	//Serveur Config
	public 		$b_curl							= false;

	//Website Config
	public		$mods							= array();
	public		$b_multilang					= false;
	public		$s_translation					= false;
	public		$b_notification					= false;
	public		$b_minifier						= false;
	public 		$is_install						= false;
	public 		$project 						= '';
	public 		$isApi							= 0;
	public 		$ApiUri							= '';
	public 		$bdebug							= false;
	public 		$token							;
	public 		$volants							= 0;

	//Backoffice Config
	public		$sortable						= false;
	public		$up_max_filesize				= '1024000';

	//Front config
	public 		$authTree						= '';
	public 		$s_device						= '';
	public 		$s_display						= 'default';
	public 		$s_display_default				= 'desktop';
	public 		$extranet						= '';
	public 		$s_default_view					= 'frontoffice';
	public		$b_print						= false;
	public		$b_pdf							= false;
	public 		$b_module						= false;
	public		$b_mail							= false;
	public		$cache							= false;
	public		$iscache						= false;
	public		$cacheTime						= 3600;
	public		$b_cart							= false;
	public		$b_overlay						= false;
	public		$i_lang							= false;
	public		$s_lang							= false;
	public 		$a_include_pages				= array();
	public		$a_css							= array();
	public		$a_css_out						= array();
	public		$s_extended_css					= '';
	public		$a_js_first						= array();
	public		$a_js							= array();
	public		$a_js_out						= array();	
	public		$s_extended_js					= '';
	public 		$uploadFolder					= '';
	public 		$uploadSecureFolder				= '';
	public 		$uploadTemp						= '';
	public 		$preg_pattern_date				= '';
	public 		$preg_pattern_email1			= '';
	public 		$preg_pattern_tel				= '';
	public 		$preg_pattern_tel2				= '';
	public 		$preg_pattern_num				= '';
	public 		$pattern_date					= '';  
	public 		$_special_GET					= array();
	public 		$_special_POST					= array();   
	public 		$b_breadcrumb					= true;
	public 		$b_breadcrumbTree				= true;	   
	public 		$upTiny							= '';  
	public 		$preg_pattern_email				= '';  
	public 		$preg_pattern_tel1				= '';  
	public		$s_extended_js_last				= '';
	public 		$bachIsBlue						= false;
	public 		$checkForm						= array(); 

	//Externe API config
	public 		$isSendinblue					= false;
	public 		$sdbApiKey						= '';
	public 		$isStripe						= false;
	public 		$stripeApiKey					= '';
	public 		$stripeApiSecret				= '';
	public 		$isrecaptcha					= false;
	public 		$recaptchaKey					= '';
	public 		$recaptchaSecret					= '';
	public 		$gtm							= '';
	public 		$isGoogleSSO					= false;
	public 		$ggbApiKey						= '';
	public 		$ggbIdClient					= '';
	public 		$isFacebookSSO					= false;
	public 		$fbbApiKey						= '';
	public 		$fbbApiSecret					= '';
	public 		$ispaypal						= '';
	public 		$paypalId						= '';
	public 		$paypalUri						= '';
	public 		$paypalAccount					= '';
	public 		$paypalSecret					= '';

										//MAKE EN ARRAY OF VALUES
										public		$i_level						= '0';										
										public		$s_level						= '';										
										public		$s_level1						= '';										
										public		$s_level2						= '';										
										public		$s_level3						= '';										
										public		$s_level4						= '';										
										public		$s_level5						= '';										
										public		$s_level6						= '';
										
										public 		$utils							;
										
										public		$stats							= array();
																
																												
										public		$month							= array();
										
										public		$archiv							= false;
										
										public		$needauth						= true;
										
										public		$_id							= '';
										
										public		$meta							= array();
										
										
										public		$mailer							= array();
										
										public		$a_config_lang					= array();
										
										public		$a_translation					= '';
										
										public		$HTTP_ROOT						= '';
										
										public		$HTTP_DOMAIN					= '';
										
										public		$MEDIA_PATH						= '';
										
										public		$ASSETS_PATH						= '';
										
										public		$CDN_PATH						= '';
										
										public		$MEDIA_DOWNLOAD					= '';
	
										public 		$islucene						= false;
										
										public 		$lucene_index					= '';
										
										public 		$indexation						;
										
										public 		$is_SSO						= false;
										
										protected 	$_ldapIni 						= 'cas.ini';

										public  	$ldap_protocol					= '';
										
										public  	$ldap_host						= ''; 
										
										public  	$ldap_port						= '';
										 
										public  	$ldap_context					= '';
										
										
										
										public 		$s_template						= 'default';
										
										public 		$s_template_default				= 'default';
										
										public 		$log							= 'false';
		
	public 		function __construct()
    {
		$this->_run();
	}
	
	public 		function _run()
	{
		//starting session
		
		ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/_tmp'));
		ini_set('session.gc_probability', 1);
		ini_set('session.gc_maxlifetime', 3600);
		@session_start();

		//loading function
		$this->_inc_func();
		
		//load default configuration
		$this->_load_config();

		//initialise vars
		$this->_init_vars();
								
		//api authentication
		if($this->isApi ){
			$this->_my_api();
			$this->is_install = true;
		}
		else{
			//database connection
			$this->is_install = $this->_db_param();
		}
		if($this->is_install)
		{
			//load default variables
			$this->_load_vars();
		}

		//loading modules
		$this->_load_init_mods();

		//loading general conf
		$this->_get_general_conf();	
								
								//if(isset($_GET['level1']) && ($_GET['level1'] == "admin" || $_GET['level1'] == "plugins") || $this->islucene){

									if($this->is_install)
									{
										
										//loading modules
										$this->_load_mods();

										//email configuration
										$this->_email_config();
								
										//loading rel files
										$this->_get_rel();
									}
									else
									{
										//loading modules
										$this->_load_mods('init');
								
										//loading rel files
										$this->_get_rel();
									}
								//}
		
	}

	private function _my_api()
	{
		$api_POST = array();
		$api_POST['auth'] = base64_encode($this->s_apikey . "|" . $_SERVER['REMOTE_ADDR']  . "|" . $_SERVER['HTTP_HOST']);

		// CRL code
		$curlApiRequest = $this->sendCurlRequest($this->ApiUri . '?rquest=auth', $api_POST, 'POST', true);
		$jwt = $curlApiRequest->jwt;

		require_once LIBRARY_PATH . '/jwt/src/BeforeValidException.php';
		require_once LIBRARY_PATH . '/jwt/src/ExpiredException.php';
		require_once LIBRARY_PATH . '/jwt/src/SignatureInvalidException.php';
		require_once LIBRARY_PATH . '/jwt/src/JWT.php';

		$decoded = JWT::decode($jwt, $this->s_apikey, array('HS256'));
		 
		if(!$curlApiRequest || $_SERVER['SERVER_NAME'] != $decoded->aud){
			$this->utils->not_found_page();
		}
	}
	
	private 		function _load_config()
	{
		$o_parser 						= parse_ini_file(APPLICATION_PATH . '/configs/' . $this->_filesystemIni, true);
		$this->s_device 				= (isset($o_parser[APPLICATION_ENV]['configuration.device']) ? $o_parser[APPLICATION_ENV]['configuration.device'] : $this->s_device);
		$this->s_template 				= (isset($o_parser[APPLICATION_ENV]['configuration.template']) ? $o_parser[APPLICATION_ENV]['configuration.template'] : $this->s_template);
		$this->bdebug 				= (isset($o_parser[APPLICATION_ENV]['configuration.debug']) ? $o_parser[APPLICATION_ENV]['configuration.debug'] : 0);
		$this->isApi 					= (isset($o_parser[APPLICATION_ENV]['configuration.isApi']) ? $o_parser[APPLICATION_ENV]['configuration.isApi'] : 0);
		$this->ApiUri 					= (isset($o_parser[APPLICATION_ENV]['configuration.ApiUri']) ? $o_parser[APPLICATION_ENV]['configuration.ApiUri'] : 0);
		$this->s_apikey 				= (isset($o_parser[APPLICATION_ENV]['configuration.apikey']) ? $o_parser[APPLICATION_ENV]['configuration.apikey'] : 0);	
		$this->apiWordpressUri 				= (isset($o_parser[APPLICATION_ENV]['configuration.apiWordpressUri']) ? $o_parser[APPLICATION_ENV]['configuration.apiWordpressUri'] : 0);

		$this->isSendinblue 			= (isset($o_parser[APPLICATION_ENV]['configuration.isSendinblue']) ? $o_parser[APPLICATION_ENV]['configuration.isSendinblue'] : 0);
		$this->sdbApiKey 			= (isset($o_parser[APPLICATION_ENV]['configuration.sendinblue.apikey']) ? $o_parser[APPLICATION_ENV]['configuration.sendinblue.apikey'] : 0);
		$this->isStripe 			= (isset($o_parser[APPLICATION_ENV]['configuration.isStripe']) ? $o_parser[APPLICATION_ENV]['configuration.isStripe'] : 0);
		$this->stripeApiKey 			= (isset($o_parser[APPLICATION_ENV]['configuration.stripe.apikey']) ? $o_parser[APPLICATION_ENV]['configuration.stripe.apikey'] : 0);
		$this->stripeApiSecret 			= (isset($o_parser[APPLICATION_ENV]['configuration.stripe.apisecret']) ? $o_parser[APPLICATION_ENV]['configuration.stripe.apisecret'] : 0);
		$this->isrecaptcha 			= (isset($o_parser[APPLICATION_ENV]['configuration.isRecaptcha']) ? $o_parser[APPLICATION_ENV]['configuration.isRecaptcha'] : 0);
		$this->recaptchaKey 			= (isset($o_parser[APPLICATION_ENV]['configuration.recaptchaKey']) ? $o_parser[APPLICATION_ENV]['configuration.recaptchaKey'] : 0);
		$this->recaptchaSecret 			= (isset($o_parser[APPLICATION_ENV]['configuration.recaptchaSecret']) ? $o_parser[APPLICATION_ENV]['configuration.recaptchaSecret'] : 0);
		$this->gtm 			= (isset($o_parser[APPLICATION_ENV]['configuration.gtm']) ? $o_parser[APPLICATION_ENV]['configuration.gtm'] : 0);
		$this->isGoogleSSO 			= (isset($o_parser[APPLICATION_ENV]['configuration.isGoogleSSO']) ? $o_parser[APPLICATION_ENV]['configuration.isGoogleSSO'] : 0);
		$this->ggbApiKey 			= (isset($o_parser[APPLICATION_ENV]['configuration.googleSSO.apikey']) ? $o_parser[APPLICATION_ENV]['configuration.googleSSO.apikey'] : 0);
		$this->ggbIdClient 			= (isset($o_parser[APPLICATION_ENV]['configuration.googleSSO.idclient']) ? $o_parser[APPLICATION_ENV]['configuration.googleSSO.idclient'] : 0);
		$this->isFacebookSSO 			= (isset($o_parser[APPLICATION_ENV]['configuration.isFacebookSSO']) ? $o_parser[APPLICATION_ENV]['configuration.isFacebookSSO'] : 0);
		$this->fbbApiKey 			= (isset($o_parser[APPLICATION_ENV]['configuration.facebookSSO.apikey']) ? $o_parser[APPLICATION_ENV]['configuration.facebookSSO.apikey'] : 0);
		$this->fbbApiSecret 			= (isset($o_parser[APPLICATION_ENV]['configuration.facebookSSO.apisecret']) ? $o_parser[APPLICATION_ENV]['configuration.facebookSSO.apisecret'] : 0);
		$this->ispaypal 			= (isset($o_parser[APPLICATION_ENV]['configuration.isPaypal']) ? $o_parser[APPLICATION_ENV]['configuration.isPaypal'] : 0);
		$this->paypalId 			= (isset($o_parser[APPLICATION_ENV]['configuration.paypal.clientID']) ? $o_parser[APPLICATION_ENV]['configuration.paypal.clientID'] : 0);
		$this->paypalUri 			= (isset($o_parser[APPLICATION_ENV]['configuration.paypal.uri']) ? $o_parser[APPLICATION_ENV]['configuration.paypal.uri'] : 0);
		$this->paypalAccount 			= (isset($o_parser[APPLICATION_ENV]['configuration.paypal.account']) ? $o_parser[APPLICATION_ENV]['configuration.paypal.account'] : 0);
		$this->paypalSecret 			= (isset($o_parser[APPLICATION_ENV]['configuration.paypal.secret']) ? $o_parser[APPLICATION_ENV]['configuration.paypal.secret'] : 0);

		$this->s_display 				= (isset($o_parser[APPLICATION_ENV]['configuration.default.device']) ? $o_parser[APPLICATION_ENV]['configuration.default.device'] : '');
		$this->extranet 				= (isset($o_parser[APPLICATION_ENV]['configuration.default.extranet']) ? $o_parser[APPLICATION_ENV]['configuration.default.extranet'] : '');
		$this->iscache 				= (isset($o_parser[APPLICATION_ENV]['configuration.default.cache']) ? $o_parser[APPLICATION_ENV]['configuration.default.cache'] : false);
		$this->iscache 				= filter_var($this->iscache, FILTER_VALIDATE_BOOLEAN);
		$this->cacheTime 			= (isset($o_parser[APPLICATION_ENV]['configuration.default.cacheTime']) ? $o_parser[APPLICATION_ENV]['configuration.default.cacheTime'] : $this->cacheTime);
		$this->b_print					= (isset($o_parser[APPLICATION_ENV]['configuration.print']) ? $o_parser[APPLICATION_ENV]['configuration.print'] : false);
		$this->b_print					= filter_var($this->b_print, FILTER_VALIDATE_BOOLEAN);
		$this->b_pdf					= (isset($o_parser[APPLICATION_ENV]['configuration.pdf']) ? $o_parser[APPLICATION_ENV]['configuration.pdf'] : false);
		$this->b_pdf					= filter_var($this->b_pdf, FILTER_VALIDATE_BOOLEAN);
		$this->b_mail					= (isset($o_parser[APPLICATION_ENV]['configuration.mail']) ? $o_parser[APPLICATION_ENV]['configuration.mail']: false);
		$this->b_mail					= filter_var($this->b_mail, FILTER_VALIDATE_BOOLEAN);
		$this->b_cart					= (isset($o_parser[APPLICATION_ENV]['configuration.cart']) ? $o_parser[APPLICATION_ENV]['configuration.cart'] : false);
		$this->b_cart					= (isset($o_parser[APPLICATION_ENV]['configuration.cart']) ? $o_parser[APPLICATION_ENV]['configuration.cart'] : false);
		$this->b_cart					= filter_var($this->b_cart, FILTER_VALIDATE_BOOLEAN);
		$this->b_multilang				= (isset($o_parser[APPLICATION_ENV]['configuration.multilang']) ? $o_parser[APPLICATION_ENV]['configuration.default.i_lang'] : false);
		$this->b_multilang				= filter_var($this->b_multilang, FILTER_VALIDATE_BOOLEAN);
		$this->i_lang					= (isset($o_parser[APPLICATION_ENV]['configuration.default.i_lang']) ? $o_parser[APPLICATION_ENV]['configuration.default.i_lang'] : '');
		$this->s_lang					= (isset($o_parser[APPLICATION_ENV]['configuration.default.s_lang']) ? $o_parser[APPLICATION_ENV]['configuration.default.s_lang'] : '');
		$this->b_minifier				= (isset($o_parser[APPLICATION_ENV]['configuration.minifier']) ? $o_parser[APPLICATION_ENV]['configuration.minifier'] : false);
		$this->b_minifier = filter_var($this->b_minifier, FILTER_VALIDATE_BOOLEAN);
		$this->s_translation			= (isset($o_parser[APPLICATION_ENV]['configuration.default.s_translation']) ? $o_parser[APPLICATION_ENV]['configuration.default.s_translation'] : '');
		$this->b_notification			= (isset($o_parser[APPLICATION_ENV]['configuration.default.notification']) ? $o_parser[APPLICATION_ENV]['configuration.default.notification'] : '');
		$this->sortable					= (isset($o_parser[APPLICATION_ENV]['configuration.sortable']) ? $o_parser[APPLICATION_ENV]['configuration.sortable'] : '');
		$this->archiv					= (isset($o_parser[APPLICATION_ENV]['configuration.archiv']) ? $o_parser[APPLICATION_ENV]['configuration.archiv'] : '');
		$this->needauth					= (isset($o_parser[APPLICATION_ENV]['configuration.needauth']) ? $o_parser[APPLICATION_ENV]['configuration.needauth']: '');
		$this->b_overlay				= (isset($o_parser[APPLICATION_ENV]['configuration.overlay']) ? $o_parser[APPLICATION_ENV]['configuration.overlay'] : false);
		$this->b_overlay				= filter_var($this->b_overlay, FILTER_VALIDATE_BOOLEAN);
		$this->up_max_filesize			= (isset($o_parser[APPLICATION_ENV]['configuration.default.upload_max_filesize']) ? $o_parser[APPLICATION_ENV]['configuration.default.upload_max_filesize'] : '');
		$this->uploadFolder				= APPLICATION_PATH . (isset($o_parser[APPLICATION_ENV]['configuration.default.uploadFolder']) ? $o_parser[APPLICATION_ENV]['configuration.default.uploadFolder'] : '');		
		$this->uploadSecureFolder		= APPLICATION_PATH . (isset($o_parser[APPLICATION_ENV]['configuration.default.uploadSecureFolder']) ? $o_parser[APPLICATION_ENV]['configuration.default.uploadSecureFolder'] : '');
		$this->uploadTemp				= APPLICATION_PATH . (isset($o_parser[APPLICATION_ENV]['configuration.default.uploadTemp']) ? $o_parser[APPLICATION_ENV]['configuration.default.uploadTemp'] : '');
		$this->upTiny					= (isset($o_parser[APPLICATION_ENV]['configuration.default.tiny']) ? $o_parser[APPLICATION_ENV]['configuration.default.tiny'] : '');

		$this->HTTP_ROOT				= $this->utils->getHttpProtocol() . '://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost') . '/';
		$this->HTTP_DOMAIN				= $this->utils->getHttpProtocol() . '://' . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost');
		$this->CDN_PATH					= $this->HTTP_ROOT . 'content/bdd/' ;
		$this->MEDIA_PATH				= $this->HTTP_ROOT . 'templates/'.$this->s_template.'/content/static/';
		$this->ASSETS_PATH				= $this->HTTP_ROOT . '!locked/content/interface/';
		$this->MEDIA_DOWNLOAD			= $this->HTTP_ROOT . 'media_download/';
		
		$this->islucene				= (isset($o_parser[APPLICATION_ENV]['configuration.default.islucene']) ? $o_parser[APPLICATION_ENV]['configuration.default.islucene'] : false);
		
		$this->lucene_index				= (isset($o_parser[APPLICATION_ENV]['configuration.default.lucene_index']) ? $_SERVER['DOCUMENT_ROOT'] . '/../' . $o_parser[APPLICATION_ENV]['configuration.default.lucene_index'] : false);
		
		$this->preg_pattern_date	= (isset($o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.date']) ? $o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.date'] : '');
		$this->preg_pattern_email	= (isset($o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.email']) ? $o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.email'] : '');
		$this->preg_pattern_email1	= (isset($o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.email1']) ? $o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.email1'] : '');
		$this->preg_pattern_tel		= (isset($o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.tel']) ? $o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.tel'] : '');
		$this->preg_pattern_tel1		= (isset($o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.tel1']) ? $o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.tel1'] : '');
		$this->preg_pattern_tel2		= (isset($o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.tel2']) ? $o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.tel2'] : '');
		$this->preg_pattern_num		= (isset($o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.num']) ? $o_parser[APPLICATION_ENV]['configuration.default.preg_pattern.num'] : '');
		$this->pattern_date			= (isset($o_parser[APPLICATION_ENV]['configuration.default.pattern.dates']) ? $o_parser[APPLICATION_ENV]['configuration.default.pattern.dates'] : '');
		
		
		$this->month					= (isset($o_parser[APPLICATION_ENV]['configuration.default.month']) ? $o_parser[APPLICATION_ENV]['configuration.default.month'] : '');
		
		$this->log					= (isset($o_parser[APPLICATION_ENV]['configuration.log']) ? $o_parser[APPLICATION_ENV]['configuration.log'] : '');



		$this->is_SSO					= (isset($o_parser[APPLICATION_ENV]['configuration.sso']) ? $o_parser[APPLICATION_ENV]['configuration.sso'] : '');

		//loading sso files
		if($this->is_SSO)
			$this->_load_sso();
		
	}

	private 		function _db_param()
	{
		$o_parser 				= parse_ini_file(APPLICATION_PATH . '/configs/' . $this->_dbIni, true);
		$this->db_host 		= (isset($o_parser[APPLICATION_ENV]['resources.db.params.host']) && !empty($o_parser[APPLICATION_ENV]['resources.db.params.host']) ? $o_parser[APPLICATION_ENV]['resources.db.params.host'] : '');
		$this->db_login		= (isset($o_parser[APPLICATION_ENV]['resources.db.params.username']) && !empty($o_parser[APPLICATION_ENV]['resources.db.params.username']) ? $o_parser[APPLICATION_ENV]['resources.db.params.username'] : '');
		$this->db_pwd 		= (isset($o_parser[APPLICATION_ENV]['resources.db.params.password']) && !empty($o_parser[APPLICATION_ENV]['resources.db.params.password']) ? $o_parser[APPLICATION_ENV]['resources.db.params.password'] : '');
		$this->db_name 		= (isset($o_parser[APPLICATION_ENV]['resources.db.params.dbname']) && !empty($o_parser[APPLICATION_ENV]['resources.db.params.dbname']) ? $o_parser[APPLICATION_ENV]['resources.db.params.dbname'] : '');
		$this->db_encode		= (isset($o_parser[APPLICATION_ENV]['resources.db.params.encode']) && !empty($o_parser[APPLICATION_ENV]['resources.db.params.encode']) ? $o_parser[APPLICATION_ENV]['resources.db.params.encode'] : '');
		$this->db_prefixe	= (isset($o_parser[APPLICATION_ENV]['resources.db.params.prefixe']) && !empty($o_parser[APPLICATION_ENV]['resources.db.params.prefixe']) ? $o_parser[APPLICATION_ENV]['resources.db.params.prefixe'] : ''); 
		$this->db_port	= (isset($o_parser[APPLICATION_ENV]['resources.db.params.port']) && !empty($o_parser[APPLICATION_ENV]['resources.db.params.port']) ? $o_parser[APPLICATION_ENV]['resources.db.params.port'] : ''); 
		$this->db_type	= (isset($o_parser[APPLICATION_ENV]['resources.db.params.dbtype']) && !empty($o_parser[APPLICATION_ENV]['resources.db.params.dbtype']) ? $o_parser[APPLICATION_ENV]['resources.db.params.dbtype'] : ''); 

		switch($this->db_type){
			default:
			case '':
			case 'mysql':
				require_once LIBRARY_PATH . '/db.class.php' ;
				$this->database = new Mysql($this->db_host, $this->db_login, $this->db_pwd, $this->db_name, $this->db_port, $this->db_encode, $this->db_type);
			break;

			case 'pgsql': 
				require_once LIBRARY_PATH . '/db.class.php' ;
				$this->database = new Mysql($this->db_host, $this->db_login, $this->db_pwd, $this->db_name, $this->db_port, $this->db_encode, $this->db_type);
			break;
		}

		if($this->database->feed == '' || $this->database->feed == null )
			return false;
		else 
			return true;
	}

									private 		function _load_sso()
									{
										$o_parser 				= parse_ini_file(APPLICATION_PATH . '/configs/' . $this->_casIni, true);
										$this->ldap_protocol 	= (isset($o_parser[APPLICATION_ENV]['cas.protocol']) && !empty($o_parser[APPLICATION_ENV]['cas.protocol']) ? $o_parser[APPLICATION_ENV]['cas.protocol'] : '');
										$this->ldap_port			= (isset($o_parser[APPLICATION_ENV]['cas.port']) && !empty($o_parser[APPLICATION_ENV]['cas.port']) ? $o_parser[APPLICATION_ENV]['cas.port'] : '');
										$this->ldap_host 		= (isset($o_parser[APPLICATION_ENV]['cas.host']) && !empty($o_parser[APPLICATION_ENV]['cas.host']) ? $o_parser[APPLICATION_ENV]['cas.host'] : '');
										$this->ldap_context 		= (isset($o_parser[APPLICATION_ENV]['cas.context']) && !empty($o_parser[APPLICATION_ENV]['cas.context']) ? $o_parser[APPLICATION_ENV]['cas.context'] : '');

										//CAS AUTH
										require_once LIBRARY_PATH . '/cas/CAS.php' ;

										if(APPLICATION_ENV != "production" ) 
										{
											phpCAS::setDebug();
											phpCAS::setVerbose(true);
										}

										// Initialize phpCAS
										phpCAS::client($this->ldap_protocol, $this->ldap_host, intval($this->ldap_port), $this->ldap_context);
										phpCAS::setCasServerCACert($ldap_server_ca_cert_path);
										phpCAS::setNoCasServerValidation();
									}
	
	private 		function _load_vars()
	{
		// translation
		require_once APPLICATION_PATH . '/controllers/!locked/TranslationController.php' ;
		$this->a_config_lang = $a_config_lang;
		
	}
	
									private 		function _load_init_mods($init = '')
									{
										/*if($this->isApi ){
											$ch = curl_init($this->ApiUri . '?ctrl=general&rquest=get_conf');
											curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
											curl_setopt($ch, CURLOPT_POSTFIELDS, $_data);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

											$response = curl_exec($ch);

											$result = json_decode($response);

											$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);		
											curl_close($ch);

											//if($http_code == 200)
										}else{
											//
										}*/
										$o_parser 		= parse_ini_file(APPLICATION_PATH . '/configs/' . $this->_modsIni, true);
										$_iCompt = 0;
										if(isset($o_parser[APPLICATION_ENV]['resources.modules']))
										foreach($o_parser[APPLICATION_ENV]['resources.modules'] as $key => $val)
										{
											if($val)
											{				
												//config modules for front
												if(is_file(APPLICATION_PATH . '/modules/' . $key . '/config/' . $this->_confIni))
												{
													$this->o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/' . $key . '/config/' . $this->_confIni, true);
													$this->mods[$key]['path'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.path']) ? $this->o_mod_parser[APPLICATION_ENV]['module.path'] : '');
													$this->mods[$key]['index'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.index']) ? $this->o_mod_parser[APPLICATION_ENV]['module.index'] : false);
													$this->mods[$key]['aIndex'] = array();
													$this->mods[$key]['cache'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.cache']) ? $this->o_mod_parser[APPLICATION_ENV]['module.cache'] : false);
													$this->mods[$key]['referer'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.referer']) ? $this->o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
													$this->mods[$key]['name'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.name']) ? $this->o_mod_parser[APPLICATION_ENV]['module.name'] : '');
													$this->mods[$key]['title'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.title']) ? $this->o_mod_parser[APPLICATION_ENV]['module.title'] : '');
													$this->mods[$key]['onMenu'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.onMenu']) ? $this->o_mod_parser[APPLICATION_ENV]['module.onMenu'] : '');
													$this->mods[$key]['picto'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.picto']) ? $this->o_mod_parser[APPLICATION_ENV]['module.picto'] : '');
													$this->mods[$key]['b_print'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_print']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_print'] : false);
													$this->mods[$key]['b_pdf'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_pdf']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_pdf'] : false);
													$this->mods[$key]['b_mail'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_mail']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_mail'] : false);
													$this->mods[$key]['rel'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.rel']) ? $this->o_mod_parser[APPLICATION_ENV]['module.rel'] : '');
													$this->mods[$key]['b_breadcrumbTree'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree'] : false);
													
													if(is_file(APPLICATION_PATH . '/modules/' . $key . '/config/' . $this->_modsIni))
													{
														$this->o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/' . $key . '/config/' . $this->_modsIni, true);
														if(isset($this->o_mod_parser[APPLICATION_ENV]['resources.modules']))
														foreach($this->o_mod_parser[APPLICATION_ENV]['resources.modules'] as $_key => $_val)
														{
															if($_val)
															{
																//config modules for front
																if(is_file(APPLICATION_PATH . '/modules/' . $key . '/modules/' . $_key . '/config/' . $this->_confIni))
																{
																	$this->o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/special/' . $key . '/modules/' . $_key . '/config/' . $this->_confIni, true);
																	$this->mods[$key]['modules'][$_key]['path'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.path']) ? $this->o_mod_parser[APPLICATION_ENV]['module.path'] : '');
																	$this->mods[$key]['modules'][$_key]['index'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.index']) ? $this->o_mod_parser[APPLICATION_ENV]['module.index'] : false);
																	$this->mods[$key]['modules'][$_key]['aIndex'] = array();
																	$this->mods[$key]['modules'][$_key]['cache'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.cache']) ? $this->o_mod_parser[APPLICATION_ENV]['module.cache'] : '');
																	$this->mods[$key]['modules'][$_key]['referer'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.referer']) ? $this->o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
																	$this->mods[$key]['modules'][$_key]['name'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.name']) ? $this->o_mod_parser[APPLICATION_ENV]['module.name'] : '');
																	$this->mods[$key]['modules'][$_key]['title'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.title']) ? $this->o_mod_parser[APPLICATION_ENV]['module.title'] : '');
																	$this->mods[$key]['modules'][$_key]['onMenu'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.onMenu']) ? $this->o_mod_parser[APPLICATION_ENV]['module.onMenu'] : '');
																	$this->mods[$key]['modules'][$_key]['picto'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.picto']) ? $this->o_mod_parser[APPLICATION_ENV]['module.picto'] : '');
																	$this->mods[$key]['modules'][$_key]['b_print'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_print']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_print'] : false);
																	$this->mods[$key]['modules'][$_key]['b_pdf'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_pdf']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_pdf'] : false);
																	$this->mods[$key]['modules'][$_key]['b_mail'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_mail']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_mail'] : false);
																	$this->mods[$key]['modules'][$_key]['b_breadcrumbTree'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree'] : false);
																	$this->mods[$key]['modules'][$_key]['rel'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.rel']) ? $this->o_mod_parser[APPLICATION_ENV]['module.rel'] : '');
																}
															}
														}
													}
												}
												if(isset($_SESSION['user_info']) && isset($this->s_level1) && ($this->s_level1 == "admin" || $this->s_level1 == "plugins") || $this->islucene){	
													//config modules sql to install
													if(is_file(APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/' . $this->_confSql))
													{
														if(isset($this->mods[$key])) $this->mods[$key]['id'] = $_iCompt;					
														$this->o_mod_parser = file_get_contents(APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/' . $this->_confSql);
														$this->db_request .= $this->o_mod_parser;	
													}

													//config modules for back	
													if(is_file(APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/' . $this->_confIni))
													{
														
														$a_config = array();
														if(isset($this->mods[$key])) $this->mods[$key]['id'] = $_iCompt;
														
														$this->o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/' . $this->_confIni, true);
														
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['group'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.group']) ? $this->o_mod_parser[APPLICATION_ENV]['module.group'] : '');
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['referer'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.referer']) ? $this->o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['name'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.name']) ? $this->o_mod_parser[APPLICATION_ENV]['module.name'] : '');
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['path'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.path']) ? $this->o_mod_parser[APPLICATION_ENV]['module.path'] : '');
														if(isset($this->o_mod_parser[APPLICATION_ENV]['module.stat']))
															$this->stats[] = $this->o_mod_parser[APPLICATION_ENV]['module.stat'];
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['id'] = $_iCompt;

													}
													$_iCompt++;
												}
											}
										}
										if(isset($o_parser[APPLICATION_ENV]['resources.specialmodules']))
										foreach($o_parser[APPLICATION_ENV]['resources.specialmodules'] as $key => $val)
										{
											if($val)
											{
												//config modules for front
												if(is_file(APPLICATION_PATH . '/modules/special/' . $key . '/config/' . $this->_confIni))
												{
													$this->o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/special/' . $key . '/config/' . $this->_confIni, true);
													$this->mods[$key]['path'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.path']) ? $this->o_mod_parser[APPLICATION_ENV]['module.path'] : '');
													$this->mods[$key]['index'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.index']) ? $this->o_mod_parser[APPLICATION_ENV]['module.index'] : false);
													$this->mods[$key]['aIndex'] = array();
													$this->mods[$key]['cache'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.cache']) ? $this->o_mod_parser[APPLICATION_ENV]['module.cache'] : '');
													$this->mods[$key]['referer'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.referer']) ? $this->o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
													$this->mods[$key]['name'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.name']) ? $this->o_mod_parser[APPLICATION_ENV]['module.name'] : '');
													$this->mods[$key]['title'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.title']) ? $this->o_mod_parser[APPLICATION_ENV]['module.title'] : '');
													$this->mods[$key]['onMenu'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.onMenu']) ? $this->o_mod_parser[APPLICATION_ENV]['module.onMenu'] : '');
													$this->mods[$key]['picto'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.picto']) ? $this->o_mod_parser[APPLICATION_ENV]['module.picto'] : '');
													$this->mods[$key]['b_print'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_print']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_print'] : false);
													$this->mods[$key]['b_pdf'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_pdf']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_pdf'] : false);
													$this->mods[$key]['b_mail'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_mail']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_mail'] : false);
													$this->mods[$key]['b_breadcrumbTree'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree'] : false);
													$this->mods[$key]['rel'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.rel']) ? $this->o_mod_parser[APPLICATION_ENV]['module.rel'] : '');
													
													if(is_file(APPLICATION_PATH . '/modules/special/' . $key . '/config/' . $this->_modsIni))
													{
														$this->o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/special/' . $key . '/config/' . $this->_modsIni, true);
														foreach($this->o_mod_parser[APPLICATION_ENV]['resources.modules'] as $_key => $_val)
														{
															if($_val)
															{
																//config modules for front
																if(is_file(APPLICATION_PATH . '/modules/special/' . $key . '/modules/' . $_key . '/config/' . $this->_confIni))
																{
																	$this->o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/special/' . $key . '/modules/' . $_key . '/config/' . $this->_confIni, true);
																	$this->mods[$key]['modules'][$_key]['path'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.path']) ? $this->o_mod_parser[APPLICATION_ENV]['module.path'] : '');
																	$this->mods[$key]['modules'][$_key]['index'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.index']) ? $this->o_mod_parser[APPLICATION_ENV]['module.index'] : false);
																	$this->mods[$key]['modules'][$_key]['aIndex'] = array();
																	$this->mods[$key]['modules'][$_key]['cache'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.cache']) ? $this->o_mod_parser[APPLICATION_ENV]['module.cache'] : '');
																	$this->mods[$key]['modules'][$_key]['referer'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.referer']) ? $this->o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
																	$this->mods[$key]['modules'][$_key]['name'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.name']) ? $this->o_mod_parser[APPLICATION_ENV]['module.name'] : '');
																	$this->mods[$key]['modules'][$_key]['b_print'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_print']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_print'] : false);
																	$this->mods[$key]['modules'][$_key]['b_pdf'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_pdf']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_pdf'] : false);
																	$this->mods[$key]['modules'][$_key]['b_mail'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_mail']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_mail'] : false);
																	$this->mods[$key]['modules'][$_key]['b_breadcrumbTree'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree']) ? $this->o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree'] : false);
																	$this->mods[$key]['modules'][$_key]['rel'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.rel']) ? $this->o_mod_parser[APPLICATION_ENV]['module.rel'] : '');
																}
															}
														}
													}
												}
												
												if(isset($_SESSION['user_info']) && isset($this->s_level1) && ($this->s_level1 == "admin" || $this->s_level1 == "plugins") || $this->islucene){
													//config modules sql to install
													if(is_file(APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/' . $this->_confSql))
													{
														if(isset($this->mods[$key])) $this->mods[$key]['id'] = $_iCompt;
														$this->o_mod_parser = file_get_contents(APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/' . $this->_confSql);
														$this->db_request .= $this->o_mod_parser;
													}
													//config modules for back
													if(is_file(APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/' . $this->_confIni))
													{
														$a_config = array();
														if(isset($this->mods[$key])) $this->mods[$key]['id'] = $_iCompt;
														
														$this->o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/' . $this->_confIni, true);
														
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['group'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.group']) ? $this->o_mod_parser[APPLICATION_ENV]['module.group'] : '');
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['referer'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.referer']) ? $this->o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['name'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.name']) ? $this->o_mod_parser[APPLICATION_ENV]['module.name'] : '');
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['path'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.path']) ? $this->o_mod_parser[APPLICATION_ENV]['module.path'] : '');					
														if(isset($this->o_mod_parser[APPLICATION_ENV]['module.stat']))
															$this->stats[] = $this->o_mod_parser[APPLICATION_ENV]['module.stat'];
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['index'] = (isset($this->o_mod_parser[APPLICATION_ENV]['module.index']) ? $this->o_mod_parser[APPLICATION_ENV]['module.index'] : false);
														$this->database->configs[$this->o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['id'] = $_iCompt;
													}
													$_iCompt++;
												}
											}
										}

										//$this->utils->do_dump($this->database->configs);
										//$this->utils->do_dump($this->mods);
									}
	private 		function _load_mods($init = '')
	{
		$o_parser 		= parse_ini_file(APPLICATION_PATH . '/configs/' . $this->_modsIni, true);
		$_iCompt = 0;
		if(isset($o_parser[APPLICATION_ENV]['resources.modules']))
		foreach($o_parser[APPLICATION_ENV]['resources.modules'] as $key => $val)
		{
			if($val)
			{
				//config modules for front
				if(is_file(APPLICATION_PATH . '/modules/' . $key . '/config/' . $this->_confIni))
				{
					$o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/' . $key . '/config/' . $this->_confIni, true);
					$this->mods[$key]['path'] = (isset($o_mod_parser[APPLICATION_ENV]['module.path']) ? $o_mod_parser[APPLICATION_ENV]['module.path'] : '');
					$this->mods[$key]['index'] = (isset($o_mod_parser[APPLICATION_ENV]['module.index']) ? $o_mod_parser[APPLICATION_ENV]['module.index'] : false);
					$this->mods[$key]['aIndex'] = array();
					$this->mods[$key]['referer'] = (isset($o_mod_parser[APPLICATION_ENV]['module.referer']) ? $o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
					$this->mods[$key]['name'] = (isset($o_mod_parser[APPLICATION_ENV]['module.name']) ? $o_mod_parser[APPLICATION_ENV]['module.name'] : '');
					$this->mods[$key]['title'] = (isset($o_mod_parser[APPLICATION_ENV]['module.title']) ? $o_mod_parser[APPLICATION_ENV]['module.title'] : '');
					$this->mods[$key]['onMenu'] = (isset($o_mod_parser[APPLICATION_ENV]['module.onMenu']) ? $o_mod_parser[APPLICATION_ENV]['module.onMenu'] : '');
					$this->mods[$key]['picto'] = (isset($o_mod_parser[APPLICATION_ENV]['module.picto']) ? $o_mod_parser[APPLICATION_ENV]['module.picto'] : '');
					$this->mods[$key]['b_print'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_print']) ? $o_mod_parser[APPLICATION_ENV]['module.b_print'] : '');
					$this->mods[$key]['b_pdf'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_pdf']) ? $o_mod_parser[APPLICATION_ENV]['module.b_pdf'] : '');
					$this->mods[$key]['b_mail'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_mail']) ? $o_mod_parser[APPLICATION_ENV]['module.b_mail'] : '');
					$this->mods[$key]['rel'] = (isset($o_mod_parser[APPLICATION_ENV]['module.rel']) ? $o_mod_parser[APPLICATION_ENV]['module.rel'] : '');
					$this->mods[$key]['b_breadcrumbTree'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree']) ? $o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree'] : '');
					
					if(is_file(APPLICATION_PATH . '/modules/' . $key . '/config/' . $this->_modsIni))
					{
						$o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/' . $key . '/config/' . $this->_modsIni, true);
						if(isset($o_mod_parser[APPLICATION_ENV]['resources.modules']))
						foreach($o_mod_parser[APPLICATION_ENV]['resources.modules'] as $_key => $_val)
						{
							if($_val)
							{
								//config modules for front
								if(is_file(APPLICATION_PATH . '/modules/' . $key . '/modules/' . $_key . '/config/' . $this->_confIni))
								{
									$o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/special/' . $key . '/modules/' . $_key . '/config/' . $this->_confIni, true);
									$this->mods[$key]['modules'][$_key]['path'] = (isset($o_mod_parser[APPLICATION_ENV]['module.path']) ? $o_mod_parser[APPLICATION_ENV]['module.path'] : '');
									$this->mods[$key]['modules'][$_key]['index'] = (isset($o_mod_parser[APPLICATION_ENV]['module.index']) ? $o_mod_parser[APPLICATION_ENV]['module.index'] : false);
									$this->mods[$key]['modules'][$_key]['aIndex'] = array();
									$this->mods[$key]['modules'][$_key]['referer'] = (isset($o_mod_parser[APPLICATION_ENV]['module.referer']) ? $o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
									$this->mods[$key]['modules'][$_key]['name'] = (isset($o_mod_parser[APPLICATION_ENV]['module.name']) ? $o_mod_parser[APPLICATION_ENV]['module.name'] : '');
									$this->mods[$key]['modules'][$_key]['title'] = (isset($o_mod_parser[APPLICATION_ENV]['module.title']) ? $o_mod_parser[APPLICATION_ENV]['module.title'] : '');
									$this->mods[$key]['modules'][$_key]['onMenu'] = (isset($o_mod_parser[APPLICATION_ENV]['module.onMenu']) ? $o_mod_parser[APPLICATION_ENV]['module.onMenu'] : '');
									$this->mods[$key]['modules'][$_key]['picto'] = (isset($o_mod_parser[APPLICATION_ENV]['module.picto']) ? $o_mod_parser[APPLICATION_ENV]['module.picto'] : '');
									$this->mods[$key]['modules'][$_key]['b_print'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_print']) ? $o_mod_parser[APPLICATION_ENV]['module.b_print'] : '');
									$this->mods[$key]['modules'][$_key]['b_pdf'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_pdf']) ? $o_mod_parser[APPLICATION_ENV]['module.b_pdf'] : '');
									$this->mods[$key]['modules'][$_key]['b_mail'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_mail']) ? $o_mod_parser[APPLICATION_ENV]['module.b_mail'] : '');
									$this->mods[$key]['modules'][$_key]['b_breadcrumbTree'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree']) ? $o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree'] : '');
									$this->mods[$key]['modules'][$_key]['rel'] = (isset($o_mod_parser[APPLICATION_ENV]['module.rel']) ? $o_mod_parser[APPLICATION_ENV]['module.rel'] : '');
								}
							}
						}
					}
				}

				if(isset($_SESSION['user_info']) && isset($this->s_level1) && ($this->s_level1 == "admin" || $this->s_level1 == "plugins") || $this->islucene){
					//config modules sql to install
					if(is_file(APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/' . $this->_confSql))
					{
						if(isset($this->mods[$key])) $this->mods[$key]['id'] = $_iCompt;					
						$o_mod_parser = file_get_contents(APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/' . $this->_confSql);
						$this->db_request .= $o_mod_parser;	
					}

					//config modules for back	
					if(is_file(APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/' . $this->_confIni))
					{
						
						$a_config = array();
						if(isset($this->mods[$key])) $this->mods[$key]['id'] = $_iCompt;
						
						$o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/' . $this->_confIni, true);
						
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['group'] = (isset($o_mod_parser[APPLICATION_ENV]['module.group']) ? $o_mod_parser[APPLICATION_ENV]['module.group'] : '');
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['group'] = (isset($o_mod_parser[APPLICATION_ENV]['module.group']) ? $o_mod_parser[APPLICATION_ENV]['module.group'] : '');
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['referer'] = (isset($o_mod_parser[APPLICATION_ENV]['module.referer']) ? $o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['name'] = (isset($o_mod_parser[APPLICATION_ENV]['module.name']) ? $o_mod_parser[APPLICATION_ENV]['module.name'] : '');
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['name'] = (isset($o_mod_parser[APPLICATION_ENV]['module.name']) ? $o_mod_parser[APPLICATION_ENV]['module.name'] : '');
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['path'] = (isset($o_mod_parser[APPLICATION_ENV]['module.path']) ? $o_mod_parser[APPLICATION_ENV]['module.path'] : '');
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['id'] = $_iCompt;
						if(is_file(APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/configs.config.php'))
						{
							require_once APPLICATION_PATH . '/modules/admin/modules/' . $key . '/config/configs.config.php' ;

							$iKey = 0;
							foreach($a_config as $item => $value)
							{
								$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['content'][] = array(
									"id"			=> $iKey,
									"index"			=> (isset($value['index']) && $value['index'] ? $value['index'] : ''),
									"name"			=> (isset($value['name']) && !empty($value['name']) ? $value['name'] : ''),
									"table"			=> (isset($value['table']) && !empty($value['table']) ? $value['table'] : ''),
									"code"			=> (isset($value['code']) && !empty($value['code']) ? $value['code'] : ''),
									"indexCode"		=> (isset($value['indexCode']) && !empty($value['indexCode']) ? $value['indexCode'] : ''),
									"addon"			=> (isset($value['addon']) && !empty($value['addon']) ? $value['addon'] : 'default'),
									"mode"			=> (isset($value['mode']) && !empty($value['mode']) ? $value['mode'] : ''),
									"val_id"		=> (isset($value['val_id']) && !empty($value['val_id']) ? $value['val_id'] : ''),
									"cle"			=> (isset($value['cle']) && !empty($value['cle']) ? $value['cle'] : ''),
									"tri"			=> (isset($value['tri']) && !empty($value['tri']) ? $value['tri'] : ''),
									"condition"		=> (isset($value['condition']) && !empty($value['condition']) ? $value['condition'] : ''),
									"optim_search"	=> (isset($value['optim_search']) && !empty($value['optim_search']) ? $value['optim_search'] : ''),
									"actions"		=> (isset($value['actions']) && !empty($value['actions']) ? $value['actions'] : ''),
									"special_field"	=> (isset($value['special_field']) && !empty($value['special_field']) ? $value['special_field'] : ''),
									"more_actions"	=> (isset($value['more_actions']) && !empty($value['more_actions']) ? $value['more_actions'] : ''),
									"js"			=> (isset($value['js']) && !empty($value['js']) ? $value['js'] : ''),
									"css"			=> (isset($value['css']) && !empty($value['css']) ? $value['css'] : ''),
									"champs"		=> (isset($value['champs']) && !empty($value['champs']) ? $value['champs'] : ''),
									"auto_fields"	=> (isset($value['auto_fields']) && !empty($value['auto_fields']) ? $value['auto_fields'] : ''),
									"external"		=> (isset($value['external']) && !empty($value['external']) ? $value['external'] : ''),
									"do_before"		=> (function_exists('do_before_' . (isset($value['code']) && !empty($value['code']) ? $value['code'] : '')) ? 'do_before_' . (isset($value['code']) && !empty($value['code']) ? $value['code'] : '') : ''),
									"do_after"		=> (function_exists('do_after_' . (isset($value['code']) && !empty($value['code']) ? $value['code'] : '')) ? 'do_after_' . (isset($value['code']) && !empty($value['code']) ? $value['code'] : '') : '')
								);							
								$iKey++;
							}
							ksort($this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content']);
						}
					}
					$_iCompt++;
				}
			}
		}
		if(isset($o_parser[APPLICATION_ENV]['resources.specialmodules']))
		foreach($o_parser[APPLICATION_ENV]['resources.specialmodules'] as $key => $val)
		{			
			if($val)
			{
				//config modules for front
				if(is_file(APPLICATION_PATH . '/modules/special/' . $key . '/config/' . $this->_confIni))
				{
					$o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/special/' . $key . '/config/' . $this->_confIni, true);
					$this->mods[$key]['path'] = (isset($o_mod_parser[APPLICATION_ENV]['module.path']) ? $o_mod_parser[APPLICATION_ENV]['module.path'] : '');
					$this->mods[$key]['index'] = (isset($o_mod_parser[APPLICATION_ENV]['module.index']) ? $o_mod_parser[APPLICATION_ENV]['module.index'] : false);
					$this->mods[$key]['aIndex'] = array();
					$this->mods[$key]['referer'] = (isset($o_mod_parser[APPLICATION_ENV]['module.referer']) ? $o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
					$this->mods[$key]['name'] = (isset($o_mod_parser[APPLICATION_ENV]['module.name']) ? $o_mod_parser[APPLICATION_ENV]['module.name'] : '');
					$this->mods[$key]['title'] = (isset($o_mod_parser[APPLICATION_ENV]['module.title']) ? $o_mod_parser[APPLICATION_ENV]['module.title'] : '');
					$this->mods[$key]['onMenu'] = (isset($o_mod_parser[APPLICATION_ENV]['module.onMenu']) ? $o_mod_parser[APPLICATION_ENV]['module.onMenu'] : '');
					$this->mods[$key]['picto'] = (isset($o_mod_parser[APPLICATION_ENV]['module.picto']) ? $o_mod_parser[APPLICATION_ENV]['module.picto'] : '');
					$this->mods[$key]['b_print'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_print']) ? $o_mod_parser[APPLICATION_ENV]['module.b_print'] : '');
					$this->mods[$key]['b_pdf'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_pdf']) ? $o_mod_parser[APPLICATION_ENV]['module.b_pdf'] : '');
					$this->mods[$key]['b_mail'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_mail']) ? $o_mod_parser[APPLICATION_ENV]['module.b_mail'] : '');
					$this->mods[$key]['b_breadcrumbTree'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree']) ? $o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree'] : '');
					$this->mods[$key]['rel'] = (isset($o_mod_parser[APPLICATION_ENV]['module.rel']) ? $o_mod_parser[APPLICATION_ENV]['module.rel'] : '');
					
					if(is_file(APPLICATION_PATH . '/modules/special/' . $key . '/config/' . $this->_modsIni))
					{
						$o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/special/' . $key . '/config/' . $this->_modsIni, true);
						foreach($o_mod_parser[APPLICATION_ENV]['resources.modules'] as $_key => $_val)
						{
							if($_val)
							{
								//config modules for front
								if(is_file(APPLICATION_PATH . '/modules/special/' . $key . '/modules/' . $_key . '/config/' . $this->_confIni))
								{
									$o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/special/' . $key . '/modules/' . $_key . '/config/' . $this->_confIni, true);
									$this->mods[$key]['modules'][$_key]['path'] = (isset($o_mod_parser[APPLICATION_ENV]['module.path']) ? $o_mod_parser[APPLICATION_ENV]['module.path'] : '');
									$this->mods[$key]['modules'][$_key]['index'] = (isset($o_mod_parser[APPLICATION_ENV]['module.index']) ? $o_mod_parser[APPLICATION_ENV]['module.index'] : false);
									$this->mods[$key]['modules'][$_key]['aIndex'] = array();
									$this->mods[$key]['modules'][$_key]['referer'] = (isset($o_mod_parser[APPLICATION_ENV]['module.referer']) ? $o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
									$this->mods[$key]['modules'][$_key]['name'] = (isset($o_mod_parser[APPLICATION_ENV]['module.name']) ? $o_mod_parser[APPLICATION_ENV]['module.name'] : '');
									$this->mods[$key]['modules'][$_key]['title'] = (isset($o_mod_parser[APPLICATION_ENV]['module.title']) ? $o_mod_parser[APPLICATION_ENV]['module.title'] : '');
									$this->mods[$key]['modules'][$_key]['onMenu'] = (isset($o_mod_parser[APPLICATION_ENV]['module.onMenu']) ? $o_mod_parser[APPLICATION_ENV]['module.onMenu'] : '');
									$this->mods[$key]['modules'][$_key]['picto'] = (isset($o_mod_parser[APPLICATION_ENV]['module.picto']) ? $o_mod_parser[APPLICATION_ENV]['module.picto'] : '');
									$this->mods[$key]['modules'][$_key]['b_print'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_print']) ? $o_mod_parser[APPLICATION_ENV]['module.b_print'] : '');
									$this->mods[$key]['modules'][$_key]['b_pdf'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_pdf']) ? $o_mod_parser[APPLICATION_ENV]['module.b_pdf'] : '');
									$this->mods[$key]['modules'][$_key]['b_mail'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_mail']) ? $o_mod_parser[APPLICATION_ENV]['module.b_mail'] : '');
									$this->mods[$key]['modules'][$_key]['b_breadcrumbTree'] = (isset($o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree']) ? $o_mod_parser[APPLICATION_ENV]['module.b_breadcrumbTree'] : '');
									$this->mods[$key]['modules'][$_key]['rel'] = (isset($o_mod_parser[APPLICATION_ENV]['module.rel']) ? $o_mod_parser[APPLICATION_ENV]['module.rel'] : '');
								}
							}
						}
					}
				}
				
				if(isset($_SESSION['user_info']) && isset($this->s_level1) && ($this->s_level1 == "admin" || $this->s_level1 == "plugins") || $this->islucene){	
					//config modules sql to install
					if(is_file(APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/' . $this->_confSql))
					{
						if(isset($this->mods[$key])) $this->mods[$key]['id'] = $_iCompt;
						$o_mod_parser = file_get_contents(APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/' . $this->_confSql);
						$this->db_request .= $o_mod_parser;
					}
					//config modules for back
					if(is_file(APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/' . $this->_confIni))
					{
						$a_config = array();
						if(isset($this->mods[$key])) $this->mods[$key]['id'] = $_iCompt;
						
						$o_mod_parser = parse_ini_file(APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/' . $this->_confIni, true);
						
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['group'] = (isset($o_mod_parser[APPLICATION_ENV]['module.group']) ? $o_mod_parser[APPLICATION_ENV]['module.group'] : '');
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['referer'] = (isset($o_mod_parser[APPLICATION_ENV]['module.referer']) ? $o_mod_parser[APPLICATION_ENV]['module.referer'] : '');
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['name'] = $this->_get_lexique((isset($o_mod_parser[APPLICATION_ENV]['module.name']) ? $o_mod_parser[APPLICATION_ENV]['module.name'] : ''));
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['path'] = (isset($o_mod_parser[APPLICATION_ENV]['module.path']) ? $o_mod_parser[APPLICATION_ENV]['module.path'] : '');
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['index'] = (isset($o_mod_parser[APPLICATION_ENV]['module.index']) ? $o_mod_parser[APPLICATION_ENV]['module.index'] : false);
						$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['id'] = $_iCompt;
						if(is_file(APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/configs.config.php'))
						{
							require_once APPLICATION_PATH . '/modules/admin/modules/special/' . $key . '/config/configs.config.php' ;
							$iKey = 0;
							foreach($a_config as $item => $value)
							{
								$this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content'][$_iCompt]['content'][] = array(
									"id"			=> $iKey,
									"index"			=> (isset($value['index']) && $value['index'] ? $value['index'] : ''),
									"name"			=> (isset($value['name']) && !empty($value['name']) ? $value['name'] : ''),
									"table"			=> (isset($value['table']) && !empty($value['table']) ? $value['table'] : ''),
									"code"			=> (isset($value['code']) && !empty($value['code']) ? $value['code'] : ''),
									"indexCode"		=> (isset($value['indexCode']) && !empty($value['indexCode']) ? $value['indexCode'] : ''),
									"addon"			=> (isset($value['addon']) && !empty($value['addon']) ? $value['addon'] : 'default'),
									"mode"			=> (isset($value['mode']) && !empty($value['mode']) ? $value['mode'] : ''),
									"val_id"		=> (isset($value['val_id']) && !empty($value['val_id']) ? $value['val_id'] : ''),
									"cle"			=> (isset($value['cle']) && !empty($value['cle']) ? $value['cle'] : ''),
									"tri"			=> (isset($value['tri']) && !empty($value['tri']) ? $value['tri'] : ''),
									"condition"		=> (isset($value['condition']) && !empty($value['condition']) ? $value['condition'] : ''),
									"optim_search"	=> (isset($value['optim_search']) && !empty($value['optim_search']) ? $value['optim_search'] : ''),
									"actions"		=> (isset($value['actions']) && !empty($value['actions']) ? $value['actions'] : ''),
									"special_field"	=> (isset($value['special_field']) && !empty($value['special_field']) ? $value['special_field'] : ''),
									"more_actions"	=> (isset($value['more_actions']) && !empty($value['more_actions']) ? $value['more_actions'] : ''),
									"js"			=> (isset($value['js']) && !empty($value['js']) ? $value['js'] : ''),
									"css"			=> (isset($value['css']) && !empty($value['css']) ? $value['css'] : ''),
									"champs"		=> (isset($value['champs']) && !empty($value['champs']) ? $value['champs'] : ''),
									"auto_fields"	=> (isset($value['auto_fields']) && !empty($value['auto_fields']) ? $value['auto_fields'] : ''),
									"external"		=> (isset($value['external']) && !empty($value['external']) ? $value['external'] : ''),
									"do_before"		=> (function_exists('do_before_' . (isset($value['code']) && !empty($value['code']) ? $value['code'] : '')) ? 'do_before_' . (isset($value['code']) && !empty($value['code']) ? $value['code'] : '') : ''),
									"do_after"		=> (function_exists('do_after_' . (isset($value['code']) && !empty($value['code']) ? $value['code'] : '')) ? 'do_after_' . (isset($value['code']) && !empty($value['code']) ? $value['code'] : '') : '')
								);
								$iKey++;
							}	
							ksort($this->database->configs[$o_mod_parser[APPLICATION_ENV]['module.group']]['content']);				
						}
					}
					$_iCompt++;
				}
			}
		}
		if(isset($this->database->configs))
			ksort($this->database->configs);
		
		if(empty($init) && $this->lucene_index)
			$this->_indexation();
		//$this->utils->do_dump($this->database->configs);
		//$this->utils->do_dump($this->mods);
	}
	
	private 		function _indexation()
	{
		require_once LIBRARY_PATH . '/indexation.class.php' ;
		$this->indexation = new indexation();
		$this->indexation->setindexation($this);
	}
	
	private 		function _init_vars()
	{	
		$this->s_level1 					= (isset($_GET['level1']) && $_GET['level1'] != "" ? htmlentities($_GET['level1']) : '');
		$this->s_level2 					= (isset($_GET['level2']) && $_GET['level2'] != "" ? htmlentities($_GET['level2']) : '');
		$this->s_level3 					= (isset($_GET['level3']) && $_GET['level3'] != "" ? htmlentities($_GET['level3']) : '');
		$this->s_level4 					= (isset($_GET['level4']) && $_GET['level4'] != "" ? htmlentities($_GET['level4']) : '');

		$this->s_level5 					= (isset($_GET['level5']) && !empty($_GET['level5']) ? htmlentities($_GET['level5']) : '');
		if(!ini_get("allow_url_fopen")) 
			$this->b_curl = true;
	}
	private 		function _inc_func()
	{
		require_once SYSTEM_PATH . '/Utils.php' ;
		$this->utils = new Utils();
		if(APPLICATION_ENV == "production" ) 
			set_error_handler(array($this->utils, 'myErrorHandler'));
	}
	private 		function _get_rel()
	{
		//include css and js files
		require_once APPLICATION_PATH . '/configs/!locked/inc.vars.php' ;
	}
	private 		function _get_general_conf()
	{
		require_once APPLICATION_PATH . '/controllers/!locked/GeneralConfigController.php' ;
	}
	private 		function _email_config()
	{
		$o_parser 						= parse_ini_file(APPLICATION_PATH . '/configs/' . $this->_mailIni, true);
		$this->mailer['smtp_auth'] 		= (isset($o_parser[APPLICATION_ENV]['mailer.smtp_auth']) && !empty($o_parser[APPLICATION_ENV]['mailer.smtp_auth']) ? $o_parser[APPLICATION_ENV]['mailer.smtp_auth'] :  '');
		$this->mailer['port']			= (isset($o_parser[APPLICATION_ENV]['mailer.port']) && !empty($o_parser[APPLICATION_ENV]['mailer.port']) ? $o_parser[APPLICATION_ENV]['mailer.port'] : '');
		$this->mailer['secure']			= (isset($o_parser[APPLICATION_ENV]['mailer.secure']) && !empty($o_parser[APPLICATION_ENV]['mailer.secure']) ? $o_parser[APPLICATION_ENV]['mailer.secure'] : '');
		$this->mailer['host']			= (isset($o_parser[APPLICATION_ENV]['mailer.host']) && !empty($o_parser[APPLICATION_ENV]['mailer.host']) ? $o_parser[APPLICATION_ENV]['mailer.host'] : '');
		$this->mailer['username']		= (isset($o_parser[APPLICATION_ENV]['mailer.username']) && !empty($o_parser[APPLICATION_ENV]['mailer.username']) ? $o_parser[APPLICATION_ENV]['mailer.username'] : '');
		$this->mailer['sender']		= (isset($o_parser[APPLICATION_ENV]['mailer.sender']) && !empty($o_parser[APPLICATION_ENV]['mailer.sender']) ? $o_parser[APPLICATION_ENV]['mailer.sender'] : '');
		$this->mailer['password'] 		= (isset($o_parser[APPLICATION_ENV]['mailer.password']) && !empty($o_parser[APPLICATION_ENV]['mailer.password']) ? $o_parser[APPLICATION_ENV]['mailer.password'] : '');
		$this->mailer['name']			= (isset($o_parser[APPLICATION_ENV]['mailer.name']) && !empty($o_parser[APPLICATION_ENV]['mailer.name']) ? $o_parser[APPLICATION_ENV]['mailer.name'] : '');
		foreach($o_parser[APPLICATION_ENV]['mailer.contact'] as $key => $val)
		{
			$this->mailer['contact'][$key] = $val;
		}
	}
	
	public 		function _set_db_config($host, $user, $pwd, $dbname, $prefixe)
	{
		$dbContent = '[production]
		resources.db.params.host 		= "' . $host . '"
		resources.db.params.username 	= "' . $user . '"
		resources.db.params.password 	= "' . $pwd . '"
		resources.db.params.dbname 		= "' . $dbname . '"
		resources.db.params.encode 		= "utf8"
		resources.db.params.prefixe 	= "' . $prefixe . '"
		
		[development]
		resources.db.params.host 		= "' . $host . '"
		resources.db.params.username 	= "' . $user . '"
		resources.db.params.password 	= "' . $pwd . '"
		resources.db.params.dbname 		= "' . $dbname . '"
		resources.db.params.encode 		= "utf8"
		resources.db.params.prefixe 	= "' . $prefixe . '"';
		file_put_contents(APPLICATION_PATH . '/configs/' . $this->_dbIni, $dbContent);
	}
	
	public 		function _init_db()
	{
		//loading modules
		$this->_load_mods('init');
			
		//email configuration
		$this->_email_config();
		
		//loading general conf
		$this->_get_general_conf();	
	}

	public 		function _get_langue($bJson = true){
		// CRL code
		$_data = array();
		$curlApiRequest = $this->sendCurlRequest($this->ApiUri . '?rquest=lang', $_data, 'POST', $bJson);
		return $curlApiRequest;
	}

	public function _set_lexique(){
		if($this->isApi ){
			// CRL code
			$data['lang'] = $this->i_lang;

			$curlApiRequest = $this->sendCurlRequest($this->ApiUri . '?rquest=SetLexique', $data, 'POST', true);
			$_tmp = $curlApiRequest;
			if(isset($_tmp) && $_tmp != 0)
				foreach($_tmp as $key => $val)
				{
					$this->a_lexique[$val->translation_type][$val->translation_page][$val->label] = $val;
				}
		}else{
			$this->database->set_lexique($this->i_lang);
		}
	}

	public function _get_lexique($s_translate, $b_type = 2, $b_page = 0){
		if($this->isApi == '1' ){
			return $s_translate;
		}else{;
			$this->database->get_lexique($s_translate, $b_type, $b_page);
			return $s_translate;
		}
	}

	public function _setReferer($sConfig, $s_field, $s_referer = "", $query = '', $a_data = array()){
		if($this->isApi == '1' ){
			$data['detail_category'] = $this->i_lang;
			$data['detail_referer'] = $this->i_lang;
			$data['lang'] = $this->i_lang;


			$detail_category = $cmsapi->_request['detail_category'];
			$detail_referer = $cmsapi->_request['detail_referer'];
			$lang = $cmsapi->_request['lang'];

			$curlApiRequest = $this->sendCurlRequest($this->ApiUri . '?ctrl=Menu&rquest=getReferer', $data, 'POST', true);
		}else{
			$this->database->setReferer($sConfig, $s_field, $s_referer, $query, $a_data);			
		}
	}

	public function search_query($config){
		
		if(isset($config['champs']))	
			foreach($config['champs'] as $key => $field){
				$aData = array();
				if(isset($field['table_link'])){
					$s_query = "SELECT " . $field['champ_link'] . ", " . $field['cle_link'] . "
							  FROM " . $field['table_link'];
	
					if(isset($field['condition_link']) && !empty($field['condition_link'])) 
						$s_query .= " WHERE " . implode(' AND ', $field['condition_link']);

					$s_query .= isset($field['sort_link']) && !empty($field['sort_link']) ? " ORDER BY " . $field['sort_link'] : '';
					
					if($this->isApi ){
						$_data = array();
						$_data['squery'] = $s_query;
						$_data['data'] = json_encode(array());
						
						$curlApiRequest = $this->sendCurlRequest($this->ApiUri . '?ctrl=Back&rquest=getData', $_data);

						$result = $curlApiRequest ;
					}else{
						$result = $this->database->prepare_query($s_query, array(), 'multiple');
					}

					foreach($result as $_key => $val)
					{
						if(!is_array($val))
							$val = (array)$val;
						if(preg_match('#CONCAT#',$field['champ_link']))
						{
							$_field['champ_link'] = preg_replace('#CONCAT#','',$field['champ_link']);
							$_field['champ_link'] = preg_replace('#,\' \'#','',$_field['champ_link']);
							$_field['champ_link'] = preg_replace('#\(#','',$_field['champ_link']);
							$_field['champ_link'] = preg_replace('#\)#','',$_field['champ_link']);
							$_field['champ_link'] = preg_replace('# AS #',',',$_field['champ_link']);
	
							$_a_field = explode(',',$_field['champ_link']);
			
							$aData[$val[$_a_field[2]]] = $val[$_a_field[2]];
						}
						else
							$aData[$val[$field['cle_link']]] = $val[$field['champ_link']];
					}
	
					$config['champs'][$key]['data'] = $aData;
				}
				elseif(isset($field['data'])) $config['champs'][$key]['data'] = $field['data'];
			}
		return $config;
	}
	public function _make_query($config, $s_search, $s_sort, $i_conf, $type = "SELECT"){
		global $_currentRules, $s_config;
		
		$i_join = 1;
		$a_query = array(
			"OR"=>array(),
			"AND"=>array(),
			"SET"=>array()
		);
		$condition = '';
		$s_query = "";
		$a_query_select = array('t0.'.$config['cle']);
		$s_query_table = "";
		$s_query_join = "";
		$s_query_set = "";
		$s_query_cond = "";
		$s_query_cond_more = "";

		switch($type)
		{
			default:
			case '':
			case 'SELECT':
				$s_query .= "
					SELECT t0.* " ;

				$s_query_table .= "
					 FROM " . $config['table'] . " AS t0";

				$s_query_cond .= "
					 WHERE " . (isset($config['condition']) && !empty($config['condition']) ? $config['condition'] : '1 ');
			break;

			case 'INSERT':
				$s_query .= "
					INSERT INTO ";

				$s_query_table .= $config['table'];

				$s_query_set .= " ";
				// 	SET ";

				$_a_query = array(
					"request"		=> "INSERT INTO " .  $config['table'],
					"fields"		=> array(),
					"values"		=> array()
				);
			break;

			case 'UPDATE':
				$s_query .= "
					UPDATE " ;

				$s_query_table .= $config['table'];

				$s_query_set .= " 
				 	SET ";

				$s_query_cond .= "
					 WHERE " . $config['cle'] . " = " . $_GET['val_id'];

				/*$_a_query = array(
					"request"		=> "UPDATE " .  $config['table'],
					"fields"		=> array(),
					"values"		=> array()
				);*/
			break;

			case 'DELETE':
				$s_query .= "
					SELECT t0.*" ;
			break;


		}
		foreach($config['champs'] as $field){
			if(isset($field['on_list']) && $field['on_list'])
				$a_query_select[] = 't0.' . $field['champ'] /*. " AS t0_" . $field['champ']*/;
		
			if((!isset($field['method']) || $field['method'] != "hach-salt") && (!isset($field['verif']) || !in_array('notempty',$field['verif']) || (isset($field['verif']) && in_array('notempty',$field['verif']))) && ((isset($_POST[$field['champ']]) && !empty($_POST[$field['champ']])) || !empty($s_search)))
			{
				$a_query['OR'][] = "t0." . $field['champ'] . (empty($s_search) ? '="' : ' LIKE "' ) . (empty($s_search ) ? (isset($_POST[$field['champ']]) ? (empty($_POST[$field['champ']]) && $field['type'] == 'checkbox' ? '0' : ($_POST[$field['champ']])) : '') : '%' . $s_search . '%' ) . '"';
			}

			if($field['type'] != "hidden" && (!isset($field['method']) || $field['method'] != "hach-salt") && (!isset($field['verif']) || !in_array('notempty',$field['verif']) || (isset($field['verif']) && in_array('notempty',$field['verif']))) && ((isset($field['verif']) && in_array('mandatory',$field['verif']) ) || ($_currentRules == 0 || ((is_array($_currentRules) && isset($_currentRules[$s_config]) && in_array($field['champ'], $_currentRules[$s_config])) || (!is_array($_currentRules) && isset($_currentRules->$s_config) && in_array($field['champ'], $_currentRules->$s_config))))))
			{
				$a_query['SET'][] = $field['champ'] . (empty($s_search) ? '="' : ' LIKE "' ) . (empty($s_search) ? (isset($_POST[$field['champ']]) ? (empty($_POST[$field['champ']]) && $field['type'] == 'checkbox' ? '0' : addslashes($_POST[$field['champ']])) : '') : '%' . $s_search . '%' ) . '"';
				$_a_query["fields"][] = $field['champ'];
				$_a_query["values"][] = (empty($s_search) ? (isset($_POST[$field['champ']]) ? (empty($_POST[$field['champ']]) && $field['type'] == 'checkbox' ? '0' : addslashes($_POST[$field['champ']])) : '') : '%' . $s_search . '%' ) ;
			}

			if($type == "SELECT" && $field['type'] == "field_list" && !isset($field['data']))
			{
				$a_query_select[] = "t" . $i_join . "." . $field['champ_link'];
				$s_query_join .= (isset($field['verif']) && (in_array('notempty',$field['verif']) || in_array('mandatory',$field['verif'])) ? " INNER JOIN " : " LEFT OUTER JOIN ") . $field['table_link'] . " AS t" . $i_join . " ON t" . $i_join . "." . $field['cle_link'] . "=" . "t0." . $field['champ'];

				if(isset($field['condition_link']) && !empty($field['condition_link'])) 
				{
					foreach($field['condition_link'] as $cond)
						$a_query['AND'][] = " t" . $i_join . "." . $cond;
				}

				if(preg_match('#CONCAT#',$field['champ_link']))
				{
					$field['champ_link'] = preg_replace('#CONCAT#','',$field['champ_link']);
					$field['champ_link'] = preg_replace('#,\' \'#','',$field['champ_link']);
					$field['champ_link'] = preg_replace('#\(#','',$field['champ_link']);
					$field['champ_link'] = preg_replace('#\)#','',$field['champ_link']);

					$a_field = explode(',',$field['champ_link']);
	
					foreach($a_field as $value)
						$a_query['OR'][] = 't' . $i_join . "." . $value . " LIKE '%" . $search . "%'";
						
				}
				
				if(!isset($a_field) && !empty($search) && !preg_match("#CONCAT#",$field['champ_link'])) 
					$a_query['OR'][] = "t" . $i_join . "." . $field['champ_link'] . " LIKE '%" . $search . "%'" ;	
				
				$i_join++;	
			}
		}

		if(isset($config['optim_search']) && !empty($config['optim_search']) && count($config['optim_search'])>0){
			foreach($config['optim_search'] as $key => $val){
				if(isset($_POST[$val['champ']]) && $_POST[$val['champ']]!="")
					if(isset($val['condition_type']) && $val['condition_type'] =="json")
						$a_query['AND'][] = "JSON_CONTAINS(t0." . $val['champ'] . ",'{\"addonsId\":[" . ($_POST[$val['champ']]) . "]}')";
					else
						$a_query['AND'][] = $val['champ'] . '="' . $_POST[$val['champ']] . '"';
				elseif(isset($_GET[$val['champ']]) && $_GET[$val['champ']]!="")
					if(isset($val['condition_type']) && $val['condition_type'] =="json")
						$a_query['AND'][] = "JSON_CONTAINS(t0." . $val['champ'] . ",'{\"addonsId\":[" . ($_GET[$val['champ']]) . "]}')";
					else
						$a_query['AND'][] = $val['champ'] . '="' . $_GET[$val['champ']] . '"';
				elseif(isset($val['verif']) && in_array('mandatory', $val['verif']))
					if(isset($val['condition_type']) && $val['condition_type'] =="json")
						$a_query['AND'][] = "JSON_CONTAINS(t0." . $val['champ'] . ",'{\"addonsId\":[" . (isset($val['default_value']) ? $val['default_value'] : 1) . "]}')";
					else
						$a_query['AND'][] = $val['champ'] . '="' . $_GET[$val['default_value']] . '"';
			}
		}
		if(isset($config['auto_fields']) && !empty($config['auto_fields']) && count($config['auto_fields']) >= 1){
			foreach($config['auto_fields'] as $field){
				if(!isset($field['action']) || (isset($field['action']) && $field['action'] == $_GET['action'])){
					$a_query['SET'][] = $field['champ'] . '="' . ($field['value']) . '"';
					$_a_query["fields"][] = $field['champ'];
					$_a_query["values"][] = $field['value'];
				}
			}
		}	

		if($type == "SELECT" && isset($config['external']) && !empty($config['external']))
			foreach($config['external'] as $key){
				if(isset($key['languages']))
				{
					$s_query .= ", t" . $i_join . ".*";					
					$s_query_join .= " LEFT OUTER JOIN " . $key['table'] . " AS t" . $i_join . " ON t" . $i_join . "." . $key['key'] . "=" . "t0." . $config['cle'];
					$a_query['AND'][] = "t" . $i_join . ".lang = " . $this->i_lang;
					$i_join++;						
				}
			}
			
		if(count($a_query) > 0 )
		{
			if($type == "SELECT")
			{
				$condition .= (isset($a_query['AND']) && count($a_query['AND']) > 0 ? (isset($config['condition']) && !empty($config['condition']) ? ' AND ' : '') . ' (' . implode(' AND ', $a_query['AND']) .')' : '');
				$condition .= (isset($a_query['OR']) && count($a_query['OR'])>0 ? (isset($config['condition']) && !empty($config['condition']) ? ' AND ' : '') . ' ('. implode(' OR ', $a_query['OR']).')' : '');
				$s_query_cond .= (!empty($condition) ? $condition : '');
			}elseif($type == "INSERT" )
			{
				//$condition .= (isset($a_query['SET']) && count($a_query['SET']) > 0 ? implode(', ', $a_query['SET']) : '');
				$condition .= (isset($_a_query['fields']) && count($_a_query['fields']) > 0 ? '('.implode(', ', $_a_query['fields']).') values("' . implode('", "', $_a_query['values']).'")'  : '');
				$s_query_set .= (!empty($condition) ? $condition : '');
			}elseif( $type == "UPDATE")
			{
				$condition .= (isset($a_query['SET']) && count($a_query['SET']) > 0 ? implode(', ', $a_query['SET']) : '');
				$s_query_set .= (!empty($condition) ? $condition : '');
			}
		}

		$s_query .= $s_query_table . ($type == "SELECT" ?  $s_query_join : '') . ($type == "INSERT" || $type == "UPDATE" ?  $s_query_set : '') . $s_query_cond . $s_sort ;

		return $s_query;
	}

	public function sendCurlRequest($baseUri, $_data = array(), $rtype = 'POST', $bJson = false){

		$ch = curl_init($baseUri);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $rtype);
		if($rtype == "POST")
			curl_setopt($ch, CURLOPT_POSTFIELDS, $_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		$response = curl_exec($ch);
//var_dump($response);
		if($bJson)
			$result = json_decode($response);
		else
			$result = json_decode($response, true);

		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);	

		curl_close($ch);

		if($http_code == 200)
			return $result;
		else
			return false;
	}
}
?>
