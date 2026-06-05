<?php
// Init vars
$a_data = array();
$a_carrousel = array();

$s_lexique_delete = $starter->_get_lexique('Supprimer');
$s_lexique_add = $starter->_get_lexique('Ajouter');

//content
$a_data_query = array(
	'detail_referer' => array($starter->s_level2,PDO::PARAM_STR),
	'lang' => array($starter->i_lang,PDO::PARAM_INT),
);
$s_query = "
	SELECT t0.*, t1.*, t3.detail_label AS detail_download_label, t3.detail_text AS detail_info, t3.detail_referer AS detail_download_referer, t4.detail_label AS detail_category_label, t4.detail_referer AS detail_category_referer
	FROM download AS t0
	INNER JOIN download_detail AS t3
	ON t3.detail_download = t0.download_id
	INNER JOIN download_categories AS t1
	ON t1.category_id = t0.download_category
	INNER JOIN download_categories_detail AS t4
	ON t4.detail_category = t1.category_id
	WHERE t3.detail_referer = :detail_referer
	AND t0.online = 1
	AND t1.online = 1
	AND t0.archive = 0
	AND t1.archive = 0	
	AND t3.lang = :lang
	AND t4.lang = :lang
";

if(isset($_SESSION['user_info']) && $_SESSION['user_info']['user_statut'] != 0){
	$a_data_query['category_id'] = array($auth->authCat,PDO::PARAM_STR);
	$s_query .= "
		AND category_id IN (:category_id)";
}

$a_data = $starter->database->prepare_query($s_query,$a_data_query);

if(!$a_data) $starter->utils->not_found_page();


if(!empty($a_data['download_content']))
{
	$path = APPLICATION_PATH . '/../web/content/bdd/downloads/cover/' . $a_data['download_content'] . '/';
	$a_carrousel = $starter->utils->file_listing($path);
}
$a_data['category_label'] = (!empty($a_data['detail_label']) ? $a_data['detail_label'] : $a_data['category_label']);
$a_data['download_label'] = (!empty($a_data['detail_label']) ? $a_data['detail_label'] : $a_data['download_label']);

$s_category = $a_data['category_label'];
$s_size = (!empty($a_data['download_path']) ? $starter->utils->displayBytesLabel(filesize('../secure/'.$a_data['download_path'])) : ' 0 ko');

$menu->breadcrumbTree[1] = '<a href="' . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->s_level1 . '">' . $starter->_get_lexique('Téléchargements') . '</a>';
$menu->breadcrumbTree[2] = $a_data ['download_label'];

// META


// OUTPUT

// rel files
$s_rel_id = "download-detail";

// CSS
$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "modules/special/download/css/download_detail.css");

// JS
$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "js/mod-carousel-minified.js");
$starter->a_js[] 	= array("src"=> $starter->HTTP_ROOT . "modules/special/download/js/download_detail.js");

// VIEWS
$s_include_page = '/modules/special/download/views/' . (is_dir(APPLICATION_PATH .'/modules/special/download/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/download_detail.php' ;
?>
