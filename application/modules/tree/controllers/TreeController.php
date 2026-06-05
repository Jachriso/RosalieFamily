<?php
require_once APPLICATION_PATH . '/controllers/!locked/MenuController.php';
class Tree extends Starter
{
	protected $s_page = 'index.php';
    public $a_data = array();
	private $name;

	function __construct() {
        $this->init();
    }

    private function init()
    {
        $this->name = strtolower(get_class($this));
    	$request = new MenuController();
		$this->a_data = $request->getCurrent();
    	$this->view();
    }

    public function view(){
    	global $starter;
    	$this->a_data['label'] = (isset($this->a_data['detail_label']) && !empty($this->a_data['detail_label']) ? $this->a_data['detail_label'] : $this->a_data['tree_label']);
		$this->a_data['thumb'] = '<img src="' . (!empty($this->a_data['tree_icon']) ? $starter->CDN_PATH . $this->a_data['tree_icon'] : $starter->MEDIA_PATH . 'static/spacer_square.gif') . '" alt="' . $this->a_data['label'] . '" />';
		$this->a_data['uri'] = (preg_match('#.html#', $_SERVER['REQUEST_URI']) ? dirname($_SERVER['REQUEST_URI']) . '/'  : $_SERVER['REQUEST_URI'] ) . $this->a_data['detail_referer'] . '/';
		
		// VIEWS
		//return array(1,1,1,$this->s_include,1,1);
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/head.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/head.php' ;
		
		if(isset($_SESSION['user_info'])){
			$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/connected/' . $starter->s_display . '/header.php') ? 'connected/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/header.php' ;
			$starter->a_include_pages[]  = '/modules/menu/views/' . (is_file(APPLICATION_PATH .'/modules/menu/views/' . 'connected/' . $starter->s_display. '/index.php') ? 'connected/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/index.php' ;
		}else{
			$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/header.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/header.php' ;
			$starter->a_include_pages[]  = '/modules/menu/views/' . (is_file(APPLICATION_PATH .'/modules/menu/views/' . $starter->s_template . '/' . $starter->s_display. '/index.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/index.php' ;
		}
		
		$starter->a_include_pages[]  = '/modules/'.$this->name.'/views/' . (is_file(APPLICATION_PATH .'/modules/'.$this->name.'/views/' . $starter->s_template . '/' . $starter->s_display . '/'.$this->s_page) ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/'.$this->s_page ;
		
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/modals.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/modals.php' ;
		if(!isset($_SESSION['user_info']))
			$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/footer.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/foot.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/foot.php' ;
    }
}
?>