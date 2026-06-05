<?php

class tree_stats{

	public $output = array();

	public $type = 'stackedBar';
	
	public 		function __construct($date_start='', $date_end =''){
		$this->_run($date_start, $date_end);
	}	
	
	/**************************************************************************************************
	*	getTreeStats : HUB 
	*	input : ID du sous-site (INT)
	*	output : variable de classe "menu" (ARRAY)
	**************************************************************************************************/
	public 		function _run( $date_start='', $date_end ='', $i_level = 1, $i_id = 0, $i_tree_id = 0)
	{
		global $starter ;
		$total = array();
		
		$a_data_query = array(
			'stat_tree_date' => array($date_start . " 00:00:00",PDO::PARAM_STR),
			'stat_tree_date_' => array($date_end . " 00:00:00",PDO::PARAM_STR),
			'lang' => array($starter->i_lang,PDO::PARAM_INT),
		);

		$s_query = "
			SELECT t0.stat_tree_page AS tree_stat, tree_label, tree_level, tree_parent
			FROM stats_tree AS t0
			INNER JOIN admin_users AS t1
			ON t1.user_id = t0.stat_tree_user
			INNER JOIN tree AS t3
			on t3.tree_id = t0.stat_tree_page
			INNER JOIN tree_detail AS t4
			ON t4.detail_tree = t3.tree_id
			WHERE t0.stat_tree_date >= :stat_tree_date
			AND t0.stat_tree_date <= :stat_tree_date_
			AND t4.lang = :lang
			AND t3.online = 1
			AND t3.archive = 0
			AND t0.stat_tree_referer IS NULL
			ORDER BY tree_level DESC, tree_stat DESC";

		if($starter->isApi ){
			$_data = array();
			$_data['stat_tree_date'] = $date_start . " 00:00:00";
			$_data['stat_tree_date_'] = $date_end . " 00:00:00";
			$_data['lang'] = $starter->i_lang;
			
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Stats&rquest=getTree', $_data);
			$_tmp = $curlApiRequest ;
		}else{
			$_tmp = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');
		}

		if($_tmp != false)
			foreach($_tmp as $item => $val)
			{
				if(!is_array($val))
					$val = (array)$val;
				//$this->output[$val['group_id']]['name'] = $val['group_name'] ;
				//$this->output[$val['group_id']]['tree_level'] = $val['tree_level'] ;
				//$this->output[$val['group_id']]['tree_parent'] = $val['tree_parent'] ;
				$this->output['stat'][$val['tree_stat']]['name'] = $val['tree_label'];

				if(isset($this->output['stat'][$val['tree_stat']]['stats']))
					$this->output['stat'][$val['tree_stat']]['stats'] += 1;
				else
					$this->output['stat'][$val['tree_stat']]['stats'] = 1;

				if(isset($this->output['stat-total']))
					$this->output['stat-total'] += 1;
				else
					$this->output['stat-total'] = 1;

				/*if(isset($total['groups']))
					$total['groups'] += 1;
				else
					$total['groups']= 1;

				if(isset($total['total']))
					$total['total'] += 1;
				else
					$total['total'] = 1;*/
				
			}
		/*if(count($this->output) > 0)
		{
			foreach($this->output as $item => $val)
			{				
				if($val['tree_level'] != 1){
					if(!isset($this->output[$val['tree_parent']]['children'][$item]))
						$this->output[$val['tree_parent']]['children'][] = $this->output[$item];
					unset($this->output[$item]);
				}
			}
			$this->output = array_reverse($this->output);
			$this->output['total'] = $total;
		}*/
		return $this->output ;
	}
		
	/* end of class */
}?>