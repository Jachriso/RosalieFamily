<?php
require_once APPLICATION_PATH . '/controllers/!locked/UserController.php';
require_once APPLICATION_PATH . '/controllers/RecoController.php';
require_once APPLICATION_PATH . '/controllers/MpbController.php';
require_once APPLICATION_PATH . '/controllers/InviteController.php';

class Statistiques extends Starter
{
	public $a_data = array();
	public $s_include_page = '';
	public $statistiques;

	function __construct() {
        $this->init();
    }

    private function init()
    {
    	global $starter;

    	if(!isset($_SESSION['user_info'])){
			header("Location:" . $starter->HTTP_ROOT .$starter->s_lang . '/' . $starter->mods['subscribe']['referer'] );
			exit();
		}
		
		$_current_level 			= (isset($starter->s_level2) && !empty($starter->s_level2) && !preg_match('#page_#',$starter->s_level2) ? $starter->s_level2 : '');
		$menu = new MenuController();
		$module = $menu->getModule('statistiques', $_current_level);
    	if(empty($module))
    		$module = "listing";

		if(!empty($module) && !isset($starter->mods['statistiques']['modules'][$module])){
			$starter->utils->not_found_page();
		}
		else{
			
			$user = new UserController();
			$this->a_data = $user->getUser($_SESSION['user_info']['user_id']);

			require_once dirname(__FILE__) . $starter->mods['statistiques']['modules'][$module]['path'] ;
					
			$this->statistiques = new Statistique();
			$this->s_include_page = $this->statistiques->s_include_page;
			
			// META
			$starter->utils->getmeta($starter->i_level);

			// rel files
			$s_rel_id = $starter->mods['statistiques']['rel'];
			$this->view();
		}
    }

    public function view(){
    	global $starter;
    	// CSS

		// JS

		// VIEWS
		// VIEWS
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/head.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/head.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/connected/' . $starter->s_display . '/header.php') ? 'connected/' . $starter->s_display : 'connected/' . $starter->s_display_default) . '/header.php' ;
		
		$starter->a_include_pages[]  = '/modules/menu/views/' . (is_file(APPLICATION_PATH .'/modules/menu/views/connected/' . $starter->s_display . '/index.php') ? 'connected/' . $starter->s_display : 'connected/' . $starter->s_display_default) . '/index.php' ;

		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/connected/' . $starter->s_display . '/nav.php') ? 'connected/' . $starter->s_display : 'connected/' . $starter->s_display_default) . '/nav.php' ;

		$starter->a_include_pages[] = $this->statistiques->s_include_page;
		
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/modals.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/modals.php' ;
		//$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/footer.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/foot.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/foot.php' ;
    }
}
?>