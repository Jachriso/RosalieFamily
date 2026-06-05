<?php
// init vars
$s_config = '';
$s_field = '';
$s_value = '0';
$s_key = '';
$s_item = '';
$s_page = $s_form_case ;
switch($s_page){
	default:
	case '':
		$s_html = $starter->_get_lexique('erreur de mise à jour',1);
		$a_output['response_message'] = $s_html ;
		$a_output['response_code'] = 1 ;

		// output
		echo json_encode($a_output);
		exit ;
	break;
	
	case 'vignette_upload':

		require_once APPLICATION_PATH.'/modules/plugins/modules/cropper/controllers/vignette_upload.php';

	break;

	case 'cropper':

		require_once APPLICATION_PATH.'/plugins/modules/cropper/controllers/cropper.php';

	break;

	case 'delete_element':

		require_once 'DeleteController.php';
		$delete = new Delete();

	break;

	case 'update_online':

		require_once 'UpdateOnlineController.php';
		$update = new UpdateOnline();

	break;

	case 'update_sort':

		require_once 'UpdateSortController.php';
		$update = new UpdateSort();

	break;

	case 'update_tree':

		require_once 'UpdateTreeController.php';
		$update = new UpdateTree();

	break;

	case 'add_special_grid':

		require_once dirname(__FILE__) . '/add_special_grid.php';

	break;

	case 'update_special_grid':

		require_once dirname(__FILE__) . '/update_special_grid.php';

	break;

	case 'delete_special_grid':

		require_once dirname(__FILE__) . '/delete_special_grid.php';

	break;

	case 'saveDataImg':

		require_once dirname(__FILE__) . '/saveDataImg.php';

	break;
}
?>
