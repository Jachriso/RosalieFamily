<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';

class Dashboard extends Starter
{
	private $name;
	private $s_page = 'index.php';
	public $amount = 0;
	public $amount_received = 0;
	public $a_data_invite = array();
	public $a_data_recos = array(); 
	public $a_data_recos_received = array();
	public $a_data_mpb = array();
	public $a_data_mpb_received = array();
	public $absence = 0;

	function __construct() {
        $this->init();
    }

    private function init()
    {
    	global $starter;
    	
    	if(!isset($_SESSION['user_info'])){
			header("Location:" . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['subscribe']['referer'] );
			exit();
		}

        $this->name = strtolower(get_class($this));
    	$starter->cache  = $starter->mods['dashboard']['cache'];
    	
		// rel files
		$s_rel_id = "dashboard";
		$this->view();
	}

    public function view(){
    	global $starter;

		// CSS
			
		// JS

		// VIEWS
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/head.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/head.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/connected/' . $starter->s_display . '/header.php') ? 'connected/' . $starter->s_display : 'connected/' . $starter->s_display_default) . '/header.php' ;
		
		$starter->a_include_pages[]  = '/modules/menu/views/' . (is_file(APPLICATION_PATH .'/modules/menu/views/connected/' . $starter->s_display . '/index.php') ? 'connected/' . $starter->s_display : 'connected/' . $starter->s_display_default) . '/index.php' ;

		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/connected/' . $starter->s_display . '/nav.php') ? 'connected/' . $starter->s_display : 'connected/' . $starter->s_display_default) . '/nav.php' ;

		$starter->a_include_pages[]  = '/modules/special/'.$this->name.'/views/' . (is_file(APPLICATION_PATH .'/modules/special/'.$this->name.'/views/' . $starter->s_template . '/' . $starter->s_display . '/'.$this->s_page) ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/'.$this->s_page ;
		
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/modals.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/modals.php' ;
		//$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/footer.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/foot.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/foot.php' ;
    }
}
?>