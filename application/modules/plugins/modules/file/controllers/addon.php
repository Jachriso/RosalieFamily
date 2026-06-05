<?php
/******************************************/
//INIT VARS
/******************************************/
$b_error = false;
$a_data = (isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$s_form_field]) ? $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$s_form_field] : $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['external'][0]['languages'][$s_form_ilang][$s_form_field]) ;

// uploading
if(isset($_FILES['file_uploaded']) && $_FILES['file_uploaded']['error'] == $starter->_get_lexique('réussi')){

	$mimeMagicFile = get_cfg_var('mime_magic.magicfile');
	$finfo = new finfo(FILEINFO_MIME, $mimeMagicFile);
	$a_file_data = explode(';',$finfo->buffer(file_get_contents($_FILES['file_uploaded']['tmp_name'])));
	$s_file_data = $a_file_data[0];
	$a_file_data['filesize'] = filesize($_FILES['file_uploaded']['tmp_name']);
	$a_img_data_more = pathinfo($_FILES['file_uploaded']['name'], PATHINFO_EXTENSION);

	// upload result
	$a_errors = $starter->utils->displayUploadErrors($_FILES['file_uploaded']['error']) ;
	if($a_errors['error_code'] > 0){
		$b_error = true ;
		$s_error = $a_errors['error_label'];
	}
	
	// checking type	
	if(!$b_error)
		if(((isset($a_data['allowedFileExtensions']) && !preg_match('#'.$a_img_data_more.'#', $a_data['allowedFileExtensions'])) || !isset($a_data['allowedFileExtensions'])) || isset($a_data['allowedFileTypes']) && is_array($a_data['allowedFileTypes']) && !in_array($a_img_data['mime'], $a_data['allowedFileTypes'])){
			$b_error = true ;
			$s_error = $starter->_get_lexique('Type de fichier non autorisé') ;
	}
	// checking size
	if(!$b_error){
		$i_filesize = (isset($a_file_data['filesize']) ? $a_file_data['filesize'] : $starter->up_max_filesize);
		
		if($_FILES['file_uploaded']['size'] > $i_filesize){
			$b_error = true ;
			$s_error = $starter->_get_lexique("Le poids de l'image excède le poids autorisé");
		}
	}
	
	// rename
	if(!$b_error){
		$s_filename = date("Ymd_his") . $starter->utils->xtTraiter($_FILES['file_uploaded']['name']) . strtolower(strrchr($_FILES['file_uploaded']['name'], '.'));
		$s_newname = (isset($a_data['secure']) && $a_data['secure'] ? $starter->uploadSecureFolder : $starter->uploadFolder) . $s_filename ;

		if(!@move_uploaded_file($_FILES['file_uploaded']['tmp_name'], $s_newname)){
			$b_error = true ;
			$s_error = $starter->_get_lexique("Une erreur est survenue pendant le transfert. Veuillez vous rapprocher de l'administrateur");
		}
		else chmod($s_newname, 0777);
	}
}
$starter->a_include_pages[]  = '/modules/plugins/modules/' . $s_form_plugin . '/views/addon.php';
?>