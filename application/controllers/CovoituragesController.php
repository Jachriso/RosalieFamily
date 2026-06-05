<?php 
class CovoituragesController extends Starter
{
	function __construct() {
    }

    public function newCovoiturage()
    {
		global $starter;
		$a_fields = array(
			"fields" => array(
				'covoiturage_date'	=> array(
					"field"			=> "covoiturage_date",
					"type"			=> "date",
					"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Date du covoiturage"),
					"error_label"	=> $starter->_get_lexique("Saisie de la Date du covoiturage incorrecte"),
				),
				'covoiturage_type'	=> array(
					"field"			=> "covoiturage_type",
					"type"			=> "select",
					"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Type de votre demande"),
					"error_label"	=> $starter->_get_lexique("Saisie du Type de votre demande incorrecte"),
					"data" 			=> array(
						"1" 			=> $starter->_get_lexique("Je suis conducteur"),
						"2" 			=> $starter->_get_lexique("Je suis passager"),
					),
				),
				'covoiturage_add_start'	=> array(
					"field"			=> "covoiturage_add_start",
					"type"			=> "select",
					//"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Adresse de départ du covoiturage"),
					"error_label"	=> $starter->_get_lexique("Saisie de l'Adresse de départ incorrecte"),
					"data" 			=> array(),
				),
				'covoiturage_add_end'	=> array(
					"field"			=> "covoiturage_add_end",
					"type"			=> "select",
					"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Adresse d'arrivée' du covoiturage"),
					"error_label"	=> $starter->_get_lexique("Saisie de l'Adresse d'arrivée incorrecte"),
					"data" 			=> array(),
				),
				'covoiturage_h_start'	=> array(
					"field"			=> "covoiturage_h_start",
					"type"			=> "text",
					//"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Horaire de départ du covoiturage"),
					"error_label"	=> $starter->_get_lexique("Saisie de l'horaire de départ incorrecte"),
					"maxlength"		=> 255,
				),
				'covoiturage_h_end'	=> array(
					"field"			=> "covoiturage_h_end",
					"type"			=> "text",
					"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Horaire d'arrivée' du covoiturage"),
					"error_label"	=> $starter->_get_lexique("Saisie de l'horaire d'arrivée incorrecte"),
					"maxlength"		=> 255,
				),
				'covoiturage_nb_places'	=> array(
					"field"			=> "covoiturage_nb_places",
					"type"			=> "number",
					"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Nombre de places"),
					"error_label"	=> $starter->_get_lexique("Saisie du nombre de place incorrecte"),
					"maxlength"		=> 255,
				),
				'covoiturage_adherent'	=> array(
					"field"			=> "covoiturage_adherent",
					"type"			=> "select",
					"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Mes enfants"),
					"error_label"	=> $starter->_get_lexique("Saisie de l'enfant incorrecte"),
					"data" 			=> array(),
				),
			),
		);

		return $a_fields;
    }

    public function newSearch()
    {
		global $starter;
		$a_fields = array(
			"fields" => array(
				'covoiturage_type'	=> array(
					"field"			=> "covoiturage_type",
					"type"			=> "select",
					"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Type de demande"),
					"error_label"	=> $starter->_get_lexique("Saisie du Type de votre demande incorrecte"),
					"data" 			=> array(
						"1" 			=> $starter->_get_lexique("Je cherche un conducteur"),
						"2" 			=> $starter->_get_lexique("Je cherche un passager"),
					),
				),
			),
		);

		return $a_fields;
    }

    public function getResa()
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
				"ref" => array(isset($_POST['ref']) ? $_POST['ref'] : $_GET['ref'], PDO::PARAM_STR),
				"user" => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
			);

			$s_query ="
				SELECT adherent_lname, adherent_fname, adherent_bday, covoiturage_type, adherent_id
				FROM covoiturages_resas AS t0
				INNER JOIN adherents AS t1
				ON t1.adherent_id = t0.adherent
				INNER JOIN covoiturages AS t2
				ON t2.ref = t0.ref
				WHERE t0.ref = :ref
				AND t0.user = :user
			";
			if(isset($_POST['covoiturage_type'])){
				$a_data_query['covoiturage_type'] = array($_POST['covoiturage_type'], PDO::PARAM_INT);
			
				$s_query .="
					AND covoiturage_type = :covoiturage_type";
			}
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');

			return $a_data;
		}
    }


    public function getResaByRef($ref)
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
				"resa_ref" => array($ref, PDO::PARAM_STR),
			);

			$s_query ="
				SELECT t2.user_email, t2.user_id, t2.user_firstname, t3.user_email AS resa_user_email, t3.user_id AS resa_user_id, t3.user_firstname AS resa_user_firstname, valid_cond, valid_passager, covoiturage_date, covoiturage_add_end, covoiturage_type, t0.adherent, covoiturage_adherent
				FROM covoiturages_resas AS t0
				INNER JOIN covoiturages AS t1
				ON t1.ref = t0.ref
				INNER JOIN admin_users AS t2
				ON t2.user_id = t1.user
				INNER JOIN admin_users AS t3
				ON t3.user_id = t0.user
				WHERE t0.resa_ref = :resa_ref
			";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			return $a_data;
		}
    }


    public function getResasByRef($ref)
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
				"resa_ref" => array($ref, PDO::PARAM_STR),
			);

			$s_query ="
				SELECT t2.user_email, t2.user_phone, t2.user_id, t2.user_firstname, t3.user_email AS resa_user_email, t3.user_phone AS resa_user_phone, t3.user_id AS resa_user_id, t3.user_firstname AS resa_user_firstname, valid_cond, valid_passager, covoiturage_date, covoiturage_add_end, covoiturage_type, t0.adherent, adherent_fname, adherent_lname, resa_ref, valid_recup, valid_trajet
				FROM covoiturages_resas AS t0
				INNER JOIN covoiturages AS t1
				ON t1.ref = t0.ref
				INNER JOIN admin_users AS t2
				ON t2.user_id = t1.user
				INNER JOIN admin_users AS t3
				ON t3.user_id = t0.user
				INNER JOIN adherents  AS t4
				ON t4.adherent_id = t0.adherent
				WHERE t0.ref = :resa_ref
			";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query, "miltiple");

			return $a_data;
		}
    }

    public function newResa()
    {
		global $starter;
		$a_fields = array(
			"fields" => array(
				'adherent'	=> array(
					"field"			=> "adherent",
					"type"			=> "select",
					"verif"			=> array("mandatory"),
					"label"			=> $starter->_get_lexique("Enfant"),
					"error_label"	=> $starter->_get_lexique("Saisie du Type de votre demandee l'enfant incorrecte"),
				),
			),
		);

		return $a_fields;
    }

    public function addCovoiturage()
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			
			$a_data_query = array(
				'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),				
				'ref' => array(strtolower($starter->utils->generateRandomString(32)), PDO::PARAM_STR),
				'covoiturage_date' => array($_POST['covoiturage_date'], PDO::PARAM_STR),
				'covoiturage_type' => array($_POST['covoiturage_type'], PDO::PARAM_INT),
				//'covoiturage_add_start' => array($_POST['covoiturage_add_start'], PDO::PARAM_STR),
				'covoiturage_add_end' => array($_POST['covoiturage_add_end'], PDO::PARAM_STR),
				//'covoiturage_h_start' => array($_POST['covoiturage_h_start'], PDO::PARAM_STR),
				'covoiturage_h_end' => array($_POST['covoiturage_h_end'], PDO::PARAM_STR),
				'covoiturage_nb_places' => array(isset($_POST['covoiturage_nb_places']) ? $_POST['covoiturage_nb_places'] : '', PDO::PARAM_INT),
				'covoiturage_adherent' => array(isset($_POST['covoiturage_adherent']) ? $_POST['covoiturage_adherent'] : '', PDO::PARAM_INT),
			); 	 

			$s_query = "
				INSERT INTO covoiturages
				SET	user = :user,
				ref = :ref,
				covoiturage_type = :covoiturage_type,
				covoiturage_date = :covoiturage_date,
				/*covoiturage_add_start = :covoiturage_add_start,*/
				covoiturage_add_end = :covoiturage_add_end,
				/*covoiturage_h_start = :covoiturage_h_start,*/
				covoiturage_h_end = :covoiturage_h_end,
				covoiturage_nb_places = :covoiturage_nb_places,
				covoiturage_adherent = :covoiturage_adherent";

			$starter->database->prepare_query($s_query,$a_data_query);
			
		}
    } 
    
    public function updateCovoiturage()
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
				 	 		 	 
			$a_data_query = array(
				'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
				'ref' => array($_POST['ref'], PDO::PARAM_INT),
				'covoiturage_date' => array($_POST['covoiturage_date'], PDO::PARAM_STR),
				'covoiturage_type' => array($_POST['covoiturage_type'], PDO::PARAM_INT),
			); 	 

			$s_query = "
				UPDATE covoiturages
				SET	covoiturage_type = :covoiturage_type,
				covoiturage_date = :covoiturage_date
				WHERE ref = :ref
				AND user = :user";

			$starter->database->prepare_query($s_query,$a_data_query);
		}
    } 	
    
    public function updateTrajet()
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
				 	 		 	 
			$a_data_query = array(
				"ref" => array(isset($_POST['ref']) ? $_POST['ref'] : '', PDO::PARAM_STR),
			);

			$s_query = "
				UPDATE covoiturages_resas
				SET valid_trajet = 1	
				WHERE resa_ref = :ref";

			$starter->database->prepare_query($s_query,$a_data_query);
			
		}
    } 	
    
    public function addResa($adata = array())
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			$_ref = strtolower($starter->utils->generateRandomString(32));
			if($adata['covoiturage_type'] == 1){ 
				$a_data_query = array(
					'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
					'ref' => array($_POST['ref'], PDO::PARAM_STR),
					'resa_ref' => array($_ref, PDO::PARAM_STR),
					'adherent' => array($_POST['adherent'], PDO::PARAM_INT),
				); 	 
			}else{
				$a_data_query = array(
					'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
					'ref' => array($_POST['ref'], PDO::PARAM_STR),
					'resa_ref' => array($_ref, PDO::PARAM_STR),
					'adherent' => array($adata['covoiturage_adherent'], PDO::PARAM_INT),
				); 	 
			}
			$s_query = "
				INSERT INTO covoiturages_resas
				SET	ref = :ref,
				user = :user,
				resa_ref = :resa_ref,
				adherent = :adherent";

			$starter->database->prepare_query($s_query,$a_data_query);

			return $_ref;
		}
    } 	
    
    public function updateResa($adata = array())
    {
    	global $starter;
		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{		 	 
			if($adata['covoiturage_type'] == 1){ 
				$a_data_query = array(
					'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
					'ref' => array($_POST['ref'], PDO::PARAM_STR),
					'adherent' => array($_POST['adherent'], PDO::PARAM_INT),
				);
			}else{
				$a_data_query = array(
					'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
					'ref' => array($_POST['ref'], PDO::PARAM_STR),
					'adherent' => array($adata['user'], PDO::PARAM_INT),
				);
			}

			$s_query = "
				UPDATE covoiturages_resas
				SET	adherent = :adherent
				WHERE ref = :ref
				AND user = :user";

			$starter->database->prepare_query($s_query,$a_data_query);
		}
    }
    
    public function getCovoiturages($user = Null)
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

			$a_data_query['covoiturage_date'] = array(date('Y-m-d'), PDO::PARAM_STR);
			
			$s_query ="
				SELECT t0.ref, covoiturage_type, covoiturage_date, covoiturage_add_start, covoiturage_add_end, covoiturage_h_start, covoiturage_h_end, covoiturage_nb_places, t1.user_lastname AS user_lastname_resa, t1.user_firstname AS user_firstname_resa, t1.user_avatar AS user_avatar_resa, resa_id, t2.user AS user_resa_id, resa_ref, t1.user_city AS user_city_resa, t1.user_street AS user_street_resa, t1.user_city2 AS user_city2_resa, t1.user_street2 AS user_street2_resa, t1.user_email AS user_email_resa, t1.user_phone AS user_phone_resa, covoiturage_adherent, adherent_fname, adherent_lname, valid_cond, valid_passager, valid_trajet, t0.user, t3.user_lastname, t3.user_firstname, t3.user_avatar, t3.user_city, t3.user_street, t3.user_city2, t3.user_street2, t3.user_email, t3.user_phone, valid_recup, valid_trajet
				FROM covoiturages AS t0
				INNER JOIN admin_users AS t1
				ON t1.user_id = t0.user
				LEFT OUTER JOIN covoiturages_resas AS t2				
				ON t2.ref = t0.ref
				LEFT OUTER JOIN admin_users AS t3
				ON t3.user_id = t2.user
				LEFT OUTER JOIN adherents AS t4
				ON t4.adherent_id = t0.covoiturage_adherent
				WHERE t1.online = 1
				AND t1.archive = 0
				AND covoiturage_date >= :covoiturage_date";

			if(isset($_POST['covoiturage_type'])){
				$a_data_query['covoiturage_type'] = array($_POST['covoiturage_type'], PDO::PARAM_INT);
			
				$s_query .="
					AND covoiturage_type = :covoiturage_type";
			}

			if($user != Null){
				$a_data_query['user'] = array($user, PDO::PARAM_INT);
			
				$s_query .="
					AND (t0.user = :user OR t2.user = :user)";
			}else{
				$a_data_query['user'] = array($_SESSION['user_info']['user_id'], PDO::PARAM_INT);
			
				$s_query .="
					AND t0.user != :user";
			}
			
			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');

			return $a_data;
		}
    }
    
    public function getCovoituragesPass($user = Null)
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
				SELECT t0.ref, t0.user AS covoit_user, covoiturage_type, covoiturage_date, covoiturage_add_start, covoiturage_add_end, covoiturage_h_start, covoiturage_h_end, covoiturage_nb_places, t2.user_lastname AS user_lastname_resa, t2.user_firstname AS user_firstname_resa, t2.user_avatar AS user_avatar_resa, resa_id, resa_ref, t2.user_city AS user_city_resa, t2.user_street AS user_street_resa, t2.user_city2 AS user_city2_resa, t2.user_street2 AS user_street2_resa, t2.user_email AS user_email_resa, t2.user_phone AS user_phone_resa, covoiturage_adherent, adherent_fname, adherent_lname, valid_cond, valid_passager, valid_trajet, t1.user, t3.user_lastname, t3.user_firstname, t3.user_avatar, t3.user_city, t3.user_street, t3.user_city2, t3.user_street2, t3.user_email, t3.user_phone, valid_recup, valid_trajet
				FROM covoiturages AS t0
				INNER JOIN covoiturages_resas AS t1				
				ON t1.ref = t0.ref
				INNER JOIN admin_users AS t2
				ON t2.user_id = t1.user
				INNER JOIN admin_users AS t3
				ON t3.user_id = t0.user
				LEFT OUTER JOIN adherents AS t4
				ON (
					t4.adherent_id = t0.covoiturage_adherent OR
					t4.adherent_id = t1.adherent
				)
				WHERE t2.online = 1
				AND t2.archive = 0
			";
			if(isset($_POST['covoiturage_type'])){
				$a_data_query['covoiturage_type'] = array($_POST['covoiturage_type'], PDO::PARAM_INT);
			
				$s_query .="
					AND covoiturage_type = :covoiturage_type";
			}

			if($user != Null){
				$a_data_query['user'] = array($user, PDO::PARAM_INT);
			
				$s_query .="
					AND t1.user = :user";
			}else{
				$a_data_query['covoiturage_date'] = array(date('Y-m-d'), PDO::PARAM_STR);
			
				$s_query .="
					AND covoiturage_date > :covoiturage_date";
			}
			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');

			return $a_data;
		}
    }
    
    public function validCovoiturage($a_data){
    	global $starter;
		if($starter->isApi ){
			$a_data = array();
						
			// CRL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getList', $_data);
			//$this->a_download = $curlApiRequest;

			return $a_data;
		}else{
			
			$a_data_query = array(
				"ref" => array(isset($_GET['ref']) ? $_GET['ref'] : '', PDO::PARAM_STR),
			);

			$s_query = "
				UPDATE covoiturages_resas";
				
			if($a_data['covoiturage_type'] == 1 && $a_data['resa_user_id'] == $_SESSION['user_info']['user_id']){
				$s_query .= "
					SET valid_cond = 1";
			}elseif($a_data['covoiturage_type'] == 2 && $a_data["user_id"] == $_SESSION['user_info']['user_id']){
				$s_query .= "
					SET valid_passager = 1";
			}
			elseif($a_data['covoiturage_type'] == 1 && $a_data['user_id'] == $_SESSION['user_info']['user_id']){
				$s_query .= "
					SET valid_passager = 1";
			}elseif($a_data['covoiturage_type'] == 2 && $a_data["resa_user_id"] == $_SESSION['user_info']['user_id']){
				$s_query .= "
					SET valid_cond = 1";
			}

			$s_query .= "				
				WHERE resa_ref = :ref";
				
			$starter->database->prepare_query($s_query,$a_data_query);

		}
    }

    public function validAdherent($type,$ref){
    	global $starter;
		if($starter->isApi ){
			$a_data = array();
						
			// CRL code
			//$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getList', $_data);
			//$this->a_download = $curlApiRequest;

			return $a_data;
		}else{
			
			$a_data_query = array(
				"ref" => array($ref, PDO::PARAM_STR),
			);

			$s_query = "
				UPDATE covoiturages_resas";
			if($type == 1){
				$s_query .= "
					SET valid_recup = 1";
			}else{
				$s_query .= "
					SET valid_trajet = 1";
			}

			$s_query .= "
				WHERE resa_ref = :ref";
				
			$starter->database->prepare_query($s_query,$a_data_query);

		}
    }

    public function getCovoiturage($user = Null)
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
				"ref" => array(isset($_POST['ref']) ? $_POST['ref'] : $_GET['ref'], PDO::PARAM_STR),
			);

			$s_query ="
				SELECT covoiturage_type, t0.user, adherent, covoiturage_add_end, covoiturage_date, t0.ref, resa_ref, covoiturage_adherent
				FROM covoiturages AS t0
				INNER JOIN admin_users AS t1
				ON t1.user_id = t0.user				
				LEFT OUTER JOIN covoiturages_resas AS t2
				ON t2.ref = t0.ref
				WHERE t1.online = 1
				AND t1.archive = 0
				AND t0.ref = :ref
			";
			if(isset($_POST['covoiturage_type'])){
				$a_data_query['covoiturage_type'] = array($_POST['covoiturage_type'], PDO::PARAM_INT);
			
				$s_query .="
					AND covoiturage_type = :covoiturage_type";
			}
			if($user != Null){
				$a_data_query['user'] = array($user, PDO::PARAM_INT);
			
				$s_query .="
					AND t1.user_id = :user";
			}

			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			return $a_data;
		}
    }
}
?>