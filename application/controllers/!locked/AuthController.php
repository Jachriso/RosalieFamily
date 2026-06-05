<?php
class AuthController extends Starter
{
	public $authTree = '';
	public $authChartes = '';
	public $authBack = '';
	public $authGroup = '';
	
	function __construct() {
    }

	
	/**************************************************************************************************
	*	getAuth :  
	*	input : 
	*	output : variable de classe "auth" (ARRAY)
	**************************************************************************************************/
    public 		function checkIdent($login, $pwd, $remember = false)
    {		
		global $starter ;
		$log = array(
			"email"		=>"",
			"group"		=>"",
			"id"		=>"",
			"login"		=>"",
			"avatar"	=>"",
			"nom"		=>"",
			"prenom"	=>"",
			"asso"	=>"",
			"cat"	=>"",
			"rules"		=>"",
			"company"	=>"",
			"statut"	=>"",
			"valid"		=>"",
			"brutforce"	=>"");		

		$_statut = 0;
		$_map = new stdClass();
		if($starter->isApi ){
			$_data = array();
			$_data['login'] = $login;
			// CRL code
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=login', $_data);
			$_user = $curlApiRequest;

		}else{
			$a_data_query = array(
				'user_login' => array($login,PDO::PARAM_STR),
			);

			$s_query = "
				SELECT t0.*, t1.* 
				FROM admin_users AS t0 
				LEFT OUTER JOIN admin_groups AS t1 
				ON t1.group_id = t0.user_statut 
				WHERE t0.online = 1 
				AND t0.archive = 0 
				AND user_login = :user_login";

			$_user = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');
		}
		if(!$_user){
			return NULL;
		}else{
			foreach($_user as $key => $val){
				if(!is_array($val))
					$val = (array)$val;	
				
				$b_verif = $starter->utils->password_verify($pwd, $val['user_salt'], $val['user_password'], $val['user_lastlog']);
				if($b_verif )
				{
					$_statut = $val['user_statut'];

					if(preg_match('#addonsId#', $_statut)){	
						$_statut = json_decode($_statut);
						$_statut = $_statut->addonsId;
						
						if($starter->isApi ){
							$_data = array();
							$_data['group_id'] = implode(',',$_statut);
							// CRL code
							$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getGroupMap', $_data);
							$_menu_auth = $curlApiRequest;
						}else{
							$a_data_query = array(
								
							);

							$s_query = "
								SELECT map
								FROM admin_groups
								WHERE group_id IN (".implode(',',$_statut).")
								AND online = 1
								AND ARCHIVE = 0";
							$_menu_auth = $starter->database->prepare_query($s_query,$a_data_query,'multiple');
						}
						$_authTree = '';
						$_authChartes = '';
						$_authBack = '';
						$_authGroup = '';
						foreach($_menu_auth as $_key => $_val){

							$_tmp = json_decode($_val['map']);

							if(isset($_tmp->rules_treeId))
								$_authTree = (empty($_authTree) ? $_tmp->rules_treeId : array_merge($_authTree, $_tmp->rules_treeId));

							if(isset($_tmp->rules_chartesId))
								$_authChartes = (empty($_authChartes) ? $_tmp->rules_chartesId : array_merge($_authChartes, $_tmp->rules_chartesId));
								
							if(isset($_tmp->rules_backId))
								$_authBack = (empty($_authBack) ? $_tmp->rules_backId : (object) array_merge((array) $_authBack, (array) $_tmp->rules_backId));

							if(isset($_tmp->rules_groupId))
								$_authGroup = (empty($_authGroup) ? $_tmp->rules_groupId : array_merge( $_authGroup, $_tmp->rules_groupId));
						}
						$_map->rules_treeId = (!empty($_authTree) ? json_encode($_authTree) : '');
						$_map->rules_chartesId = (!empty($_authChartes) ? json_encode($_authChartes) : '');
						$_map->rules_backId = $_authBack;
						$_map->rules_groupId = (!empty($_authGroup) ? json_encode($_authGroup) : '');
						$_map = json_encode($_map);
					}

					$log['email']		= $val['user_email'];
					$log['login']		= $val['user_email'];
					$log['group']		= isset($val['group_name']) ? $val['group_name'] : '';
					$log['id']			= $val['user_id'];
					$log['nom']			= $val['user_lastname'];
					$log['avatar']		= $val['user_avatar'];
					$log['valid']		= $val['user_valid'];
					$log['prenom']		= $val['user_firstname'];
					$log['asso']		= $val['asso'];
					$log['company']		= $val['user_company'];
					$log['rules']		= (!empty($val['map']) ? $val['map'] : $_map);
					$log['statut']		= ($_statut == 0 ? "0" : $_statut);
					$log['brutforce']	= $val['user_brutforce'];
					return $log;
				}
			}
		}
		return NULL;
	}

