<?php 
//init vars
$a_cart = array();
$a_data = array();
$a_del = array();
$i_id 	= array();
$starter->s_level3 			= (isset($_GET['level3']) && !empty($_GET['level3']) ? htmlentities($_GET['level3']) : (isset($_GET['level3']) && $_GET['level3'] == 0 ? '0' : ''));
$a_get_del = (isset($_GET['cartDel']) ? htmlentities($_GET['cartDel']) : '');
$a_get_type = (isset($_GET['cartType']) ? htmlentities($_GET['cartType']) : '');

//content
$a_data_query = array(
	'cart_id' => array($_SESSION['PHPSESSID'],PDO::PARAM_STR),
);
$s_query = "	
	SELECT cart_item 
	FROM download_cart 
	WHERE cart_id = :cart_id";
$a_cart = json_decode($starter->database->prepare_query($s_query,$a_data_query));

if(!$a_cart ){
	$s_popin_title = $starter->_get_lexique("Le fichier demandé n'est pas disponible") ;
	$starter->s_extended_js .= "$(document).ready(function() {download_del_callback(0, 0, 0)});";
	$s_include_page = '/modules/special/popin/simple_message.php' ;

}
else
{
	// POST values
	if($starter->utils->is__countable($_POST) && count($_POST) > 0 && (!empty($a_get_del) || $a_get_type != "ask")) {
	{
		$a_data = explode(',',($a_get_del));

		foreach($a_data as $key => $val)
		{
			if(in_array($val,$a_cart[0]->index)) $_tmp[] = $val ;
		}

		foreach($a_cart[0]->index as $key => $val)
		{
			if(in_array($val,$_tmp)) $a_del[] = $key;
		}
		/*delete item*/
		foreach($a_del as $key => $val)
		{
			unset($a_cart[0]->index[$val]);
		}
		$a_cart[0]->index = array_values($a_cart[0]->index);
		
		if($starter->utils->is__countable($a_cart[0]->index) && count($a_cart[0]->index) > 0 ) {
			$a_data_query = array(
				'cart_item' => array(json_encode($a_cart),PDO::PARAM_STR),
				'cart_id' => array($_SESSION['PHPSESSID'],PDO::PARAM_STR),
			);
			$s_query = "
				UPDATE download_cart 
				SET cart_item = :cart_item
				WHERE cart_id = :cart_id";
		}else 
		{
			$a_data_query = array(
				'cart_id' => array($_SESSION['PHPSESSID'],PDO::PARAM_STR),
			);
			$s_query = "
				DELETE FROM download_cart 
				WHERE cart_id = :cart_id";
			unset($a_cart);
		}
		if($starter->database->prepare_query($s_query,$a_data_query))
		{
			$s_popin_title = $starter->_get_lexique('Votre panier a bien été mis à jour.');
			$a_output['response_quantity'] = (isset($a_cart) && $starter->utils->is__countable($a_cart[0]->index) && count($a_cart[0]->index) != 0 ? count($a_cart[0]->index) : 0);
			$a_output['response_item'] = $a_get_del ;
			$starter->s_extended_js .= "$(document).ready(function() {download_del_callback(0, " . $a_output['response_quantity'] . ", '" . json_encode($a_output['response_item']) . "')});";
		}
		else{
			$s_popin_title = $starter->_get_lexique('Il y a eu un problème de suppression lors de la demande de suppression du support.');
			$starter->s_extended_js .= "$(document).ready(function() {download_del_callback(0, 0, 0)});";
		}
		$s_include_page = '/modules/special/popin/simple_message.php' ;
		
	}
	else
	{
		if(count(explode(',',$a_get_del)) == 1 && (!isset($a_get_type) || $a_get_type != "ask"))
		{
			$a_data_query = array(
				'detail_referer' => array($starter->s_level3,PDO::PARAM_STR),
			);
			$s_query ="
				SELECT * 
				FROM download AS t0
				INNER JOIN download_detail AS t1
				ON t1.detail_download = t0.download_id
				WHERE download_online = 1 
				AND detail_referer = :detail_referer";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			if(!in_array($a_data['download_id'],$a_cart[0]->index)){
				$s_popin_title = $starter->_get_lexique('Ce fichier n\'est pas dans votre panier');
				$s_include_page = '/modules/special/popin/simple_message.php' ;
				$starter->s_extended_js .= "$(document).ready(function() {download_del_callback(0, 0, 0)});";
			}
		}else{
			
			$s_popin_title = $starter->_get_lexique('Etes vous certain de vouloir retirer ces fichiers de votre panier ?');			
			$s_include_page = '/modules/special/popin/delete_confirmation.php' ;
		}
	}
}

// JS
$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "modules/special/download/js/download_del.js");
// VIEWS
?>
