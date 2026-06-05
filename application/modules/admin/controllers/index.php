<?php
$o_conf = (isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]) ? $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config] : '');
$i_conf = (isset($starter->database->configs[$s_form_page]['content'][$s_module]['id']) ? $starter->database->configs[$s_form_page]['content'][$s_module]['id'] : '');

// init vars
$i_level = (isset($menu->current[5]) && isset($starter->s_level5) && !empty($starter->s_level5) ? '5' : (isset($menu->current[4]) && isset($starter->s_level4) && !empty($starter->s_level4) ? '4' : (isset($menu->current[3]) && isset($starter->s_level3) && !empty($starter->s_level3) ? '3' : (isset($menu->current[2]) && isset($starter->s_level2) && !empty($starter->s_level2) ? '2' : '1'))));
$s_level = (isset($menu->current[5]) && isset($starter->s_level5) && !empty($starter->s_level5) ? $starter->s_level5 : (isset($menu->current[4]) && isset($starter->s_level4) && !empty($starter->s_level4) ? $starter->s_level4 : (isset($menu->current[3]) && isset($starter->s_level3) && !empty($starter->s_level3) ? $starter->s_level3 : (isset($menu->current[2]) && isset($starter->s_level2) && !empty($starter->s_level2) ? $starter->s_level2 : $starter->s_level1))));

if(!empty($s_form_nav)) 
	$a_open_menu = explode(',', $s_form_nav);

if($_SESSION['user_info']['user_statut'] != "0" && !empty($s_module)) 
	$_currentConf = (!is_array($a_config_rules) ? $a_config_rules->$s_module : $a_config_rules[$s_module]);

$s_engine = ($s_addon!="default" ? $s_addon : $s_action);

if($starter->s_level1 != "plugins" &&((!isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]) && !isset($s_module) && !isset($s_config)) ||(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]) && $s_addon != $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon']) || ($_SESSION['user_info']['user_statut'] != "0" && ((!empty($s_form_page) &&!in_array($s_form_page,$a_config_page)) || (is_array($_currentRules) && !isset($_currentRules[$s_config]) && $s_config != '') || (!is_array($_currentRules) && !isset($_currentRules->$s_config) && $s_config != '') || (!empty($s_action) && $s_action != 'list' && ((!is_array($_currentRules) && isset($_currentRules->$s_config) && !in_array($s_action ,$_currentRules->$s_config)) || (is_array($_currentRules) && isset($_currentRules[$s_config]) && !in_array($s_action ,$_currentRules[$s_config])))))))) 
{
	header('Location:' . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . 'admin');
	exit();
}

require_once APPLICATION_PATH . '/controllers/!locked/AuthController.php' ;
$auth = new AuthController();
$auth->getAuth();

require_once APPLICATION_PATH . '/controllers/!locked/MenuController.php' ;
$menu = new MenuController();

