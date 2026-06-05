<?php
$a_config[0] = array(
					 "name"					=> $this->_get_lexique('Languages',1),
					 "addon"				=> "default",
					 "table"				=> "langs",
					 "code"					=> "langs",
					 "tri"					=> "lang_name ASC",
					 "cle"					=> "lang_id",
					 "condition"			=> "",					 
    				 "actions"				=> array('edit', 'delete'),
    				 "more_actions"			=> array('add'),
					 "champs"				=> array(
												"online" => array(
													"champ"						=> "online",
													"title"						=> $this->_get_lexique('En ligne',1),
													"type"						=> "checkbox",
													"on_list"					=> true
												),
												"lang_ref" => array(
													"champ"						=> "lang_ref",
													"title"						=> $this->_get_lexique('referer',1),
													"type"						=> "varchar",
													"maxlength"					=> 2,
													"verif"						=> array("mandatory"),
													"on_list"					=> true,
													"list_css"					=> "width:7%;"
												),
												"lang_name" => array(
													"champ"						=> "lang_name",
													"title"						=> $this->_get_lexique('Nom',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
													"verif"						=> array("mandatory"),
													"on_list"					=> true,
													"list_css"					=> "width:10%;",
												),										
												"lang_translation" => array(
													"champ"						=> "lang_translation",
													"title"						=> $this->_get_lexique('Code pays_LANGUE',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
													"verif"						=> array("mandatory"),
													"on_list"					=> true,
													"list_css"					=> "width:20%;",
												),
											),			
					"auto_fields"	=> array(
					),
);
?>
