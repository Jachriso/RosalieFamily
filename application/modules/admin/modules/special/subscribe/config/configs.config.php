<?php
$a_config[0] = array(
					 "name"					=> $this->_get_lexique('Utilisateur',1),
					 "addon"				=> "default",
					 "table"				=> "admin_users",
					 "code"					=> "admin_users",
					 "tri"					=> "user_inscription DESC",
					 "cle"					=> "user_id",
					 "condition"			=> "user_statut!='0' AND t0.archive=0 {IDENT}",
					 "condition_include"	=> true,					 
					 "optim_search" 		=> array(
												"user_valid" 		=> array(
													"champ"						=> "user_valid",
													"title"						=> $this->_get_lexique('Etat',1),
													"type"						=> "radio",
													"data"						=> array("0"=>$this->_get_lexique('En attente',1),"1"=>$this->_get_lexique('Valider',1),"2"=>$this->_get_lexique('Refuser',1))
												),
												"user_statut" => array(
													"champ"						=> "user_statut",
													"title"						=> $this->_get_lexique('Group',1),
													"type"						=> "field_list",
													"table_link"				=> "admin_groups",
													"champ_link"				=> "group_name",
													"cle_link"					=> "group_id",
													"condition_link"			=> array("online = 1", "archive = 0", "{IDENT}"),
													"condition_type"			=> "json"
												),
					 ),
    				 "actions"				=> array('edit', 'delete'),
    				 "more_actions"			=> array('add', 'search'),
					 "champs"				=> array(
					 							"online" => array(
														"champ"					=> "online",
														"title"					=> $this->_get_lexique('online',1),
														"type"					=> "checkbox",
														"icon"					=> "switch",
														"on_list"				=> true,
														"zone"					=> "action",
														"priority"				=> 1,
												),
												"user_valid" => array(
													"champ"						=> "user_valid",
													"title"						=> $this->_get_lexique('Etat',1),
													"type"						=> "field_list",
													"data"						=> array("0"=>$this->_get_lexique('En attente',1),"1"=>$this->_get_lexique('Valider',1),"2"=>$this->_get_lexique('Refuser',1)),
													"on_list"					=> true,
													"list_css"					=> "width:7%;"
												),
												"user_lastname" => array(
													"champ"						=> "user_lastname",
													"title"						=> $this->_get_lexique('Nom',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
													"verif"						=> array("mandatory"),
													"error_label"				=> $this->_get_lexique('Saisie du nom incorrecte',1),
													"on_list"					=> true,
													"list_css"					=> "width:10%;",
												),
												"user_firstname" => array(
													"champ"						=> "user_firstname",
													"title"						=> $this->_get_lexique('Prénom',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
													"verif"						=> array("mandatory"),
													"error_label"				=> $this->_get_lexique('Saisie du prénom incorrecte',1),
													"on_list"					=> true,
													"list_css"					=> "width:10%;",
												),
												/*"user_absence" => array(
													"champ"						=> "user_absence",
													"title"						=> $this->_get_lexique('Absence',1),
													"type"						=> "number",
													"maxlength"					=> 2,
													"error_label"				=> $this->_get_lexique("Saisie de l'Absence incorrecte",1),
													"on_list"					=> true,
													"list_css"					=> "width:10%;",
												),*/
												"user_company" => array(
													"champ"						=> "user_company",
													"title"						=> $this->_get_lexique('Société',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
												),
												"user_phone" => array(
													"champ"						=> "user_phone",
													"title"						=> $this->_get_lexique('Téléphone',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
												),
												"user_inscription" => array(
													"champ"						=> "user_inscription",
													"title"						=> $this->_get_lexique("Date d'inscription",1),
													"type"						=> "hidden",
												),
												"user_lastlog" => array(
													"champ"						=> "user_lastlog",
													"title"						=> $this->_get_lexique('Dernière connexion',1),
													"type"						=> "hidden",
													"on_list"					=> true,
													"list_css"					=> "width:15%;",
												),
												"user_statut"		=> array(
													"champ"						=> "user_statut",
													"title"						=> "Groupes",
													"type"						=> "select_group",
													"vtype"						=> "inside",
													"origin"					=> "special",
													"condition_link"			=> array("online = 1", "archive = 0", "{IDENT}"),
												),
												"user_email" => array(
													"champ"						=> "user_email",
													"title"						=> $this->_get_lexique('E-mail',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
													"verif"						=> array("mandatory", "verify"), 
													"check_method"				=> "already",
													"error_label"				=> $this->_get_lexique("Saisie de l'email incorrecte",1),
												),
												"user_login" => array(
													"champ"						=> "user_login",
													"title"						=> $this->_get_lexique('Identifiant',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
													"verif"						=> array("mandatory", "verify"),
													"check_method"				=> "already",
													"error_label"				=> $this->_get_lexique("Saisie de l'identifiant incorrecte",1),
												),
												"user_password" => array(
													"champ"						=> "user_password",
													"title"						=> $this->_get_lexique('Mot de passe',1),
													"type"						=> "password",
													"maxlength"					=> 255,
													"method"					=> "hach-salt",
													"verif"						=> array("verify", "notempty"),
													//"check_method"				=> "zxcvbn",
													"error_label"				=> $this->_get_lexique("Mot de passe trop faible",1),
												),	 	 	 					
												"map"=> array(
													"champ"						=> "map",
													"title"						=> $this->_get_lexique('Gestion des droits'),
													"type"						=> "select_rules",
													"vtype"						=> "inside",
													"origin"					=> "special"
												),
												"user_brutforce" => array(
													"champ"						=> "user_brutforce",
													"title"						=> $this->_get_lexique('Brutforce',1),
													"type"						=> "varchar",
													"maxlength"					=> 1,
												),
											),			
					"auto_fields"	=> array(
						"user_salt" => array("champ"=>"user_salt", "value"=>$this->utils->generateRandomString(32), "action"=>"add"),
						"user_inscription " => array("champ"=>"user_inscription ", "value"=>date("Y-m-d"), "action"=>"add"),
					),
);
function do_before_admin_users()
{
	global $starter, $o_result_before, $s_action, $s_form_valId, $s_module, $s_config;
	
	if($_SESSION['user_info']['user_statut'] == 0)
	{
		$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['condition'] = preg_replace('#{IDENT}#','',$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['condition']);
		unset($starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['optim_search']['user_statut']['condition_link'][2]);
		unset($starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['champs']['user_statut']['condition_link'][2]);
		
	}
	else
	{
		$s_rules = json_decode($_SESSION['user_info']['user_rules']);
		
		$s_rules = preg_replace('#"#','',$s_rules->rules_groupId);
		$s_rules = preg_replace('#\[#','',$s_rules);
		$s_rules = preg_replace('#\]#','',$s_rules);
		$s_rules = explode(',',$s_rules);
		
		$_groupmap = ($_SESSION['user_info']['user_statut']);
		$s_groupmap = "(";
		$iCompt = 0;
		foreach($s_rules as $_group => $map){
			$s_groupmap .= ($iCompt == 0 ? '' : ' OR ') . " user_statut LIKE '%" . $map . "%'";
			$iCompt ++;
		}
		$s_groupmap .= ')';

		//$_groupmap = $_groupmap->rules_groupId;

		$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['condition'] 	= preg_replace('#{IDENT}#',' AND ' . $s_groupmap , $starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['condition'] );

		$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['optim_search']['user_statut']['condition_link']	= preg_replace('#{IDENT}#',' group_id IN (' . implode(',',$s_rules) .')',$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['optim_search']['user_statut']['condition_link']);
		
		$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['champs']['user_statut']['condition_link']	= preg_replace('#{IDENT}#',' group_id IN (' . implode(',',$_groupmap) .')',$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['champs']['user_statut']['condition_link']);

	}
	if($s_action == "edit")
	{
		$s_query ="
			SELECT user_valid
			FROM admin_users
			WHERE user_id = :user_id";

		$a_data_query = array(
			'user_id' => array(intval($s_form_valId),PDO::PARAM_INT),
		);	
		
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
			$o_result = $curlApiRequest;
		}else{
			$o_result = $starter->database->prepare_query($s_query,$a_data_query);			
		}
	}
}
function do_after_admin_users()
{
	global $starter, $o_result_before, $_id, $s_form_valId, $s_action;
	$iInsert = (!empty($s_form_valId) ? $s_form_valId : $_id);
	if($s_action == "add"){
		
		$salt = $starter->utils->generateRandomString(32);
		if(!empty($_POST['user_password'])) $uniqPass = $_POST['user_password'];
		else  $uniqPass = $starter->utils->generateRandomString();
			
		$passwordToBeStored = $starter->utils->password_hash($uniqPass, $salt);
		$a_data_query = array(
			'user_inscription' => array(date("Y-m-d"),PDO::PARAM_STR),
			'user_lastlog' => array(date("Y-m-d H:i:s"),PDO::PARAM_STR),
			'user_password' => array($passwordToBeStored,PDO::PARAM_STR),
			'user_salt' => array($salt,PDO::PARAM_STR),
			'user_id' => array(intval($iInsert),PDO::PARAM_INT),
		);

		$s_query ="
			UPDATE admin_users
			SET user_inscription = :user_inscription,
			user_lastlog = :user_lastlog,
			user_password = :user_password,
			user_salt = :user_salt
			WHERE user_id = :user_id";
				
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Tree&rquest=setData', $_data);
			$o_result = $curlApiRequest;
		}else{
			$o_result = $starter->database->prepare_query($s_query,$a_data_query);			
		}


		/******************************************************************************
		 * 
		 * SYNCH ACCOUNT TO WORDPRESS API
		 * 
		 ******************************************************************************/ 
		$ch = curl_init($starter->apiWordpressUri . "addUser/");
	    $headers = array(
	        'Content-Type: application/json'
	    );
	    $user_tokenapi = $starter->utils->generateRandomString(25);

	    $postData = array(
        	'token' => $user_tokenapi,
        	'user_firstname' => $_POST['user_firstname'],
        	'user_lastname' => $_POST['user_lastname'],
        	'user_company' => $_POST['user_company'],
        	'user_phone' => $_POST['user_phone'],
        	'user_email' => $_POST['user_email'],
		);

		curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
	    curl_setopt($ch, CURLOPT_ENCODING, '');
	    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	    $response = curl_exec($ch);
	    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	    if($httpCode == 201){
	        
	    }else{

	    }
	}
	elseif($s_action == "edit")
	{
		$salt = $starter->utils->generateRandomString(32);
		$uniqPass = $_POST['user_password'];
		$passwordToBeStored = $starter->utils->password_hash($uniqPass, $salt);
		$a_data_query = array(
			'user_password' => array($passwordToBeStored,PDO::PARAM_STR),
			'user_salt' => array($salt,PDO::PARAM_STR),
			'user_id' => array(intval($iInsert),PDO::PARAM_INT),
		);
		$s_query ="
			UPDATE admin_users
			SET user_password = :user_password,
			user_salt = :user_salt
			WHERE user_id = :user_id";
				
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Tree&rquest=setData', $_data);
			$o_result = $curlApiRequest;
		}else{
			$o_result = $starter->database->prepare_query($s_query,$a_data_query);			
		}
	}
	
	if($_POST['user_valid'] == "1" && (isset($o_result_before['user_valid']) && $o_result_before['user_valid'] != 1) || ($s_action == "add" ))
	{
		require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';
						
		//$link_token = $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . 'confirm/' . $s_token_email;

		$email = new EmailSender();
		$a_data_email = array(
			'tpl' => dirname(__FILE__) . '/../views/email/subscribe_confirmation.php',
			'action' => "subscribe-confirmation",
			'destinataire' => $_POST['user_email'],
			'subject' => $starter->_get_lexique("Votre inscription &agrave; REV"),
		);
		
		$sender_email = $email->sendEmail($a_data_email);

		/*require_once LIBRARY_PATH . '/phpmailer/class.phpmailer.php' ;
		
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
		$s_result = '' ;

		$s_tpl_file = dirname(__FILE__) . '/../views/email/subscribe_confirmation.php';
		if(!$starter->b_curl) $s_template 		= 	file_get_contents($s_tpl_file) ;
		else		 $s_template 		= 	$starter->utils->curl_load($s_tpl_file) ;
		$s_action = "subscribe-confirmation";
		
		ob_start();
		print eval('?>'. $s_template);
		$s_template = ob_get_contents();
		ob_end_clean();
		
		require APPLICATION_PATH . '/modules/email_sender/controllers/index.php' ;*/
	}
	else if($_POST['user_valid'] == "2" && (isset($o_result_before['user_valid']) && $o_result_before['user_valid'] != 2) || ($s_action == "add" ))
	{	

		require_once APPLICATION_PATH . '/controllers/!locked/EmailSenderController.php';
						
		//$link_token = $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . 'confirm/' . $s_token_email;

		$email = new EmailSender();
		$a_data_email = array(
			'tpl' => dirname(__FILE__) . '/../views/email/subscribe_forbiden.php',
			'action' => "subscribe-forbiden",
			'destinataire' => $_POST['user_email'],
			'subject' => $starter->_get_lexique("Votre inscription &agrave; Prestataires de mariage"),
		);
		
		$sender_email = $email->sendEmail($a_data_email);

		/*require_once LIBRARY_PATH . '/phpmailer/class.phpmailer.php' ;
		
		$mail = new PHPMailer(true); //New instance, with exceptions enabled
		$s_result = '' ;
					
		$s_tpl_file = dirname(__FILE__) . '/../views/email/subscribe_forbiden.php';
		if(!$starter->b_curl) $s_template 		= 	file_get_contents($s_tpl_file) ;
		else		 $s_template 		= 	$starter->utils->curl_load($s_tpl_file) ;
		ob_start();
		print eval('?>'. $s_template);
		$s_template = ob_get_contents();
		ob_end_clean();
		$s_action = "subscribe-forbiden";
		require APPLICATION_PATH . '/modules/email_sender/controllers/index.php' ;*/
				
	}
}
$a_config[1] = array(
					 "name"					=> $this->_get_lexique('groupe'),
					 "addon"				=> "default",
					 "table"				=> "admin_groups",
					 "code"					=> "admin_groups",
					 "tri"					=> "group_name ASC",
					 "cle"					=> "group_id",
					 "condition"			=> "group_id != 0 AND archive = 0 {IDENT}",
					 "condition_include"	=> true,				
    				 "actions"				=> array('edit', 'delete'),
    				 "more_actions"			=> array('add'),
					 "champs"				=> array(
												"online" => array(
														"champ"					=> "online",
														"title"					=> $this->_get_lexique('online'),
														"type"					=> "checkbox",
														"icon"					=> "switch",
														"on_list"				=> true,
														"zone"					=> "action",
														"priority"				=> 1,
												),
												"group_name" 	=> array(
													"champ"						=> "group_name",
													"title"						=> $this->_get_lexique('Nom'),
													"type"						=> "varchar",
													"maxlength"					=> 255,
													"verif"						=> array("mandatory"),
													"on_list"					=> true
												),
												"map"		=> array(
													"champ"						=> "map",
													"title"						=> "Gestion des droits",
													"type"						=> "select_rules",
													"vtype"						=> "inside",
													"origin"					=> "special"
												),
									)
);
function do_before_admin_groups()
{
	global $starter, $s_module, $s_config, $o_result_before ;
	
	if($_SESSION['user_info']['user_statut'] == 0 )
	{
		$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['condition'] 	= preg_replace('#{IDENT}#','',$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['condition']);
	}	
	else
	{
		$s_rules = json_decode($_SESSION['user_info']['user_rules']);
		
		$s_rules = preg_replace('#"#','',$s_rules->rules_groupId);
		$s_rules = preg_replace('#\[#','',$s_rules);
		$s_rules = preg_replace('#\]#','',$s_rules);
		$s_rules = explode(',',$s_rules);
		
		$_groupmap = ($_SESSION['user_info']['user_statut']);
		$s_groupmap = "(";
		$iCompt = 0;
		foreach($s_rules as $_group => $map){
			$s_groupmap .= ($iCompt == 0 ? '' : ' OR ') . " group_id LIKE '%" . $map . "%'";
			$iCompt ++;
		}
		$s_groupmap .= ')';

		$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['condition'] 	= preg_replace('#{IDENT}#',' AND ' . $s_groupmap , $starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['condition'] );

	}
}
?>