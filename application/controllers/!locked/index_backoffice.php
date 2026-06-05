<?php
// init vars
$a_config_data = array();
$a_config_page = array();
$a_config_rules = 0;
$_currentRules = 0;

$s_form_page 					= (isset($_GET['page']) ? htmlentities($_GET['page']) : '');
$s_action 						= (isset($_GET['action']) ? htmlentities($_GET['action']) : '');
$s_addon 						= (isset($_GET['addon']) ? htmlentities($_GET['addon']) : 'tree');
$s_module 						= (isset($_GET['module']) ? htmlentities($_GET['module']) : '');
$s_config 						= (isset($_GET['config_id']) ? htmlentities($_GET['config_id']) : '');
$s_dsort 						= (isset($_GET['dsort']) ? htmlentities($_GET['dsort']) : '');
$s_form_sort 					= (isset($_GET['sort']) ? htmlentities($_GET['sort']) : '');
$s_form_isort 					= (isset($_GET['isort']) ? htmlentities($_GET['isort']) : '');
$s_search						= (isset($_GET['search']) ? htmlentities($_GET['search']) : '');
$s_search = preg_replace("#\(#",'',$s_search);
$s_search = preg_replace("#\)#",'',$s_search);
$s_search = preg_replace("#delete#",'',$s_search);
$s_search = preg_replace("#from#",'',$s_search);
$s_search = preg_replace("#select#",'',$s_search);
$s_search = preg_replace("#insert#",'',$s_search);
$s_search = preg_replace("#where#",'',$s_search);
$s_search = preg_replace("# alter #",'',$s_search);
$s_search = preg_replace("# table #",'',$s_search);
$s_search = preg_replace("# drop #",'',$s_search);
$s_search = preg_replace("# trunc #",'',$s_search);
$s_search = preg_replace("# or #",'',$s_search);
$s_search = preg_replace("# and #",'',$s_search);

$s_search						= htmlentities($s_search);
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
$s_form_templates 				= (isset($_GET['templates']) ? htmlentities($_GET['templates']) : '');

$starter->cache  				= $starter->mods['admin']['cache'];
$o_result_before 				= array();
$a_list_view 					= array();
$a_open_menu 					= array();
$i_range 						= 20;
$i_start 						= 0;
$i_pages 						= 1;
$include_page 					= '';
$result 						= array();
$aData 							= array();
$_aData 						= array();
$search 						= '';
$a_search 						= array();

$_key_stat = 0;
$a_top_menu = array();

//On enregistre notre token
$starter->token = bin2hex(random_bytes(32));

if($_SESSION['user_info']['user_statut'] != "0" && !empty($s_module))
{
	$a_config_rules = (!empty(json_decode($_SESSION['user_info']["user_rules"])->rules_backId) ? json_decode($_SESSION['user_info']["user_rules"])->rules_backId : '');
	$_currentRules = (!is_array($a_config_rules) ? $a_config_rules->$s_module : $a_config_rules[$s_module]);
}
require_once APPLICATION_PATH . '/configs/!locked/backoffice-inc.vars.php' ;
// controller

require_once APPLICATION_PATH . '/modules/admin/modules/menu/controllers/index.php' ;

if(isset($starter->mods['dispatch']) && $starter->mods['dispatch'])
	require_once APPLICATION_PATH . '/modules/dispatch/controllers/index.php' ;
else

	require_once APPLICATION_PATH . '/modules/admin/controllers/index.php' ;

?>
