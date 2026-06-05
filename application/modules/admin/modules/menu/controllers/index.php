<?php
require_once 'MenuController.php';
$a_adminMenu = new AdminMenu();
$a_config_data = $a_adminMenu->a_config_data;
$a_config_page = $a_adminMenu->a_config_page;
$a_config_rules = $a_adminMenu->a_config_rules;

if(empty($a_config_rules) && $_SESSION['user_info']['user_statut'] != "0")
{
	header("Location: " . $starter->HTTP_ROOT);
	exit();
}
?>