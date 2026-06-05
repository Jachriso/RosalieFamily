<?php
/******************************************/
//INIT VARS
/******************************************/
$b_error = false;
$a_data = $starter->_configs[$_GET['page']]['content'][$_GET['module']]['content'][$_GET['config_id']]['champs'][$_GET['field']] ;
$a_include_pages[] = '/../modules/plugins/modules/' . $s_form_plugin . '/views/addon.php';
?>
