<?php 
class AdherentsController extends Starter
{
	function __construct() {
    }

    public function newAdherent()
    {
		global $starter;
		$a_fields = array(
			"fields" => array(
				'adherent_fname'	=> array(
					"field"			=> "adherent_fname",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Prénom de l'enfant"),
					"error_label"	=>	$starter->_get_lexique("Saisie du Prénom de l'enfant incorrecte"),
					"maxlength"		=>	255,
				),
				'adherent_lname'	=> array(
					"field"			=> "adherent_lname",
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Nom de l'enfant"),
					"error_label"	=>	$starter->_get_lexique("Saisie du Nom de l'enfant incorrecte"),
					"maxlength"		=>	255,
				),
				'adherent_bday'	=> array(
					"field"			=> "adherent_bday",
					"type"			=> "date",
					"label"			=>	$starter->_get_lexique("Date de naissance"),
					"error_label"	=>	$starter->_get_lexique("Saisie de la Date de naissance incorrecte"),
				),
				'asso'	=> array(
					"field"			=> "asso",
					"type"			=> "select",
					"label"			=>	$starter->_get_lexique("Choix des associations"),
					"error_label"	=>	$starter->_get_lexique("Saisie de l'ssociation incorrecte"),
				),
			),
		);

		if(isset($_POST['adherents']) && $_POST['adherents'] > 0){
			for($i=1;$i<=$_POST['adherents'];$i++){
				$a_fields['fields']['adherent_fname_'.$i] = array(
					"field"			=> "adherent_fname_".$i,
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Prénom de l'enfant *"),
					"error_label"	=>	$starter->_get_lexique("Saisie du Prénom de l'enfant incorrecte"),
					"verif"			=>	array("mandatory"),
					"maxlength"		=>	255,
				);
				$a_fields['fields']['adherent_lname_'.$i] = array(
					"field"			=> "adherent_lname_".$i,
					"type"			=> "varchar",
					"label"			=>	$starter->_get_lexique("Nom de l'enfant *"),
					"error_label"	=>	$starter->_get_lexique("Saisie du Nom de l'enfant incorrecte"),
					"verif"			=>	array("mandatory"),
					"maxlength"		=>	255,
				);
				$a_fields['fields']['adherent_bday_'.$i] = array(
					"field"			=> "adherent_bday_".$i,
					"type"			=> "date",
					"label"			=>	$starter->_get_lexique("Age de l'enfant *"),
					"error_label"	=>	$starter->_get_lexique("Saisie de la Date de naissance incorrecte"),
					"verif"			=>	array("mandatory"),
				);
				$a_fields['fields']['asso_'.$i] = array(
					"field"			=> "asso_".$i,
					"type"			=> "select",
					"label"			=>	$starter->_get_lexique("Associations"),
					"error_label"	=>	$starter->_get_lexique("Saisie de l'ssociation incorrecte"),
				);
			}
		}
		return $a_fields;
    }

