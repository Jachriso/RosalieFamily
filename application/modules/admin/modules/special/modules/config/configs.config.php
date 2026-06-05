<?php
$a_config[0] = array(
					 "name"					=> $this->_get_lexique('Modules',1),
					 "addon"				=> "default",
					 "table"				=> "tree_module",
					 "code"					=> "module",
					 "tri"					=> "module_id ASC",
					 "cle"					=> "module_id",
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
												"module_name" => array(
													"champ"						=> "module_name",
													"title"						=> $this->_get_lexique('Nom',1),
													"on_list"					=> true,
													"type"						=> "varchar",
													"maxlength"					=> 255,
												),
												"module_path" => array(
													"champ"						=> "module_path",
													"title"						=> $this->_get_lexique('chemin',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
												),
											),			
					"auto_fields"	=> array(
					),
);
?>