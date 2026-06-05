<?php
$a_config[0] = array(
					 "name"					=> $this->_get_lexique('Liste sémantique',1),
					 "addon"				=> "default",
					 "table"				=> "search",
					 "code"					=> "search",
					 "tri"					=> "search_title ASC",
					 "cle"					=> "search_id",
					 "condition"			=> " archive = 0",					 
    				 "actions"				=> array('edit', 'delete'),
    				 "more_actions"			=> array('add', 'search'),
					 "champs"				=> array(
												"online" => array(
													"champ"						=> "online",
													"title"						=> $this->_get_lexique('En ligne',1),
													"type"						=> "checkbox",
													"on_list"					=> true
												),
												"search_title" => array(
													"champ"						=> "search_title",
													"title"						=> $this->_get_lexique('Titre',1),
													"type"						=> "varchar",
													"maxlength"					=> 255,
													"verif"						=> array("mandatory"),
													"on_list"					=> true,
													"list_css"					=> "width:10%;",
												),										
												"search_content" => array(
													"champ"						=> "search_content",
													"title"						=> $this->_get_lexique('Contenu de la liste',1),
													"type"						=> "textarea",
													"on_list"					=> true,
													"list_css"					=> "width:20%;",
												),
											),			
					"auto_fields"	=> array(
					),
);
function do_after_search()
{
	global $starter, $_id, $s_form_valId;
	$iInsert = (!empty($s_form_valId) ? $s_form_valId : $_id);
	$_s_list = explode(',',$_POST["search_content"]);
	$a_data_query = array(
		'search_list' => array('{\"item\":" . json_encode($_s_list) . "}',PDO::PARAM_STR),
		'search_id' => array(intval($iInsert),PDO::PARAM_INT),
	);	
	$s_query ="
		UPDATE search
		SET search_list = :search_list
		WHERE search_id = :search_id";
			
	$o_result = $starter->database->prepare_query($s_query,$a_data_query);
}
?>