	/**************************************************************************************************
	*	getAuth :  
	*	input : 
	*	output : variable de classe "auth" (ARRAY)
	**************************************************************************************************/
	public function getAuth()
	{
		global $starter ;
		$_menu_auth = array();
		
		if(isset($_SESSION['user_info']['user_statut']) &&  $_SESSION['user_info']['user_statut'] != 0 && isset($starter->needauth) && $starter->needauth)
		{
			if($starter->isApi ){
				$_data = array();
				$_data['user_id'] = intval($_SESSION['user_info']['user_id']);

				// CURL code
				$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getAuth', $_data);

				$_menu_auth = $curlApiRequest;
			}else{
				$a_data_query = array(
					'user_id' => array(intval($_SESSION['user_info']['user_id']),PDO::PARAM_INT),
				);
				$s_query = "
					SELECT map
					FROM admin_users
					WHERE user_id = :user_id
					AND online = 1";

				$_menu_auth = $starter->database->prepare_query($s_query,$a_data_query);
			}
			if(isset($_menu_auth->rules_treeId))
				$this->authTree = implode(',',$_menu_auth->rules_treeId);

			if(isset($_menu_auth->rules_chartesId))
				$this->authChartes = implode(',',$_menu_auth->rules_chartesId);
			
			if(isset($_menu_auth->rules_backId))
				$this->authBack = $_menu_auth->rules_backId;
			
			if(isset($_menu_auth->rules_groupId))
				$this->authGroup = implode(',',$_menu_auth->rules_groupId);
			
		}
	}

	public function getUserByToken($value = '')
	{
		global $starter ;
		$a_data = array();
		if(!empty($value))
			if($starter->isApi ){
				// CURL code
				//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getAuth', $_data);
				//$_menu_auth = $curlApiRequest;
			}else{
				$a_data_query = array(
					'token' => array($value,PDO::PARAM_STR),
				);
				$s_query = "
					SELECT * 
					FROM admin_users 
					WHERE user_token =:token
					";
				$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			}
		return $a_data;
	}

	public function getUserByPWDLink($value = '')
	{
		global $starter ;
		if($starter->isApi ){
			// CURL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getAuth', $_data);
			//$_menu_auth = $curlApiRequest;
		}else{
			$a_data_query = array(
				'user_forgotpwd' => array($value,PDO::PARAM_STR),
			);
			$s_query = "
				SELECT * 
				FROM admin_users
				AND user_valid != 2
				WHERE user_forgotpwd = :user_forgotpwd";
			$a_data = $starter->database->prepare_query($s_query,$a_data_query);
			
			return $a_data;
		}
	}

	public function updateUserToken($user_id = '')
	{
		global $starter ;
		if($starter->isApi ){
			// CURL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getAuth', $_data);
			//$_menu_auth = $curlApiRequest;
		}else{
			$a_data_query = array(
				'user_id' => array($user_id,PDO::PARAM_INT),
			);
			$s_query = "
				UPDATE admin_users
				SET user_token = '',
				user_valid = 1
				WHERE user_id = :user_id" ;
			$starter->database->prepare_query($s_query,$a_data_query);
		}
	}

	public function updateUserPwdLink($user_id = '')
	{
		global $starter ;
		if($starter->isApi ){
			// CURL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getAuth', $_data);
			//$_menu_auth = $curlApiRequest;
		}else{
			$pwdlink 				= $starter->utils->generateRandomString(32);
			$a_data_query = array(
				'user_forgotpwd' => array($pwdlink,PDO::PARAM_STR),
				'user_forgotpwd_date' => array(date("Y-m-d H:i:s"),PDO::PARAM_STR),
				'user_id' => array(intval($user_id),PDO::PARAM_INT),
			);
			$s_query = "
				UPDATE admin_users
				SET user_forgotpwd = :user_forgotpwd,
				user_forgotpwd_date = :user_forgotpwd_date
				WHERE user_id = :user_id";
			$starter->database->prepare_query($s_query,$a_data_query);
		}
		return $pwdlink ;
	}

	public function updateUserPwd($user_id = '')
	{
		global $starter ;
		if($starter->isApi ){
			// CURL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getAuth', $_data);
			//$_menu_auth = $curlApiRequest;
		}else{
			$salt 				= $starter->utils->generateRandomString(32);
			$uniqPass 			= $starter->utils->generateRandomString(12);
			$passwordToBeStored = $starter->utils->password_hash($uniqPass, $salt);

			$a_data_query = array(
				'user_password' => array($passwordToBeStored,PDO::PARAM_STR),
				'user_salt' => array($salt,PDO::PARAM_STR),
				'user_forgotpwd_date' => array(date("Y-m-d H:i:s"),PDO::PARAM_STR),
				'user_id' => array(intval($user_id),PDO::PARAM_INT),
			);
			$s_query = "
				UPDATE admin_users
				SET user_password = :user_password,
				user_salt = :user_salt,
				user_forgotpwd = '',
				user_forgotpwd_date = :user_forgotpwd_date
				WHERE user_id = :user_id";
				
			$starter->database->prepare_query($s_query,$a_data_query);
		}
		return $uniqPass ;
	}

