<?php
/******************************************/
//INIT VARS
/******************************************/

$s_form_plugin = (isset($_GET['plugin']) ? htmlentities($_GET['plugin']) : '');
$starter->b_module = true;
$_s_query = '';
$s_search = isset($_POST['search_download']) ? strtolower($_POST['search_download']) : (isset($_GET['search_download']) ? strtolower($_GET['search_download']) : '');
$s_download_name = isset($_POST['download_name']) ? mysqli_real_escape_string($starter->_feed,$_POST['download_name']) : (isset($_GET['download_name']) ? mysqli_real_escape_string($starter->_feed,$_GET['download_name']) : '');
$s_download_name_sort = ($s_download_name == 'ASC' ? 'DESC' : 'ASC')  ;
$val_id = (isset($_GET['val_id']) ? $_GET['val_id'] : '');
$a_items  = array();
$a_data = array();
$s_data = isset($_POST['data']) ? ($_POST['data']) : (isset($_GET['data']) ? ($_GET['data']) : '');
$iCompt = 0;
					$s_items = array();
			
// GET CONTENT
if(!empty($val_id)){
	$a_data_query = array(
		'tree_id' => array($val_id,PDO::PARAM_INT),
	);
	require_once APPLICATION_PATH . '/controllers/!locked/MenuController.php'; 
	$request = new MenuController();
	$a_items = $request->getDownload($val_id);
	$a_items = json_decode($a_items['tree_downloads']);
}
elseif(isset($_GET['data']) && !empty($_GET['data'])) {
	$a_items = json_decode($s_data);
}

if(!empty($a_items) && isset($a_items->downloadsId)){

	if($starter->isApi ){
		$_data = array();
		$_data['download_id'] = implode(', ',$a_items->downloadsId);
	
		// CRL code
		$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getList', $_data);
		$a_data = $curlApiRequest;
	}else{
		$a_data_query = array(
			'download_id' => array(implode(', ',$a_items->downloadsId),PDO::PARAM_STR),
		);

		$s_query ="
			SELECT t0.*,  t2.*
			FROM download AS t0
			INNER JOIN download_categories AS t2
			ON t2.category_id = t0.download_category
			WHERE t0.archive = 0 
			AND download_id IN (:download_id)";

		$a_data = $starter->database->prepare_query($s_query, $a_data_query,'multiple', 'download_id');
	}
/*
	foreach($a_items->downloadsId as $key => $val){
		$a_data[] = $_a_data[$val];
	}
	$_a_data = array();	
		print_r($a_data);			
	foreach($a_items->downloadsId as $keyid => $valid){
		$_a_data[$keyid] = $a_data[$valid];
		unset($a_data[$valid]);
	}
	krsort($_a_data);

	foreach($_a_data as $keyid ){
		array_unshift($a_data, $keyid);
	}*/
	$iCompt = count($a_data);
}

/*
$a_data_query = array(
	'lang' => array($starter->i_lang,PDO::PARAM_INT),
);

$s_query ="
	SELECT t0.*, t1.*
	FROM download_categories AS t0
	INNER JOIN download_categories_detail AS t1
	ON t1.detail_category = category_id
	WHERE online = 1
	AND archive = 0
	AND lang = :lang
	ORDER BY _order";

if($starter->isApi ){
	$_data = array();
	$_data['lang'] = $starter->i_lang;
		
	$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getCat', $_data);
	$a_cat = $curlApiRequest ;
}else{
	$a_cat = $starter->database->prepare_query($s_query,$a_data_query,'multiple','category_id');
}
*/
$s_query ="
	SELECT t0.*, t1.*
	FROM download AS t0
	INNER JOIN download_categories AS t1
	ON t1.category_id = t0.download_category
	WHERE t0.online = 1
	AND t0.archive = 0
	AND t1.online = 1
	AND t1.archive = 0";

if($starter->isApi ){
	$_data = array();
		
	$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getDownload', $_data);
	$a_data_full = $curlApiRequest ;
}else{
	$a_data_full = $starter->database->prepare_query($s_query,array(),'multiple','download_id');
}

if(count($_POST) > 0)
{
						/*if(count($_POST) > 0) $s_items = json_encode(($_POST['data']));
						unset($_POST['action']);
						$b_error = false;
					}*/
	$a_data_query = array();
	$s_query ="
		SELECT t0.*, t2.*
		FROM download AS t0
		INNER JOIN download_categories AS t2
		ON t2.category_id = t0.download_category
		WHERE t0.archive = 0";

	if(!empty($s_search))
	{
		if(isset($s_search ) && !empty($s_search))
		{
			$a_data_query = array(
				'lang' => array($starter->i_lang ,PDO::PARAM_INT),
			);
			$s_query ="
				SELECT t0.*, t1.*
				FROM download AS t0
				INNER JOIN download_detail AS t1
				ON t1.detail_download = t0.download_id
				INNER JOIN download_categories AS t3
				ON t3.category_id = t0.download_category
				WHERE t3.online = 1
				AND t0.archive = 0
				AND t3.archive = 0
				AND t1.lang =:lang";

			if($_SESSION['user_info']['user_statut'] != 0){
				$a_data_query['tree_id'] = array($menu->authChartes ,PDO::PARAM_STR);
				$_s_query .= "
					AND tree_id IN (:tree_id)";
			}
			$a_data_query['s_search'] = array($s_search ,PDO::PARAM_STR);
			$_s_query .=" AND (download_label LIKE '%s_search%'";
			$_s_query .=" OR t1.detail_label LIKE '%s_searc%'";
			$_s_query .=" OR t1.detail_info LIKE '%s_search%'";
			$_s_query .=" OR t1.detail_text LIKE '%s_search%')";
		}
	}

	if(!empty($s_download_name))
		$_s_query .= " ORDER BY download_label " . $s_download_name;

	/*if($starter->isApi ){
		$_data = array();
			
		$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=search', $_data);
		$a_data = $curlApiRequest ;
	}else{*/
		$a_data = $starter->database->prepare_query($s_query . $_s_query, $a_data_query,'multiple');
	//}
}
					//$a_data = array_values($a_data);
// CSS

// VIEWS
$starter->a_include_pages[]  = '/modules/plugins/modules/special/' . htmlentities($_GET['plugin']). '/views/addon.php';
?>
