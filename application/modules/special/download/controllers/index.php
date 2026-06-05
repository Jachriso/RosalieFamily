<?php
// Init vars

$b_breadcrumbTree = true;
$_current_level 			= (isset($_GET['level2']) && !empty($_GET['level2']) && !preg_match('#page_#',$_GET['level2']) ? htmlentities($_GET['level2']) : 'list');
$starter->b_mail 	= $starter->mods['download']['b_mail'];
$starter->b_print 	= $starter->mods['download']['b_print'];
$special = false;

switch($_current_level){
	default:
		require_once dirname(__FILE__) . '/download_detail.php' ;
	break;
	
	case '':
	case 'list':
		require_once dirname(__FILE__) . '/download_list.php' ;
	break;
		
	case 'telechargements_add':
		$special = true;
		require_once dirname(__FILE__) . '/download_add.php' ;
	break;
	
	case 'telechargements_del':
		$special = true;
		require_once dirname(__FILE__) . '/download_del.php' ;
	break;
	
	case $starter->mods['download']['modules']['cart']['referer']:
		require_once dirname(__FILE__) . '/download_cart.php' ;
	break;
}
// META
$starter->utils->getmeta($i_level);

// rel files
$s_rel_id = $starter->mods['download']['rel'];

// OUTPUT

// VIEWS

$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/header.php') ? $starter->s_display : 'default') . '/header.php' ;
if(!$special) 
	$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/top.php') ? $starter->s_display : 'default') . '/top.php' ;
if(!$special) 
	$starter->a_include_pages[]  = '/modules/menu/views/' . (is_file(APPLICATION_PATH .'/modules/menu/views/' . $starter->s_template . '/' . $starter->s_display . '/index.php') ? $starter->s_display : 'default') . '/index.php' ;
$starter->a_include_pages[]  = $s_include_page;
if(!$special) 
	$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_display : 'default') . '/footer.php' ;
$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_display : 'default') . '/footer.php' ;
?>
