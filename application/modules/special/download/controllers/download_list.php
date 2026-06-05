<?php
// Init vars
$a_cart = array();
$a_cat = array();
$a_charte = array();
$starter->b_mail 	= false;
$_a_tmp_cat = array();
$_a_tmp_charte = array();
//$a_total = array();

// lexique vars
$s_lexique_charte = $starter->_get_lexique('Chartes');
$s_lexique_delete = $starter->_get_lexique('Supprimer');
$s_lexique_add = $starter->_get_lexique('Ajouter');
$s_lexique_dl = $starter->_get_lexique('Télécharger');
$s_lexique_look = $starter->_get_lexique('voir');
$s_lexique_close = $starter->_get_lexique('Fermer');
$s_lexique_empty = $starter->_get_lexique('Votre sélection est vide');
$s_lexique_none = $starter->_get_lexique('aucun fichier sélectionné');
$s_lexique_search_dl = $starter->_get_lexique('Recherchez un téléchargement');
$s_lexique_search = $starter->_get_lexique('Recherche');
$s_lexique_search_value = $s_lexique_search ;
$s_lexique_categories = $starter->_get_lexique('Catégories');
$s_lexique_select_all = $starter->_get_lexique('Tout sélectionner');
$s_lexique_pagin_10 = '10';
$s_lexique_pagin_20 = '20';
$s_lexique_pagin_50 = '50';

//content

$a_data_query = array(
	'cart_id' => array($_SESSION['PHPSESSID'],PDO::PARAM_STR),
);
$s_query = "
	SELECT cart_item 
	FROM download_cart 
	WHERE cart_id = :cart_id";
$a_cart = json_decode($starter->database->prepare_query($s_query,$a_data_query));

$a_data_query = array(
	'lang' => array($starter->i_lang,PDO::PARAM_INT),
);
$s_query ="
	SELECT t0.*, t1.*, t1.detail_label AS detail_label_download_categories_detail
	FROM download_categories AS t0
	INNER JOIN download_categories_detail AS t1
	ON t1.detail_category = category_id
	WHERE online = 1
	AND archive = 0
	AND lang = :lang";

if(isset($_SESSION['user_info']) && $_SESSION['user_info']['user_statut'] != 0){
	$a_data_query['category_id']> array($auth->authCat,PDO::PARAM_STR);
	$s_query .= "
		AND category_id IN (:category_id)";
	}
	$s_query .= "	
		ORDER BY _order";
	
$a_cat = $starter->database->prepare_query($s_query, $a_data_query, 'multiple', 'category_id');

foreach($a_cat as $key => $val)
	$_aCat[] = $val['category_id'];

$a_data_query = array(
	'lang' => array($starter->i_lang,PDO::PARAM_INT),
);
$s_query ="
	SELECT t0.*, t1.*, t1.detail_label AS detail_label_tree_detail
	FROM tree AS t0
	INNER JOIN tree_detail AS t1
	ON t1.detail_tree = t0.tree_id
	WHERE lang = :lang
	AND archive = 0";
if(isset($_SESSION['user_info']) && $_SESSION['user_info']['user_statut'] != 0){
	$a_data_query['authChartes']> array($auth->authChartes,PDO::PARAM_STR);
	$s_query .= "
		AND tree_id IN (:authChartes)";
}

$s_query .= "	
	AND online = 1
	ORDER BY tree_label";

$a_charte = $starter->database->prepare_query($s_query, $a_data_query, 'multiple', 'tree_id');
foreach($a_charte as $key => $val)
	$_aCharte[] = $val['tree_id'];
	
require_once dirname(__FILE__) . '/download_search.php' ;

/*$s_pagination = preg_replace('#{TOTAL}#', $i_total, $starter->_get_lexique('éléments par page sur un <strong>total de {TOTAL}</strong>'));

$s_pagination_nav = $starter->utils->set_pages($i_pages, $i_nb_pages, $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['download']['referer'] . '/');
*/
// META


// OUTPUT

// rel files
$s_rel_id = $starter->mods['download']['rel'];

// CSS
$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "/modules/special/download/css/main.css");

// JS

// VIEWS
$s_include_page = '/modules/special/download/views/' . (is_dir(APPLICATION_PATH .'/modules/special/download/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/download_list.php' ;
?>