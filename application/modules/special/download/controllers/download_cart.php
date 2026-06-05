<?php
// Init vars
$a_cart = array();
$a_data = array();
$s_size = '';

//content
$a_data_query = array(
	'cart_id' => array($_SESSION['PHPSESSID'],PDO::PARAM_STR),
);
$s_query = "
	SELECT cart_item 
	FROM download_cart
	WHERE cart_id = :cart_id";

$_tmp = $starter->database->prepare_query($s_query,$a_data_query);

//if(!$_tmp || empty($starter->s_level2) || $starter->utils->is__countable(json_decode($_tmp))<1 ) $starter->utils->not_found_page();

$a_cart = json_decode($_tmp);
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
		ORDER BY category_label";

	$a_cat = $starter->database->prepare_query($s_query,$a_data_query, 'multiple', 'category_id');
	
	//content
	
	$a_data_query = array(
		'lang' => array($starter->i_lang,PDO::PARAM_INT),
		'download_id' => array(implode(',',$a_cart[0]->index),PDO::PARAM_STR),
	);
	$s_query = "
		SELECT t0.*, t1.*, t2.detail_label AS detail_download_label, t2.detail_info, t2.detail_text AS detail_download_text, t2.detail_referer AS detail_download_referer, t3.detail_label AS detail_category_label, t3.detail_referer AS detail_category_referer
		FROM download AS t0
		INNER JOIN download_detail AS t2
		ON t2.detail_download = download_id
		INNER JOIN download_categories  AS t1
		ON t1.category_id=t0.download_category
		INNER JOIN download_categories_detail  AS t3
		ON t3.detail_category=t1.category_id
		WHERE t1.online = 1
		AND t0.online = 1
		AND t0.archive = 0
		AND t1.archive = 0
		AND t0.download_id IN (:download_id)		
		AND t2.lang = :lang
		AND t3.lang = :lang
		ORDER BY t1.category_label";

	$a_data = $starter->database->prepare_query($s_query,$a_data_query, 'multiple','download_id');

	foreach($a_data as $key => $val){
		if(is_file('../secure/'.$val['download_path'])) $s_size += filesize('../secure/'.$val['download_path']);
	}
	$s_size = preg_replace('#{SIZE}#', $starter->utils->displayBytesLabel($s_size), $starter->_get_lexique('Taille : {SIZE}'));
}


// OUTPUT
// rel files
$s_rel_id = "cart-download";

// CSS
$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "modules/special/download/css/download_cart.css");

// JS
/*$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "modules/special/download/js/main.js");
$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "modules/special/download/js/download_cart.js");*/

// VIEWS
//$s_include_page = '/modules/special/download/views/' . (is_dir(APPLICATION_PATH .'/modules/special/download/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/download_cart.php' ;
?>
