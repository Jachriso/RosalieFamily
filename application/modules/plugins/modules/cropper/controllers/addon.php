<?php
/******************************************/
//INIT VARS
/******************************************/

$b_error = false;

$a_data = (isset($starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$s_form_field]) ? $starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$s_form_field] : $starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['external'][0]['languages'][$starter->i_lang][$s_form_field]) ;


$targ_w = (isset($a_data['width']) ? $a_data['width'] : 100);
$targ_h = (isset($a_data['height']) ? $a_data['height'] : 100);

// uploading
if(isset($_FILES['file_uploaded']) && $_FILES['file_uploaded']['size'] > 0){

	$a_img_data = getimagesize($_FILES['file_uploaded']['tmp_name']);
	$a_img_data_more = pathinfo($_FILES['file_uploaded']['name'], PATHINFO_EXTENSION);

	// upload result
	$a_errors = $starter->utils->displayUploadErrors($_FILES['file_uploaded']['error']) ;
	if($a_errors['error_code'] > 0){
		$b_error = true ;
		$s_error = $a_errors['error_label'];
	}
	
	// checking type
	if(!$b_error)
		if(isset($a_data['allowedFileTypes']) && is_array($a_data['allowedFileTypes']) && !in_array($a_img_data['mime'], $a_data['allowedFileTypes'])){
			$b_error = true ;
			$s_error = $starter->_get_lexique('Type de fichier non autorisé') ;
	}
	if(!$b_error)
		if(((isset($a_data['allowedFileExtensions']) && !preg_match('#'.$a_img_data_more.'#', $a_data['allowedFileExtensions'])) || !isset($a_data['allowedFileExtensions'])) || isset($a_data['allowedFileTypes']) && is_array($a_data['allowedFileTypes']) && !in_array($a_img_data['mime'], $a_data['allowedFileTypes'])){
			$b_error = true ;
			$s_error = $starter->_get_lexique('Type de fichier non autorisé') ;
	}
	
	// checking size
	if(!$b_error){
		$i_filesize = (isset($a_data['maxfilesize']) ? $a_data['maxfilesize'] : $starter->up_max_filesize);
		if($_FILES['file_uploaded']['size'] > $i_filesize){
			$b_error = true ;
			$s_error = $starter->_get_lexique("Le poids de l'image excède le poids autorisé");
		}
	}
	
	// checking dimensions
	if(!$b_error){
		$i_width = $a_img_data[0] ;
		$i_height = $a_img_data[1] ;
		if(isset($a_data['width']) && $i_width < $a_data['width']){
			$b_error = true ;
			$s_error = $starter->_get_lexique("Les dimensions de l'image sont incorrectes");
		}
		else if(isset($a_data['height']) && $i_height < $a_data['height']){
			$b_error = true ;
			$s_error = $starter->_get_lexique('Les dimensions de l\'image sont incorrectes');
		}
	}

	// rename
	if(!$b_error){
		$s_filename = date("Ymd_his") . $starter->utils->xtTraiter($_FILES['file_uploaded']['name']) . strtolower(strrchr($_FILES['file_uploaded']['name'], '.'));
		$s_newname = (isset($a_data['secure']) && $a_data['secure'] ? $starter->uploadSecureFolder : $starter->uploadFolder) . (isset($a_data['path']) ? $a_data['path'] . '/' : '') . $s_filename ;

		if(!@move_uploaded_file($_FILES['file_uploaded']['tmp_name'], $s_newname)){
			$b_error = true ;
			$s_error = $starter->_get_lexique("Une erreur est survenue pendant le transfert. Veuillez vous rapprocher de l'administrateur");
		}
		else chmod($s_newname, 0777);
	}
	// cancel cropper if input image dimensions equal config
	$s_action = "crop";
	if(!$b_error && ( (isset($a_data['width']) && $i_width == $a_data['width'] && isset($a_data['height']) && $i_height == $a_data['height'])) || (isset($_POST['action']) && $_POST['action'] == "upload")){
		$s_action = "upload";	
	}
	if(!$b_error) {
		header('Location:' . $starter->HTTP_ROOT . 'plugins/' . $s_form_plugin . '.html?page=' . $s_form_page . '&module=' . $s_module . '&config_id=' . $s_config . '&lang=' . $starter->s_lang . '&ilang=' . $starter->i_lang . '&field=' . $s_form_field . '&file=' . $s_filename . '&saction=' . $s_action . '&mode=crop' );
		exit();
	}
}
$a_include_pages[] = '/../modules/plugins/modules/' . $s_form_plugin . '/views/addon.php';
?>
