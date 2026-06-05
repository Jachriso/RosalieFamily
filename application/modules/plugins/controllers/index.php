<?php
// init vars
$starter->cache  = $starter->mods['plugins']['cache'];
$s_form_plugin = (isset($_GET['plugin']) ? htmlentities($_GET['plugin']) : '');
if(!empty($s_form_plugin) && (is_file( dirname( __FILE__ ) . '/../modules/' . $s_form_plugin . '/controllers/index.php') || is_file( dirname( __FILE__ ) . '/../modules/special/' . $s_form_plugin . '/controllers/index.php')))
{
	require_once (is_file( dirname( __FILE__ ) . '/../modules/' . $s_form_plugin . '/controllers/index.php') ? dirname( __FILE__ ) . '/../modules/' . $s_form_plugin . '/controllers/index.php' : dirname( __FILE__ ) . '/../modules/special/' . $s_form_plugin . '/controllers/index.php');
}
		
?>