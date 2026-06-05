<?php 
require_once APPLICATION_PATH . '/controllers/!locked/ErrorController.php';
class Errors extends Starter
{
	protected $s_page = 'index.php';
	private $name;
	private $a_data;

	function __construct() {
        $this->init();
    }

    private function init()
    {
        $this->name = strtolower(get_class($this));
    	$request = new ErrorController();
		$this->a_data = $request->getError();
    	$this->view();
    }

    public function view(){
    	global $starter;
		// VIEWS
		//return array(1,1,1,$this->s_include,1,1);
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/head.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/head.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/header.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/header.php' ;
		$starter->a_include_pages[]  = '/modules/menu/views/' . (is_file(APPLICATION_PATH .'/modules/menu/views/' . $starter->s_template . '/' . $starter->s_display. '/index.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/index.php' ;
		
		$starter->a_include_pages[]  = '/modules/'.$this->name.'/views/' . (is_file(APPLICATION_PATH .'/modules/'.$this->name.'/views/' . $starter->s_template . '/' . $starter->s_display . '/'.$this->s_page) ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/'.$this->s_page ;
		
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/modals.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/modals.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/footer.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/footer.php' ;
		$starter->a_include_pages[]  = '/views/' . (is_file(APPLICATION_PATH .'/views/' . $starter->s_template . '/' . $starter->s_display . '/!locked/foot.php') ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/!locked/foot.php' ;
    }
}