<?php
/******************************************/
//INIT VARS
/******************************************/
require_once APPLICATION_PATH . '/controllers/!locked/AuthController.php' ;
$auth = new AuthController();
$auth->getAuth();

require_once APPLICATION_PATH . '/controllers/!locked/MenuController.php' ;
$menu = new MenuController();

$b_error = false;
$insert = false;
$a_items = array();
$s_module 						= (isset($_GET['module']) ? htmlentities($_GET['module']) : '');
$s_config 						= (isset($_GET['config_id']) ? htmlentities($_GET['config_id']) : '');
$s_form_page 					= (isset($_GET['page']) ? htmlentities($_GET['page']) : '');
$s_action 						= (isset($_GET['action']) ? htmlentities($_GET['action']) : '');
$s_form_field					= (isset($_GET['field']) ? htmlentities($_GET['field']) : '');
$s_form_plugin					= (isset($_GET['plugin']) ? htmlentities($_GET['plugin']) : '');

if(isset($starter->_special_POST) && $starter->utils->is__countable($starter->_special_POST) && count($starter->_special_POST) > 0)
{
	$s_items = json_encode($starter->_special_POST);
	unset($starter->_special_POST['action']);
	$b_error = false;
	$insert = true;
}
$a_data_query = array(
	'lang' => array($starter->i_lang,PDO::PARAM_INT),
);

$s_query = "
	SELECT tree_label, detail_label, tree_parent, tree_id
	FROM tree AS t0
	INNER JOIN tree_detail AS t1
	ON t1.detail_tree = t0.tree_id
	WHERE  online = 1
	AND archive = 0
	AND lang = :lang";

if($starter->isApi ){
	$_data = array();
	$_data['lang'] = $starter->i_lang;
	$_data['referer'] = 'NULL';
	$_data['config_home'] = 'NULL';
	
	$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Menu&rquest=getCurrent', $_data);
	$a_data = $curlApiRequest ;
}else{
	$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');
}

$a_data_query = array();
$s_query = "
	SELECT group_name, map, group_id
	FROM admin_groups 
	WHERE online = 1
	AND archive = 0";
if(isset($_SESSION['user_info']['user_statut']) && $_SESSION['user_info']['user_statut'] != 0){
	$a_data_query = array(
		'authGroup' => array($auth->authGroup,PDO::PARAM_STR),
	);
	$s_query .= "
		AND group_id IN (:authGroup)";
}

if($starter->isApi ){
	$_data = array();
	if(isset($_SESSION['user_info']['user_statut']) && $_SESSION['user_info']['user_statut'] != 0){
		$_data['authGroup'] = $auth->authGroup;
	}else
		$_data['authGroup'] = '';

	$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Auth&rquest=getGroup', $_data);
	$a_group = $curlApiRequest ;
}else{
	$a_group = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');
}

$a_tree = $menu->getTree('1','0', true);

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
		
	$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
	$a_select = $curlApiRequest ;
	if(isset($a_select[0]))
		$a_select = (array)$a_select[0];
}else{
	$a_select = $starter->database->prepare_query($s_query,$a_data_query);
}
if(isset($a_select[$starter->_special_GET['field']]))
	$a_items = json_decode($a_select[$starter->_special_GET['field']]);

$starter->a_include_pages[]  = '/modules/plugins/modules/special/' . $starter->_special_GET['plugin'] . '/views/addon.php';
?>