<?php 
class UserController extends Starter
{
	function __construct() {
    }

    public function newUser()
    {
		global $starter;
		$a_fields = array(
			"fields" => array(
				'user_lastname'	=> array(
					"field"			=> "user_lastname",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Nom"),
					"error_label"	=>	$starter->_get_lexique("Saisie du Nom incorrecte"),
					"verif"			=>	array("mandatory"),
					"maxlength"		=>	255,
				),
				'user_firstname'	=> array(
					"field"			=> "user_firstname",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Prénom"),
					"error_label"	=>	$starter->_get_lexique("Saisie du Prénom incorrecte"),
					"verif"			=>	array("mandatory"),
					"maxlength"		=>	255,
				),
				'user_email'	=> array(
					"field"			=> "user_email",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Email"),
					"error_label"	=>	$starter->_get_lexique("Saisie de l'Email incorrecte"),
					"verif"			=>	array("mandatory"),
					"maxlength"		=>	255,
					"preg_pattern"	=>	$starter->preg_pattern_email,
				),
				'user_phone'	=> array(
					"field"			=> "user_phone",
					"type"			=> "tel",
					"label"			=>	$starter->_get_lexique("Numéro de Téléphone"),
					"error_label"	=>	$starter->_get_lexique("Saisie du Numéro de Téléphone incorrecte"),
					"verif"			=>	array("mandatory"),
					"preg_pattern"	=>	$starter->preg_pattern_tel,
					"maxlength"		=>	10,
					"oninput"		=> "tel",
				),
				'user_address'	=> array(
					"field"			=> "user_address",
					"type"			=> "varchar",
					"label"			=>	($_SESSION['user_info']['user_statut'] != 65 ? $starter->_get_lexique("Adresse du domicile") : $starter->_get_lexique("Adresse du siège")),
					"maxlength"		=>	255
				),
				'user_addr_label'	=> array(
					"field"			=> "user_addr_label",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Libellé"),
					"maxlength"		=>	255
				),
				'user_street'	=> array(
					"field"			=> "user_street",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Rue"),
					"maxlength"		=>	255
				),
				'user_city'	=> array(
					"field"			=> "user_city",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Ville"),
					"maxlength"		=>	255
				),
				'user_zipcode'	=> array(
					"field"			=> "user_zipcode",
					"type"			=> "number",
					"label"			=>	$starter->_get_lexique("Code Postal"),
					"maxlength"		=>	5
				),
				'user_address2'	=> array(
					"field"			=> "user_address2",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Seconde adresse"),
					"maxlength"		=>	255
				),
				'user_addr2_label'	=> array(
					"field"			=> "user_addr2_label",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Second lieu de prise en charge"),
					"maxlength"		=>	255
				),
				'user_street2'	=> array(
					"field"			=> "user_street2",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Rue"),
					"maxlength"		=>	255
				),
				'user_city2'	=> array(
					"field"			=> "user_city2",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Ville"),
					"maxlength"		=>	255
				),
				'user_zipcode2'	=> array(
					"field"			=> "user_zipcode2",
					"type"			=> "number",
					"label"			=>	$starter->_get_lexique("Code Postal"),
					"maxlength"		=>	5
				),
				'password'	=> array(
					"field"			=>	"password",
					"type"			=>  "password",
					"verif"			=>	array("mandatory"),
					"label"			=>	$starter->_get_lexique("Modifier mon mot de passe"),
					"error_label"	=>	$starter->_get_lexique("Mot de passe trop faible"),
					"options"		=>  array('tooltip'),
				),
				'password_confirm'	=>	array(
					"field"			=>	"password_confirm",
					"type"			=>  "password",
					//"verif"			=>	array("mandatory"),
					"label"			=>	$starter->_get_lexique("Confirmer votre mot de passe"),
					"error_label"	=>	$starter->_get_lexique("Confirmation du mot de passe incorrecte"),
					"check_method"	=>	'match',
					"check_option" 	=>	'password'
				),
			),
		);
		return $a_fields;
    }

