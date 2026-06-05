<?php 
class DispatchController extends Starter
{
	function __construct() {
    }

    public function getCustomers()
    {
    	global $starter;

    	if($starter->isApi ){
	    	$_data = array();

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Dispatch&rquest=getCustomers', $_data);

			$a_data = $curlApiRequest;
		}else{
			$a_data_query = array();

			$s_query = "
				SELECT user_customers
				FROM cms_users
				WHERE user_id = 1";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query);
		}

		return $a_data;
    }
}
?>