<?php
// output REL
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href' => '/!locked/lib/jquery/css/jquery-ui.css');
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href' => '/templates/' . $starter->s_template . '/modules/admin/!locked/css/main.css');
$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href' => '/templates/' . $starter->s_template . '/css/tiny_style.css');

$starter->a_js[] = array("src" => '/!locked/lib/jquery/js/jquery-ui.js');
$starter->a_js[] = array('src' => '/!locked/lib/tinymce/tinymce.min.js');
$starter->a_js[] = array('src' => '/!locked/lib/tinymce/plugins/moxiemanager/js/moxman.api.min.js');
$starter->a_js[] = array('src' => '/!locked/js/main.js');
$starter->a_js[] = array('src' => '/templates/' . $starter->s_template . '/modules/admin/!locked/js/main.js');
?>