    public function getUsers()
    {
    	global $starter;
		if($starter->isApi ){
			$a_data = array();
						
			// CRL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getList', $_data);
			//$this->a_download = $curlApiRequest;

			return $a_data;
		}else{
			$a_data_query = array();
			$s_query ="
				SELECT user_id, user_lastname, user_firstname, user_email, user_contact, user_phone, user_address, user_city, user_zipcode
				FROM admin_users as t0
				WHERE online = 1
				AND archive = 0
				AND user_valid = 1";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');

			return $a_data;
		}
    }

    public function getUser($user = 0, $status = 0)
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
				'user_id' => array($user,PDO::PARAM_INT),
			);
			$s_query ="
				SELECT user_id, user_lastname, user_firstname, user_email, user_phone, user_logo, user_sign, user_tmp, user_address, user_city, user_zipcode";

			$s_query .="
				FROM admin_users as t0";

			$s_query .="
				WHERE t0.online = 1
				AND t0.archive = 0
				AND user_valid = 1
				AND user_id = :user_id";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			return $a_data;
		}
    }

    public function getUserByEmail($email)
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
				'user_email' => array($email,PDO::PARAM_STR),
			);
			$s_query ="
				SELECT user_id, user_lastname, user_firstname, user_email, user_contact, user_phone, user_address, user_city, user_zipcode
				FROM admin_users as t0
				WHERE online = 1
				AND archive = 0
				AND user_valid != 2
				AND user_email = :user_email";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			return $a_data;
		}
    }

    public function updateUser()
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			if(!empty($_POST['password']))
			{
				$salt = $starter->utils->generateRandomString(32);
				$uniqPass = htmlentities($_POST['password']);
				$passwordToBeStored = $starter->utils->password_hash($uniqPass, $salt);
			}
	 	 	 	 	 
			$a_data_query = array(
				'user_id' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
				'user_lastname' => array($_POST['user_lastname'], PDO::PARAM_STR),
				'user_firstname' => array($_POST['user_firstname'], PDO::PARAM_STR),
				'user_email' => array($_POST['user_email'], PDO::PARAM_STR),
				'user_phone' => array(isset($_POST['user_phone']) ? $_POST['user_phone'] : '', PDO::PARAM_STR),
				'user_company_form' => array(isset($_POST['user_company_form']) ? $_POST['user_company_form'] : '', PDO::PARAM_INT),
				'user_address' => array(isset($_POST['user_address']) ? $_POST['user_address'] : '', PDO::PARAM_STR),
				'user_city' => array(isset($_POST['user_city']) ? $_POST['user_city'] : '', PDO::PARAM_STR),
				'user_zipcode' => array(isset($_POST['user_zipcode']) ? $_POST['user_zipcode'] : '', PDO::PARAM_STR),
				'user_logo' => array(isset($_POST['user_logo']) ? $_POST['user_logo'] : '', PDO::PARAM_STR),
				'user_avatar' => array(isset($_POST['user_avatar']) ? $_POST['user_avatar'] : '', PDO::PARAM_STR),
			); 	 	
			$s_query = "
				UPDATE admin_users
				SET	user_lastname = :user_lastname,
				user_firstname = :user_firstname,
				user_email = :user_email,
				user_phone = :user_phone,
				user_company_form = :user_company_form,
				user_address = :user_address,
				user_city = :user_city,
				user_zipcode = :user_zipcode,
				user_logo = :user_logo,
				user_avatar = :user_avatar,";

			if(!empty($_POST['password']))
			{
				$a_data_query['user_password'] = array($passwordToBeStored, PDO::PARAM_STR);
				$a_data_query['user_salt'] = array($salt, PDO::PARAM_STR);
				
				$s_query .= "
					, user_password = :user_password,
					user_salt = :user_salt";
			}
			$s_query .= "
				WHERE user_id = :user_id";

			$starter->database->prepare_query($s_query,$a_data_query);

			exit();
		}
    } 	 	 	 	 	 	 	
    public function updateUserProfil()
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			if(!empty($_POST['profil_pwd']))
			{
				$salt = $starter->utils->generateRandomString(32);
				$uniqPass = htmlentities($_POST['profil_pwd']);
				$passwordToBeStored = $starter->utils->password_hash($uniqPass, $salt);
			}

			$a_data_query = array(
				'user_id' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
			);
			$s_query = "
				UPDATE admin_users
				SET	user_profil = 1
				WHERE user_id = :user_id";

			$starter->database->prepare_query($s_query,$a_data_query);
		}
    }
}
?>