	public function addUser()
	{
		global $starter ;

		$s_token_email = bin2hex(random_bytes(32));

		$s_salt = $starter->utils->generateRandomString(32);		
		$uniqPass = (isset($_POST['password']) ? $_POST['password'] : $starter->utils->generateRandomString(12));
		$s_passwordToBeStored = $starter->utils->password_hash($uniqPass, $s_salt);
		$s_online = 1;
		$s_valid = 0;

		$statut = '{"addonsId":[3]}';
		
		if($starter->isApi ){
			$_data = array();
			$_data['user_lastname'] = (isset($_POST['user_lname']) ? $_POST['user_lname'] : '');
			$_data['user_firstname'] = (isset($_POST['user_fname']) ? $_POST['user_fname'] : '');
			$_data['user_email'] = $_POST['user_email'];
			$_data['user_login'] = $_POST['user_email'];
			$_data['user_mobile'] = isset($_POST['user_mobile']) ? $_POST['user_mobile'] : '';
			$_data['user_phone'] = isset($_POST['user_phone']) ? $_POST['user_phone'] : '';
			$_data['user_contact'] = isset($_POST['user_contact']) ? $_POST['user_contact'] : '';
			$_data['user_online'] = 1;
			$_data['user_valid'] = 0;
			$_data['user_password'] = $s_passwordToBeStored;
			$_data['user_statut'] = $statut;
			$_data['user_inscription'] = date("Y-m-d");	
			$_data['user_lastlog'] = date("Y-m-d H:i:s");
			$_data['user_salt'] = $s_salt;
			$_data['user_token'] = $s_token_email;
			// CRL code
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=createUser', $_data);
			$_a_user = $curlApiRequest;
		}else{
			$a_data_query = array(
				'user_lastname' => array((isset($_POST['user_lname']) ? $_POST['user_lname'] : ''), PDO::PARAM_STR),
				'user_firstname' => array((isset($_POST['user_fname']) ? $_POST['user_fname'] : ''), PDO::PARAM_STR),
				'user_email' => array($_POST['user_email'], PDO::PARAM_STR),
				'user_login' => array($_POST['user_email'], PDO::PARAM_STR),
				'user_mobile' => array(isset($_POST['user_mobile']) ? $_POST['user_mobile'] : '', PDO::PARAM_STR),
				'user_phone' => array(isset($_POST['user_phone']) ? $_POST['user_phone'] : '', PDO::PARAM_STR),
				'user_contact' => array(isset($_POST['user_contact']) ? $_POST['user_contact'] : '', PDO::PARAM_STR),
				'user_online' => array($s_online, PDO::PARAM_BOOL),
				'user_archive' => array(0, PDO::PARAM_BOOL),
				'user_valid' => array($s_valid, PDO::PARAM_BOOL),
				'user_password' => array($s_passwordToBeStored, PDO::PARAM_STR),
				'user_statut' => array($statut, PDO::PARAM_STR),
				'user_inscription' => array(date("Y-m-d"), PDO::PARAM_STR),
				'user_lastlog' => array(date("Y-m-d H:i:s"), PDO::PARAM_STR),
				'user_salt' => array($s_salt, PDO::PARAM_STR),
				'user_token' => array($s_token_email, PDO::PARAM_STR),
				'create' => array(date("Y-m-d H:i:s"), PDO::PARAM_STR),
			);
			$s_query = "
				INSERT INTO admin_users
				SET user_lastname = :user_lastname,
				user_firstname = :user_firstname,
				user_email = :user_email,
				user_login = :user_login,
				user_statut = :user_statut,
				user_mobile = :user_mobile,
				user_phone = :user_phone,
				user_contact = :user_contact,
				online = :user_online,
				user_valid = :user_valid,
				map = '',
				user_password = :user_password,
				user_inscription = :user_inscription,
				user_lastlog = :user_lastlog,
				user_salt = :user_salt,
				user_token = :user_token,
				archive = :user_archive,
				_create = :create" ;
			
			$a_query = array(
				"request"		=> "INSERT INTO admin_users",
				"fields"		=> array('user_lastname', 'user_firstname', 'user_email', 'user_login', 'user_contact', 'user_statut', 'online', 'user_valid', 'map', 'user_password', 'user_inscription', 'user_lastlog', 'user_salt', 'user_token', 'archive', '_create'),
				"values"		=> array(':user_lastname', ':user_firstname', ':user_email', ':user_login', '', ':user_statut', ':user_online', ':user_valid', '', ':user_password', ':user_inscription', ':user_lastlog', ':user_salt', ':user_token', ':archive', ':create')
			);
			$starter->database->prepare_query($s_query,$a_data_query);
			$_id = $starter->database->request_id();
		}
		$a_data['user_id'] = $_id ;
		$a_data['s_token_email'] = $s_token_email ;
		return $a_data ;
	}
	public function getBrutforce($value = '')
	{
		global $starter ;
		if($starter->isApi ){
			$_data = array();
			$_data['user_login'] = intval($value);
			// CRL code
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getBrutforce', $_data);
			$_a_user = $curlApiRequest;
		}else{
			$a_data_query = array(
				'user_login' => array($value,PDO::PARAM_STR),
			);
			$s_query = "
				SELECT user_brutforce, user_id
				FROM admin_users
				WHERE user_login = :user_login" ;
			$_a_user = $starter->database->prepare_query($s_query,$a_data_query);
		}
		return $_a_user;
	}
	public function setBrutforce($user_id = '', $ibrutforce = 0)
	{
		global $starter ;
		if($starter->isApi ){
			$_data = array();
			$_data['user_id'] = intval($user_id);	
			$_data['user_brutforce'] = $ibrutforce;					
			// CRL code
			$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=setBrutforce', $_data);
		}else{
			$a_data_query = array(
				'user_id' => array(intval($user_id),PDO::PARAM_INT),
				'user_brutforce' => array($ibrutforce,PDO::PARAM_INT),
			);
			$s_query = "
				UPDATE admin_users
				SET user_brutforce = :user_brutforce
				WHERE user_id = :user_id" ;
			$starter->database->prepare_query($s_query,$a_data_query);
		}
	}

