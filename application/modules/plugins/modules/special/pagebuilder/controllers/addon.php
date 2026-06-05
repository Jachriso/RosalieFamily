<?php
/******************************************/
//INIT VARS
/******************************************/
$b_error = false;
$insert = false;
$_textbuilder  = '';

if(!empty($s_form_data))
{
	$a_data_query = array(
		$s_form_key => array($s_form_data,PDO::PARAM_STR),
		'lang' => array($s_form_ilang,PDO::PARAM_INT),
	);

	$s_query = "
		SELECT detail_textedit
		FROM " . $s_form_part . "
		WHERE " . $s_form_key . " = :" . $s_form_key . "
		AND lang = :lang";

	if($starter->isApi ){
		$_data = array();
		$_data['lang'] = $s_form_ilang;
		$_data['detail_tree'] = $s_form_data;
			
		$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getPageBuilder', $_data);
		$_textbuilder = $curlApiRequest ;
	}else{
		$_textbuilder = $starter->database->prepare_query($s_query,$a_data_query);
	}
}
$a_templates = explode(',', $s_form_templates);
$a_grids = explode(',', $s_form_grids);

$starter->a_include_pages[]  = '/modules/plugins/modules/special/' . $s_form_plugin . '/views/addon.php';
?>
