<?php
/******************************************/
//INIT VARS
/******************************************/
$b_error = true;
$starter->b_module = true;
$insert = false;
$s_items = array();
$a_items  = array();
$a_data = array();
$s_data = isset($_POST['data']) ? htmlentities($_POST['data']) : (isset($_GET['data']) ? htmlentities($_GET['data']) : '');

$s_module 						= (isset($_GET['module']) ? htmlentities($_GET['module']) : '');
$s_config 						= (isset($_GET['config_id']) ? htmlentities($_GET['config_id']) : '');

$s_form_page 					= (isset($_GET['page']) ? htmlentities($_GET['page']) : '');
$s_action 						= (isset($_GET['action']) ? htmlentities($_GET['action']) : '');
$s_form_navpage 				= (isset($_GET['navpage']) ? htmlentities($_GET['navpage']) : '');
$s_form_field					= (isset($_GET['field']) ? htmlentities($_GET['field']) : '');
$s_form_plugin					= (isset($_GET['plugin']) ? htmlentities($_GET['plugin']) : '');
$s_form_lang					= (isset($_GET['lang']) ? htmlentities($_GET['lang']) : '');
$s_form_ilang					= (isset($_GET['ilang']) ? htmlentities($_GET['ilang']) : '');
$s_form_config 					= (isset($_GET['config']) ? htmlentities($_GET['config']) : '');

	
if($starter->utils->is__countable($_POST) && count($_POST) > 0)
{
	$s_items = json_encode($_POST['data']);
	unset($_POST['action']);
	$b_error = false;
}

$s_query ="
	SELECT group_name, map, group_id
	FROM admin_groups
	WHERE online = 1
	AND archive = 0
	ORDER BY group_name";

if($starter->isApi ){
	$_data = array();
	$_data['authGroup'] = '';
		
	$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getGroup', $_data);
	$a_data = $curlApiRequest ;
}else{
	$a_data = $starter->database->prepare_query($s_query,array(),'multiple');
}

if(preg_match('#page_#',$_SERVER['REQUEST_URI']) && $starter->utils->is__countable($a_data) && count($a_data) == 0){
	$_uri = preg_replace('#page_+[0-9]+.html#', '', $_SERVER['REQUEST_URI']);

	header('Location:' . $_uri) ;
	exit();
}

if($s_action == "edit"){
	$a_data_query = array(
		'cle' => array($starter->_special_GET['val_id'], PDO::PARAM_INT),
	);	

	$s_query = "
		SELECT * 
		FROM " . $starter->database->configs[$starter->_special_GET['page']]['content'][$starter->_special_GET['module']]['content'][$starter->_special_GET['config_id']]['table'] . "
		WHERE " . $starter->database->configs[$starter->_special_GET['page']]['content'][$starter->_special_GET['module']]['content'][$starter->_special_GET['config_id']]['cle'] . " = :cle";

	if($starter->isApi ){
		$_data = array();
		$_data['squery'] = $s_query;
		$_data['data'] = json_encode($a_data_query);
		$_data['type'] = 'single';
			
		$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data, 'POST');
		$a_select = $curlApiRequest ;
	}else{
		$a_select = $starter->database->prepare_query($s_query,$a_data_query);	
	}
	$a_items = json_decode($a_select[$starter->_special_GET['field']]);
}
$_a_items = (array) $a_items;

$starter->a_include_pages[]  = '/modules/plugins/modules/special/' . $starter->_special_GET['plugin'] . '/views/addon.php';
?>