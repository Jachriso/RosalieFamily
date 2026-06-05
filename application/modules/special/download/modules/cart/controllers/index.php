<?php 
// vars init

$s_nb_kit_cart = 0;
$s_nb_download_cart = '0';
$a_kit_cart = array();
$a_dowload_cart = array();
$a_dowload = array();
$a_cart = array();
$a_data_cart = array();
$s_size = '';

//content
if(isset($_SESSION['PHPSESSID']))
{
	$a_data_query = array(
		'cart_id' => array($_SESSION['PHPSESSID'],PDO::PARAM_STR),
	);
    $s_query = "
		SELECT cart_item 
		FROM download_cart 
		WHERE cart_id = :cart_id";
	$a_dowload_cart = json_decode($starter->database->prepare_query($s_query,$a_data_query));
	
	if(isset($a_dowload_cart[0]->index) && is_array($a_dowload_cart[0]->index)){
		$s_nb_download_cart = ($starter->utils->is__countable($a_dowload_cart[0]->index) ? count($a_dowload_cart[0]->index) :0);
	}
			
	$a_cart = json_decode($a_dowload_cart);
	if(!$a_cart){
		
	}else{
		//unset($_tmp);
		$a_data_query = array(
			'lang' => array($starter->i_lang,PDO::PARAM_INT),
		);
		$s_query ="
			SELECT t0.*, t1.*
			FROM download_categories AS t0
			INNER JOIN download_categories_detail AS t1
			ON t1.detail_category = category_id
			WHERE category_online = 1
			AND archive = 0
			AND lang = :lang
			ORDER BY category_name";
	
		$a_cat = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', 'category_id');
		
		//content
		$a_data_query = array(
			'lang' => array($starter->i_lang,PDO::PARAM_INT),
		);
		$s_query ="
			SELECT t0.*, t1.*
			FROM tree AS t0
			INNER JOIN tree_detail AS t1
			ON t1.detail_tree = tree_id
			WHERE tree_ischarte = 1
			AND archive = 0";
		if($_SESSION['user_info']['user_statut'] != 0){
			$a_data_query['authChartes'] = array($auth->authChartes,PDO::PARAM_STR);
			$s_query .= "
				AND tree_id IN (:authChartes)";
		}
		
		$s_query .= "	
			AND tree_online = 1
			AND lang = :lang
			ORDER BY tree_label";
		
		$a_charte = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', 'tree_id');
		
		$a_data_query = array(
			'lang' => array($starter->i_lang,PDO::PARAM_INT),
			'download_id' => array(implode(',',$a_cart[0]->index),PDO::PARAM_STR),
		);
		$s_query = "
			SELECT t0.*, t1.*
			FROM download AS t0
			INNER JOIN download_detail AS t1
			ON t1.detail_download = download_id
			WHERE t0.download_online = 1
			AND t0.archive = 0
			AND t0.download_id IN (:download_id)		
			AND t1.lang = " . $starter->i_lang;
		$a_data_cart = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', 'download_id');
		foreach($a_data_cart as $key => $val){
			if(is_file('../secure/'.$val['download_path'])) $s_size += filesize('../secure/'.$val['download_path']);
		}

		$s_size = $starter->utils->displayBytesLabel($s_size);
	}
}
?>
