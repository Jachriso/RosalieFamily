<?php
require_once APPLICATION_PATH . '/controllers/UsersController.php';

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
		$token = bin2hex(random_bytes(32));

		$users = new UsersController();
		$this->a_data = $users->getUser($_SESSION['user_info']['user_id']);
		$user = new UserController();
    	$this->a_fields = $user->newUser();
		
		if($starter->utils->is__countable($_POST) && count($_POST) > 0) 
		{	
			require_once LIBRARY_PATH . '/form_checker.class.php' ;

			unset($this->a_fields['fields']['_zip']['verif']);
			
			if(!isset($_POST['password']) || empty($_POST['password'])){
				unset($this->a_fields['fields']['password']['verif']);
				unset($this->a_fields['fields']['password_confirm']['verif']);
			}

			$starter->checkForm = new form_checker($this->a_fields['fields']);

			if(($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0) || (!empty($_POST['password']) && intval($_POST['zxcvbn']) < 3)){
				if(!empty($_POST['password']) && intval($_POST['zxcvbn']) < 3)
				{
					$starter->checkForm->a_errors['password'] = $this->a_fields['fields']['password']['error_label'];
					$starter->checkForm->a_errors['password_confirm'] = $this->a_fields['fields']['password_confirm']['error_label'];
				}
				$_SESSION['WARNING'] = array(
					'type' => 'error',
					'title' => $starter->_get_lexique('Votre profil'),
					'content' => $starter->checkForm->a_errors 
				);
			}
			else
			{
    			$users->updateUser();

				//$_SESSION['user_info']['user_lastname'] = htmlentities($_POST['user_lastname']);
				//$_SESSION['user_info']['user_firstname'] = htmlentities($_POST['user_firstname']);
				$_SESSION['WARNING'] = array(
					'type' => 'success',
					'title' => $starter->_get_lexique('Votre profil.'),
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
		$starter->a_css_out[] 	= array( "rel"=>"stylesheet", "media"=>"all", "href"=> "https://unpkg.com/@webgeodatavore/photon-geocoder-autocomplete@2.0.1/dist/photon-geocoder-autocomplete.min.css");

        //JS
		$starter->a_js[] 	= array("src" => $starter->HTTP_ROOT . "!locked/js/sha1.min.js");
		$starter->a_js[] 	= array('src' => $starter->HTTP_ROOT . '/!locked/lib/jquery/js/jquery-ui.min.js');
		$starter->a_js[] 	= array("src" => $starter->HTTP_ROOT . "!locked/lib/dropzone/js/dropzone.js");
        //$starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "/!locked/lib/photon-geocoder-autocomplete/js/photon-geocoder-autocomplete.min.js");
        $starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "templates/" . $starter->s_template . "/modules/special/profil/js/main.js");
        $starter->a_js[]    = array("src" => $starter->HTTP_ROOT . "templates/" . $starter->s_template . "/modules/special/profil/js/geocoder.js");
		$starter->a_js_out[] 	= array("src"=> "https://unpkg.com/@webgeodatavore/photon-geocoder-autocomplete@2.0.1/dist/photon-geocoder-autocomplete.min.js");

		$this->s_include_page = '/modules/special/profil/views/' . (is_file(APPLICATION_PATH .'/modules/special/profil/views/' . $starter->s_display. '/mon_profil.php') ? $starter->s_display : 'default') . '/mon_profil.php';

		// rel files
		$s_rel_id = $starter->mods['profil']['modules']['mon_profil']['rel'];
	}
}
?>