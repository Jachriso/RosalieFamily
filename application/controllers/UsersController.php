<?php 
class UsersController extends Starter
{
	function __construct() {
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
				'user_address' => array(isset($_POST['user_address']) ? $_POST['user_address'] : '', PDO::PARAM_STR),
				'user_city' => array(isset($_POST['user_city']) ? $_POST['user_city'] : '', PDO::PARAM_STR),
				'user_street' => array(isset($_POST['user_street']) ? $_POST['user_street'] : '', PDO::PARAM_STR),
				'user_zipcode' => array(isset($_POST['user_zipcode']) ? $_POST['user_zipcode'] : '', PDO::PARAM_STR),
				'user_address2' => array(isset($_POST['user_address2']) ? $_POST['user_address2'] : '', PDO::PARAM_STR),
				'user_addr2_label' => array(isset($_POST['user_addr2_label']) ? $_POST['user_addr2_label'] : '', PDO::PARAM_STR),
				'user_city2' => array(isset($_POST['user_city2']) ? $_POST['user_city2'] : '', PDO::PARAM_STR),
				'user_street2' => array(isset($_POST['user_stree2t']) ? $_POST['user_street2'] : '', PDO::PARAM_STR),
				'user_zipcode2' => array(isset($_POST['user_zipcode2']) ? $_POST['user_zipcode2'] : '', PDO::PARAM_STR),
			); 	 	
			$s_query = "
				UPDATE admin_users
				SET	user_lastname = :user_lastname,
				user_firstname = :user_firstname,
				user_email = :user_email,
				user_phone = :user_phone,
				user_address = :user_address,
				user_city = :user_city,
				user_zipcode = :user_zipcode,
				user_street = :user_street,
				user_address2 = :user_address2,
				user_addr2_label = :user_addr2_label,
				user_city2 = :user_city2,
				user_street2 = :user_street2,
				user_zipcode2 = :user_zipcode2";

	        	        
			if(isset($_POST['user_logo']) )
			{
				$a_data_query['user_logo'] = array($_POST['user_logo'], PDO::PARAM_STR);
				$s_query .= "
					, user_logo = :user_logo";
			}
	        	        
			if(isset($_POST['user_avatar']) )
			{
				$a_data_query['user_avatar'] = array($_POST['user_avatar'], PDO::PARAM_STR);
				$s_query .= "
					, user_avatar = :user_avatar";
			}

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
		}
    } 	
    
    public function getAdresses($user = 0, $status = 0)
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
				SELECT user_id, user_street, user_city, user_zipcode, user_street2, user_city2, user_zipcode2, user_addr2_label";

			$s_query .="
				FROM admin_users";

			$s_query .="
				WHERE online = 1
				AND archive = 0
				AND user_valid = 1
				AND user_id = :user_id";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

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
				SELECT user_id, user_lastname, user_firstname, user_email, user_phone, user_logo, user_avatar, user_sign, user_tmp, user_address, user_city, user_zipcode, user_company, user_company_form, user_address2, user_city2, user_zipcode2, user_addr2_label, user_street, user_street2";

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
			
			$s_query ="
				SELECT user_id, user_lastname, user_firstname, user_email, CONCAT(user_lastname, ' ', user_firstname, ' ', user_company) AS label
				FROM admin_users
				WHERE online = 1
				AND archive = 0
				AND user_valid != 2
				AND user_statut != '0'";

			if(isset($_POST['reco_user'])){
				$a_data_query['user_reco'] = array('%'.$_POST['reco_user'].'%',PDO::PARAM_STR);				
				$s_query .="
					AND (
						user_lastname LIKE :user_reco OR
						user_firstname LIKE :user_reco OR
						user_email LIKE :user_reco
					)";
			}

			if(isset($_POST['mpb_user'])){
				$a_data_query['user_reco'] = array('%'.$_POST['mpb_user'].'%',PDO::PARAM_STR);				
				$s_query .="
					AND (
						user_lastname LIKE :user_reco OR
						user_firstname LIKE :user_reco OR
						user_email LIKE :user_reco
					)";
			}

			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');

			return $a_data;
		}
    }

    public function setVolants($a_data, $user, $type){
    	
    	global $starter;
		if($starter->isApi ){
			$a_data = array();
						
			// CRL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getList', $_data);
			//$this->a_download = $curlApiRequest;

			return $a_data;
		}else{
			
			$user_volants = intval($a_data['user_volants']);
			
			if($type == 1){
				$user_volants++;
			}else{
				$user_volants = $user_volants - 2;
			}

			$a_data_query = array(
				'user_id' => array($user,PDO::PARAM_INT),
				'user_volants' => array($user_volants,PDO::PARAM_INT),
			);

	    	$s_query ="
				UPDATE admin_users
				SET user_volants = :user_volants 
				WHERE user_id = :user_id";

			$starter->database->prepare_query($s_query,$a_data_query);
		}
    }

    public function getVolantsByUser($user){
    	
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
				SELECT user_volants
				FROM admin_users
				WHERE online = 1
				AND archive = 0
				AND user_id = :user_id";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			return $a_data;
		}
    }

	public function getDestinataires()
    {
    	global $starter;
		if($starter->isApi ){
			$a_data = array();
						
			// CRL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getList', $_data);
			//$this->a_download = $curlApiRequest;

			return $a_data;
		}else{
			
			$s_query ="
				SELECT user_id, user_lastname, user_firstname, user_email
				FROM admin_users
				WHERE online = 1
				AND archive = 0
				AND user_valid != 2";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');

			return $a_data;
		}
    }
}
?>