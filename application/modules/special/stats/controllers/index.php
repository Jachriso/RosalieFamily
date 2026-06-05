<?php
//init vars

if(isset($_SESSION['user_info']) && ((isset($_SESSION['stats_info']['current']) && $_SESSION['stats_info']['current'] != $_SERVER['REQUEST_URI']) || !isset($_SESSION['stats_info']['current'])))
{
	$_SESSION['stats_info']['current'] = $_SERVER['REQUEST_URI'];

	foreach($menu->current as $key => $val)
	{
		
		$_i_tree_id = (isset($val['tree_id']) ? $val['tree_id'] : '');

		if(!empty($_i_tree_id))
		{	
			$a_data_query = array(
				'stat_tree_user' => array(intval($_SESSION['user_info']['user_id']),PDO::PARAM_INT),
				'stat_tree_page' => array(intval($_i_tree_id),PDO::PARAM_INT),
				'stat_tree_date' => array(date("Y-m-d h:i:s"),PDO::PARAM_STR),
			);
			$s_query = "
				INSERT INTO stats_tree
				SET stat_tree_user = :stat_tree_user,
				stat_tree_page = :stat_tree_page,
				stat_tree_date = :stat_tree_date";

			$a_query = array(
				"request"		=> "INSERT INTO stats_tree",
				"fields"		=> array('stat_tree_user', 'stat_tree_page', 'stat_tree_date'),
				"values"		=> array(':stat_tree_user', ':stat_tree_page', ':stat_tree_date')
			);

			if($starter->utils->is__countable($menu->breadcrumbTree) && $starter->utils->is__countable($menu->breadcrumb) && count($menu->breadcrumbTree) != count($menu->breadcrumb) && !empty($starter->s_level2)){
				$a_data_query['stat_tree_referer'] = array($starter->s_level2,PDO::PARAM_STR);
				$s_query .= ",stat_tree_referer = :stat_tree_referer";	
			}

			if($starter->isApi ){
				$_data = array();
				$_data['squery'] = $s_query;
				$_data['data'] = json_encode(array());
				
				$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=insertData', $_data);
				$o_result = $curlApiRequest ;
			}else{
				$o_result = $starter->database->prepare_query($s_query,$a_data_query, '', '', $a_query);
			}
		}
	}
}
?>