    public function addAdherents()
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{

			if(isset($_POST['adherents']) && $_POST['adherents'] > 0){

				$a_data_query = array(
					'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
				); 	 

				$s_query = "";

				for($i=1;$i<=$_POST['adherents'];$i++){
					$a_data_query['adherent_lname_'.$i] = array($_POST['adherent_lname_'.$i], PDO::PARAM_STR);
					$a_data_query['adherent_fname_'.$i] = array($_POST['adherent_fname_'.$i], PDO::PARAM_STR);
					$a_data_query['adherent_bday_'.$i] = array($_POST['adherent_bday_'.$i], PDO::PARAM_STR);
					$s_query .= "
						INSERT INTO adherents
						SET	user = :user,
						adherent_lname = :adherent_lname_".$i.",
						adherent_fname = :adherent_fname_".$i.",
						adherent_bday = :adherent_bday_".$i.";";
				}

				$starter->database->prepare_query($s_query,$a_data_query);
			}
		}
    } 
    public function addAdherent($id)
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			$a_data_query = array(
				'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
				'adherent_lname' => array($_POST['adherent_lname_'.$id], PDO::PARAM_STR),
				'adherent_fname' => array($_POST['adherent_fname_'.$id], PDO::PARAM_STR),
				'adherent_bday' => array($_POST['adherent_bday_'.$id], PDO::PARAM_STR),
			);
					
			$s_query = "
				INSERT INTO adherents
				SET	user = :user,
				adherent_lname = :adherent_lname,
				adherent_fname = :adherent_fname,
				adherent_bday = :adherent_bday";
			
			$starter->database->prepare_query($s_query,$a_data_query);

			return $starter->database->request_id();
		}
    } 

    public function addAdherentAssos($id, $i, $token)
    {
    	global $starter;
		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			$a_data_query = array(
				'user' => array($id, PDO::PARAM_INT),
				'asso' => array($i, PDO::PARAM_INT),
				'token' => array($token, PDO::PARAM_STR),
			);
					
			$s_query = "
				INSERT INTO adherent_assos
				SET	adherent = :user,
				asso = :asso,
				token = :token";
			
			$starter->database->prepare_query($s_query,$a_data_query);
		}
    } 
    
    public function updateAdherents()
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			if(isset($_POST['adherents']) && $_POST['adherents'] > 0){

				$a_data_query = array(); 	 

				$s_query = "";

				for($i=1;$i<=$_POST['adherents'];$i++){
					$a_data_query['adherent_id_'.$i] = array($_POST['adherent_ref_'.$i], PDO::PARAM_INT);
					$a_data_query['adherent_lname_'.$i] = array($_POST['adherent_lname_'.$i], PDO::PARAM_STR);
					$a_data_query['adherent_fname_'.$i] = array($_POST['adherent_fname_'.$i], PDO::PARAM_STR);
					$a_data_query['adherent_bday_'.$i] = array($_POST['adherent_bday_'.$i], PDO::PARAM_STR);

					$s_query .= "
						UPDATE adherents
						SET	adherent_lname = :adherent_lname_".$i.",
						adherent_fname = :adherent_fname_".$i.",
						adherent_bday = :adherent_bday_".$i.",
						WHERE adherent_id = :adherent_id_".$i.";";
				}
				$starter->database->prepare_query($s_query,$a_data_query);
			}
		}
    }
    
    public function updateAdherentAssos($ref,$id)
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			$a_data_query = array(
				'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
				'asso' => array($_POST['adherent_assoc_'.$id], PDO::PARAM_STR),
				'adherent_id' => array($ref, PDO::PARAM_INT),
			);
					
			$s_query = "
				UPDATE adherents
				SET	adherent_lname = :adherent_lname,
				asso = :asso
				WHERE adherent_id = :adherent_id
				AND user = :user";
			
			$starter->database->prepare_query($s_query,$a_data_query);
		}
    }
    
    public function updateAdherent($ref,$id)
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			$a_data_query = array(
				'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
				'adherent_lname' => array($_POST['adherent_lname_'.$id], PDO::PARAM_STR),
				'adherent_fname' => array($_POST['adherent_fname_'.$id], PDO::PARAM_STR),
				'adherent_bday' => array($_POST['adherent_bday_'.$id], PDO::PARAM_STR),
				'adherent_id' => array($ref, PDO::PARAM_INT),
			);
					
			$s_query = "
				UPDATE adherents
				SET	adherent_lname = :adherent_lname,
				adherent_fname = :adherent_fname,
				adherent_bday = :adherent_bday
				WHERE adherent_id = :adherent_id
				AND user = :user";
			$starter->database->prepare_query($s_query,$a_data_query);

		}
    }
    
    public function updateAdherentValid($id)
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			$a_data_query = array(
				'adasso_id' => array($id, PDO::PARAM_INT),
			);
					
			$s_query = "
				UPDATE adherent_assos
				SET	_valid = 1,
				token = ''
				WHERE adasso_id = :adasso_id";
			$starter->database->prepare_query($s_query,$a_data_query);
		}
    }

    
    public function getAdherents($user = 0, $order = "")
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
				SELECT adherent_lname, adherent_fname, adherent_bday, t2.asso, adherent_id, user_address, _valid, adasso_id
				FROM adherents as t0
				INNER JOIN admin_users AS t1
				ON t1.user_id = t0.user
				INNER JOIN adherent_assos AS t2
				ON t2.adherent = t0.adherent_id
				WHERE t0.online = 1
				AND t0.archive = 0
				AND t1.online = 1
				AND t1.archive = 0
				AND t0.user = :user_id";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', (empty($order) ? '' : 'adherent_id'));

			return $a_data;
		}
    }

    
    public function getAdherentsAssos($user = 0, $order = "")
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
				SELECT t2.asso
				FROM adherents as t0
				INNER JOIN admin_users AS t1
				ON t1.user_id = t0.user
				INNER JOIN adherent_assos AS t2
				ON t2.adherent = t0.adherent_id
				WHERE t0.online = 1
				AND t0.archive = 0
				AND t1.online = 1
				AND t1.archive = 0
				AND t0.user = :user_id";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', 'asso');

			return $a_data;
		}
    }

    
    public function getAdherentsByStructure($user = 0)
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
				'asso_id' => array($_SESSION['user_info']['user_asso'],PDO::PARAM_INT),
			);
			$s_query ="
				SELECT adherent_lname, adherent_fname, adherent_bday, t2.asso, adherent_id, user_address, _valid, t2.token AS tokenad
				FROM adherents as t0
				INNER JOIN admin_users AS t1
				ON t1.user_id = t0.user
				INNER JOIN adherent_assos AS t2
				ON t2.adherent = t0.adherent_id
				WHERE t0.online = 1
				AND t0.archive = 0
				AND t1.online = 1
				AND t1.archive = 0
				AND t2.asso = :asso_id";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');

			return $a_data;
		}
    }	
    
    public function getAdherentsActiv($user = 0)
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
				SELECT adherent_lname, adherent_fname, adherent_bday, t2.asso, adherent_id, user_address
				FROM adherents as t0
				INNER JOIN admin_users AS t1
				ON t1.user_id = t0.user
				INNER JOIN adherent_assos AS t2
				ON t2.adherent = t0.adherent_id
				WHERE t0.online = 1
				AND t0.archive = 0
				AND t1.online = 1
				AND t1.archive = 0
				AND t0.user = :user_id
				AND _valid = 1";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', 'adherent_id');

			return $a_data;
		}
    }	
    
    public function getAdherent($user = 0)
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
				SELECT adherent_lname, adherent_fname, adherent_bday, asso, adherent_id, user_address
				FROM adherents as t0
				INNER JOIN admin_users AS t1
				ON t1.user_id = t0.user
				WHERE t0.online = 1
				AND t0.archive = 0
				AND t1.online = 1
				AND t1.archive = 0
				AND adherent_id = :user_id";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			return $a_data;
		}
    }	
    
    public function getAdherentParent($ref)
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
				'ref' => array($ref,PDO::PARAM_STR),
			);
			
			$s_query ="
				SELECT user_email
				FROM admin_users as t0
				INNER JOIN covoiturages_resas AS t1
				ON t1.user = t0.user_id
				WHERE t0.online = 1
				AND t0.archive = 0
				AND resa_ref = :ref";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query);
			
			return $a_data;
		}
    }
    
    public function getAdherentMailInfo($ref)
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
				'ref' => array($ref,PDO::PARAM_STR),
			);
			
			$s_query ="
				SELECT user_email, adherent_fname, covoiturage_add_end
				FROM admin_users as t0
				INNER JOIN covoiturages_resas AS t1
				ON t1.user = t0.user_id
				INNER JOIN adherents  AS t2
				ON t2.adherent_id = t1.adherent
				INNER JOIN covoiturages AS t3
				ON t3.ref = t1.ref
				WHERE t0.online = 1
				AND t0.archive = 0
				AND resa_ref = :ref";
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query);
			
			return $a_data;
		}
    }

    public function getAdherentByToken($token)
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
				'user_id' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
				'token' => array($token,PDO::PARAM_STR),
			);
			$s_query ="
				SELECT adasso_id, token, t3.user_email, t3.user_firstname, association_label
				FROM adherent_assos AS t0
				INNER JOIN admin_users AS t1
				ON t1.asso = t0.asso
				INNER JOIN adherents AS t2
				ON t2.adherent_id = t0.adherent
				INNER JOIN admin_users AS t3
				ON t3.user_id = t2.user
				INNER JOIN associations AS t4
				ON t4.association_id = t0.asso
				WHERE t1.user_id = :user_id
				AND token = :token";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			return $a_data;
		}
    }
}
?>