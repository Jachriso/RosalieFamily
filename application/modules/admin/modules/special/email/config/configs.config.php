<?php
$a_config[0] = array(
					 "name"					=> $this->_get_lexique('Emails',1),
					 "addon"				=> "default",
					 "table"				=> "emails",
					 "code"					=> "email",
					 "tri"					=> "email_id ASC",
					 "cle"					=> "email_id",
					 "condition"			=> " archive = 0",						 
    				 "actions"				=> array('edit', 'delete'),
    				 "more_actions"			=> array('add'),
					 "champs"				=> array(
												"online" => array(
														"champ"					=> "online",
														"title"					=> $this->_get_lexique('Online',1),
														"type"					=> "checkbox",
														"on_list"				=> true
												),
												"email_label" => array(
													"champ"						=> "email_label",
													"title"						=> $this->_get_lexique('Nom',1),
													"on_list"					=> true,
													"type"						=> "varchar",
													"maxlength"					=> 255,
												),
											),			
					"auto_fields"	=> array(
					),
);
$a_config[0]['external'][0] = array(
		"table"			=> "email_detail",
		 "code"			=> "detail",
		 "tri"			=> "lang ASC",
		 "key"			=> "detail_email",
		 "cle"			=> "detail_id",
);
if($this->a_config_lang != false)
foreach($this->a_config_lang as $_key => $lang){
	$a_config[0]['external'][0]['languages'][$lang->lang_id] = array(
		"detail_label" => array(
			"champ"				=> "detail_label_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Nom',1),
			"type"				=> "varchar",
			"maxlength"			=> 255
		),
		"detail_title" => array(
			"champ"				=> "detail_title_" . $lang->lang_id,
			"title"				=> $this->_get_lexique('Titre',1),
			"type"				=> "varchar",
			"maxlength"			=> 255
		),
		"detail_text" => array(
			"champ"				=> "detail_text_" . $lang->lang_id,
			"title"				=> $this->_get_lexique("Corps de l'email",1),
			"champeditchamp"	=> "detail_textedit",
			"champedit"			=> "detail_textedit_" . $lang->lang_id,
			"type"				=> "pagebuilder",
			"vtype"				=> "inside",
			"origin"			=> "special",
			"templates"			=> 'paragraph,image,button,code',
			"is_index"			=> "UnStored",
		),
	);
}
?>