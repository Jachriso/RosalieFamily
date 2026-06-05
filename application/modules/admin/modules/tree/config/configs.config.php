<?php
$a_config[0] = array(
					 "name"			=> $this->_get_lexique('Arborescence',1),
					 "addon"		=> "tree",
					 "table"		=> "tree",
					 "code"			=> "tree",
					 "tri"			=> "t0.tree_level, t0._order ASC",
					 "cle"			=> "tree_id",
					 "index"		=> false,
					 "condition"	=> " t0.archive = 0",
    				 "actions"		=> array('edit', 'preview', 'duplicate', 'delete'),
    				 "more_actions"	=> array('add', 'sort'),
					 "champs"		=> array(
										"online" => array(
											"champ"											=> "online",
											"title"											=> $this->_get_lexique('online',1),
											"type"											=> "checkbox",
											"on_list"										=> true
										),
										"tree_label" => array(
											"champ"											=> "tree_label",
											"title"											=> $this->_get_lexique('Titre de la page',1),
											"type"											=> "varchar",
											"maxlength"										=> 255,
											"verif"											=> array("mandatory"),
											"is_index"										=> "Text",
											"on_list"										=> true
										),
										"tree_icon" => array(
											"champ"						=> "tree_icon",
											"title"						=> $this->_get_lexique('Vignette',1),
											"type"						=> "cropper",
											"maxfilesize"				=> 1024000,
											"allowedFileExtensions"		=> "jpeg,jpg,gif,png",
											"allowedFileTypes"			=> array("image/jpeg","image/png","image/pjpeg"),
											"width"						=>400,
											"height"					=>400,
											"vtype"										=> "inside",
										),
										"tree_parent" => array(
											"champ"											=> "tree_parent",
											"title"											=> $this->_get_lexique("page d'appartenance",1),
											"type"											=> "field_list",
											"table_link"									=> "tree",
											"champ_link"									=> "tree_label",
											"cle_link"										=> "tree_id",
											"condition_link"								=> array(" tree_id IN ({LIST})"),
											"list_view"										=> "arbo",
											"sort_link"										=> "SORT_VALUE",
											"is_index"										=> "UnIndexed",
											"code"											=> "tree",
											"index_field"									=> "tree",
										),
										"tree_module" => array(
											"champ"											=> "tree_module",
											"title"											=> $this->_get_lexique('Module'),
											"type"											=> "field_list",
											"table_link"									=> "tree_module",
											"champ_link"									=> "module_name",
											"cle_link"										=> "module_id",
											"condition_link"								=> array("online = 1")
										),
										"tree_on_menu" => array(
											"champ"											=> "tree_on_menu",
											"title"											=> $this->_get_lexique("Choix du menu",1),
											"type"											=> "field_list",
											"data"											=> array(
																									"1"			=> $this->_get_lexique("Header nav",1),
																									"2"			=> $this->_get_lexique("Footer nav",1),
																									"3"			=> $this->_get_lexique("none",1),
																							),
										),
									),
					"auto_fields"	=> array(
						"user " => array("champ"=>"user ", "value"=>(isset($_SESSION['user_info']['user_id']) ? $_SESSION['user_info']['user_id'] : 0), "action"=>"add"),
						"_create " => array("champ"=>"_create ", "value"=>date("Y-m-d H:i:s"), "action"=>"add"),
						"modify " => array("champ"=>"modify ", "value"=>date("Y-m-d H:i:s"), "action"=>"edit"),
					),
);
$a_config[0]['external'][0] = array(
		"table"			=> "tree_detail",
		 "code"			=> "detail",
		 "tri"			=> "lang ASC",
		 "key"			=> "detail_tree",
		 "cle"			=> "detail_id",
);
if($this->a_config_lang != false)
foreach($this->a_config_lang as $_key => $lang)
{
	$a_config[0]['external'][0]['languages'][$lang->lang_id] = array(
		"detail_label" => array(
			"champ"				=> "detail_label_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Titre',1),
			"type"				=> "varchar",
			"maxlength"			=> 255,
			"is_index"			=> "Text",
		),
		/*"detail_text" => array(
			"champ"				=> "detail_text_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Descriptif',1),
			"type"				=> "tiny_mce",
			"css"				=> "modules/admin/css/tincy.css",
			"class"				=> "big",
			"is_index"			=> "UnStored",
		),*/
		"detail_text" => array(
			"champ"				=> "detail_text_" . $lang->lang_id,
			"champeditchamp"	=> "detail_textedit",
			"champedit"			=> "detail_textedit_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Descriptif',1),
			"type"				=> "pagebuilder",
			"vtype"				=> "inside",
			"origin"			=> "special",
			"templates"			=> 'paragraph,image,button,youtube,vimeo,map,code',
			"grids"				=> '12,6-6,4-8,8-4,4-4-4,3-3-3',
			"is_index"			=> "UnStored",
		),
		"detail_link" => array(
				"champ"		=> "detail_link_" . $lang->lang_id,
				"title"		=> $this->_get_lexique('lien',1),
				"type"		=> "varchar",
				"maxlength"	=> 255,
		),
		"detail_link_label" => array(
				"champ"		=> "detail_link_label_" . $lang->lang_id,
				"title"		=> $this->_get_lexique('libellé du lien',1),
				"type"		=> "varchar",
				"maxlength"	=> 255,
		),	
		"detail_behavior" => array(
			"champ"			=> "detail_behavior_" . $lang->lang_id,
			"title"			=>	$this->_get_lexique('Cible du lien',1),
			"type"			=> "field_list", 
			"data"			=> array(
								"1"		=> $this->_get_lexique('ouvrir dans la page courante',1),
								"2"		=> $this->_get_lexique('ouvrir dans une nouvelle page',1),
								"3"		=> $this->_get_lexique('javacsript',1),
							),
		),
		"detail_metatitle" => array(
			"champ"				=> "detail_metatitle_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Meta titre',1),
			"type"				=> "varchar",
			"maxlength"			=> 255
		),
		"detail_metadesc" => array(
			"champ"				=> "detail_metadesc_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Meta description',1),
			"type"				=> "textarea"
		),
		"detail_index" => array(
			"champ"			=> "detail_index_" . $lang->lang_id,
			"title"			=>	$this->_get_lexique('Indexation'),
			"type"			=> "field_list", 
			"data"			=> array(
								"0"		=> $this->_get_lexique('INDEX, FOLLOW',1),
								"1"		=> $this->_get_lexique('NOINDEX, FOLLOW',1),
								"2"		=> $this->_get_lexique('INDEX, NOFOLLOW',1),
								"3"		=> $this->_get_lexique('NOINDEX, NOFOLLOW',1)
							),
		),		
		"detail_referer" => array(
			"champ"				=> "detail_referer_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Referer',1),
			"type"				=> "hidden",
			"is_index"			=> "Text",
		),
		"lang" => array(
			"champ"				=> "lang_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('lang',1),
			"type"				=> "hidden",
			"is_index"			=> "Keyword",
		),
	);
}
function do_before_tree()
{
	global $starter, $s_module, $s_config, $a_list_view, $s_form_valId, $s_form_page ;

	require_once APPLICATION_PATH . '/controllers/!locked/AuthController.php' ;
	$auth = new AuthController();
	$auth->getAuth();

	require_once APPLICATION_PATH . '/controllers/!locked/MenuController.php' ;
	$menu = new MenuController();
	
	$_a_list = $menu->getTree('1', '', true);
	$a_list = array('NULL');
	if($starter->utils->is__countable($_a_list) && count($_a_list) > 0)
	{
		foreach($_a_list as $key => $val){
			if((empty($s_form_valId) || $val['tree_id'] != $s_form_valId) && ($val['tree_module'] == 0 || $val['tree_module'] == 1))
			{
				$a_list[] = $val['tree_id'];
				$a_list_view[$val['tree_id']] = array(1,$val['tree_id']);
				if(isset($val['children']) && $starter->utils->is__countable($val['children']) && count($val['children']) > 0)
				{
					foreach($val['children'] as $item => $value){
						if((empty($s_form_valId) || $value['tree_id'] != $s_form_valId) && ($value['tree_module'] == 0 || $value['tree_module'] == 1))
						{
							$a_list[] = $value['tree_id'];
							$a_list_view[$value['tree_id']] = array(2,$value['tree_id']);
							if(isset($value['children']) && $starter->utils->is__countable($value['children']) && count($value['children']) > 0)
							{
								foreach($value['children'] as $element => $field){
									if(empty($s_form_valId) || $value['tree_id'] != $s_form_valId)
									{
										$a_list[] = $field['tree_id'];
										$a_list_view[$field['tree_id']] = array(3,$field['tree_id']);
									}
								}
							}
						}
					}
				}
			}	
		}
	}
	$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['tree_parent']['condition_link'][0] 	= preg_replace('#{LIST}#',implode(',',$a_list), $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['tree_parent']['condition_link'][0]);

	if($starter->db_type == 'mysql' || empty($starter->db_type) ){
		$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['tree_parent']['sort_link'] = "FIND_IN_SET( tree_id , '{LIST}')";
	}
	else{
		$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['tree_parent']['sort_link'] = "position(tree_id::text in '{LIST}')";
	}
	
	$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['tree_parent']['sort_link'] 		= preg_replace('#{LIST}#',implode(',',$a_list), $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['tree_parent']['sort_link']);	
}
function do_after_tree()
{
	global $starter, $_id, $menu, $s_form_valId, $s_action ;
	$iInsert = (!empty($s_form_valId) ? $s_form_valId : $_id );

	$a_data_query = array(
		'tree_id' => array(intval($_POST['tree_parent']),PDO::PARAM_INT),
	);	

	$s_query ="
		SELECT tree_level
		FROM tree
		WHERE tree_id = :tree_id";
	
	if($starter->isApi ){
		$_data = array();
		$_data['squery'] = $s_query;
		$_data['data'] = json_encode($a_data_query);
		$_data['type'] = 'single';
		
		$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
		$o_result = $curlApiRequest;
	}else{
		$o_result = $starter->database->prepare_query($s_query,$a_data_query);
	}
	
	if(empty($o_result)){
		$newLevel = 1;
		$curentLevel = 1;
	}else{
		$newLevel = intval($o_result['tree_level']) + 1 ;
		$curentLevel = $o_result['tree_level'];
	}
	if($s_action == "edit" && $curentLevel != $newLevel)
	{
		$_aData = $menu->getTree($curentLevel, 0, true, $iInsert);
		$i_difLevel = $curentLevel - $newLevel;
		
		$menu->changeLevel($_aData[$iInsert]['children'], $newLevel+1);
	}

	$s_query ="
		UPDATE tree
		SET tree_level = :tree_level,
		modify = :modify,
		user = :user";

	$a_data_query_final = array(
		'tree_level' => array(intval($newLevel),PDO::PARAM_INT),
		'modify' => array(date("Y-m-d H:i:s"), PDO::PARAM_STR),
		'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
	);
	
	if($s_action == "add")
	{
		$a_data_query = array(
			'tree_parent' => array(intval($_POST['tree_parent']),PDO::PARAM_INT),
		);
		$_s_query = "
			SELECT MAX(_order) AS compt
			FROM tree
			WHERE tree_parent = :tree_parent" ;

		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $_s_query;
			$_data['data'] = json_encode($a_data_query);
			$_data['type'] = 'single';
			
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
			$o_result = $curlApiRequest;
		}else{
			$o_result = $starter->database->prepare_query($_s_query, $a_data_query);
		}

		$a_data_query_final['order'] = array((intval($o_result["compt"]) + 1),PDO::PARAM_INT);
		$s_query .= ', _order = :order';

		$s_query_update_map = "
			SELECT map, group_id
			FROM admin_groups
			WHERE online = 1
			AND group_id != 1
			";

		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query_update_map;
			$_data['data'] = json_encode(array());
			
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
			$a_data_group = $curlApiRequest;
		}else{
			$a_data_group = $starter->database->prepare_query($s_query_update_map, array(), 'multiple');
		}
		
		foreach($a_data_group as $key => $val){
			$_map = json_decode($val['map']);
						
			if(isset($_map->rules_treeId) && !in_array($iInsert, $_map->rules_treeId)) 
				$_map->rules_treeId[] = $iInsert;
			
			$a_data_query = array(
				'group_map' => array(json_encode($_map),PDO::PARAM_STR),
				'group_id' => array($val['group_id'],PDO::PARAM_INT),
				'modify' => array(date("Y-m-d H:i:s"), PDO::PARAM_STR),
				'user' => array($_SESSION['user_info']['user_id'], PDO::PARAM_INT),
			);
			$s_query_update_map = "
				UPDATE admin_groups
				SET map = :group_map,
				modify = :modify,
				user = :user
				WHERE group_id = :group_id";
			
			if($starter->isApi ){
				$_data = array();
				$_data['squery'] = $s_query_update_map;
				$_data['data'] = json_encode($a_data_query);
				
				$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
				$_tmp = $curlApiRequest;
			}else{
				$_tmp = $starter->database->prepare_query($s_query_update_map, $a_data_query);
			}
		}		
	}
	foreach($starter->a_config_lang as $_key => $lang)
	{
		$s_referer = $starter->utils->xtTraiter(((isset($_POST['detail_referer_' . $lang->lang_id]) && !empty($_POST['detail_referer_' . $lang->lang_id]) ? $_POST['detail_referer_' . $lang->lang_id] : (!empty($_POST['detail_label_' . $lang->lang_id]) ? $_POST['detail_label_' . $lang->lang_id] : $_POST['tree_label']))));
		
		$a_data_query = array(
			'detail_referer' => array($s_referer,PDO::PARAM_STR),
			'detail_tree' => array($iInsert,PDO::PARAM_INT),
			'lang' => array($lang->lang_id,PDO::PARAM_INT),
		);	
	
		$_s_query = "
			SELECT detail_referer 
			FROM tree_detail
			WHERE detail_referer = :detail_referer
			AND detail_tree != :detail_tree
			AND lang = :lang";

		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $_s_query;
			$_data['data'] = json_encode($a_data_query);
			$_data['type'] = 'single';
			
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=getData', $_data);
			$o_result = $curlApiRequest;
		}else{
			$o_result = $starter->database->prepare_query($_s_query, $a_data_query);
		}

		if($o_result != false) {
			$s_referer = $starter->_setReferer(0, $s_referer, $_s_query, $a_data_query);
		}
		
		$a_data_query = array(
			'detail_referer' => array($s_referer,PDO::PARAM_STR),
			'detail_tree' => array($iInsert,PDO::PARAM_INT),
			'lang' => array($lang->lang_id,PDO::PARAM_INT),
		);	
		$s_query_update_referer = "
			UPDATE tree_detail
			SET detail_referer = :detail_referer
			WHERE detail_tree = :detail_tree
			AND lang = :lang";
		
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query_update_referer;
			$_data['data'] = json_encode($a_data_query);
			
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
			$_tmp = $curlApiRequest;
		}else{
			$_tmp = $starter->database->prepare_query($s_query_update_referer, $a_data_query);
		}
	}
	$a_data_query_final['tree_id'] = array(intval($iInsert),PDO::PARAM_INT);

	$s_query .="
		WHERE tree_id = :tree_id";

	if($starter->isApi ){
		$_data = array();
		$_data['squery'] = $s_query;
		$_data['data'] = json_encode($a_data_query_final);
		
		$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Back&rquest=updateData', $_data);
		$o_result = $curlApiRequest;
	}else{
		$o_result = $starter->database->prepare_query($s_query, $a_data_query_final);
	}
}
?>
