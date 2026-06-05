<?php 
class Working extends Starter
{
    private $s_form_switch = "";
    public $b_bu;

	function __construct() {
        $this->initVars();
    }

    private function initVars()
    {
    	global $starter;
    	$this->s_form_switch = (isset($_GET['switch']) ? htmlentities($_GET['switch']) : '');

    	if($starter->isApi )
			$this->requestApiContent();
		else
			$this->requestContent();

    }

    private function requestApiContent()
    {
    	global $starter;

    	$_data = array();
		$_data['switch'] = $this->s_form_switch;
		
		if(isset($_SESSION['user_info']) && $_SESSION['user_info']['user_statut'] == 0 && $this->s_form_switch != ''){
			// CRL code
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Working&rquest=working', $_data);
			$this->b_bu = $this->s_form_switch;
		}else{
			// CRL code
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Working&rquest=workout', $_data, 'GET');
			$this->b_bu = $curlApiRequest;
		}

		if($this->b_bu == '') 
			$this->b_bu = 0;

		if($this->b_bu == 0 && (!isset($_SESSION['user_info']) || $_SESSION['user_info']['user_statut'] != 0)) 
		{
			$starter->s_level1 = 'switchoff';
		}
    }

    private function requestContent()
    {
    	global $starter;

		if($starter->database->feed != '' && $starter->database->feed != null )
		{
			if(isset($_SESSION['user_info']) && $_SESSION['user_info']['user_statut'] == 0 && $this->s_form_switch != ''){

				$a_data_query = array(
					'switch' => array($this->s_form_switch,PDO::PARAM_BOOL),
				);		

				$s_query = "
					UPDATE switch
					SET switch = :switch";
				$_tmp = $starter->database->prepare_query($s_query, $a_data_query);

				$this->b_bu = $this->s_form_switch;

			}else{
				$s_query = "
					SELECT switch 
					FROM switch
				";
				$this->b_bu = $starter->database->prepare_query($s_query);
				$this->b_bu = $this->b_bu['switch'];
			}

			if($this->b_bu == '') 
				$this->b_bu = 0;

			if($this->b_bu == 0 && (!isset($_SESSION['user_info']) || $_SESSION['user_info']['user_statut'] != 0)) 
			{
				$starter->s_level1 = 'switchoff';
			}
		}
		
    }
}
?>