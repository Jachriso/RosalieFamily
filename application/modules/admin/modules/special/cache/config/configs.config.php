<?php
$a_config[0] = array(
					 "name"			=> $this->_get_lexique('Cache',1),
					 "addon"		=> "cache",
					 "table"		=> "tree",
					 "code"			=>"tree",
					 "tri"			=>"_order ASC",
					 "cle"			=>"tree_id",
					 "condition"	=> " ",
    				 "actions"		=> array(''),
    				 "more_actions"	=> array('purge'),
					 "champs"		=> array(
										),
					"auto_fields"	=> array(
					),
);
?>