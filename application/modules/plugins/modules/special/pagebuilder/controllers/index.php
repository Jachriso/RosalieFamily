<?php
//init vars
$s_form_mode					= (isset($_GET['mode']) ? htmlentities($_GET['mode']) : '');
$s_form_field					= (isset($_GET['field']) ? htmlentities($_GET['field']) : '');
$s_form_fieldedit				= (isset($_GET['fieldedit']) ? htmlentities($_GET['fieldedit']) : '');
$s_form_valId					= (isset($_GET['val_id']) ? htmlentities($_GET['val_id']) : '');
$s_form_page					= (isset($_GET['page']) ? htmlentities($_GET['page']) : '');
$s_form_data = (isset($_GET['data']) ? htmlentities($_GET['data']) : '');
$s_form_ilang = (isset($_GET['ilang']) ? htmlentities($_GET['ilang']) : 1);
$s_form_plugin = (isset($starter->_special_GET['plugin']) ? htmlentities($starter->_special_GET['plugin']) : '');
$s_form_templates = (isset($_GET['templates']) ? htmlentities($_GET['templates']) : '');
$s_form_grids = (isset($_GET['grids']) ? htmlentities($_GET['grids']) : '');
$s_form_part = (isset($_GET['part']) ? htmlentities($_GET['part']) : '');
$s_form_key = (isset($_GET['key']) ? htmlentities($_GET['key']) : '');

if(!isset($s_form_mode))
	require_once dirname( __FILE__ ) . "/addon.php";
else
{
	switch($s_form_mode)
	{
		default:
		case '':
			require_once dirname( __FILE__ ) . "/addon.php";
		break;

		case 'media-popup'	:
			require_once dirname( __FILE__ ) . "/media-popup.php";
		break;

		case 'save'	:
			require_once dirname( __FILE__ ) . "/save.php";
		break;
	}
}
?>