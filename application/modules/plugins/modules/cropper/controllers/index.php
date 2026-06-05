<?php
$s_form_page 					= (isset($_GET['page']) ? htmlentities($_GET['page']) : '');
$s_action 						= (isset($_GET['action']) ? htmlentities($_GET['action']) : '');
$s_addon 						= (isset($_GET['addon']) ? htmlentities($_GET['addon']) : 'tree');
$s_module 						= (isset($_GET['module']) ? htmlentities($_GET['module']) : '');
$s_config 						= (isset($_GET['config_id']) ? htmlentities($_GET['config_id']) : '');
$s_dsort 						= (isset($_GET['dsort']) ? htmlentities($_GET['dsort']) : '');
$s_form_sort 					= (isset($_GET['sort']) ? htmlentities($_GET['sort']) : '');
$s_form_isort 					= (isset($_GET['isort']) ? htmlentities($_GET['isort']) : '');
$s_search						= (isset($_GET['search']) ? htmlentities($_GET['search']) : '');
$s_form_nav 					= (isset($_GET['nav']) ? htmlentities($_GET['nav']) : '');
$s_form_navpage 				= (isset($_GET['navpage']) ? htmlentities($_GET['navpage']) : '');
$s_form_valId 					= (isset($_GET['val_id']) ? htmlentities($_GET['val_id']) : '');
$s_form_case 					= (isset($_GET['case']) ? htmlentities($_GET['case']) : '');
$s_form_cron 					= (isset($_GET['cron']) ? htmlentities($_GET['cron']) : '');
$s_form_preview					= (isset($_GET['preview']) ? htmlentities($_GET['preview']) : '');
$s_form_field					= (isset($_GET['field']) ? htmlentities($_GET['field']) : '');
$s_form_plugin					= (isset($_GET['plugin']) ? htmlentities($_GET['plugin']) : '');
$s_form_file					= (isset($_GET['file']) ? htmlentities($_GET['file']) : '');
$s_form_saction					= (isset($_GET['saction']) ? htmlentities($_GET['saction']) : '');
$s_form_mode					= (isset($_GET['mode']) ? htmlentities($_GET['mode']) : '');
$s_form_ilang					= (isset($_GET['ilang']) ? htmlentities($_GET['ilang']) : '');
$s_form_embed					= (isset($_GET['embed']) ? htmlentities($_GET['embed']) : '');
$s_form_templates = (isset($_GET['templates']) ? htmlentities($_GET['templates']) : '');

$s_form_page                     = (isset($_GET['page']) ? htmlentities($_GET['page']) : '');
$s_action                         = (isset($_GET['action']) ? htmlentities($_GET['action']) : '');
$s_addon                         = (isset($_GET['addon']) ? htmlentities($_GET['addon']) : 'tree');
$s_module                         = (isset($_GET['module']) ? htmlentities($_GET['module']) : '');
$s_config                         = (isset($_GET['config_id']) ? htmlentities($_GET['config_id']) : '');
$s_dsort                         = (isset($_GET['dsort']) ? htmlentities($_GET['dsort']) : '');
$s_form_sort                     = (isset($_GET['sort']) ? htmlentities($_GET['sort']) : '');
$s_form_isort                     = (isset($_GET['isort']) ? htmlentities($_GET['isort']) : '');
$s_search                        = (isset($_GET['search']) ? htmlentities($_GET['search']) : '');
$s_form_nav                     = (isset($_GET['nav']) ? htmlentities($_GET['nav']) : '');
$s_form_navpage                 = (isset($_GET['navpage']) ? htmlentities($_GET['navpage']) : '');
$s_form_valId                     = (isset($_GET['val_id']) ? htmlentities($_GET['val_id']) : '');
$s_form_case                     = (isset($_GET['case']) ? htmlentities($_GET['case']) : '');
$s_form_cron                     = (isset($_GET['cron']) ? htmlentities($_GET['cron']) : '');
$s_form_preview                    = (isset($_GET['preview']) ? htmlentities($_GET['preview']) : '');
//$s_form_field                    = (isset($_GET['field']) ? htmlentities($_GET['field']) : '');
$s_form_plugin                    = (isset($_GET['plugin']) ? htmlentities($_GET['plugin']) : '');
$s_form_file                    = (isset($_GET['file']) ? htmlentities($_GET['file']) : '');
$s_form_saction                    = (isset($_GET['saction']) ? htmlentities($_GET['saction']) : '');
$s_form_mode                    = (isset($_GET['mode']) ? htmlentities($_GET['mode']) : '');
$s_form_ilang                    = (isset($_GET['ilang']) ? htmlentities($_GET['ilang']) : '');
$s_form_embed                    = (isset($_GET['embed']) ? htmlentities($_GET['embed']) : '');
$s_form_templates 					= (isset($_GET['templates']) ? htmlentities($_GET['templates']) : '');


if($s_form_mode == "crop")
	require_once dirname( __FILE__ ) . "/cropper.php";
else
	require_once dirname( __FILE__ ) . "/addon.php";


//require_once dirname( __FILE__ ) . "/vignette_upload.php";

?>