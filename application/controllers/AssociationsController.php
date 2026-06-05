<?php 
class AssociationsController extends Starter
{
	function __construct() {
    }

    public function newAssociation()
    {
		global $starter;
		$a_fields = array(
			"fields" => array(
				
			),
		);
		return $a_fields;
    }

    public function addAssociation()
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			 	 
			$a_data_query = array(
				'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
				'adherent_lname' => array($_POST['adherent_lname'], PDO::PARAM_STR),
				'adherent_fname' => array($_POST['adherent_fname'], PDO::PARAM_STR),
				'adherent_bday' => array($_POST['adherent_bday'], PDO::PARAM_STR),
				'adherent_assoc' => array($_POST['adherent_assoc'], PDO::PARAM_INT),
			); 	 

			$s_query = "
				INSERT INTO adherents
				SET	user = :user,
				adherent_lname = :adherent_lname,
				adherent_fname = :adherent_fname,
				adherent_bday = :adherent_bday,
				adherent_assoc = :adherent_assoc";

			$starter->database->prepare_query($s_query,$a_data_query);
		}
    } 

    public function updateAssociation()
    {
    	global $starter;

		if($starter->isApi ){
			echo '<br>API Ã construire<br>';
		}else{
			$a_data_query = array(
				'adherent_id' => array($_POST['adherent_id'], PDO::PARAM_INT),
				'adherent_lname' => array($_POST['adherent_lname'], PDO::PARAM_STR),
				'adherent_fname' => array($_POST['adherent_fname'], PDO::PARAM_STR),
				'adherent_bday' => array($_POST['adherent_bday'], PDO::PARAM_STR),
				'adherent_assoc' => array($_POST['adherent_assoc'], PDO::PARAM_INT),
			);

			$s_query = "
				UPDATE adherents
				SET	adherent_lname = :adherent_lname,
				adherent_fname = :adherent_fname,
				adherent_bday = :adherent_bday,
				adherent_assoc = :adherent_assoc,
				WHERE adherent_id = :adherent_id";

			$starter->database->prepare_query($s_query,$a_data_query);
		}
    } 	
    
    public function getAssociations()
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
				SELECT association_id, association_label, association_address, association_zip, association_city, association_email, association_phone, association_address2, association_zip2, association_city2, association_addr_label1, association_addr_label2
				FROM associations
				WHERE online = 1
				AND archive = 0";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', 'association_id');

			return $a_data;
		}
    }
    
    public function getAssociationById($id)
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
				'association_id' => array($id, PDO::PARAM_INT),
			); 	 

			$s_query ="
				SELECT association_label, association_address, association_zip, association_city, association_email, association_phone, association_address2, association_zip2, association_city2, association_addr_label1, association_addr_label2
				FROM associations
				WHERE online = 1
				AND archive = 0
				AND association_id = :association_id";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			return $a_data;
		}
    }	
    
    public function getAssociationsByAdherent($id)
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
				SELECT association_id, association_label, association_address, association_zip, association_city, association_email, association_phone, association_address2, association_zip2, association_city2, association_addr_label1, association_addr_label2
				FROM associations AS t0
				INNER JOIN adherent_assos AS t1
				ON t1.asso = t0.association_id
				WHERE online = 1
				AND archive = 0
				AND _valid = 1";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', 'association_id');

			return $a_data;
		}
    }
}
?>