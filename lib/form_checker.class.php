<?php
class form_checker
{
	var $a_errors = array();
	var $a_query_items = array();

	public function __construct($_a_fields = array())
	{
		global $starter, $s_module, $s_config;

		$_is_error = false ;

		foreach($_a_fields as $key => $val)
		{
			$_is_error = false ;

			if(isset($_POST[$key]) && (!isset($val['type']) || (isset($val['type']) && $val['type'] != "tiny_mce")))
			{
				if(!is_array($_POST[$key])){
					$_POST[$key] = trim($_POST[$key]);
					$_POST[$key] = strip_tags($_POST[$key]);
				}
			}
			elseif(isset($_POST[$key]) && isset($val['type']) && $val['type'] == "tiny_mce")
			{
				$_POST[$key] = trim($_POST[$key]);
			}
			elseif(isset($_POST[$key]))
			{
				if(is_array($_POST[$key])){
					$_POST[$key] = array_map("trim", $_POST[$key]);
					$_POST[$key] = array_map("strip_tags", $_POST[$key]);
				}
				else{
					$_POST[$key] = "";
				}
			}
			if(isset($val['verif']) && is_array($val['verif']) && ($val['verif'][0] == "mandatory" || $val['verif'][0] == "verify"))
			{
				// empty field ?);
				if((!isset($_POST[$key]) || $_POST[$key] == "" || (isset($val['minlength']) && strlen($_POST[$key]) < $val['minlength']) || (isset($val['maxlength']) && strlen($_POST[$key]) > $val['maxlength']) || (is_array($_POST[$key]) && count($_POST[$key]) == 0) || (isset($val['default_value']) && $_POST[$key] == $val['default_value']) || (isset($val['error_label']) && $_POST[$key] == $val['error_label'])) && $val['verif'][0] == "mandatory" )
				{
					$_is_error = true ;
				}
				// preg_match rule ?
				else if(isset($val['preg_mode']))
				{
					switch($val['preg_mode'])
					{
						case 'preg_pattern_all':
							preg_match_all($val['preg_pattern'],$_POST[$key], $matches, PREG_OFFSET_CAPTURE);
							if(count($matches[0]) == 0 || count($matches[0]) > 20)
							{
								$_is_error = true ;
							}
							foreach ($matches[0] as $item => $value)
							{
								$_a_tmp_POST[] = $value[0];
							}
							$_POST[$key] = implode(';',$_a_tmp_POST);
						break;
					}
				}
				else if(isset($val['preg_pattern']) && !preg_match($val['preg_pattern'], $_POST[$key]))
				{
					$_is_error = true ;
				}
				else if( isset($val['minLength']) && strlen($_POST[$key]) < $val['minLength'] )
				{
					$_is_error = true;
					if(isset($val['error_label_minLength']))
						$val['error_label'] = $val['error_label_minLength'];
				}
				// specific rule ?

				if(isset($val['check_method']) && !$_is_error && !empty($_POST[$key]))
				{
					switch($val['check_method'])
					{
						case "match" :
							$_is_error = $_POST[$key] != $_POST[$val['check_option']] ;
						break;

						case 'zxcvbn' :
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/MatchInterface.php';
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/Match.php';
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/Bruteforce.php';
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/YearMatch.php';
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/SpatialMatch.php';
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/SequenceMatch.php';
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/RepeatMatch.php';										
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/DictionaryMatch.php';		
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/ReverseDictionaryMatch.php';	
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/L33tMatch.php';	
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matchers/DateMatch.php';	
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Matcher.php';	
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Feedback.php';	
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Scorer.php';	
							require dirname( __FILE__ ) . '/ZxcvbnPhp/TimeEstimator.php';
							require dirname( __FILE__ ) . '/ZxcvbnPhp/Zxcvbn.php';
							$zxcvbn = new ZxcvbnPhp\Zxcvbn();
							$zxcvbnscore = $zxcvbn->passwordStrength($_POST[$key]);
							if(in_array('notempty',$val['verif'])){
								$_is_error = !empty($_POST[$key]) && $zxcvbnscore['score'] < 3 ;
							}
							else{
								$_is_error = $zxcvbnscore['score'] < 3 ;
							}

						break;

						case 'already' :
							$a_data_query = array(
								'field' => array($_POST[$key], PDO::PARAM_STR),
								'key' => array( (isset($_GET['page']) && isset($_POST[$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['cle']]) ? $_POST[$starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['cle']] : (isset($_GET['val_id']) ? $_GET['val_id'] : (isset($_SESSION['user_info']) ? $_SESSION['user_info']['user_id'] : 0))), PDO::PARAM_INT),
							);
							$s_query = "
								SELECT COUNT(*) AS count
								FROM " . (isset($val['check_data']['table']) ? $val['check_data']['table'] : $starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['table']) . " 
								WHERE " . (isset($val['db_field']) ? $val['db_field'] : $val['champ'] ) . " = :field 
								AND " . (isset($val['check_data']['key']) ? $val['check_data']['key'] : (isset($_GET['page']) && isset($starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['cle']) ? $starter->database->configs[$_GET['page']]['content'][$s_module]['content'][$s_config]['cle'] : 0)) . " != :key";
					
							if($starter->archiv)
								$s_query .= " AND archive = 0";

							if($starter->isApi ){
								$_data = array();
								$_data['squery'] = $s_query;
								$_data['data'] = json_encode($a_data_query);
								$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
								$_tmp = $curlApiRequest ;
							}else{
								$_tmp = $starter->database->prepare_query($s_query, $a_data_query) ;
							}

							if($_tmp['count'] >= 1)
								$_is_error = 1;
							
							if(isset($val['error_label_' . $val['check_method']]))
								$val['error_label'] = $val['error_label_' . $val['check_method']];
						break;
						
						case 'exist' :
							$a_data_query = array(
								'field' => array($_POST[$key], PDO::PARAM_STR),
							);
							$s_query = "
								SELECT COUNT(*) 
								FROM " . (isset($val['check_data']['table']) ? $val['check_data']['table'] : $a_config[$s_config]['table']) . " 
								WHERE " . (isset($val['db_field']) ? $val['db_field'] : $val['champ'] ) . " = :field" ;
							if($starter->isApi ){
								$_data = array();
								$_data['squery'] = $s_query;
								$_data['data'] = json_encode($a_data_query);
								$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
								$_tmp = $curlApiRequest ;
							}else{
								$_tmp = $starter->database->prepare_query($s_query, $a_data_query) ;
							}
							if(!$_tmp)
								$_is_error = 1;

							if(isset($val['error_label_' . $val['check_method']]))
								$val['error_label'] = $val['error_label_' . $val['check_method']];

						break;
					}
				}
			}
			else if(isset($val['required_complex']))
			{
				switch($val['required_complex'])
				{
					case 'date' :
						$_a_data = array();
						$_a_data['year'] 	= isset($_POST[$key . '_year']) && intval($_POST[$key . '_year']) > 0 ? $_POST[$key . '_year'] : '0000' ;
						$_a_data['month'] 	= isset($_POST[$key . '_month']) && intval($_POST[$key . '_month']) > 0 ? $_POST[$key . '_month'] : '00' ;
						$_a_data['day'] 	= isset($_POST[$key . '_day']) && intval($_POST[$key . '_day']) > 0 ? $_POST[$key . '_day'] : '00' ;
						foreach($_a_data as $_k => $_v)
						{
							$_is_error = intval($_v) == 0 && isset($val['verif']) && is_array($val['verif']) && $val['verif'][0] == "mandatory";
							if(strlen($_v) < 2) $_a_data[$_k] = '0' . $_v ;
						}
						$_POST[$key] = implode('-', $_a_data);
					break;
				}
			}

			// check errors
			if($_is_error)
			{
				$this->a_errors[$key] = (isset($val['error_label']) ? $val['error_label'] : 'error') ;
				$_a_fields[$key]['error'] = true;
			}
			else
			{
				$_a_fields[$key]['success'] 	= true;
			}
		}
		

		/*
		if(count($this->a_errors) == 0)
		{
			foreach($_a_fields as $key => $val)
			{
				if(isset($val['db_field']))
				{
					$this->a_query_items[] = $val['db_field'] . " = '" . (strip_tags($_POST[$key])) . "'" ;
				}
			}
		}*/
	}
	/* end of class */
}
?>
