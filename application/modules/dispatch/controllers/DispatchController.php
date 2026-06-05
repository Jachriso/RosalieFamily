<?php 
require_once APPLICATION_PATH . '/controllers/DispatchController.php';
class Dispatch extends Starter
{
	public $a_data = array();

	function __construct() {
        $this->init();
    }

    private function init()
    {
    	$request = new DispatchController();
		$this->a_data = $request->getCustomers();
    	$this->view();
    }

    public function view(){
    	global $starter;
    			
		// VIEWS
		//return array(1,1,1,$this->s_include,1,1);
		$starter->a_include_pages[] = '/views/' . (is_dir(APPLICATION_PATH . '/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/header.php' ;
		$starter->a_include_pages[] = '/views/' . (is_dir(APPLICATION_PATH . '/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/top.php' ;
		$starter->a_include_pages[] = '/modules/menu/views/' . (is_dir(APPLICATION_PATH .'/modules/menu/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/index.php' ;
		$starter->a_include_pages[] = '/modules/dispacth/views/' . (is_dir(APPLICATION_PATH .'/modules/dispacth/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/index.php';
		$starter->a_include_pages[] = '/views/' . (is_dir(APPLICATION_PATH . '/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/footer.php' ;
		$starter->a_include_pages[] = '/views/' . (is_dir(APPLICATION_PATH . '/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/footer.php' ;
    }
}
?>