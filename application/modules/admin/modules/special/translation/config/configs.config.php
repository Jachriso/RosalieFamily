<?php
$a_config[0] = array("name"			=>$this->_get_lexique('Dictionnaire',1),
					 "addon"		=>"default",
					 "table"		=>"translation",
					 "code"			=>"translation",
					 "tri"			=>"t0.translation_id ASC",
					 "cle"			=>"translation_id",
					 "condition"	=> " t0.archive = 0",	
    				 "actions"		=> array('edit', 'delete'),
    				 "more_actions"	=> array('search', 'nav'),
    				 "optim_search" 		=> array(
												"translation_type" => array(
													"champ"									=> "translation_type",	
													"title"									=> $this->_get_lexique('Destination',1),
													"type"									=> "field_list",
													"data"									=> array(
																									"0"			=> "Front Office",
																									"1"			=> "Back Office",
																								),
												),
					 ),
					 "champs"		=>array(
										"translation_label" 		=> array(
												"champ"							=> "translation_label",
												"title"							=> $this->_get_lexique('Mot',1),
												"type"							=> "varchar",
												"maxlength"						=> 255,
												"verif"							=> array("readonly"),
												"on_list"						=> true
										),
										"translation_type" 		=> array(
												"champ"							=> "translation_type",
												"title"							=> $this->_get_lexique('Destination',1),
												"type"							=> "field_list",
												"data"							=> array(
																							"0"			=> "Front Office",
																							"1"			=> "Back Office",
																					),
												"on_list"						=> true
										),
										"translation_page" 		=> array(
												"champ"							=> "translation_page",
												"title"							=> $this->_get_lexique('Cible',1),
												"type"							=> "field_list",
												"table_link"					=> "tree",
												"champ_link"					=> "tree_label",
												"cle_link"						=> "tree_id",
												"on_list"						=> true
										),
									)
);
$a_config[0]['external'][0] = array(
		"table"			=> "translation_detail",
		 "code"			=> "detail",
		 "tri"			=> "lang ASC",
		 "key"			=> "translate_translation",
		 "cle"			=> "translate_id",
);
if($this->a_config_lang != false)
foreach($this->a_config_lang as $_key => $lang){
	$a_config[0]['external'][0]['languages'][$lang->lang_id] = array(
		"translate_label" => array(
			"champ"			=> "translate_label_" . $lang->lang_id,
			"title"			=> $this->_get_lexique('Traduction',1),
			"type"			=> "tiny_mce",
			"switchtype"	=> array("0"=>"tiny_mce", "1"=>"textarea"),
			"on_list"		=> true
		),
	);
}
?>