<?php
//header("Content-Type: application/json");
$returnArray = array('result'	=>	false);

if ( !empty( $_FILES ) && $_FILES['file']['size'] > 0 ){



	$confData = json_decode($_REQUEST['confData']);



	$s_module = $confData->s_module;
	$s_form_page = $confData->s_form_page;
	$s_form_field = $confData->s_form_field;
	$s_config = $confData->s_config;

	$b_error = false;
	$a_data = (isset($starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$s_form_field]) ? $starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$s_form_field] : $starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['external'][0]['languages'][$starter->i_lang][$s_form_field]) ;


	$targ_w = (isset($a_data['width']) ? $a_data['width'] : 100);
	$targ_h = (isset($a_data['height']) ? $a_data['height'] : 100);


	$a_img_data = getimagesize($_FILES['file']['tmp_name']);

	// upload result
	$a_errors = $starter->utils->displayUploadErrors($_FILES['file']['error']) ;
	if($a_errors['error_code'] > 0){
		$b_error = true;
		$s_error = $a_errors['error_label'];
	}
	
	// checking type
	if(!$b_error)
		if(isset($a_data['allowedFileTypes']) && is_array($a_data['allowedFileTypes']) && !in_array($a_img_data['mime'], $a_data['allowedFileTypes'])){
			$b_error = true;
			$s_error = $starter->_get_lexique('Type de fichier non autorisé') ;
	}
	// checking size
	if(!$b_error){
		$i_filesize = (isset($a_data['maxfilesize']) ? $a_data['maxfilesize'] : $starter->up_max_filesize);
		if($_FILES['file']['size'] > $i_filesize){
			$b_error = true;
			$s_error = $starter->_get_lexique("Le poids de l'image excède le poids autorisé");
		}
	}
	
	// checking dimensions
	if(!$b_error){
		$i_width = $a_img_data[0] ;
		$i_height = $a_img_data[1] ;
		if(isset($a_data['width']) && $i_width < $a_data['width']){
			$b_error = true;
			$s_error = $starter->_get_lexique("Les dimensions de l'image sont incorrectes");
		}
		else if(isset($a_data['height']) && $i_height < $a_data['height']){
			$b_error = true;
			$s_error = $starter->_get_lexique('Les dimensions de l\'image sont incorrectes');
		}
	}

	// rename
	$returnArray['open_crop'] = false;
	if(!$b_error){
		$s_filename = date("Ymd_his") . $starter->utils->xtTraiter($_FILES['file']['name']) . strtolower(strrchr($_FILES['file']['name'], '.'));
		//$s_newname = (isset($a_data['secure']) && $a_data['secure'] ? $starter->uploadSecureFolder : $starter->uploadFolder) . (isset($a_data['path']) ? $a_data['path'] : '') . $s_filename ;
		$s_newname = (isset($a_data['secure']) && $a_data['secure'] ? $starter->uploadSecureFolder : $starter->uploadFolder) . $s_filename ;

		$s_file_url = $starter->CDN_PATH . '/' . $s_filename;

		if(!@move_uploaded_file($_FILES['file']['tmp_name'], $s_newname)){
			$b_error = true ;
			$s_error = $starter->_get_lexique("Une erreur est survenue pendant le transfert. Veuillez vous rapprocher de l'administrateur");
			
		}else{
			$returnArray['open_crop'] = true;
			chmod($s_newname, 0777);

		}

		
	}

	if(!$b_error){
		$returnArray['result'] = true;
		$returnArray['error'] = false;
		$returnArray['s_filename'] = $s_filename;
		$returnArray['s_filename_url'] = $s_file_url;
	}else{
		$returnArray['s_error'] = trim($s_error);
		$returnArray['error'] = true;
	}
}

echo json_encode($returnArray);
die();
?>
