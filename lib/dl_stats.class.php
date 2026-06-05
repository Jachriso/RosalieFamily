<?php

class dl_stats{

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
			'download_date' => array($date_start,PDO::PARAM_STR),
			'download_date_' => array($date_end,PDO::PARAM_STR),
			'lang' => array($starter->i_lang,PDO::PARAM_INT),
		);

		$s_query = "
			SELECT t3.download_id, download_label
			FROM cms_stats_downloads AS t0
			INNER JOIN admin_users AS t1
			ON t1.user_id = t0.download_user
			INNER JOIN cms_download AS t3
			on t3.download_id = t0.download_item
			INNER JOIN cms_download_detail AS t4
			ON t4.detail_download = t3.download_id
			WHERE t0.download_date >= :download_date
			AND t0.download_date <= :download_date_
			AND t4.lang = :lang
			AND t3.online = 1
			AND t3.archive = 0
			ORDER BY download_label ASC";

		if($starter->isApi ){
			$_data = array();
			$_data['download_date'] = $date_start;
			$_data['download_date_'] = $date_end;
			$_data['lang'] = $starter->i_lang;
			
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Stats&rquest=getDownloads', $_data);
			$_tmp = $curlApiRequest ;
		}else{
			$_tmp = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');
		}
		
		if($_tmp != false)
			foreach($_tmp as $item => $val)
			{
				if(!is_array($val))
					$val = (array)$val;
				$this->output['name'] = 'user' ;
				//$this->output[$val['group_id']]['tree_level'] = $val['tree_level'] ;
				//$this->output[$val['group_id']]['tree_parent'] = $val['tree_parent'] ;
				$this->output['stat'][$val['download_id']]['name'] = $val['download_label'];

				if(isset($this->output['stat'][$val['download_id']]['stats']))
					$this->output['stat'][$val['download_id']]['stats'] += 1;
				else
					$this->output['stat'][$val['download_id']]['stats'] = 1;

				if(isset($this->output['stat-total']))
					$this->output['stat-total'] += 1;
				else
					$this->output['stat-total'] = 1;

				if(isset($total['groups']))
					$total['groups'] += 1;
				else
					$total['groups'] = 1;

				if(isset($total['total']))
					$total['total'] += 1;
				else
					$total['total'] = 1;				
			}
		
		return $this->output ;
	}
		
	/* end of class */
}?>