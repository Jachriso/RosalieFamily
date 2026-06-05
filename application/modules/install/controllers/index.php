<?php
// init vars
$a_data = array();
$a_errors = array();

$a_fields = array(	
	'dbname'	=> 
		array(
			"field"			=>  "dbname",
			"type"			=>  "text",
			"verif"			=>	array("mandatory"),
			"label"			=>	'Nom de la base de données',
			"maxlength"		=>	50,
			"error_label"	=>	''
		),
	'uname'	=>	
		array(			
			"field"			=>  "uname",
			"type"			=>	"text",
			"verif"			=>	array("mandatory"),
			"label"			=>	"Identifiant d'utilisateur MySQL.",
			"maxlength"		=>	255, 
			"error_label"	=>  ''
		),
	'pwd'	=> 
		array(
			"field"			=>  "pwd",
			"type"			=>	"text",
			"label"			=>	"Mot de passe de l'utilisateur MySQL",
			"maxlength"		=>	255,
			"error_label"	=>  ''
		),
	'dbhost'	=> 
		array(
			"field"			=>  "dbhost",
			"type"			=>	"text",
			"verif"			=>	array("mandatory"),
			"label"			=>	"Host de la base de données",
			"maxlength"		=>	255,
			"error_label"	=>  ''
		),
	'prefix'	=> 
		array(
			"field"			=>  "prefix",
			"type"			=>	"text",
			"verif"			=>	array("mandatory"),
			"label"			=>	"Préfixe des tables",
			"maxlength"		=>	255,
			"error_label"	=>  ''
		),
	'language'	=> 
		array(
			"field"			=>  "language",
			"type"			=>	"field_list",
			"verif"			=>	array("mandatory"),
			"label"			=>	"Language par défaut",
			"maxlength"		=>	255,
			"error_label"	=>  ''
		),
);

if($starter->utils->is__countable($_POST) && count($_POST) > 0)
{
	require_once LIBRARY_PATH . '/form_checker.class.php' ;
	$starter->checkForm = new form_checker($a_fields);

	if($starter->utils->is__countable($starter->checkForm->a_errors) && count($starter->checkForm->a_errors) > 0)
	{
		$_SESSION['WARNING'] = array(
			'type' => 'error',
			'content' => $starter->checkForm->a_errors
		) ;
	}
	else
	{		
		$starter->_set_db_config($_POST['dbhost'], $_POST['uname'], $_POST['pwd'], $_POST['dbname'], $_POST['prefix']);
		$starter->is_install = $starter->_db_param();

		if($starter->is_install)
		{			
			$starter->_init_db();
		
			$s_query = $starter->sql;
			
			$starter->database->prepare_query($s_query,$a_data_query);
		}
		else{
			$starter->_set_db_config('','','','','');
		}
		
		header("Location:" . $_SERVER['REQUEST_URI']);	
		exit();
		
	}
}
		

// rel files
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/!locked/css/main.css'); 
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/!locked/css/form.css');
		
$starter->a_js[] = array("src"=> '/templates/' . $starter->s_template . '/modules/admin/!locked/js/main.js');
$starter->a_js[] = array("src"=> '/templates/' . $starter->s_template . '/modules/admin/!locked/js/edit.js');
//output

$starter->a_include_pages[]  = '/modules/install/views/header.php' ;

$starter->a_include_pages[]  = '/modules/install/views/index.php' ;

$starter->a_include_pages[]  = '/modules/install/views/footer.php' ;

?>