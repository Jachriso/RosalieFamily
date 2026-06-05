<?php
class BackController extends Starter
{
	function __construct() {
    }

    public function selectTree($s_value, $table, $s_key){
		global $starter ;
    	$a_data_query = array(
			'key' => array($s_value, PDO::PARAM_INT),
		);
		$s_query = "
			SELECT * 
			FROM " . $table['table'] . " 
			WHERE archive = 0
			AND " . $s_key . " = :key";

		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
			$_aData = $curlApiRequest ;
		}else{
			$_aData = $starter->database->prepare_query($s_query, $a_data_query) ;
		}
		return $_aData;
    }

    public function selectComplexeTree($s_config, $s_module, $s_page){
		global $starter ;

		$a_data_query = array(
			'cle' => array(intval($_POST['val_id']),PDO::PARAM_INT),
		);	
		$s_query = "
			SELECT " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle'] . ", _order 
			FROM " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['table'] . " AS t0";

		$s_query .= "
			WHERE t0.archive = 0 
			AND t0." . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['code'] . "_parent = (
				SELECT " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['code'] . "_parent
				FROM " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['table'] . "
				WHERE archive = 0 
				AND " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle'] . " = :cle)";

		$s_query .= "
			ORDER BY " .  $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]["tri"];	

		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			$_data['cle'] = $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle'];
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
			$_aData = $curlApiRequest ;
		}else{
			$_aData = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle']);
		}
		return $_aData;
    }

	public function selectComplexeContent($s_item, $o_conf, $s_key, $_parent){
		global $starter ;

		$a_data_query = array(
			'key' => array(intval($s_item), PDO::PARAM_INT),
		);

		if($_parent[$o_conf['code'] . "_parent"] != 0){
			$s_query = "
				SELECT " . $o_conf['cle'] . ", _order 
				FROM " . $o_conf['table'] . "
				WHERE archive = 0 
				AND " . $o_conf['code'] . "_parent = " . $_parent[$o_conf['code'] . "_parent"] . "
				AND " . $s_key . " !=  :key
				ORDER BY _order";
		}else{
			$a_data_query = array();	
			$s_query = "
				SELECT " . $o_conf['cle'] . ", _order 
				FROM " . $o_conf['table'] . "
				WHERE archive = 0 
				AND " . $o_conf['code'] . "_parent = 0";
		}
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			$_data['cle'] = $o_conf['cle'];
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
			$aData = $curlApiRequest ;
		}else{
			$aData = $starter->database->prepare_query($s_query, $a_data_query, 'multiple', $o_conf['cle']);
		}
		return $aData;
	}

	public function sortComplexeContent($config){
		global $starter ;

		$a_data_query = array();	

		$s_query = "
			SELECT " . $config['cle'] . ", _order 
			FROM " . $config['table'];
			
		$s_query .= "
			WHERE archive = 0";

		if(isset($_POST['optimSearch']) && !empty($_POST['optimSearch'])){
			$_optimSearch = explode(',', $_POST['optimSearch']);
			
			foreach($_optimSearch as $key => $val){
				$_tmp = explode(':', $val);
				$s_query .= ' AND (' . $_tmp[0] . '=' . $_tmp[1] . ')'  ;
			}
		}

		$s_query .= "
			ORDER BY _order ";
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			$_data['cle'] = $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle'];
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
			$aData = $curlApiRequest ;
		}else{
			$aData = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle']);
		}
		return $aData;
	}

	public function sortTree($conf, $value){
		global $starter ;
		$a_data_query = array(
			'key' => array(intval($value), PDO::PARAM_INT),
		);
		$s_query = "
			SELECT " . $conf['code'] . "_parent
			FROM " . $conf['table'] . "
			WHERE " . $conf['cle'] . " = :key";

		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			$_data['type'] = 'single';
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=sortData', $_data);
			$aData = $curlApiRequest ;
		}else{
			$aData = $starter->database->prepare_query($s_query, $a_data_query);
		}
		return $aData;
	}

	public function sortContent($s_item, $table, $s_key){
		global $starter ;
		$a_data_query = array(
			'key' => array(intval($s_key), PDO::PARAM_INT),
		);
		$s_query = "
			SELECT " . $s_item . "
			FROM " . $table . "
			ORDER BY " . $s_key;

		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			$_data['cle'] = $s_key;
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=sortData', $_data);
			$aData = $curlApiRequest ;
		}else{
			$aData = $starter->database->prepare_query($s_query, $a_data_query, 'multiple', $s_key);
		}

		return $aData;
	}

	public function selectContent($o_conf){
		global $starter ;
		$a_data_query = array();
		$s_query = "
			SELECT " . $o_conf['cle'] . "
			FROM " . $o_conf['table'] . "
			ORDER BY " . $o_conf['tri'];

		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			$_data['cle'] = $o_conf['cle'];
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=sortData', $_data);
			$aData = $curlApiRequest ;
		}else{
			$aData = $starter->database->prepare_query($s_query, $a_data_query, 'multiple', $o_conf['cle']);
		}
		return $aData;
	}

	public function deleteContent($s_value, $table, $s_key){
		global $starter ;
		$a_data_query = array(
			'key' => array($s_value, PDO::PARAM_INT),
		);
		$s_query = "
			DELETE FROM " . $table['table'] . " 
			WHERE " . $s_key . " = :key";
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
		}else{
			$starter->database->prepare_query($s_query,$a_data_query);
		}
	}

	public function updateContent($s_value, $table, $s_key, $s_field = '', $s_valuefield = '')
	{
		global $starter ;
		$a_data_query = array(
			'key' => array($s_value, PDO::PARAM_INT),
			'modify' => array(date("Y-m-d H:i:s"), PDO::PARAM_STR),
			'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
		);
		if(!empty($s_field)){
			$a_data_query['field'] = array(($s_valuefield==1 ? 0 : 1), PDO::PARAM_BOOL);
			$s_set = "
				SET " . $s_field . " = :field,";
		}else
			$s_set = "
				SET archive = 1,";
		$s_query = "
			UPDATE " . $table['table'];
		
		$s_query .= $s_set;

		$s_query .= "
			modify = :modify,
			user = :user
			WHERE " . $s_key . " = :key";
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
		}else{
			$starter->database->prepare_query($s_query,$a_data_query);
		}
	}
}
?>