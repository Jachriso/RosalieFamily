<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';
require_once APPLICATION_PATH . '/controllers/CovoituragesController.php';
require_once APPLICATION_PATH . '/controllers/AdherentsController.php';

class Covoiturage extends Covoiturages
{
	public $a_fields = array();
    public $a_data = array();
    public $s_include_page = '';

	function __construct() {
        $this->init();
    }
    private function init()
    {
    	global $starter;

		if(!isset($_SESSION['user_info'])){
    		header("Location:" . $starter->HTTP_ROOT .$starter->s_lang . '/' . $starter->mods['subscribe']['referer'] );
			exit();
    	}else{
			$users = new UsersController();
			$covoiturage = new CovoituragesController();
			$adherents = new AdherentsController();
			$this->a_data = $adherents->getAdherentsActiv($_SESSION['user_info']['user_id']);

	        //CSS
			//$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "!locked/lib/dropzone/css/dropzone.css");
	        //$starter->a_css[] = array( "rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "/!locked/lib/photon-geocoder-autocomplete/css/photon-geocoder-autocomplete.min.css");

	        //JS
			$this->s_include_page = '/modules/special/covoiturages/views/' . (is_file(APPLICATION_PATH .'/modules/special/covoiturages/views/' . $starter->s_display. '/dashboard.php') ? $starter->s_display : 'default') . '/dashboard.php';

			// rel files
			$s_rel_id = $starter->mods['covoiturages']['modules']['dashboard']['rel'];
		}
    }
}
?>