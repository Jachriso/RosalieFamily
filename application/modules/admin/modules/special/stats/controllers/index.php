<?php
// init vars
$a_errors = array();
$s_output = '';
$s_page = (!empty($s_form_page) ? $s_form_page : 'tree');
$s_include_page = '';
$_key = $s_module;
$s_date_start = date("Y-m") . '-00';// mois courant
$s_date_end = date("Y-m-d");// mois courant
$s_form_date_start = (isset($_POST['date_start']) ? htmlentities($_POST['date_start']) : '');
$s_form_date_end = (isset($_POST['date_end']) ? htmlentities($_POST['date_end']) : '');
$a_fields = array(
	'date_start'	=> array(
		"type"				=> "date",
		"label"				=> '',
		"default_value"		=> '',		
		"error_label"		=> $starter->_get_lexique('erreur de saisie de date',1),
	),
	'date_end'	=> array(
		"type"				=> "date",
		"label"				=> '',
		"default_value"		=> '',		
		"error_label"		=> $starter->_get_lexique('erreur de saisie de date',1),
	),	
);

if($starter->utils->is__countable($starter->stats) && count($starter->stats) > 0)
{	
	if($_SESSION['user_info']['user_statut'] == "0" || (!is_array($a_config_rules) && isset($a_config_rules->$_key)) || (is_array($a_config_rules) && isset($a_config_rules[$_key])))
	{
		if(!empty($s_form_date_start)) 
			$s_date_start = substr($s_form_date_start,6,4) . '-' . substr($s_form_date_start,3,2) . '-' . substr($s_form_date_start,0,2) ;
		if(!empty($s_form_date_end)) 
			$s_date_end = substr($s_form_date_end,6,4) . '-' . substr($s_form_date_end,3,2) . '-' . substr($s_form_date_end,0,2) ;
					

		if($starter->utils->is__countable($_POST) && count($_POST) > 0)
		{
			require_once LIBRARY_PATH . '/form_checker.class.php' ;
		
			$starter->checkForm = new form_checker($a_fields);
			
			// output
			if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0)
				$_SESSION['WARNING'] = array(
					'type' => 'error',
					'content' => $starter->checkForm->a_errors
				) ;
			
			else
			{
				foreach($starter->stats as $key => $modules_stats)
				{
					require_once LIBRARY_PATH . '/' . $modules_stats . '.class.php' ;
					$_tmp = $modules_stats;
					if(class_exists($modules_stats, true))
					{
						extract(array($modules_stats => $modules_stats));
						$modules_stats = new $modules_stats($s_date_start, $s_date_end );
						$starter->stats[$key] = $modules_stats;			
						$starter->stats[$key]->name = $_tmp;
					}
				}
			}		
		}

		if(isset($_POST['action']) && $_POST['action'] == "export")
		{
				
			header('Content-Description: File Transfer');
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: inline; filename=stats.xls');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: no-cache');
			//header('Content-Length: ' . filesize($s_file));
		
			require_once dirname(__FILE__) . '/../views/index.xls.php' ;		
		
			//readfile($s_file);
			echo $s_output; 
			exit;	

		}
	}
}
// rel files
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/lib/jquery/css/jquery-ui.css');
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/template/default/css/form.css');
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/template/default/modules/special/stats/css/main.css');

// JS
$starter->a_js[] 	= array("src"=> "/!locked/lib/jquery/js/jquery-ui.js");
$starter->a_js[] 	= array("src"=> "/!locked/lib/jquery/js/jquery.canvasjs.min.js");

if($starter->s_lang == "fr") 
	$starter->a_js[] 	= array("src"=> "/!locked/lib/jquery/js/jquery.ui.datepicker-fr.js");
$starter->a_js[] 	= array("src"=> '/templates/' . $starter->s_template . '/modules/admin/template/default/modules/special/stats/js/main.js');

//output
$include_page = '/modules/admin/modules/special/stats/views/index.php' ;
?>
