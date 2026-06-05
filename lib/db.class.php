<?php

class Mysql extends Starter{

	public $feed ;
	public $configs;
	public $i_lang;
	public $a_lexique = array();
	private $mysql_db ;
	
	public function __construct($mysql_host, $mysql_login, $mysql_pwd, $mysql_db, $mysql_port, $mysql_encode = 'utf8', $dbtype = 'mysql')
	{
		$this->feed = null;
		try{
            $this->feed = new PDO($dbtype.":host=" . $mysql_host . ";port=" . $mysql_port . ";dbname=" . $mysql_db, $mysql_login, $mysql_pwd);
            $this->feed->exec("set names " . $mysql_encode);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
	}
	public function prepare_query($s_query, $a_values = array(),$s_type = 'single', $_field = '', $aquery= array())
	{
		global $starter;
		$_logvars = '';

		if(count($aquery) > 0){
			$s_query = $aquery['request'];
			$s_query.=' (';
			$s_query.=implode(',',$aquery['fields']);
			$s_query.=')';
			$s_query.=' values(';
			$s_query.=implode(',',$aquery['values']);
			$s_query.=')';	
		}
		$preparedQuery = $this->feed->prepare($s_query);
		if(!empty($a_values) && count($a_values) > 0)
			foreach($a_values as $key => $val){
				$_logvars .= ' ' . $key . ' : ' . $val[0] . '<br>';
				$preparedQuery->bindValue(':' . $key, $val[0], $val[1]);
			}
		$preparedQuery->execute() or exit(print_r($preparedQuery->errorInfo()));
		if(isset($_SESSION['user_info']) && isset($starter->log) && $starter->log)
		{
			if(preg_match('#UPDATE#',$s_query) || preg_match('#DELETE#',$s_query) || preg_match('#INSERT#',$s_query))
				$starter->utils->logGenerator($s_query, $_logvars);
		}
		if($s_type == 'single')
			$result = $preparedQuery->fetch(PDO::FETCH_ASSOC);
		else{
			$_result = $preparedQuery->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($_field))
			{
				if(count($_result) > 0)
					foreach($_result as $key => $val)
						$result[$val[$_field]] = $val;
				else
					$result = $_result; 
			}
			else
				$result = $_result; 
		}
		return $result;
	}

	public function request_id()
	{
		$result = $this->feed->lastInsertId();
		return $result;
	}

	public function setReferer($sConfig, $s_referer = "", $query = '', $a_data = array())
	{
		preg_match_all('/_[0-9]{1,}/', $s_referer, $matches);


		if(count($matches[0]) > 0)
			$s_referer = preg_replace('/_[0-9]{1,}/','', $s_referer . '_') . (intval(substr(array_pop($matches[0]),1)) + 1);
		else 
			$s_referer .= "_1";

		$a_data['detail_referer'] = array($s_referer,PDO::PARAM_STR);
		$o_result = $this->prepare_query($s_query, $a_data);

		if($o_result != false) 
			$s_referer = $this->setReferer($sConfig, $s_referer, $query, $a_data);
		
		return $s_referer;
	}
	
