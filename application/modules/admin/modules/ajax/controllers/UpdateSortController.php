<?php 
class UpdateSort extends Starter
{
	private $a_output = array();

	function __construct() {
        $this->init();
    }

    private function init(){
    	// init vars
		$s_config = $_POST['s_config'];
		$s_module = $_POST['module'];
		$s_page = $_POST['page'];
		$config = $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config];

		$aData = sortComplexeContent($config);

		$i_current = intval($aData[$_POST['val_id']]["_order"]);
		$i_new = $_POST['i_pos'] + 1;

		$starter->database->sort_table( $s_page, $s_config, $s_module, 'sortcomplexe', $aData, $i_current, $i_new);

		$s_html =  'success';
		$this->a_output['response_message'] = $s_html ;
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