<?php
/******************************************/
//INIT VARS
/******************************************/
$b_error = false;
$a_data = $starter->_configs[$s_form_page ]['content'][$s_module]['content'][$s_config]['champs'][$s_form_field] ;

$targ_w = (isset($a_data['width']) ? $a_data['width'] : 100);
$targ_h = (isset($a_data['height']) ? $a_data['height'] : 100);

$s_filename = ($_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['file'] : $s_form_file);
$s_filename_view = (isset($a_data['path']) ? $a_data['path'] .'/' : '') . $s_filename;
/******************************************************/
/************************JCROP*************************/
/******************************************************/
if (($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == "crop") || ($s_form_saction == "upload"))
{
	
	$jpeg_quality = 90;

	$src = (isset($a_data['secure']) && $a_data['secure'] ? $starter->uploadSecureFolder : $starter->uploadFolder) . (isset($a_data['path']) ? $a_data['path'] .'/' : '') . ($_SERVER['REQUEST_METHOD'] == 'POST' ? $_POST['file'] : $s_form_file);
	list($imagewidth, $imageheight, $imageType) = getimagesize($src);
			
	$imageType = image_type_to_mime_type($imageType);

	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($src); 
			break;
		case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($src); 
			break;
		case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($src); 
			break;
	}
	if(isset($a_data['multiple_size']))
	{
		foreach($a_data['multiple_size'] as $key => $val)
		{
			$name = (isset($val['name']) ? $val['name'] : '');
			$thumb_image_name = (isset($a_data['secure']) && $a_data['secure'] ? $starter->uploadSecureFolder : $starter->uploadFolder) . (isset($a_data['path']) ? $a_data['path'] .'/' : '') . ($_SERVER['REQUEST_METHOD'] == 'POST' ? $name . $_POST['file'] : $name . $s_form_file);
	
			$targ_w = $val['width'];
			$targ_h = $val['height'];
			$ratio = max($imagewidth/$targ_w, $imageheight/$targ_h);
			if(isset($s_form_saction) && $s_form_saction == "upload")
			{
				$d_img_h = ceil($imageheight / $ratio);
				$d_img_w = ceil($imagewidth / $ratio);
			}else
			{
				$d_img_h = $targ_h;
				$d_img_w = $targ_w;
			}
	
			$d_img_x = ($d_img_w < $targ_w ? ($targ_w - $d_img_w) / 2 : 0);
			$d_img_y = ($d_img_h < $targ_h ? ($targ_h - $d_img_h) / 2 : 0);
			$s_img_x = (isset($_POST['dataX']) && !empty($_POST['dataX']) ? $_POST['dataX'] : 0);
			$s_img_y = (isset($_POST['dataY']) && !empty($_POST['dataY']) ? $_POST['dataY'] : 0);
			$s_img_w = (isset($_POST['dataWidth']) && !empty($_POST['dataWidth']) ? $_POST['dataWidth'] : $imagewidth);
			$s_img_h = (isset($_POST['dataHeight']) && !empty($_POST['dataHeight']) ? $_POST['dataHeight'] : $imageheight);
	
			$newImage = imagecreatetruecolor($targ_w,$targ_h);
			$color = imagecolorallocate($newImage, 255, 255, 255);
			imagefill($newImage, 0, 0, $color);

			imagecopyresampled($newImage,$source,$d_img_x,$d_img_y,$s_img_x,$s_img_y,$d_img_w,$d_img_h,$s_img_w,$s_img_h);
			
			switch($imageType) {
				case "image/gif":
					imagegif($newImage,$thumb_image_name); 
					break;
				case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
					imagejpeg($newImage,$thumb_image_name,90); 
					break;
				case "image/png":
				case "image/x-png":
					imagepng($newImage,$thumb_image_name);  
					break;
			}
		}
	}
	else
	{
		$ratio = max($imagewidth/$targ_w, $imageheight/$targ_h);
		if($s_form_saction == "upload")
		{
			$d_img_h = ceil($imageheight / $ratio);
			$d_img_w = ceil($imagewidth / $ratio);
		}else
		{
			$d_img_h = $targ_h;
			$d_img_w = $targ_w;
		}

		$d_img_x = ($d_img_w < $targ_w ? ($targ_w - $d_img_w) / 2 : 0);
		$d_img_y = ($d_img_h < $targ_h ? ($targ_h - $d_img_h) / 2 : 0);
		$s_img_x = (isset($_POST['dataX']) && !empty($_POST['dataX']) ? $_POST['dataX'] : 0);
		$s_img_y = (isset($_POST['dataY']) && !empty($_POST['dataY']) ? $_POST['dataY'] : 0);
		$s_img_w = (isset($_POST['dataWidth']) && !empty($_POST['dataWidth']) ? $_POST['dataWidth'] : $imagewidth);
		$s_img_h = (isset($_POST['dataHeight']) && !empty($_POST['dataHeight']) ? $_POST['dataHeight'] : $imageheight);

		$newImage = imagecreatetruecolor($targ_w,$targ_h);
		$color = imagecolorallocate($newImage, 255, 255, 255);
		imagefill($newImage, 0, 0, $color);

		imagecopyresampled($newImage,$source,$d_img_x,$d_img_y,$s_img_x,$s_img_y,$d_img_w,$d_img_h,$s_img_w,$s_img_h);
		$thumb_image_name = $src;
				
		switch($imageType) {
			case "image/gif":
				imagegif($newImage,$thumb_image_name); 
				break;
			case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				imagejpeg($newImage,$thumb_image_name,90); 
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$thumb_image_name);  
				break;
		}
	}
}
// If not a POST request, display page below:
$a_include_pages[] = '/../modules/plugins/modules/' . $s_form_plugin . '/views/cropper.php';
?>
