<?php
$a_config[0] = array(
					 "name"			=> $this->_get_lexique('Catégories de téléchargement',1),
					 "addon"		=> "default",
					 "table"		=> "download_categories",
					 "code"			=> "category",
					 "tri"			=> "_order ASC",
					 "cle"			=> "category_id",
					 "condition"	=> " t0.archive = 0",
					 "index"		=> false,
					 "indexCode"	=> "download_category",
    				 "actions"		=> array('edit', 'delete'),
    				 "more_actions"	=> array('add', 'sort'),
					 "champs"		=> array(
										"online" => array(
											"champ"										=> "online",
											"title"										=> $this->_get_lexique('online',1),
											"type"										=> "checkbox",
											"on_list"									=> true
										),
										"category_label" => array(
											"champ"										=> "category_label",
											"title"										=> $this->_get_lexique('Nom de la catégorie',1),
											"type"										=> "varchar",
											"maxlength"									=> 255,
											"verif"										=> array("mandatory"),
											"on_list"									=> true,
											"is_index"									=> "Text",
										),
									),
					"auto_fields"	=> array(
						"user " => array("champ"=>"user ", "value"=>(isset($_SESSION['user_info']['user_id']) ? $_SESSION['user_info']['user_id'] : 0), "action"=>"add"),
						"_create " => array("champ"=>"_create ", "value"=>date("Y-m-d H:i:s"), "action"=>"add"),
						"modify " => array("champ"=>"modify ", "value"=>date("Y-m-d H:i:s"), "action"=>"edit"),
					)
);
$a_config[0]['external'][0] = array(
		 "table"		=> "download_categories_detail",
		 "code"			=> "download_categories_detail",
		 "tri"			=> "lang ASC",
		 "key"			=> "detail_category",
		 "cle"			=> "detail_id",
);
foreach($this->a_config_lang as $_key => $lang){
	$a_config[0]['external'][0]['languages'][$lang->lang_id] = array(
		"detail_label" => array(
			"champ"				=> "detail_label_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Titre',1),
			"type"				=> "varchar",
			"maxlength"			=> 255,
			"on_list"									=> true,
			"is_index"			=> "Text",
		),
	);
}
function do_after_category()
{
	global $starter, $_id, $s_form_valId ;
	$iInsert = (!empty($s_form_valId ) ? $s_form_valId  : $_id);

	foreach($starter->a_config_lang as $_key => $lang)
	{
		$s_referer = $starter->utils->xtTraiter(isset($_POST['detail_referer_' . $lang->lang_id]) && !empty($_POST['detail_referer_' . $lang->lang_id]) ? $_POST['detail_referer_' . $lang->lang_id] : (!empty($_POST['detail_label_' . $lang->lang_id]) ? $_POST['detail_label_' . $lang->lang_id] : $_POST['category_label']));
		
		$a_data_query = array(
			'detail_referer' => array($s_referer,PDO::PARAM_STR),
			'detail_category' => array($iInsert,PDO::PARAM_INT),
			'lang' => array($lang->lang_id,PDO::PARAM_INT),
		);	
		$_s_query = "
			SELECT detail_referer 
			FROM download_categories_detail
			WHERE detail_referer =  :detail_referer
			AND detail_category != :detail_category
			AND lang = :lang";
		
		if($starter->isApi ){
			$_data = array();
			$_data['detail_referer'] = $s_referer;
			$_data['detail_category'] = $iInsert;
			$_data['lang'] = $lang->lang_id;

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getCatReferer', $_data);
			$o_result = $curlApiRequest;
		}else{
			$o_result = $starter->database->prepare_query($_s_query,$a_data_query);			
		}

		if($o_result != NULL)  
			$s_referer = $starter->database->setReferer(0, $s_referer, $_s_query, $a_data_query);
			
		$a_data_query = array(
			'detail_referer' => array($s_referer,PDO::PARAM_STR),
			'detail_category' => array($iInsert,PDO::PARAM_INT),
			'lang' => array($lang->lang_id,PDO::PARAM_INT),
		);	

		$s_query_update_referer = "
			UPDATE download_categories_detail
			SET detail_referer = :detail_referer
			WHERE detail_category = :detail_category
			AND lang = :lang";

		if($starter->isApi ){
			$_data = array();
			$_data['detail_referer'] = $s_referer;
			$_data['detail_category'] = $iInsert;
			$_data['lang'] = $lang->lang_id;

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=setCatReferer', $_data);
			$_tmp = $curlApiRequest;
		}else{
			$_tmp = $starter->database->prepare_query($s_query_update_referer,$a_data_query);	
		}
		
	}
}
$a_config[1] = array(
					 "name"			=> $this->_get_lexique('Téléchargements',1),
					 "addon"		=> "default",
					 "table"		=> "download",
					 "code"			=> "download",
					 "tri"			=> "download_label ASC",
					 "cle"			=> "download_id",
					 "index"		=> false,
					 "indexCode"	=> "download",
					 "condition"	=> " t0.archive = 0",
					 "optim_search" 		=> array(												
												"download_category" => array(
													"champ"									=> "download_category",	
													"title"									=> $this->_get_lexique('Catégorie',1),
													"type"									=> "field_list",
													"table_link"							=> "download_categories",
													"champ_link"							=> "category_label",
													"cle_link"								=> "category_id",
													"condition_link"						=> array("online=1","archive=0"),
												),
												"online" => array(
													"champ"									=> "online",
													"title"									=> $this->_get_lexique('online',1),
													"type"									=> "radio",
													"data"									=> array("1"=>$this->_get_lexique('oui',1),"0"=>$this->_get_lexique('non',1)
												)
											),
												
					 ),
    				 "actions"		=> array('edit', 'delete'),
    				 "more_actions"	=> array('add', 'search', 'nav'),
					 "champs"		=> array(
										"online" => array(
												"champ"									=> "online",
												"title"									=> $this->_get_lexique('online',1),
												"type"									=> "checkbox",
												"on_list"								=> true
										),
										"download_label" => array(
												"champ"									=> "download_label",
												"title"									=> $this->_get_lexique('Nom du téléchargement',1),
												"type"									=> "varchar",
												"maxlength"								=> 255,
												"verif"									=> array("mandatory"),
												"error_label"							=> $this->_get_lexique('Saisie du nom incorrecte',1),
												"on_list"								=> true,
												"list_css"								=> "width:30%;",
												"is_index"								=> "Text",
										),
										"download_thumb" => array(
											"champ"										=> "download_thumb",
											"title"										=> $this->_get_lexique('Vignette',1),
											"type"										=> "cropper",
											"maxfilesize"								=> 2048000,
											"allowedFileExtensions"						=> "jpeg,jpg,gif,png",
											"allowedFileTypes"							=> array("image/jpeg","image/png","image/pjpeg"),
											"width"										=> 315,
											"height"									=> 170,
											"path"										=> "downloads/thumbs/",
											"is_index"									=> "UnIndexed",
											"vtype"										=> "inside",
										),
										"download_path" => array(
											"champ"										=> "download_path",
											"title"										=> $this->_get_lexique('Fichier à télécharger',1),
											"type"										=> "file",
											"secure"									=> true,
											"maxfilesize"								=> 419430000,
											"allowedFileExtensions"						=> "jpeg,jpg,gif,png,pdf,zip",
											"allowedFileTypes"							=> array("image/gif","image/jpeg","image/png","application/pdf","application/zip"),
											"file_name"									=> "download_file_name",
											"is_index"									=> "UnIndexed",
										),
										"download_file_name" => array(
											"champ"										=> "download_file_name",
											"title"										=> $this->_get_lexique('Nom du fichier',1),
											"type"										=> "notvisible",
											"verif"										=> array("readonly"),
										),
										"download_content" => array(
											"champ"										=> "download_content",
											"title"										=> $this->_get_lexique('Couvertures',1),
											"type"										=> "image",
											"maxfilesize"								=> 1024000,
											"allowedFileExtensions"						=> "jpeg,jpg,gif,png",
											"allowedFileTypes"							=> array("image/gif","image/jpeg","image/png"),
											"special_path"								=> '{SEPCIAL_PATH}',
											"path"										=> "downloads/cover/",
											"vtype"										=> "inside",
										),
										"download_category" => array(
											"champ"									=> "download_category",	
											"title"									=> $this->_get_lexique('Catégorie',1),
											"type"									=> "field_list",
											"table_link"							=>  "download_categories",
											"champ_link"							=> "category_label",
											"cle_link"								=> "category_id",
											"condition_link"						=> array("online=1","archive=0"),
											"on_list"								=> true,
											"list_css"								=> "width:30%;",
											"verif"									=> array("mandatory"),
											"is_index"								=> "Keyword",
										),					
									),
									"auto_fields"	=> array(
										"download_date" => array("champ"=>"download_date", "value"=>date("Y-m-d H:i:s"), "action"=>"add")
									),
);
$a_config[1]['external'][0] = array(
		"table"			=> "download_detail",
		 "code"			=> "download_detail",
		 "tri"			=> "lang ASC",
		 "key"			=> "detail_download",
		 "cle"			=> "detail_id",
);
foreach($this->a_config_lang as $_key => $lang){
	$a_config[1]['external'][0]['languages'][$lang->lang_id] = array(
		"detail_label" => array(
			"champ"				=> "detail_label_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Titre',1),
			"type"				=> "varchar",
			"maxlength"			=> 255,
			"is_index"			=> "Text",											
			"on_list"			=> true,
		),
		"detail_text" => array(
			"champ"				=> "detail_text_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Descriptif',1),
			"type"				=> "tiny_mce",
			"class"				=> "big",
			"is_index"			=> "UnStored",
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
function do_before_download()
{
	global $starter, $s_module, $s_config, $a_list_view, $o_result_before, $s_action, $s_form_valId, $s_form_page ;
	
	$s_special_path = date("Ymd_his") ;
	
	if($s_action == "edit")
	{
		$a_data_query = array(
			'download_id' => array(intval($s_form_valId),PDO::PARAM_INT),
		);	

		$s_query ="
			SELECT download_content
			FROM download
			WHERE download_id = :download_id";
		
		if($starter->isApi ){
			$_data = array();
			$_data['download_id'] = intval($s_form_valId);

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getContent', $_data);
			$o_result = $curlApiRequest;
		}else{
			$o_result = $starter->database->prepare_query($s_query,$a_data_query);
		}

		if(!is_bool($o_result) && !empty($o_result['download_content'])) 
			$s_special_path  = $o_result['download_content'] ;

	}
	$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['download_content']['special_path'] = preg_replace('#{SEPCIAL_PATH}#',$s_special_path,$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['download_content']['special_path']);
}

function do_after_download()
{
	global $starter, $_id, $s_form_valId ;
	$iInsert = (!empty($s_form_valId ) ? $s_form_valId  : $_id);
	
	foreach($starter->a_config_lang as $_key => $lang)
	{
		$s_referer = $starter->utils->xtTraiter((isset($_POST['detail_referer_' . $lang->lang_id]) && !empty($_POST['detail_referer_' . $lang->lang_id]) ? $_POST['detail_referer_' . $lang->lang_id] : (!empty($_POST['detail_label_' . $lang->lang_id]) ? $_POST['detail_label_' . $lang->lang_id] : $_POST['download_label'])));
		
		$a_data_query = array(
			'detail_referer' => array($s_referer,PDO::PARAM_STR),
			'detail_download' => array($iInsert,PDO::PARAM_INT),
			'lang' => array($lang->lang_id,PDO::PARAM_INT),
		);

		$_s_query = "
			SELECT detail_referer 
			FROM download_detail
			WHERE detail_referer = :detail_referer
			AND detail_download != :detail_download
			AND lang = :lang";
		
		if($starter->isApi ){
			$_data = array();
			$_data['detail_referer'] = $s_referer;
			$_data['detail_download'] = $iInsert;
			$_data['lang'] = $lang->lang_id;

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=getReferer', $_data);
			$o_result = $curlApiRequest;
		}else{
			$o_result = $starter->database->prepare_query($_s_query,$a_data_query);
		}
		
		if($o_result != NULL) 
			$s_referer = $starter->database->setReferer(0, 'detail_referer', $s_referer, $_s_query, $a_data_query);
		
		$a_data_query = array(
			'detail_referer' => array($s_referer,PDO::PARAM_STR),
			'detail_download' => array($iInsert,PDO::PARAM_INT),
			'lang' => array($lang->lang_id,PDO::PARAM_INT),
		);

		$s_query_update_referer = "
			UPDATE download_detail
			SET detail_referer = :detail_referer			
			WHERE detail_download = :detail_download
			AND lang = :lang";
		
		if($starter->isApi ){
			$_data = array();
			$_data['detail_referer'] = $s_referer;
			$_data['detail_download'] = $iInsert;
			$_data['lang'] = $lang->lang_id;

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Download&rquest=setReferer', $_data);
			$_tmp = $curlApiRequest;
		}else{
			$_tmp = $starter->database->prepare_query($s_query_update_referer, $a_data_query);
		}
	}
}
?>
