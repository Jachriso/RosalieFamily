<?php
$s_current_module = (isset($o_result['module_path']) ? $o_result['module_path'] : $starter->s_level);

if(isset($starter->mods[$s_current_module])){
	$starter->b_mail   			= $starter->mods[$s_current_module]['b_mail'];
	$starter->b_print  			= $starter->mods[$s_current_module]['b_print'];
	$starter->b_pdf    			= $starter->mods[$s_current_module]['b_pdf'];
	$starter->b_breadcrumbTree  = $starter->mods[$s_current_module]['b_breadcrumbTree'];
	$starter->cache  			= $starter->mods[$s_current_module]['cache'];
	// rel files
	$s_rel_id = $starter->mods[$s_current_module]['rel'];
}
// META
$starter->utils->getmeta($starter->i_level);	
?>