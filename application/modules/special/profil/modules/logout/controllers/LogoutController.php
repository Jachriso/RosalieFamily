<?php
require_once APPLICATION_PATH . '/controllers/UserController.php';
class Profil extends Profils
{
	function __construct() {
        $this->init();
    }
    private function init()
    {
    	global $starter;

    	header("Location: " . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['login']['modules']['logout']['referer']);
		exit();
    }
}
?>