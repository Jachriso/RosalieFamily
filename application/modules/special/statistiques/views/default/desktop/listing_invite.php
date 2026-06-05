<section class="padB80">
    <div class="container">
        <div class="overview relative flex alignfC">
            <div class="inlineb">
                <div class="title margH20 padV5">
                    <span class="ft25 ftLH30"><?php echo $starter->_get_lexique("Toutes les invitations");?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="container pad20">
        <div class="row g-3">
            <div class="col-sm-6 col-12">
                <div class="back1 pad20 relative">
                    <div class="row">
                        <div class="col-12">
                            <svg class="" xmlns="http://www.w3.org/2000/svg" width="22.77" height="23.031" viewBox="0 0 22.77 23.031">
                                <path id="Tracé_79" data-name="Tracé 79" d="M44.992,23.357a2.334,2.334,0,0,0-1.9-.972H36.986a.228.228,0,0,1-.181-.088.222.222,0,0,1-.048-.2l1.248-5.965A2.4,2.4,0,0,0,37.4,14a2.395,2.395,0,0,0-3.723.316l-5.328,7.942a.234.234,0,0,1-.195.1h-.159A1.52,1.52,0,0,0,26.484,21h-2.3a1.526,1.526,0,0,0-1.524,1.525V34.052a1.526,1.526,0,0,0,1.524,1.525h2.3a1.525,1.525,0,0,0,1.5-1.262h.38a.239.239,0,0,1,.152.057l1.6,1.36a2.324,2.324,0,0,0,1.5.552H39.97A2.331,2.331,0,0,0,42.178,34.7l3.128-9.237a2.341,2.341,0,0,0-.314-2.107M26.965,34.052a.481.481,0,0,1-.481.481h-2.3a.48.48,0,0,1-.48-.481V22.528a.481.481,0,0,1,.48-.481h2.3a.482.482,0,0,1,.481.481Zm17.352-8.924-3.129,9.239a1.287,1.287,0,0,1-1.218.874H31.616a1.281,1.281,0,0,1-.828-.3l-1.6-1.36a1.278,1.278,0,0,0-.828-.306h-.307V23.4h.095a1.28,1.28,0,0,0,1.062-.566L34.54,14.9a1.349,1.349,0,0,1,2.442,1.027l-1.246,5.966a1.276,1.276,0,0,0,1.25,1.539H43.1a1.289,1.289,0,0,1,1.22,1.7" transform="translate(-22.658 -13.253)" class="fillred"/>
                            </svg>
                        </div>
                        <div class="col-md-6 col-12">
                            <p class="ft20 ftblack ftLH26 margT20" ><?php echo $starter->_get_lexique("Invitation(s) envoyée(s)") ;?></p>
                        </div>
                        <div class="col-md-6 col-12">
                            <p class="ft40 ftblack ftLH46 alignR alignL-sm margT20 margT0-sm" ><?php echo count($stats->statistiques->a_data);?></p>
                        </div>
                        <div class="col-12">
                            <div class="listing">
<?php foreach($stats->statistiques->a_data AS $key => $val){?>
                                <div class=" row g-3">
                                    <div class="col-12">
                                        <div class="">
                                            <?php echo $starter->_get_lexique("De") . " " . $val['sender_firstname'] . " " . $val['sender_lastname'] . " " . $val['sender_email'] . " " . $starter->_get_lexique("à") . " " . $val['receiver_firstname'] . " " . $val['receiver_lastname'] . " " . $val['receiver_email'] . " " . $val['invite_phone'] . " " . $val['invite_company']. " " . $val['invite_domaine'] . " " . $starter->_get_lexique("le") . " " . $starter->utils->format_date("dd-mm-YYYY",$val['invite_date'], true, ' ');?>
                                        </div>
                                    </div>
                                </div>
<?php 
}?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>