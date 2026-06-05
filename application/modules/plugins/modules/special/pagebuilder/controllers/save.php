<?php
$html         =  $_POST['html'];
$htmledit     = $_POST['htmledit'];
$field        = ( !empty($_POST['fieldtosave']) ? $_POST['fieldtosave'] : '');
$fieldedit    = ( !empty($_POST['fieldtosaveedit']) ? $_POST['fieldtosaveedit'] : '');

$config = array();
if (isset($_POST['data'])) {
    foreach ($_POST['data'] as $param=>$value) {    $config[$param] = $value; }
}
$output = array(
	"response_content" => $html,
	"response_contentedit" => $htmledit,
	"response_field" => $field,
	"response_fieldedit" => $fieldedit
);
echo json_encode($output);    
exit();   
  
?>