	public function setLog($user_id = '')
	{
		global $starter ;
		if($starter->isApi )
		{
			$_data = array();
			$_data['log_user'] = intval($user_id);
			$_data['log_ip'] = $_SERVER['REMOTE_ADDR'];
			$_data['log_date'] = date('Y-m-d H:i:s');
			
			// CURL code
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=logs', $_data);
			
			$_data = array();
			$_data['user_id'] = intval($user_id);
			$_data['user_lastlog'] = date('Y-m-d H:i:s');
			
			// CURL code
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=lastLog', $_data);

		}else{
			$a_data_query = array(
				'log_user' => array(intval($user_id),PDO::PARAM_INT),
				'log_ip' => array($_SERVER['REMOTE_ADDR'],PDO::PARAM_STR),
				'log_date' => array(date('Y-m-d H:i:s'),PDO::PARAM_STR),
			);
			$s_query = "
				INSERT INTO logs
				SET log_user = :log_user,
				log_ip = :log_ip,
				log_date = :log_date";

			$a_query = array(
				"request"		=> "INSERT INTO logs",
				"fields"		=> array('log_user', 'log_ip', 'log_date'),
				"values"		=> array(':log_user', ':log_ip', ':log_date')
			);
			$starter->database->prepare_query($s_query,$a_data_query, '', '', $a_query);
			
			$a_data_query = array(
				'user_id' => array(intval($user_id),PDO::PARAM_INT),
				'user_lastlog' => array(date('Y-m-d H:i:s'),PDO::PARAM_STR),
			);
			$s_query = "
				UPDATE admin_users
				SET user_lastlog = :user_lastlog
				WHERE user_id = :user_id";
			$starter->database->prepare_query($s_query,$a_data_query);
		};
	}

    public function updateUserForgotPassword($PWDLINK, $user_id)
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{

			$a_data_query = array(
				'user_forgotpwd' => array($PWDLINK,PDO::PARAM_STR),
				'user_forgotpwd_date' => array(date("Y-m-d H:i:s"),PDO::PARAM_STR),
				'user_id' => array(intval($user_id),PDO::PARAM_INT),
				'modify' => array(date("Y-m-d H:i:s"), PDO::PARAM_STR),
			);
			$s_query = "
				UPDATE admin_users
				SET user_forgotpwd = :user_forgotpwd,
				user_forgotpwd_date = :user_forgotpwd_date,
				modify = :modify
				WHERE user_id = :user_id";
			
			$starter->database->prepare_query($s_query,$a_data_query);
		}
    }

    public function getUserByTokenPWD($token = "")
    {
    	global $starter;
		if($starter->isApi ){
			$a_data = array();
						
			// CRL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getList', $_data);
			//$this->a_download = $curlApiRequest;

			return $a_data;
		}else{
			$a_data_query = array(
				'user_forgotpwd' => array($token,PDO::PARAM_STR),
			);
			$s_query = "
				SELECT * 
				FROM admin_users 
				WHERE user_forgotpwd = :user_forgotpwd
				";
			$a_data = $starter->database->prepare_query($s_query,$a_data_query);
			return $a_data;
		}
    }
}
?>
