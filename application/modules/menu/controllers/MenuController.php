<?php 
require_once APPLICATION_PATH . '/controllers/!locked/MenuController.php';
require_once APPLICATION_PATH . '/controllers/UsersController.php';

class Menu extends Starter
{
    public $a_footer_menu = array();
    public $a_notifications = array();

    function __construct() {
        $this->init();
    }

    private function init()
    {
        global $starter;
        $request = new MenuController();
        $this->a_footer_menu = $request->getFooter();

        $user = new UsersController();
        $starter->volants = (isset($_SESSION['user_info']['user_id']) ? $user->getVolantsByUser($_SESSION['user_info']['user_id']) : 0);
        
        //JS
        $starter->a_js[]    = array("src"=> $starter->HTTP_ROOT . "templates/".$starter->s_template."/modules/menu/js/main.js");

        //CSS
        $starter->a_css[] = array("rel"=>"stylesheet", "media"=>"all", "href"=> $starter->HTTP_ROOT . "templates/".$starter->s_template."/modules/menu/css/main.css");
    }
}
?>
