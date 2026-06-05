<?php
class Plugin extends Starter
{
	private $s_form_plugin = '';

	function __construct() {
        $this->init();
    }

    private function init()
    {
    	global $starter;
    	$starter->cache  = $starter->mods['plugins']['cache'];
    	$this->s_form_plugin = (isset($_GET['plugin']) ? htmlentities($_GET['plugin']) : '');
    	$this->getPlugin();
    }

    public function getPlugin(){
    	global $starter;

    	if(!empty($this->s_form_plugin) && (is_file( dirname( __FILE__ ) . '/../modules/' . $this->s_form_plugin . '/controllers/index.php') || is_file( dirname( __FILE__ ) . '/../modules/special/' . $this->s_form_plugin . '/controllers/index.php')))
		{
			require_once (is_file( dirname( __FILE__ ) . '/../modules/' . $this->s_form_plugin . '/controllers/index.php') ? dirname( __FILE__ ) . '/../modules/' . $this->s_form_plugin . '/controllers/index.php' : dirname( __FILE__ ) . '/../modules/special/' . $this->s_form_plugin . '/controllers/index.php');
		}
    }
}
?>