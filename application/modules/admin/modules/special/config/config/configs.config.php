<?php
$a_config[0] = array(
					 "name"					=> $this->_get_lexique('Configuration générale',1),
					 "addon"				=> "default",
					 "table"				=> "config",
					 "code"					=> "config",
					 "tri"					=> "config_id ASC",
					 "cle"					=> "config_id",
					 "condition"			=> "",					 
    				 "actions"				=> array('edit'),
					 "mode"					=> "unique",
					 "val_id"				=> 1,
					 "champs"				=> array(
												"config_meta_title" => array(
													"champ"						=> "config_meta_title",
													"title"						=> $this->_get_lexique('Meta title',1),
												"on_list"				=> true,
													"type"						=> "varchar",
													"maxlength"					=> 255,
												),
												"config_meta_description" => array(
													"champ"						=> "config_meta_description",
													"title"						=> $this->_get_lexique('Meta description',1),
													"type"						=> "textarea",
												),
												"config_meta_image" => array(
													"champ"										=> "config_meta_image",
													"title"										=> $this->_get_lexique('Image',1),
													"type"										=> "image",
													"maxfilesize"								=> 1024000,
													"allowedFileExtensions"						=> "jpeg,jpg,gif,png",
													"allowedFileTypes"							=> array("image/gif","image/jpeg","image/png"),
												),
												"config_home" => array(
													"champ"				=> "config_home",
													"title"				=> $this->_get_lexique("Page d'accueil",1),
													"type"				=> "field_list",
													"table_link"		=> "tree",
													"champ_link"		=> "tree_label",
													"cle_link"			=> "tree_id",
													"condition_link"	=> array(" archive = 0"),
												),
											),			
					"auto_fields"	=> array(
					),
);
$a_config[0]['external'][0] = array(
		"table"			=> "config_detail",
		 "code"			=> "detail",
		 "tri"			=> "lang ASC",
		 "key"			=> "detail_config",
		 "cle"			=> "detail_id",
);
if($this->a_config_lang != false)
foreach($this->a_config_lang as $_key => $lang){
	$a_config[0]['external'][0]['languages'][$lang->lang_id] = array(
		"detail_title" => array(
			"champ"				=> "detail_title_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Meta title',1),
			"type"				=> "varchar",
			"maxlength"			=> 255
		),
		"detail_description" => array(
			"champ"				=> "detail_description_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Meta description',1),
			"type"				=> "textarea"
		),
	);
}
?>