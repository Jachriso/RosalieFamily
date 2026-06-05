<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';
require_once APPLICATION_PATH . '/controllers/VehiculesController.php';

class Profil extends Profils
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
			$vehicule = new VehiculesController();
			$this->a_data = $vehicule->getVehicules($_SESSION['user_info']['user_id']);
			$this->a_fields = $vehicule->newVehicule();
	
			if($starter->utils->is__countable($_POST) && count($_POST) > 0) 
			{	
				require_once LIBRARY_PATH . '/form_checker.class.php' ;

				$starter->checkForm = new form_checker($this->a_fields['fields']);

				if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0){
					$_SESSION['WARNING'] = array(
						'type' => 'error',
						'title' => $starter->_get_lexique('Votre véhicule'),
						'content' => $starter->checkForm->a_errors 
					);
				}
				else
				{
					if($this->a_data == false){
	        			$vehicule->addVehicule();
	        		}else{
	        			$vehicule->updateVehicule();
	        		}

					//$_SESSION['user_info']['user_lastname'] = htmlentities($_POST['user_lastname']);
					//$_SESSION['user_info']['user_firstname'] = htmlentities($_POST['user_firstname']);
					$_SESSION['WARNING'] = array(
						'type' => 'success',
						'title' => $starter->_get_lexique('Votre véhicule.'),
						'content' => array($starter->_get_lexique('Les modifications ont bien été prises en compte.')), 
					);

					header('Location:' . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer']);
					exit();
				}
			}
			

	        //CSS
			//$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "!locked/lib/dropzone/css/dropzone.css");
	        //$starter->a_css[] = array( "rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "/!locked/lib/photon-geocoder-autocomplete/css/photon-geocoder-autocomplete.min.css");
			$starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "!locked/lib/dropzone/css/dropzone.css?ver=0.0.1");
			
	        //JS
			$starter->a_js[] 	= array('src' => $starter->HTTP_ROOT . '/!locked/lib/jquery/js/jquery-ui.min.js');
			$starter->a_js[] 	= array("src" => $starter->HTTP_ROOT . "!locked/lib/dropzone/js/dropzone.js");
	        //$starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "/!locked/lib/photon-geocoder-autocomplete/js/photon-geocoder-autocomplete.min.js");
	        $starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "templates/" . $starter->s_template . "/modules/special/profil/js/main.js");

			$this->s_include_page = '/modules/special/profil/views/' . (is_file(APPLICATION_PATH .'/modules/special/profil/views/' . $starter->s_display. '/vehicules.php') ? $starter->s_display : 'default') . '/vehicules.php';

			// rel files
			$s_rel_id = $starter->mods['profil']['modules']['vehicules']['rel'];
		}
    }
}
?>