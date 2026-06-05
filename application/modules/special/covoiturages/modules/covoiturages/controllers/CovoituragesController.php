<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';
require_once APPLICATION_PATH . '/controllers/CovoituragesController.php';
require_once APPLICATION_PATH . '/controllers/AssociationsController.php';

class Covoiturage extends Covoiturages
{
	public $a_fields = array();
    public $a_data = array();
    public $s_include_page = '';
    public $a_assoc = array();

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
	    	$this->a_data = $covoiturage->getCovoiturages();
	    	foreach($this->a_data AS $key => $val){
	    		if(!empty($val['resa_id']))
	    			if(isset($this->a_data[$key]['places']))
	    				$this->a_data[$key]['places']--;
	    			else
	    				if($val['covoiturage_type'] == 1)
	    					$this->a_data[$key]['places'] = intval($val['covoiturage_nb_places']) - 1;
		    			else
		    				$this->a_data[$key]['places'] = 0;
	    		else
	    			if($val['covoiturage_type'] == 1)
			    		$this->a_data[$key]['places'] = intval($val['covoiturage_nb_places']);
	    			else
	    				$this->a_data[$key]['places'] = 1;
	    	}

	    	$this->a_fields = $covoiturage->newSearch();

			$associations = new AssociationsController(); 
			$list_assos = $associations->getAssociations();
			foreach($list_assos AS $key => $val){
				$this->a_assoc[$val['association_id']."_1"]['label'] = $val['association_label'];
				$this->a_assoc[$val['association_id']."_1"]['addr'] = $val['association_label'] . " : " . $val['association_address'] . ", " . $val['association_zip'] . " : "  . $val['association_city'];
				if(!empty($val['association_address2']) && !empty($val['association_zip2']) && !empty($val['association_city2'])){
					$this->a_assoc[$val['association_id']."_2"]['label'] = $val['association_label'] ;
					$this->a_assoc[$val['association_id']."_2"]['addr'] = $val['association_label'] . " : " . $val['association_address2'] . ", " . $val['association_zip2'] . " : "  . $val['association_city2'];
				}
			}

	        //CSS
			//$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "!locked/lib/dropzone/css/dropzone.css");
	        //$starter->a_css[] = array( "rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "/!locked/lib/photon-geocoder-autocomplete/css/photon-geocoder-autocomplete.min.css");
	        
	        //JS
	        $starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "templates/" . $starter->s_template . "/modules/special/covoiturages/js/main.js");

			$this->s_include_page = '/modules/special/covoiturages/views/' . (is_file(APPLICATION_PATH .'/modules/special/covoiturages/views/' . $starter->s_display. '/index.php') ? $starter->s_display : 'default') . '/index.php';

			// rel files
			$s_rel_id = $starter->mods['covoiturages']['modules']['covoiturages']['rel'];
		}
    }
}
?>