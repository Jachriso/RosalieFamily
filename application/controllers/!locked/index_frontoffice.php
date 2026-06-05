<?php
// init vars
$s_form_action = (isset($_GET['action']) ? htmlentities($_GET['action']) : '');
// menu
if(!isset($_SESSION['PHPSESSID'])) 
	$_SESSION['PHPSESSID'] = $starter->utils->generateRandomString();

require_once APPLICATION_PATH . '/controllers/!locked/AuthController.php';
$auth = new AuthController();
$a_auth = $auth->getAuth();

require_once APPLICATION_PATH . '/controllers/!locked/MenuController.php';
$menu = new MenuController();
$a_menu = array();

if(isset($_SERVER['HTTP_REFERER']))
{
	$url = parse_url($_SERVER['HTTP_REFERER']);
	if(!empty($url['query']))
    	parse_str($url['query'], $query_params);
   	
	if(isset($query_params['config_id']) && isset($query_params['action']) && $query_params['action'] == "preview" && ($_SESSION['user_info']['user_statut'] == 0 || isset($_currentConf[$query_params['config_id']]) && in_array($s_form_action,$_currentConf[$query_params['config_id']]))){
		$a_menu = $menu->getTree(1, 0, $b_back = true);
		$a_menu = $a_menu->_menu_items;
	}
	else{
		$a_menu = $menu->getTree();
	}
}
else{
	$a_menu = $menu->getTree();
}
// init vars
$i_level = (isset($menu->current[5]) && isset($starter->s_level5) && !empty($starter->s_level5) ? '5' : (isset($menu->current[4]) && isset($starter->s_level4) && !empty($starter->s_level4) ? '4' : (isset($menu->current[3]) && isset($starter->s_level3) && !empty($starter->s_level3) ? '3' : (isset($menu->current[2]) && isset($starter->s_level2) && !empty($starter->s_level2) ? '2' : '1'))));
if(empty($starter->s_level))
	$starter->s_level = (isset($menu->current[5]) && $starter->utils->is__countable($menu->current) && count($menu->current) >= 5 && isset($starter->s_level5) && !empty($starter->s_level5) ? $starter->s_level5 : (isset($menu->current[4]) && $starter->utils->is__countable($menu->current) && count($menu->current) >= 4 && isset($starter->s_level4) && !empty($starter->s_level4) ? $starter->s_level4 : (isset($menu->current[3]) && $starter->utils->is__countable($menu->current) && count($menu->current) >= 3 && isset($starter->s_level3) && !empty($starter->s_level3) ? $starter->s_level3 : (isset($menu->current[2]) && $starter->utils->is__countable($menu->current) && count($menu->current) >= 2 && isset($starter->s_level2) && !empty($starter->s_level2) ? $starter->s_level2 : (!empty($starter->s_level1) ? $starter->s_level1 : 'covoiturages')))));
;
if($starter->s_level != "plugins")
	require_once APPLICATION_PATH . '/configs/!locked/frontoffice-inc.vars.php' ;
else
	require_once APPLICATION_PATH . '/configs/!locked/backoffice-inc.vars.php' ;

if(isset($starter->b_cart) && $starter->b_cart)
	require_once APPLICATION_PATH . '/controllers/' . $starter->mods['download']['modules']['cart']['path'] ;

// tree menu
require_once APPLICATION_PATH . '/modules/menu/controllers/index.php' ;
$module = $menu->getModules($starter->s_level);