	public function sort_table($s_page, $s_config, $s_module, $s_case = "", $a_data = array(), $i_current = 0, $i_new = 0)
	{
		global $starter;

		if(empty($s_page))
			$s_page = htmlspecialchars($_GET['page']);
			
		$iSort = false;
		
		if($i_current > $i_new) 
		{
			$iSort = false;
		}
		elseif($i_current < $i_new) 
		{
			$iSort = true;
		}
		$iOrder = 1;
		
		foreach($a_data as $key => $val)
		{
			$_iOrder = $val["_order"];
			if($s_case == "sortcomplexe")
			{
				$_iOrder = $iOrder;
				if($iSort)
				{
					if($iOrder <= $i_new && $iOrder > $i_current)
						$_iOrder = $iOrder - 1;
					else if($iOrder == $i_current)
						$_iOrder = $i_new;
				}
				else
				{
					if($iOrder >= $i_new && $iOrder < $i_current)
						$_iOrder = $iOrder + 1;
					else if($iOrder == $i_current)
						$_iOrder = $i_new;
				}
				$a_data_query = array(
					'order' => array($_iOrder, PDO::PARAM_INT),
					'cle' => array(intval($val[$starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle']]), PDO::PARAM_INT),
				);
				$s_query = "
					UPDATE " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['table'] . " 
					SET _order = :order
					WHERE " .$starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle'] . " = :cle";
				
				$this->prepare_query($s_query, $a_data_query);
				$iOrder++;
								
			}
			else if($s_case == "delete")
			{
				$a_data_query = array(
					'order' => array($iOrder, PDO::PARAM_INT),
					'cle' => array(intval($val[$starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle']]), PDO::PARAM_INT),
				);
				$s_query = "
					UPDATE " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['table'] . " 
					SET _order = :order
					WHERE " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle'] . " = :cle";

				$this->prepare_query($s_query, $a_data_query);
				$iOrder++;
				
			}
			else
			{
				if($s_case == "sort")
				{
					if($iOrder == $i_new) $_iOrder = $i_current;
					elseif($iOrder == $i_current) $_iOrder = $i_new;
				}
				
				if(intval($val[$starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle']]) != (isset($_GET['val_id']) ? htmlspecialchars($_GET['val_id']) : $_POST['val_id']) || $s_case == "sort" ) {
					$a_data_query = array(
						'order' => array($_iOrder, PDO::PARAM_INT),
						'cle' => array(intval($val[$starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle']]), PDO::PARAM_INT),
					);
					$s_query = "
						UPDATE " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['table'] . " 
						SET _order = :order
						WHERE " . $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]['cle'] . " = :cle";

					$this->prepare_query($s_query, $a_data_query);
					$iOrder++;
				}
			}
		}			
	}
		
	function add_lexique($s_translate = '', $b_type = 0, $b_page = 0)
	{
		if(!empty($s_translate))
		{
			// if($b_page == 1){
			// 	$_s_referer = (!empty($starter->s_level4) ? $starter->s_level4 : (!empty($starter->s_level3) ? $starter->s_level3 : (!empty($starter->s_level2) ? $starter->s_level2 : (!empty($starter->s_level1) ? $starter->s_level1 : ''))));

			// 	$a_data_query = array(
			// 		'referer' => array($_s_referer,PDO::PARAM_STR)
			// 	);
			// 	$s_query = "
			// 		SELECT detail_tree
			// 		FROM tree_detail 
			// 		WHERE detail_referer = :referer";
			// 	$_tmpReferer = $this->prepare_query($s_query,$a_data_query);
			// }
			$a_data_query = array(
				'label' => array(addslashes($s_translate),PDO::PARAM_STR),
				'type' => array(($b_type),PDO::PARAM_INT), 
			);
			if($b_page != 0){
				$a_data_query['page'] = array($b_page,PDO::PARAM_INT);
			}

			$s_query = "
				SELECT * 
				FROM translation 
				WHERE archive = 0
				AND translation_label = :label
				AND translation_type = :type";
			if($b_page != 0)
				$s_query .= "
					AND translation_page = :page";

			$_tmp = $this->prepare_query($s_query,$a_data_query);

			if(!$_tmp)
			{
				$a_data_query = array(
					'label' => array(addslashes($s_translate),PDO::PARAM_STR),
					'type' => array(($b_type),PDO::PARAM_INT), 
				);		
				if($b_page != 0){
					$a_data_query['page'] = array($b_page,PDO::PARAM_INT);
				}
				$a_query = array(
					"request"		=> "INSERT INTO translation",
					"fields"		=> array('translation_label', 'archive', 'online', 'translation_type'),
					"values"		=> array(':label', 0, 1, ':type')					
				);
				$s_query = "
					INSERT INTO translation
					SET translation_label = :label,
					archive = 0,
					online = 1, 
					translation_type = :type";
				if($b_page != 0){
					$s_query .= "
						, translation_page = :page";
					$a_query["fields"][] = 'translation_page';
					$a_query["values"][] = ':page';
				}

				$this->prepare_query($s_query,$a_data_query,'','',$a_query);
	
				$_id = $this->request_id();
				
				$s_query = "
					SELECT * 
					FROM langs 
					WHERE online = 1";
				
				$_tmp = $this->prepare_query($s_query, array(), 'multiple', 'lang_id');
				if($_tmp != false)
					foreach($_tmp as $_key => $lang)
					{
						$a_data_query = array(
							'label' => array(addslashes($s_translate),PDO::PARAM_STR),
							'translation' => array($_id,PDO::PARAM_INT), 
							'lang' => array($lang['lang_id'],PDO::PARAM_INT), 
						);
						$a_query = array(
							"request"		=> "INSERT INTO translation_detail",
							"fields"		=> array('translate_label', 'translate_translation', 'lang'),
							"values"		=> array(':label', ':translation', ':lang')					
						);
						$s_query = "
							INSERT INTO translation_detail
							SET translate_label = :label,
							translate_translation = :translation,
							lang = :lang";
						$this->prepare_query($s_query, $a_data_query, '', '',$a_query);
					}
			}
		}
		$this->set_lexique($this->i_lang);
	}	
	
	public function get_lexique($s_translate, $b_type = 2, $b_page = 0)
	{	
		global $starter;
		$_s_translate = mb_strtolower(strip_tags($s_translate));

		if($b_page == 1){
			$_s_referer = (!empty($starter->s_level4) ? $starter->s_level4 : (!empty($starter->s_level3) ? $starter->s_level3 : (!empty($starter->s_level2) ? $starter->s_level2 : (!empty($starter->s_level1) ? $starter->s_level1 : ''))));
			$a_data_query = array(
				'referer' => array($_s_referer,PDO::PARAM_STR)
			);
			$s_query = "
				SELECT detail_tree
				FROM tree_detail 
				WHERE detail_referer = :referer";
			$_tmpReferer = $this->prepare_query($s_query,$a_data_query);
		}
		
		$b_page = (isset($_tmpReferer) ? $_tmpReferer['detail_tree'] : '0');
		
		if(isset($this->a_lexique[$b_type][$b_page][$_s_translate]))
			return $this->a_lexique[$b_type][$b_page][$_s_translate]['translate_label'];
		else 
		{
			$this->add_lexique($_s_translate, $b_type, $b_page);
			return $s_translate;
		}
	}
	public function set_lexique($i_lang){

		$this->i_lang = $i_lang;
		
		$a_data_query = array(
			'lang' => array(($i_lang),PDO::PARAM_INT),
		);		

		$s_query = "
			SELECT LOWER(t0.translation_label) AS label, t1.translate_label, translation_type, translation_page
			FROM translation AS t0
			INNER JOIN translation_detail AS t1
			ON t1.translate_translation = t0.translation_id
			WHERE archive  = 0 
			AND t1.lang = :lang";
		$_tmp = $this->prepare_query($s_query,$a_data_query, 'multiple');
		
		if($_tmp != 0)
			foreach($_tmp as $key => $val)
			{
				$this->a_lexique[$val['translation_type']][$val['translation_page']][$val['label']] = $val;
			}

	}
}
?>
