<?php 
//init vars
$a_cart = array();
$a_data = array();
$b_verif = true;
$a_get = (isset($_GET['cartAdd']) ? htmlentities($_GET['cartAdd']) : '');

//content
$a_data_query = array(
	'cart_id' => array($_SESSION['PHPSESSID'],PDO::PARAM_STR),
);
$s_query = "
	SELECT cart_item 
	FROM download_cart 
	WHERE cart_id = :cart_id";
$a_cart = json_decode($starter->database->prepare_query($s_query,$a_data_query));

if(!empty($a_get) ){
{
	$a_data = json_decode($a_get);

	if(!$a_cart && !$a_data)
		$s_popin_title = $starter->_get_lexique('Aucun fichier sélectionné.');

	elseif(!$a_cart){
		$a_cart = $a_data;
		$a_data_query = array(
			'cart_id' => array($_SESSION['PHPSESSID'],PDO::PARAM_STR),
			'cart_item' => array(json_encode($a_cart),PDO::PARAM_STR),
		);
		$s_query = "
			INSERT INTO download_cart 
			SET cart_id = :cart_id, 
			cart_item = :cart_item";
		$a_query = array(
			"request"		=> "INSERT INTO download_cart",
			"fields"		=> array('cart_id', 'cart_item'),
			"values"		=> array(':cart_id', ':cart_item')
		);
		$o_result = $starter->database->prepare_query($s_query,$a_data_query, '', '', $a_query);

		$s_popin_title = $starter->_get_lexique('Le fichier a bien été ajouté au panier');
	}
	else
	{
		if($starter->utils->is__countable($a_data[0]->index) && count($a_data[0]->index) > 1)
		{
			foreach($a_data[0]->index as $key => $val)
			{
				if(!in_array($val,$a_cart[0]->index)) $a_cart[0]->index[] = $val ;
			}
		}
		else
		{
			foreach($a_data[0]->index as $key => $val)
			{
				if(in_array($val,$a_cart[0]->index)) $b_verif = false;
				else $a_cart[0]->index[] = $val;
			}	
		}
		if(!$b_verif)
			$s_popin_title = $starter->_get_lexique('Le fichier est déjà dans votre panier');	
		else{
			$s_popin_title = $starter->_get_lexique('Le fichier a bien été ajouté au panier');
			$a_data_query = array(
				'cart_id' => array($_SESSION['PHPSESSID'],PDO::PARAM_STR),
				'cart_item' => array(json_encode($a_cart),PDO::PARAM_STR),
			);
			$s_query = "	
				UPDATE download_cart 
				SET cart_item = :cart_item
				WHERE cart_id = :cart_id";
			$o_result = $starter->database->prepare_query($s_query,$a_data_query);
		}
	}
	
	$a_output['response_quantity'] 			= ($starter->utils->is__countable($a_cart[0]->index) ? count($a_cart[0]->index) : 0);
	$a_output['response_quantity_label'] 	= $starter->_get_lexique('Mon panier ') ;
	$a_output['response_item'] = $a_data[0]->index;
	$starter->s_extended_js .= "$(document).ready(function() {download_add_callback(" . $a_output['response_quantity'] . ", '" . json_encode($a_output['response_item']) . "')});";
	
}else
	$s_popin_title = $starter->_get_lexique('Aucun fichier sélectionné');

// JS
$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "modules/special/download/js/download_add.js");

// VIEWS
$s_include_page = '/modules/special/popin/simple_message.php' ;
?>
