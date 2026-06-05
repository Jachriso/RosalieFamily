<?php

class logs_stats{

	public $output = array();

	public $type = 'line';
	
	public 		function __construct($date_start='', $date_end =''){
		$this->_run($date_start, $date_end);
	}	
		
	/**************************************************************************************************
	*	getTraficStats : HUB 
	*	input : ID du sous-site (INT)
	*	output : variable de classe "menu" (ARRAY)
	**************************************************************************************************/
	public 		function _run($date_start='', $date_end ='')
	{
		global $starter ;
		$total = array();
		$a_data_query = array(
			'log_date' => array($date_start,PDO::PARAM_STR),
			'log_date_' => array($date_end,PDO::PARAM_STR),
		);

		$s_query = "
			SELECT COUNT(t0.log_id) AS trafic_stat, substr(log_date,1,10) AS log_date
			FROM logs AS t0
			INNER JOIN admin_users AS t1
			ON t1.user_id = t0.log_user
			WHERE t0.log_date >= :log_date
			AND t0.log_date <= :log_date_
			GROUP BY substr(log_date,1,10)";

		if($starter->isApi ){
			$_data = array();
			$_data['log_date'] = $date_start;
			$_data['log_date_'] = $date_end;
			
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Stats&rquest=getLogs', $_data);
			$_tmp = $curlApiRequest ;
		}else{
			$_tmp = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');
		}
		foreach($_tmp as $key => $val)
		{
			if(!is_array($val))
				$val = (array)$val;
			$this->output['name'] = 'user';
			$this->output['stat'][] = array(
				'date' => $val['log_date'],
				'stats' => $val['trafic_stat']
			);
			$this->output['stat-total'] = (isset($this->output['stat-total']) ? $this->output['stat-total'] + intval($val['trafic_stat']) : intval($val['trafic_stat']));

			/*if(isset($total['groups'][$val['group_id']]))
				$total['groups'][$val['group_id']] += $val['trafic_stat'];
			else
				$total['groups'][$val['group_id']] = $val['trafic_stat'];

			if(isset($total['total']))
				$total['total'] += $val['trafic_stat'];
			else
				$total['total'] = $val['trafic_stat'];*/
		}

					
		//$this->output['total'] = $total;
		return $this->output ;
	}
		
	/* end of class */
}?>