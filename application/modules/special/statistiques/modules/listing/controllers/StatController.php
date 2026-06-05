<?php

class Statistique extends Starter
{
    private $name;
    private $s_page = 'index.php';
    public $amount = 0;
    public $mpb_amount = 0;
    public $total_amount = 0;
    public $recos_validated = 0;
    public $a_data_invite = array();
    public $a_data_recos_validated = array();
    public $a_data_mpb = array();
    public $a_data_recos = array(); 
    public $s_include_page = '';
    public $statut = '';

    function __construct() {
        $this->init();
    }

    private function init()
    {
        global $starter;

        if(!isset($_SESSION['user_info'])){
            header("Location:" . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['subscribe']['referer'] );
            exit();
        }

        $invite = new InviteController();
        $this->a_data_invite = $invite->getInvites();

        $recos = new RecoController();
        $this->a_data_recos = $recos->getRecos();
        foreach($this->a_data_recos AS $key => $val){
            $this->amount += intval($val['reco_amount']);
        }

        $this->a_data_recos_validated = $recos->getRecosByStatus(1);
        $this->recos_validated += intval($this->a_data_recos_validated['number_reco']);
        
        $mpb = new MpbController();
        $this->a_data_mpb = $mpb->getMpbs();
        foreach($this->a_data_mpb AS $key => $val){
            $this->mpb_amount += intval($val['mpb_amount']);
        }
        $this->total_amount = $this->amount + $this->mpb_amount ;

        $this->name = strtolower(get_class($this));
        $starter->cache  = $starter->mods['statistiques']['cache'];
        
        // rel files
        $s_rel_id = "listing";
        $this->view();
    }

    public function view(){
        global $starter;

        // CSS
            
        // JS

        // VIEWS

        $this->s_include_page = '/modules/special/statistiques/views/' . (is_file(APPLICATION_PATH .'/modules/special/statistiques/views/' . $starter->s_template . '/' . $starter->s_display . '/'.$this->s_page) ? $starter->s_template . '/' . $starter->s_display : $starter->s_template_default . '/' . $starter->s_display_default) . '/'.$this->s_page ;

    }
}
?>