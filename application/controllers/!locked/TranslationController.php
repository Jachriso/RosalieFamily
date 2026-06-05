<?php
// init
$s_form_lang = (isset($_GET['lang']) ? htmlentities($_GET['lang']) : '');
$s_form_level1 = (isset($_GET['level1']) ? htmlentities($_GET['level1']) : '');

$a_config_lang  = array();
// controller

if($this->isApi ){
	$a_config_lang = $this->_get_langue();
}else{
	$s_query = "
		SELECT * 
		FROM langs 
		WHERE online = 1 
		AND archive = 0";
	$a_config_lang = $this->database->prepare_query($s_query, array(), 'multiple', 'lang_id');
	$a_config_lang = json_decode(json_encode($a_config_lang), FALSE);

	$s_query = "
		SELECT lang_ref 
		FROM langs
		WHERE online = 1 
		AND archive = 0
		AND lang_def = 1";
	$def_config_lang = $this->database->prepare_query($s_query, array());
}

if(!empty($s_form_lang))
{
	if(!$this->isApi ){
		$a_data_query = array(
    		'lang_ref' => array($_GET['lang'],PDO::PARAM_STR),
		);		

		$s_query = "
			SELECT lang_id, lang_ref, lang_translation, lang_name, lang_herit 
			FROM langs 
			WHERE lang_ref = :lang_ref";
		//if($_GET['level1'] != 'admin')
		$s_query .= " 
				AND online = 1 
				AND archive = 0";
		$_lang = $this->database->prepare_query($s_query, $a_data_query, 'single', 'lang_id');
	}else
		$_lang = (array)$a_config_lang->$s_form_lang;

	if($_lang && is_array($_lang))
	{
		$this->s_translation = $_lang['lang_translation'] ;
		$this->i_lang = $_lang['lang_id'] ;
		$this->s_lang = $_lang['lang_ref'] ;
	}
	else
	{
		if((!empty($s_form_level1) && $s_form_level1 != 'media_download' && $s_form_level1 != 'media_upload' && $s_form_level1 != 'mediag_download' && $s_form_level1 != 'pdf_viewer') || !isset($starter->b_module) || !$starter->b_module)
		{
			header("Location:" . $this->HTTP_ROOT . 'fr') ;
			exit ;
		}
	}
	unset($_lang);
	$this->_set_lexique();
}
elseif(( empty($s_form_level1) || (!empty($s_form_level1) && $s_form_level1 != 'media_download' && $s_form_level1 != 'media_upload' && $s_form_level1 != 'plugins' && $s_form_level1 != 'pdf_viewer')) && (!isset($starter->b_module) || !$starter->b_module) && $this->b_multilang)
{
	$_tmp = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) . '/' ;
	
	$a_data_query = array(
		'lang_ref' => array($_tmp,PDO::PARAM_STR),
	);

	$s_query = "
		SELECT * 
		FROM langs 
		WHERE lang_ref = :lang_ref
		AND online = 1
		AND archive = 0";
		
	$_lang = $this->database->prepare_query($s_query,$a_data_query);
	if($_lang && is_array($_lang))
	{
		header("Location:" . $this->HTTP_ROOT . $_tmp) ;
		exit ;
	}
	elseif($def_config_lang != false && isset($def_config_lang['lang_ref']))
	{
		header("Location:" . $this->HTTP_ROOT . $def_config_lang['lang_ref']) ;
		exit ;

	}
	else
	{
		header("Location:" . $this->HTTP_ROOT . 'fr') ;
		exit ;

	}
}else
	$this->_set_lexique();
?>