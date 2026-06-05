<?php

// output REL
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/lib/font-awesome/css/fontawesome.min.css');
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/lib/bootstrap/css/bootstrap.min.css');
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/!locked/css/front_main.css');
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/'.$starter->s_template.'/css/fonts.css');
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/'.$starter->s_template.'/css/front_style.css');
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/'.$starter->s_template.'/css/tiny_style.css');


$starter->a_js[] = array('src' => '/!locked/lib/font-awesome/js/6aaf481e1d.js', 'crossorigin' => 'anonymous');
$starter->a_js[] = array('src' => '/!locked/lib/iconify/js/iconify-icon.min.js');
$starter->a_js[] = array('src' => '/!locked/lib/bootstrap/js/bootstrap.min.js');
$starter->a_js[] = array('src' => '/!locked/js/front_main.js');
$starter->a_js[] = array('src' => '/templates/'.$starter->s_template.'/js/front_script.js');

?>