<?php
/*
 * jQuery File Upload Plugin PHP Example 5.14
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

error_reporting(E_ALL | E_STRICT);
session_start();
if(isset($_SESSION['user_info']) && ($_SESSION['user_info']["user_statut"] == "2" || $_SESSION['user_info']["user_statut"] == "0") && isset($_SERVER['HTTP_REFERER']) && preg_match("#/plugins/image.html#",$_SERVER['HTTP_REFERER'])){
	$specialdir = (isset($_SESSION['specialdir']) ? $_SESSION['specialdir'] : (isset($_GET['specialdir']) ? htmlentities($_GET['specialdir']) : (isset($_POST['specialdir']) ? htmlentities($_POST['specialdir']) : '')));
	$specialdir = preg_replace('#\.\.\/#','',$specialdir);
	require('UploadHandler.php');
	$upload_handler = new UploadHandler(array(
		'image_versions' => array(
			'thumbnail' => array(
	            'max_width' => 300,
	            'max_height' => 170,
				'upload_dir' => dirname( __FILE__ ) . '/../../../../content/bdd/' . $specialdir . '/thumbs/',
	    		'upload_url' => $_SERVER['DOMAIN_NAME'] . '/content/bdd/' . $specialdir . '/thumbs/')),
		'upload_dir' => dirname( __FILE__ ) . '/../../../../content/bdd/' . $specialdir . '/',
	    'upload_url' => $_SERVER['DOMAIN_NAME'] . '/content/bdd/' . $specialdir . '/'));
}else
exit();