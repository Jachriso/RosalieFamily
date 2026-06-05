<?php 
require_once APPLICATION_PATH . '/controllers/!locked/BackController.php';
class UpdateOnline extends Starter
{
	private $a_output = array();

	function __construct() {
        $this->init();
    }

    private function init(){
    	global $starter;
    	// init vars
    	$s_module = (isset($_POST['module']) ? $_POST['module'] : '');
		$s_page = (isset($_POST['page']) ? $_POST['page'] : '');
		$s_config = (isset($_POST['iConfig']) ? $_POST['iConfig'] : '');
		$s_item	= (isset($_POST['iItem']) ? $_POST['iItem'] : '');
		$s_key = (isset($_POST['ikey']) ? $_POST['ikey'] : '');
		$s_addon = (isset($_POST['addon']) ? $_POST['addon'] : '');
		$s_token = (isset($_POST['token']) ? $_POST['token'] : '');
		$s_field = (isset($_POST['sField']) ? $_POST['sField'] : '');
		$s_value = (isset($_POST['iVal']) ? $_POST['iVal'] : '');

		$request = new BackController();

		if($s_config == '' || empty($s_field) || $s_value=='' || $s_item == '' || empty($s_key) || $s_token != $_SESSION['token'])
		{
			$s_html = $starter->_get_lexique('erreur de mise à jour',1);
			$this->a_output['response_message'] = $s_html ;
			$this->a_output['response_code'] = 1 ;

			// output
			$this->view();
		}
		$request->updateContent($s_item, $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config], $s_key, $s_field, $s_value);

		$s_html = $starter->_get_lexique('mise à jour ok',1);
		$this->a_output['response_message'] = $s_html ;
		$this->a_output['response_field'] = $s_item ;
		$this->a_output['response_value'] = $s_value==1 ? 0 : 1 ;
		$this->a_output['response_code'] = 0 ;

		// output
		$this->view();
    }

    private function view(){
    	// output
		echo json_encode($this->a_output);
		exit ;
    }
}
?>