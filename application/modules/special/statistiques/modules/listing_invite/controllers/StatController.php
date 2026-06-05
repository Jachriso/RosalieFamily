<?php

class Statistique extends Statistiques
{
    private $s_page = 'listing_invite.php';
    public $a_fields = array();
    public $a_data = array();
    public $a_data_received = array();
    public $s_include_page = '';
    public $statut = '';
    public $type = '';

    function __construct() {
        $this->init();
    }
    private function init()
    {
        global $starter;
        
        $invite = new InviteController();
        $this->a_data = $invite->getInvites();

        //CSS

        //JS

        $this->s_include_page = '/modules/special/statistiques/views/' . (is_file(APPLICATION_PATH .'/modules/special/statistiques/views/' . $starter->s_template . '/' . $starter->s_display . '/'.$this->s_page) ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/'.$this->s_page ;

        // rel files
        $s_rel_id = $starter->mods['recos']['modules']['listing']['rel'];

    }
}
?>