// controller
switch($module)
{
	default :
		if(isset($menu->current[$i_level]) && (!empty($menu->current[$i_level]->tree_module) || !empty($menu->current[$i_level]['tree_module'])))
		{
			if($starter->isApi ){
				$_data = array();
				$_data['module_id'] = (isset($menu->current[$i_level]->tree_module) ? intval($menu->current[$i_level]->tree_module) : $menu->current[$i_level]['tree_module']);

				// CRL code
				$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=GeneralConfig&rquest=getModule', $_data);
				$o_result = $curlApiRequest;

				if(!$o_result)
					$starter->utils->not_found_page();
			}
			else
			{
				$a_data_query = array(
					'module_id' => array((!empty($menu->current[$i_level]->tree_module)  ? $menu->current[$i_level]->tree_module : (!empty($menu->current[$i_level]['tree_module']) ? $menu->current[$i_level]['tree_module'] : '')),PDO::PARAM_INT),
				);		
				$s_query = "
					SELECT module_path
					FROM tree_module
					WHERE module_id = :module_id";
				$o_result = $starter->database->prepare_query($s_query,$a_data_query);
			}
			if(!$o_result || !isset($starter->mods[$o_result['module_path']]) || !$starter->mods[$o_result['module_path']]) 
				$starter->utils->not_found_page();

			$_file = APPLICATION_PATH . '/modules/' . $o_result['module_path'] . '/config/config.php';
			if(is_file($_file))			
				include $_file ;
			$_file = APPLICATION_PATH. '/modules/' . $o_result['module_path'] . '/controllers/index.php';
			if(is_file($_file)) 
				include $_file ;
			else
			{				
				$_file = APPLICATION_PATH . '/modules/special/' . $o_result['module_path'] . '/controllers/index.php';
				if(is_file($_file)) 
					include $_file ;
				else
					$starter->utils->not_found_page();
			}
			unset($_file);
		}
		elseif(isset($menu->current[$i_level]) && ((isset($menu->current[$i_level]['detail_referer']) && $menu->current[$i_level]['detail_referer'] == $starter->s_level) || (empty($starter->s_level) && $menu->current[$i_level]['tree_id'] == $starter->meta['config_home']))){

			include APPLICATION_PATH . $starter->mods['tree']['path'] ;
			$starter->s_level = 'tree';
		}
		elseif(isset($starter->mods) && isset($starter->mods[$module]))
		{
			$_file = APPLICATION_PATH . '/' . $starter->mods[$module]['path'] ;

			if(is_file($_file)) 
				include $_file ;
			else  {
				$starter->utils->not_found_page();
			}
			unset($_file);
		}
		else {
			$starter->s_level = "error";
			$starter->utils->not_found_page();
		}
	
	break;

	case 'switchoff' :
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/header.php') ? $starter->s_display : 'default') . '/header.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/top.php') ? $starter->s_display : 'default') . '/top.php' ;
		$starter->a_include_pages[]  = '/modules/special/working/views/' . (is_file(APPLICATION_PATH .'/modules/special/working/views/' . $starter->s_template . '/' . $starter->s_display . '/index.php') ? $starter->s_display : 'default') . '/index.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_display : 'default') . '/footer.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_display : 'default') . '/footer.php' ;
	
	break;

	case 'cron' :
		
		include APPLICATION_PATH . '/modules/special/cron/cron.php' ;	
	
	break;

	case 'ajax' :
		
		include APPLICATION_PATH . '/modules/special/ajax/controllers/index.php' ;	
		
	break;

	case 'pdf_viewer' :

		include APPLICATION_PATH . '/controllers/!locked/pdf_viewer.php' ;
	
	break;

	case 'media_download' :

		require_once APPLICATION_PATH . '/controllers/!locked/DownloadController.php' ;
		$download = new DownloadController();
        $download->loadDownload();
	
	break;

	case 'media_upload' :

		require_once APPLICATION_PATH . '/controllers/!locked/UploadController.php' ;
		$upload = new UploadController();
        $upload->loadUpload();
	
	break;

	case 'download_zip' :
	
		require_once APPLICATION_PATH . '/controllers/!locked/DownloadController.php' ;
		$download = new DownloadController();
        $download->s_type = 'zip';
        $download->loadDownload();
	
	break;
	
	case 'plugins' :
	
		include APPLICATION_PATH . '/modules/plugins/controllers/index.php' ;
	
	break;
	
	case 'confirm' :
	
		include APPLICATION_PATH . '/modules/special/subscribe/controllers/index.php' ;
	
	break;
	
	case 'reset' :
	
		include APPLICATION_PATH . '/modules/special/forgot_password/controllers/index.php' ;
	
	break;
}

require_once SYSTEM_PATH . '/FrontVars.php' ;
?>
