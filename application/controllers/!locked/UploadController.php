<?php 
class UploadController extends Starter
{
	function __construct() {
    }

    public function loadUpload()
    {
    	global $starter;

    	$a_output['response_message'] = 'error';
    	$s_form_type = htmlentities($_GET['type']);
    	$s_form_folder = htmlentities($_GET['file']);
    	$b_date = (isset($_GET['date']) ? true : false);

		if(isset($_GET['upload']) && !empty($_FILES["file"])){
			if($s_form_type == "secure"){
				$uploaddir = APPLICATION_PATH . '/../secure/' . $s_form_folder . '/';
			}elseif($s_form_type == "api"){
				$uploaddir = APPLICATION_PATH . '/../../rev/wp-content/uploads/api/';
			}else{
				$uploaddir = APPLICATION_PATH . '/../web/content/bdd/';
			}
			if(isset($_GET['filename']) & !empty($_GET['filename']) ){
				$filename = $_GET['filename'];
			}else{
				$filename = $_FILES['file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$filename = basename($_FILES['file']['name'],'.'.$ext );
				$filename = $starter->utils->xtTraiter($filename) . '.'.$ext;
			}
			if($b_date)
				$filename = date("Y-m-d-his") . "_" . $filename;
			$uploadfile = $uploaddir . $filename;
			$tmp_name = $_FILES["file"]["tmp_name"];
		    $moved = move_uploaded_file($tmp_name, $uploadfile);
			if( $moved ) {
		    	$a_output['response_message'] =  $filename;
			}
			else
				$a_output['response_message'] =  "Not uploaded because of error #".$_FILES["file"]["error"];
		}elseif(isset($_GET['uploadremove']) && !empty($_POST["name"])){
			if($s_form_type == "secure"){
				$uploaddir = APPLICATION_PATH . '/../secure/' . $s_form_folder . '/';
			}elseif($s_form_type == "api"){
				$uploaddir = APPLICATION_PATH . '/../../rev/wp-content/uploads/api/';
			}else{
				$uploaddir = APPLICATION_PATH . '/../web/content/bdd/';
			}
			$uploadfile = $uploaddir . $_POST["name"];
		    if (file_exists($uploadfile)) {
		    	unlink($uploadfile);
		    	$a_output['response_message'] =  $_POST["name"];
			} 
		}
		echo json_encode($a_output);
		exit ;
    }
}
?>
