<?php
require_once APPLICATION_PATH . '/controllers/!locked/UserController.php';
require_once APPLICATION_PATH . '/controllers/!locked/MenuController.php';

class Profils extends Starter
{
	public $a_data = array();
	public $s_include_page = '';
	public $profil;

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
		$module = $menu->getModule('profil', $_current_level);
    	if(empty($module))
    		$module = "dashboard";

		if(!empty($module) && !isset($starter->mods['profil']['modules'][$module])){
			$starter->utils->not_found_page();
		}
		else{
			
			$user = new UserController();
			$this->a_data = $user->getUser($_SESSION['user_info']['user_id']);

			require_once dirname(__FILE__) . $starter->mods['profil']['modules'][$module]['path'] ;
					
			$this->profil = new Profil();
			$this->s_include_page = $this->profil->s_include_page;
			
			// META
			$starter->utils->getmeta($starter->i_level);

			// rel files
			$s_rel_id = $starter->mods['profil']['rel'];
			if(!isset($this->mission->view) || $this->mission->view != false)
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

		$starter->a_include_pages[] = $this->profil->s_include_page;
		
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/modals.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/modals.php' ;
		//$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/footer.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/foot.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/foot.php' ;
    }
}
?>