switch($s_action){
	
	default:
		require_once APPLICATION_PATH . '/modules/admin/modules/home/controllers/index.php';
	break;
	
	case 'ajax':
	case 'preview':
		require_once APPLICATION_PATH . '/modules/admin/modules/' . $s_action . '/controllers/index.php';
	break;
	
	case 'list':
		if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']) && function_exists($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']))
		{
			call_user_func($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']);
			$o_conf = (isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]) ? $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config] : '');
		}
		switch($s_addon){
	
			case 'cache':
			case 'stats':
				require_once APPLICATION_PATH . '/modules/admin/modules/special/' . $s_addon . '/controllers/index.php';
			break;
			
			default :
			case 'bloc_home':
			case 'special_grid':
				
				$_base_order_link = array();
				$base_order_link = '';
				foreach($_GET as $param => $value)
				{
					if($param != 'lang' && $param != 'level1' && $param != 'level2' && $param != 'level3' && $param != 'level4' && $param != 'level5' && $param != 'sort' && $param != 'isort' )
					{
						$_base_order_link[$param] = htmlentities($value);
						$base_order_link .= '&' . $param . '=' . htmlentities($value);
					}
				}
				
				$_base_order_link_sort = array();
				if(!empty($s_form_sort))
				{
					$_base_order_link_sort = explode(',', $s_form_sort);
				}

				/* LIMIT */
				if(!empty($o_conf['more_actions']) && in_array('nav',$o_conf['more_actions']))
				{
					if(!empty($s_form_navpage))
					{
						$i_pages = intval(substr(($s_form_navpage),5,strlen(($s_form_navpage))));
						if(!is_numeric($i_pages)) $i_pages = 1;
						$i_start = ($i_pages>1 ? $i_pages -1 : $i_pages) * $i_range;
					}
					$s_query_limit = "
						LIMIT " . $i_start . "," . $i_range;
				}
				
				/* ORDER BY */
				if(!empty($s_form_sort)){
					$s_sort = $s_form_sort . " " . $s_form_isort;
				}else if(isset($o_conf['tri']) && !empty($o_conf['tri'])){
					$s_sort = $o_conf['tri'];				
				}else{
					$s_sort = $o_conf['cle'];
				}
				$s_query_order = " 
					ORDER BY " . $s_sort ;

				$s_query = $starter->_make_query($o_conf, addslashes($s_search), $s_query_order, $i_conf, "SELECT");

				if(!empty($o_conf['more_actions']) && in_array('nav',$o_conf['more_actions']))
				{
					$s_query_total = $s_query;
					$s_query .= $s_query_limit;
				}
				$a_data_query = array();
				if($starter->isApi ){
					$_data = array();
					$_data['squery'] = $s_query;
					$_data['data'] = json_encode($a_data_query);

					$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
					$aData = $curlApiRequest ;
				}else{
					$aData = $starter->database->prepare_query($s_query, $a_data_query, 'multiple');
				}
				if(isset($o_conf['optim_search']) && !empty($o_conf['optim_search'])){
					
					$_tmp_optim_GET = '';
					foreach($o_conf['optim_search'] as $optim => $optim_val)
					{
						$aData_optim = array();
						if($optim_val['type'] == 'field_list')
						{
							if(isset($optim_val['data']))
							{
								$aData_optim = $optim_val['data'];
							}
							else
							{
								$s_query = "
									SELECT " . $optim_val['champ_link'] . ", " . $optim_val['cle_link'] . "
								  	FROM " . $optim_val['table_link'];
								  
								if(isset($optim_val['condition_link']) && !empty($optim_val['condition_link'])) 
									$s_query .= " WHERE " . implode(' AND ', $optim_val['condition_link']);
								
								$s_query .= isset($optim_val['sort_link']) && !empty($optim_val['sort_link']) ? " ORDER BY " . $optim_val['sort_link'] : '';
								$a_data_query = array();
								
								if($starter->isApi ){
									$_data = array();
									$_data['squery'] = $s_query;
									$_data['data'] = json_encode($a_data_query);
									
									$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getOptim', $_data);
									$optim_result = $curlApiRequest ;
								}else{
									$optim_result = $starter->database->prepare_query($s_query, $a_data_query, 'multiple');
								}
								
								foreach($optim_result as $key => $val)
									$aData_optim[$val[$optim_val['cle_link']]] = $val[$optim_val['champ_link']];
							}
							$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['optim_search'][$optim_val['champ']]['data'] = $aData_optim;

						}
						$_tmp_optim_GET .= '&' . (isset($_GET[$optim_val['champ']]) ? htmlentities($optim_val['champ']) . '=' . htmlentities($_GET[$optim_val['champ']]) : '');
					}
				}
				
				if(!empty($o_conf['more_actions']) && in_array('nav',$o_conf['more_actions']))
				{
					$a_data_query = array();

					if($starter->isApi ){
						$_data = array();
						$_data['squery'] = $s_query_total;
						$_data['data'] = json_encode($a_data_query);
						
						$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getActions', $_data);
						$result = $curlApiRequest ;
					}else{
						$result = $starter->database->prepare_query($s_query_total, $a_data_query, 'multiple');
					}
					
					$i_total = ($starter->utils->is__countable($result) ? count($result) : 0);
					$i_nb_pages = ceil($i_total / $i_range);
					$s_pagination_nav = $starter->utils->set_nav($i_pages, $i_nb_pages, $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['admin']['referer'] . '/?page=' . $s_form_page . '&config_id=' . $s_config . '&addon=' . $s_addon . '&module=' . $s_module . '&action=' . $s_action . (!empty($s_form_sort) ? '&sort=' . $s_form_sort . (!empty($s_form_isort) ? '&isort=' . $s_form_isort : '') : '') . (!empty($s_search) ? '&search=' . $s_search : '') . (isset($_tmp_optim_GET) ? $_tmp_optim_GET : ''));
				}
				 
				 $starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/css/list.css');

				if($s_addon == 'bloc_home'){					
				    require_once APPLICATION_PATH . '/modules/admin/modules/special/bloc_home/controllers/index.php';
				}
				else
				if($s_addon == 'special_grid'){					
				    require_once APPLICATION_PATH . '/modules/admin/modules/special/special_grid/controllers/index.php';
				}
				else
					$include_page = '/modules/admin/views/list.php'; 
			break;
		
			case 'tree' :

				$aData = $menu->getTree(1, '', true);

				$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/modules/tree/css/main.css?'.$starter->utils->generateRandomString(10));
				
				$starter->a_js[] = array("src"=> '/templates/' . $starter->s_template . '/modules/admin/modules/tree/js/main.js');
				
				$include_page = '/modules/admin/modules/tree/views/index.php' ;
			break;
			
			case 'arbo' :

				/* ORDER BY */
				if(!empty($s_form_sort)){
					$s_sort = $s_form_sort . " " . (!empty($s_form_isort) ? $s_form_isort : '');
				}else if(isset($o_conf['tri']) && !empty($o_conf['tri'])){
					$s_sort = $o_conf['tri'];				
				}else{
					$s_sort = $o_conf['cle'];
				}
				$s_query_order = " 
					ORDER BY " . $s_sort ;

				$s_query = $starter->_make_query($o_conf, addslashes($s_search), $s_query_order, $i_conf, "SELECT");
				
				$a_data_query = array();

				if($starter->isApi ){
					$_data = array();
					$_data['squery'] = $s_query;
					$_data['data'] = json_encode($a_data_query);
					
					$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
					$a_data = $curlApiRequest ;
				}else{
					$a_data = $starter->database->prepare_query($s_query, $a_data_query, 'multiple');
				}

				foreach($a_data as $key => $val)
				{
					if($val[$o_conf['code'] . '_parent'] == 0){
						$aData[$val[$o_conf['cle']]] = $val;
					}
					elseif(isset($aData[$val[$o_conf['code'] . '_parent']]))
						$aData[$val[$o_conf['code'] . '_parent']]['children'][$val[$o_conf['cle']]] = $val;
					else
					{
						$aData[$val[$o_conf['code'] . '_parent']] = array();
						$aData[$val[$o_conf['code'] . '_parent']]['children'][$val[$o_conf['cle']]] = $val;
					}
				}
				$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/modules/tree/css/main.css');
				
				$starter->a_js[] = array("src"=> '/templates/' . $starter->s_template . '/modules/admin/modules/tree/js/main.js');
				
				$include_page = '/modules/admin/views/arbo.php' ;				
			break;
			
		}		
	break;
	
	case 'add':
		if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']) && function_exists($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']))
		{
			call_user_func($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']);
			$o_conf = (isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]) ? $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config] : '');
		}

		if($starter->utils->is__countable($_POST) && count($_POST) > 0)
		{
			require_once LIBRARY_PATH . '/form_checker.class.php' ;
			$starter->checkForm = new form_checker($o_conf['champs']);

			if(($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0 ) )
			{
				$_SESSION['WARNING'] = array(
					'type' => 'error',
					'content' => $starter->checkForm->a_errors
				) ;
			}
			else
			{
				$s_query = $starter->_make_query($o_conf, '', '', $i_conf, "INSERT");
				$a_data_query = array();
				
				if($starter->isApi ){
					$_data = array();
					$_data['squery'] = $s_query;
					$_data['data'] = json_encode($a_data_query);
					
					$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=insertData', $_data);
					$_id = $curlApiRequest[0];
				}else{
					$starter->database->prepare_query($s_query, $a_data_query);
					$_id = $starter->database->request_id();
				}

				if(isset($o_conf['external']) && !empty($o_conf['external']))	{
					foreach($o_conf['external'] as $key)
					{
						$s_query = "
							INSERT INTO " . $key['table'];
						$s_query_set = "
							SET ";

						$a_query = array(
							"request"		=> "INSERT INTO " .  $key['table']
						);
						if(isset($key['languages']))
							foreach($key['languages'] as $element => $languages )
							{
								$a_query["fields"] = array();
								$a_query["values"] = array();
								$iCompt = 0;
								$a_data_query = array(
									'lang' => array($element,PDO::PARAM_INT),
									'key' => array($_id,PDO::PARAM_INT),
								);
								$s_query_advanced = 'lang = :lang, ' . $key['key'] . ' = :key, ';
								$a_query["fields"][] = 'lang';
								$a_query["fields"][] = $key['key'];
								$a_query["values"][] = ':lang';
								$a_query["values"][] = ':key';

								foreach($languages as $item => $value)
								{
									if($value['type'] != "hidden"){
										$a_data_query[$item] = array($_POST[$value['champ']],PDO::PARAM_STR);
										$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . $item . " = :" . $item;
										
										$a_query["fields"][] = $item;
										$a_query["values"][] = ':'.$item;

										if(isset($value['champedit'])){
											$a_data_query[$item . 'edit'] = array(($_POST[$value['champedit']]), PDO::PARAM_STR);
											$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . $item .'edit' . " = :" . $item . 'edit';
											$a_query["fields"][] = $item . 'edit';
											$a_query["values"][] = ':'.$item . 'edit';
										}
										$iCompt ++;
									}
								}
								$_s_query = $s_query . $s_query_set . $s_query_advanced ;
								
								if($starter->isApi ){
									$_data = array();
									$_data['squery'] = $_s_query;
									$_data['data'] = json_encode($a_data_query);
									
									$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=insertData', $_data);
								}else{
									$starter->database->prepare_query($_s_query, $a_data_query, '', '');
								}
							}
						elseif(isset($key['special']))
							foreach($key['special'] as $element => $languages )
							{
								$iCompt = 0;
								$a_data_query = array(
									'specialkey' => array($element,PDO::PARAM_INT),
									'key' => array($_id,PDO::PARAM_INT),
								);
								$s_query_advanced = $special['key'] . ' = :specialkey, ' . $key['key'] . ' = :key, ';
								foreach($languages as $item => $value)
								{
									if($value['type'] != "hidden"){
										$a_data_query[$item] = array($_POST[$value['champ']],PDO::PARAM_STR);
										$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . $item . " = :" . $item;
										$iCompt ++;
									}
								}
								$_s_query = $s_query . $s_query_set . $s_query_advanced ;
								if($starter->isApi ){
									$_data = array();
									$_data['squery'] = $_s_query;
									$_data['data'] = json_encode($a_data_query);
									
									$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=insertData', $_data);
								}else{
									$starter->database->prepare_query($_s_query, $a_data_query);
								}
							}
					}
				}
	
				if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_after']) && function_exists($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_after'])) 
					call_user_func($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_after']);
				
				$_SESSION['WARNING'] = array(
					'type' => 'success',
					'content' => array(
					$starter->_get_lexique("enregistremment effectué avec succès.",0))) ;
				header("Location:?page=" . $s_form_page . "&module=" . intval($s_module) . "&config_id=" . intval($s_config) . "&addon=" . $s_addon . "&action=list");	
				exit("");
				
			}
		}
		
		if(isset($o_conf['external']) && $starter->utils->is__countable($o_conf['external']) && count($o_conf['external']) > 0 )	{
			foreach($o_conf['external'] as $key)
			{		
				if(isset($key['css']) && !empty($key['css']) )
					$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> $key['css']);
				if(isset($key['js'])  && !empty($key['css']))
					$starter->a_js[] = array("src"=> $key['js']);
			}
		}
		$o_conf = $starter->search_query($o_conf);

		if(isset($o_conf['css']) && !empty($o_conf['css']) )
			$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> $o_conf['css']);
		if(isset($o_conf['js']) && !empty($o_conf['js']) )
			$starter->a_js[] = array("src"=> $o_conf['js']);
			
		$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/css/form.css');
		$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/lib/dropzone/css/dropzone.min.css');
		$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/lib/cropper-master/css/cropper.min.css');
		$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/lib/cropper-master/css/main.css');

		$starter->a_js[] = array("src"=> '/!locked/lib/dropzone/js/dropzone.min.js');
		$starter->a_js[] = array("src"=> '/!locked/lib/cropper-master/js/cropper.js');
		
		//$starter->a_js[] = array("src"=> '/!locked/lib/cropper-master/js/main.js');

		$starter->a_js[] = array("src"=> '/templates/' . $starter->s_template . '/modules/admin/js/edit.js');
		$include_page = '/modules/admin/views/edit.php' ;
	break;
	
	case 'edit':

		if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']) && function_exists($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before'])){
			call_user_func($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']);
			$o_conf = $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config] ;
		}
		if($starter->utils->is__countable($_POST) && count($_POST) >0)
		{
			require_once LIBRARY_PATH . '/form_checker.class.php' ;
			$starter->checkForm = new form_checker($o_conf['champs']);

			if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0){
				$_SESSION['WARNING'] = array( 
					'type' => 'error',
					'content' => $starter->checkForm->a_errors 
				);
			}
			else
			{
				$s_query = $starter->_make_query($o_conf, '', '', $i_conf, "UPDATE");
				$a_data_query = array();

				if($starter->isApi ){
					$_data = array();
					$_data['squery'] = $s_query;
					$_data['data'] = json_encode($a_data_query);
					
					$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
					$_id = $curlApiRequest ;
				}else{
					$starter->database->prepare_query($s_query, $a_data_query);
					$_id = $starter->database->request_id();
				}

				if(isset($o_conf['external']) && !empty($o_conf['external']))	{
					foreach($o_conf['external'] as $key)
					{
						$a_data_query_verif = $a_data_query = array(
							'key' => array($s_form_valId,PDO::PARAM_STR),
						);
						$s_query_verif = "
							SELECT *
							FROM " . $key['table'] . "
							WHERE " . $key['key'] . " = :key";
						
						$s_query = "
							UPDATE " . $key['table'];
						$s_query_insert = "
							INSERT INTO " . $key['table'];
						$s_query_set = "
							SET ";
						$s_query_where = "
							WHERE " . $key['key'] . " = :key";

						$a_query = array(
							"request"		=> ""
						);
						if(isset($key['languages']))
							foreach($key['languages'] as $element => $languages )
							{
								$a_query["fields"] = array();
								$a_query["values"] = array();
								$iCompt = 0;
								$s_query_advanced = '';
								$s_query_where_advanced = '';
								
								foreach($languages as $item => $value)
								{
									if($value['type'] != "hidden")
									{
										$a_data_query[$item] = array($_POST[$value['champ']], PDO::PARAM_STR);
										$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . $item . " = :" . $item;
										$a_query["fields"][] = $item;
										$a_query["values"][] = ':'.$item;

										if(isset($value['champedit'])){
											$a_data_query[$item . 'edit'] = array(($_POST[$value['champedit']]), PDO::PARAM_STR);
											$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . $item .'edit' . " = :" . $item . 'edit';
											$a_query["fields"][] = $item . 'edit';
											$a_query["values"][] = ':'.$item . 'edit';
										}
										$iCompt ++;
									}
								}
								$a_data_query['lang'] = array($element, PDO::PARAM_INT);
								$a_data_query_verif['lang'] = array($element, PDO::PARAM_INT);

								$s_query_where_advanced .= "
									AND lang = :lang";
								$_s_query_verif = $s_query_verif . $s_query_where_advanced;

								if($starter->isApi ){
									$_data = array();
									$_data['squery'] = $_s_query_verif;
									$_data['data'] = json_encode($a_data_query_verif);
									$_data['type'] = 'single';

									$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
									$_tmp = $curlApiRequest ;
								}else{
									$_tmp = $starter->database->prepare_query($_s_query_verif, $a_data_query_verif);
								}

								if($_tmp == false) {
									$_s_query = $s_query_insert . $s_query_set . $s_query_advanced . " , lang = :lang, " . $key['key'] . " = :key";	
									$a_query["request"] = "INSERT INTO " .  $key['table'];
									$a_query["fields"][] = 'lang';
									$a_query["fields"][] = $key['key'];
									$a_query["values"][] = ':lang';
									$a_query["values"][] = ':key';

									if($starter->isApi ){
										$_data = array();
										$_data['squery'] = $_s_query;
										$_data['data'] = json_encode($a_data_query);
										
										$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=insertData', $_data);
									}else{
										$starter->database->prepare_query($_s_query, $a_data_query, '', '', $a_query);
									}
								}
								else {
									//$a_query["request"][] = "UPDATE " .  $key['table'];
									$_s_query = $s_query . $s_query_set . $s_query_advanced . $s_query_where . $s_query_where_advanced;

									if($starter->isApi ){
										$_data = array();
										$_data['squery'] = $_s_query;
										$_data['data'] = json_encode($a_data_query);
										$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
									}else{
										$starter->database->prepare_query($_s_query, $a_data_query);
									}
								}
							}
						elseif(isset($key['special']))
							foreach($key['special'] as $element => $special )
							{
								$iCompt = 0;
								$s_query_advanced = '';
								$s_query_where_advanced = '';
								foreach($special['champs'] as $item => $value)
								{
									$a_data_query[$item] = array(addslashes($_POST[$value['champ']]), PDO::PARAM_STR);
									$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . $item . " = :" . $item;
									$iCompt ++;
								}
								$a_data_query['specialkey'] = array($element, PDO::PARAM_STR);
								$s_query_where_advanced .= "
									AND " . $special['key'] . " = :specialkey";

								if($starter->isApi ){
									$_data = array();
									$_data['squery'] = $_s_query;
									$_data['data'] = json_encode($a_data_query);
									
									$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
									$_tmp = $curlApiRequest ;
								}else{
									$_tmp = $starter->database->prepare_query($_s_query, $a_data_query);
								}
		
								if($_tmp == false) {
									$_s_query = $s_query_insert . $s_query_set . $s_query_advanced . ", ". $special['key'] . " = :specialkey, " . $key['key'] . " = :key";
								}
								else 
									$_s_query = $s_query . $s_query_set . $s_query_advanced . $s_query_where . $s_query_where_advanced;

								if($starter->isApi ){
									$_data = array();
									$_data['squery'] = $_s_query;
									$_data['data'] = json_encode($a_data_query);
									
									$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
								}else{
									$starter->database->prepare_query($_s_query, $a_data_query);
								}
							}
					}
				}

				if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_after']) && function_exists($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_after'])) 
					call_user_func($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_after']);		
				
				if($starter->lucene_index != false && $starter->mods[$starter->database->configs[$s_form_page]['content'][$s_module]['path']]['index'])
					$starter->indexation->storeindexation($o_conf);

				$_SESSION['WARNING'] = array(
					'type' => 'success', 
					'content' => array($starter->_get_lexique("enregistremment effectué avec succès.",0))
				);

				//header("Location:?page=" . $s_form_page . "&module=" . intval($s_module) . "&config_id=" . intval($s_config) . "&addon=" . $s_addon . "&action=" . (!empty($starter->database->configs[$s_form_page]['content'][$s_module]['mode']) && $starter->database->configs[$s_form_page]['content'][$s_module]['mode'] == "unique" ? 'edit&val_id=' . $s_form_valId : 'list'));	
				header("Location:" . $_SESSION['URI_BACK']);
				empty($_SESSION['URI_BACK']);
				unset($_SESSION['URI_BACK']);
				exit();
			}
		}
		else 
			$_SESSION['URI_BACK'] = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "?page=" . $s_form_page . "&module=" . intval($s_module) . "&config_id=" . intval($s_config) . "&addon=" . $s_addon . "&action=" . (!empty($starter->database->configs[$s_form_page]['content'][$s_module]['mode']) && $starter->database->configs[$s_form_page]['content'][$s_module]['mode'] == "unique" ? 'edit&val_id=' . $s_form_valId : 'list'));
		
		$a_data_query = array(
			'cle' => array($s_form_valId,PDO::PARAM_INT),
		);
		$s_query = "
			SELECT t0.*";
		$s_query_from = "
			FROM " . $o_conf['table'] . " AS t0";
		$s_query_where = "
			WHERE t0." . $o_conf['cle'] . " = :cle";
		if(isset($o_conf['condition']) && !empty($o_conf['condition']) ) 
			$s_query_where .= " AND " . $o_conf['condition'];
				
		$s_query .= $s_query_from .$s_query_where;
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);

			$aData = $curlApiRequest ;
			$aData = (array)$aData[0] ;
		}else{
			$aData = $starter->database->prepare_query($s_query, $a_data_query);
		}
		if(isset($o_conf['external']) && !empty($o_conf['external']))	{
			foreach($o_conf['external'] as $key)
			{
				$s_query = "
					SELECT ";
				$s_query_from = "
					FROM " . $key['table'] . " AS t0";
				$s_query_where = "
					WHERE t0." . $key['key'] . " = :cle";
				
				if(isset($key['languages']))
					foreach($key['languages'] as $element => $languages )
					{
						$iCompt = 0;
						$s_query_advanced = '';
						$s_query_where_advanced = '';
						foreach($languages as $item => $value)
						{
							$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . " t0." . $item . " AS " . $value['champ'] ;
							
							if(isset($value['champedit'])) 
								$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . " t0." . $value['champeditchamp'] . " AS " . $value['champedit'] ;
							$iCompt ++;
						}

						$a_data_query['lang'] = array($element, PDO::PARAM_STR);
						$s_query_where_advanced .= "
							AND lang = :lang";
						$_s_query = $s_query . $s_query_advanced . $s_query_from . $s_query_where . $s_query_where_advanced;

						if($starter->isApi ){
							$_data = array();
							$_data['squery'] = $_s_query;
							$_data['data'] = json_encode($a_data_query);
							$_data['type'] = 'single';
							
							$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
							$_tmp = $curlApiRequest ;
						}else{
							$_tmp = $starter->database->prepare_query($_s_query, $a_data_query);
						}
						if($_tmp != false)
						{
							$_aData = array_keys($_tmp);
							foreach($_aData as $item => $value)
							{
								$aData[$value] = $_tmp[$value];
							}
						}
					}
				elseif(isset($key['special']))
					foreach($key['special'] as $element => $special )
					{
						$iCompt = 0;
						$s_query_advanced = '';
						$s_query_where_advanced = '';
						foreach($special['champs'] as $item => $value)
						{
							$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . " t0." . $item . " AS " . $value['champ'] ;
							$iCompt ++;
						}
						$a_data_query['specialkey'] = array($element, PDO::PARAM_STR);
						$s_query_where_advanced .= "
							AND " . $special['key'] . " = :specialkey";
						$_s_query = $s_query . $s_query_advanced . $s_query_from . $s_query_where . $s_query_where_advanced;

						if($starter->isApi ){
							$_data = array();
							$_data['squery'] = $_s_query;
							$_data['data'] = json_encode($a_data_query);
							
							$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
							$_tmp = $curlApiRequest ;
						}else{
							$_tmp = $starter->database->prepare_query($_s_query, $a_data_query);
						}

						if($_tmp != false) 
						{
							$_aData = array_keys($_tmp);
							foreach($_aData as $item => $value)
							{
								$aData[$value] = $_tmp[$value];
							}
						}
					}
				
				if(isset($key['css']) && !empty($key['css']))
					$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> $key['css']);
				if(isset($key['js'])  && !empty($key['js']))
					$starter->a_js[] = array("src"=> $key['js']);
			}
		}
		$o_conf = $starter->search_query($o_conf);

		$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/css/form.css');
		
		$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/lib/dropzone/css/dropzone.min.css');
		$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/lib/cropper-master/css/cropper.css');
		$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/lib/cropper-master/css/main.css');

		$starter->a_js[] = array("src"=> '/!locked/lib/dropzone/js/dropzone.min.js');
		$starter->a_js[] = array("src"=> '/!locked/lib/cropper-master/js/cropper.js');
		//$starter->a_js[] = array("src"=> '/!locked/lib/cropper-master/js/main.js');

		$starter->a_js[] = array("src"=> '/templates/' . $starter->s_template . '/modules/admin/js/edit.js');

		if(isset($o_conf['css'])  && !empty($o_conf['css']))
			$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> $o_conf['css']);
		if(isset($o_conf['js'])  && !empty($o_conf['js']))
			$starter->a_js[] = array("src"=> $o_conf['js']);

		$include_page = '/modules/admin/views/edit.php' ;

	break;
	
	case 'duplicate':
		if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']) && function_exists($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before'])){
			call_user_func($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['do_before']);
			$o_conf = $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config] ;
		}
		$a_data_query = array(
			'cle' => array($s_form_valId, PDO::PARAM_INT),
		);
		if($_POST['token'] == $_SESSION['token']){
			$s_query = "
				SELECT t0.*";
			$s_query_from = "
				FROM " . $o_conf['table'] . " AS t0";
			$s_query_where = "
				WHERE t0." . $o_conf['cle'] . " = :cle";
			if(isset($o_conf['condition']) && !empty($o_conf['condition']) ) 
				$s_query_where .= " AND " . $o_conf['condition'];
			
			$s_query .= $s_query_from .$s_query_where;

			if($starter->isApi ){
				$_data = array();
				$_data['squery'] = $s_query;
				$_data['data'] = json_encode($a_data_query);
				
				$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
				$aData = $curlApiRequest ;
			}else{
				$aData = $starter->database->prepare_query($s_query,$a_data_query);
			}
			
			$a_data_query = array();
			$s_query = "
				INSERT INTO " . $o_conf['table'] . "
				SET ";
			$a_query = array(
				"request"		=> "INSERT INTO " .  $o_conf['table'],
				"fields"		=> array(),
				"values"		=> array()
			);

			$_count = 0;
			foreach($aData as $key => $val){
				$_count ++; 
				if($key != $o_conf['cle'] && !empty($val)){
					$a_data_query[$key] = array($val, PDO::PARAM_STR);
					$s_query .=  $key . " = :" . $key . ",";
					$a_query["fields"][] = $key;
					$a_query["fields"][] = ':' . $key;
				}
			}
			$s_query = substr($s_query, 0, -1);

			if($starter->isApi ){
				$_data = array();
				$_data['squery'] = $s_query;
				$_data['data'] = json_encode($a_data_query);
				
				$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=insertData', $_data);
				$max_id = $curlApiRequest ;
			}else{
				$starter->database->prepare_query($s_query, $a_data_query, '', '', $a_query);
				$max_id = $starter->database->request_id();
			}

			if(isset($o_conf['external']) && !empty($o_conf['external']))	{
				foreach($o_conf['external'] as $key)
				{
					$a_data_query = array(
						'key' => array($s_form_valId, PDO::PARAM_INT),
					);	
					$s_query = "
						SELECT ";
					$s_query_from = "
						FROM " . $key['table'] . " AS t0";
					$s_query_where = "
						WHERE t0." . $key['key'] . " = :key";
					if(isset($key['languages']))
						foreach($key['languages'] as $element => $languages )
						{
							$iCompt = 0;
							$s_query_advanced = '';
							$s_query_where_advanced = '';
							foreach($languages as $item => $value)
							{
								$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . " t0." . $item ;
								$iCompt ++;
							}
							$a_data_query['lang'] = array($element, PDO::PARAM_INT);
							$s_query_where_advanced .= "
								AND lang = :lang";
							$_s_query = $s_query . $s_query_advanced . $s_query_from . $s_query_where . $s_query_where_advanced;
							
							if($starter->isApi ){
								$_data = array();
								$_data['squery'] = $s_query;
								$_data['data'] = json_encode($a_data_query);
								
								$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
								$_tmp = $curlApiRequest ;
							}else{
								$_tmp = $starter->database->prepare_query($s_query, $a_data_query);
							}
													
							if($_tmp != false)
							{
								$a_data_query = array(
									'key' => array($max_id, PDO::PARAM_INT),
								);
								$_s_query = "
									INSERT INTO " . $key['table'] . "
									SET " . $key['key'] . " = :key";
								$a_query = array(
									"request"		=> "INSERT INTO " .  $o_conf['table'],
									"fields"		=> array(),
									"values"		=> array()
								);
								foreach($_tmp as $_key => $_val){
									$a_data_query[$_key] = array($_val, PDO::PARAM_STR);
									$_s_query .= "," . $_key . " = :" . $_key;
									$a_query["fields"][] = $_key;
									$a_query["fields"][] = ':' . $_key;
								}
								if($starter->isApi ){
									$_data = array();
									$_data['squery'] = $_s_query;
									$_data['data'] = json_encode($a_data_query);
									
									$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=insertData', $_data);
								}else{
									$starter->database->prepare_query($_s_query, $a_data_query, '', '', $a_query);
								}
							}
						}
					elseif(isset($key['special']))
						foreach($key['special'] as $element => $special )
						{
							$a_data_query = array(
								'specialkey' => array($element, PDO::PARAM_INT),
							);
							$iCompt = 0;
							$s_query_advanced = '';
							$s_query_where_advanced = '';
							foreach($special['champs'] as $item => $value)
							{
								$s_query_advanced .= ($iCompt == 0 ? '' : ', ') . " t0." . $item ;
								$iCompt ++;
							}
							$s_query_where_advanced .= "
								AND " . $special['key'] . " = :specialkey";
							$_s_query = $s_query . $s_query_advanced . $s_query_from . $s_query_where . $s_query_where_advanced;

							if($starter->isApi ){
								$_data = array();
								$_data['squery'] = $_s_query;
								$_data['data'] = json_encode($a_data_query);
								
								$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=insertData', $_data);
								$_tmp = $curlApiRequest ;
							}else{
								$_tmp = $starter->database->prepare_query($_s_query, $a_data_query);
							}

							if($_tmp != false) 
							{
								$a_data_query = array(
									'key' => array($max_id, PDO::PARAM_INT),
								);
								$_s_query = "
									INSERT INTO " . $key['table'] . "
									SET " . $key['key'] . " = :key";
								$a_query = array(
									"request"		=> "INSERT INTO " .  $key['table'],
									"fields"		=> array(),
									"values"		=> array()
								);
								foreach($_tmp as $_key => $_val){
									$a_data_query[$_key] = array($_val, PDO::PARAM_STR);
									$_s_query .= "," . $_key . " = :" . $_key;
									$a_query["fields"][] = $_key;
									$a_query["fields"][] = ':' . $_key;
								}
								if($starter->isApi ){
									$_data = array();
									$_data['squery'] = $_s_query;
									$_data['data'] = json_encode($a_data_query);
									
									$starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=insertData', $_data);
								}else{
									$starter->database->prepare_query($_s_query, $a_data_query);
								}
							}
						}
				}
			}
		}
		
		header("Location:?page=" . $s_form_page . "&module=" . intval($s_module) . "&config_id=" . intval($s_config) . "&addon=" . $s_addon . "&action=list" . (isset($s_form_nav) ? '&nav=' . $s_form_nav : ''));
		exit();

	break;		
	
	case "sort" :
		$a_data_query = array();
		$s_query = "
			SELECT " . $o_conf['cle'] . ", _order 
			FROM " . $o_conf['table'];
					
		switch($s_dsort){
			case "sort_up" :
					
				switch($s_addon){
					
					case 'tree':
						$a_data_query = array(
							'cle' => array($s_form_valId,PDO::PARAM_INT),
						);
						$s_query .= "
							WHERE " . $o_conf['code'] . "_parent = (
								SELECT " . $o_conf['code'] . "_parent
								FROM " . $o_conf['table'] . "
								WHERE " . $o_conf['cle'] . " = :cle)";
						
					break;
					
				}
				$s_query .= "
					ORDER BY _order ";	

				if($starter->isApi ){
					$_data = array();
					$_data['squery'] = $_s_query;
					$_data['data'] = json_encode($a_data_query);
					$_data['cle'] = $o_conf['cle'];
					
					$curlApiReq = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=sortData', $_data);
					$aData = $curlApiRequest ;

				}else{
					$aData = $starter->database->prepare_query($_s_query, $a_data_query, 'multiple', $o_conf['cle']);
				}
								
				$i_current = intval($aData[$s_form_valId]["_order"]);
				$i_new = $i_current - 1;

			break;
	
			case "sort_down" :
				$a_data_query = array();
				switch($s_addon){
					
					case 'tree':
						$a_data_query = array(
							'cle' => array($s_form_valId,PDO::PARAM_INT),
						);
						$s_query .= "
							WHERE " . $o_conf['code'] . "_parent = (
								SELECT " . $o_conf['code'] . "_parent
								FROM " . $o_conf['table'] . "
								WHERE " . $o_conf['cle'] . " = :cle)";
					break;
										
				}
				$s_query .= "
					ORDER BY _order";

				if($starter->isApi ){
					$_data = array();
					$_data['squery'] = $s_query;
					$_data['data'] = json_encode($a_data_query);
					$_data['cle'] = $o_conf['cle'];
					
					$curlApiReq = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=sortData', $_data);
					$aData = $curlApiRequest ;

				}else{
					$aData = $starter->database->prepare_query($s_query, $a_data_query, 'multiple', $o_conf['cle']);
				}
						
				$i_current = intval($aData[$s_form_valId]["_order"]);
				$i_new = $i_current + 1;

			break;
		}
		
		$starter->database->sort_table($s_page, $s_config, $s_module, $s_action, $aData, $i_current, $i_new);
		
		header("Location:?page=" . $s_form_page . "&module=" . intval($s_module) . "&config_id=" . intval($s_config) . "&addon=" . $s_addon . "&action=list" . (isset($s_form_nav) ? '&nav=' . $s_form_nav : ''));
		exit();
	break;
}

//output

// controller
switch($s_level)
{
	default :
	case '' :
		$starter->a_include_pages[]  = '/modules/admin/views/header.php' ;
		if($s_action != "preview")
		{
			$starter->a_include_pages[]  = '/modules/admin/views/top.php' ;
			$starter->a_include_pages[]  = '/modules/admin/modules/menu/views/index.php' ;
			$starter->a_include_pages[]  = $include_page ;
		}
		$starter->a_include_pages[]  = '/modules/admin/views/footer.php' ;

	break;
	case 'plugins' :

		include APPLICATION_PATH . '/modules/plugins/controllers/index.php' ;
		
	break;
}?>