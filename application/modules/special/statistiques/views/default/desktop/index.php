<section class="padB80">
    <div class="container">
        <div class="padT30">
            <div class="container-fluid padH20">
                <div class="row gy-5 gx-5">
                    <div class="col-12">
                        <div class=" pad10 flex alignfC relative">
                            <span class="ft25 ftblack ftLH26"><?php echo $starter->_get_lexique("Les Statistiques de REV") . " " . "VAR";?></span>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="blocContent cursor" data-uri="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['statistiques']['referer'] . '/' . $starter->mods['statistiques']['modules']['listing_reco']['referer'];?>.html">
                            <div class="back1 pad20 relative">
                                <div class="triangled absolute t-0 r-0"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <svg class="" xmlns="http://www.w3.org/2000/svg" width="22.77" height="23.031" viewBox="0 0 22.77 23.031">
                                            <path id="Tracé_79" data-name="Tracé 79" d="M44.992,23.357a2.334,2.334,0,0,0-1.9-.972H36.986a.228.228,0,0,1-.181-.088.222.222,0,0,1-.048-.2l1.248-5.965A2.4,2.4,0,0,0,37.4,14a2.395,2.395,0,0,0-3.723.316l-5.328,7.942a.234.234,0,0,1-.195.1h-.159A1.52,1.52,0,0,0,26.484,21h-2.3a1.526,1.526,0,0,0-1.524,1.525V34.052a1.526,1.526,0,0,0,1.524,1.525h2.3a1.525,1.525,0,0,0,1.5-1.262h.38a.239.239,0,0,1,.152.057l1.6,1.36a2.324,2.324,0,0,0,1.5.552H39.97A2.331,2.331,0,0,0,42.178,34.7l3.128-9.237a2.341,2.341,0,0,0-.314-2.107M26.965,34.052a.481.481,0,0,1-.481.481h-2.3a.48.48,0,0,1-.48-.481V22.528a.481.481,0,0,1,.48-.481h2.3a.482.482,0,0,1,.481.481Zm17.352-8.924-3.129,9.239a1.287,1.287,0,0,1-1.218.874H31.616a1.281,1.281,0,0,1-.828-.3l-1.6-1.36a1.278,1.278,0,0,0-.828-.306h-.307V23.4h.095a1.28,1.28,0,0,0,1.062-.566L34.54,14.9a1.349,1.349,0,0,1,2.442,1.027l-1.246,5.966a1.276,1.276,0,0,0,1.25,1.539H43.1a1.289,1.289,0,0,1,1.22,1.7" transform="translate(-22.658 -13.253)" class="fillred"/>
                                        </svg>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="ft20 ftblack ftLH26 margT20" ><?php echo $starter->_get_lexique("Recommandation(s)") ;?></p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="ft40 ftblack ftLH46 alignR alignL-sm margT20 margT0-sm" ><?php echo $stats->statistiques->recos_validated;?> / <?php echo count($stats->statistiques->a_data_recos);?></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="ft40 ftblack ftLH46 alignR margT20 margT0-sm" ><?php echo ($stats->statistiques->amount != "" ? $stats->statistiques->amount : 0) . "€";?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="blocContent cursor" data-uri="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['statistiques']['referer'] . '/' . $starter->mods['statistiques']['modules']['listing_mpb']['referer'];?>.html">
                            <div class="back1 pad20 relative">
                                <div class="triangled absolute t-0 r-0"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <svg class="" xmlns="http://www.w3.org/2000/svg" width="22.77" height="23.031" viewBox="0 0 22.77 23.031">
                                            <path id="Tracé_79" data-name="Tracé 79" d="M44.992,23.357a2.334,2.334,0,0,0-1.9-.972H36.986a.228.228,0,0,1-.181-.088.222.222,0,0,1-.048-.2l1.248-5.965A2.4,2.4,0,0,0,37.4,14a2.395,2.395,0,0,0-3.723.316l-5.328,7.942a.234.234,0,0,1-.195.1h-.159A1.52,1.52,0,0,0,26.484,21h-2.3a1.526,1.526,0,0,0-1.524,1.525V34.052a1.526,1.526,0,0,0,1.524,1.525h2.3a1.525,1.525,0,0,0,1.5-1.262h.38a.239.239,0,0,1,.152.057l1.6,1.36a2.324,2.324,0,0,0,1.5.552H39.97A2.331,2.331,0,0,0,42.178,34.7l3.128-9.237a2.341,2.341,0,0,0-.314-2.107M26.965,34.052a.481.481,0,0,1-.481.481h-2.3a.48.48,0,0,1-.48-.481V22.528a.481.481,0,0,1,.48-.481h2.3a.482.482,0,0,1,.481.481Zm17.352-8.924-3.129,9.239a1.287,1.287,0,0,1-1.218.874H31.616a1.281,1.281,0,0,1-.828-.3l-1.6-1.36a1.278,1.278,0,0,0-.828-.306h-.307V23.4h.095a1.28,1.28,0,0,0,1.062-.566L34.54,14.9a1.349,1.349,0,0,1,2.442,1.027l-1.246,5.966a1.276,1.276,0,0,0,1.25,1.539H43.1a1.289,1.289,0,0,1,1.22,1.7" transform="translate(-22.658 -13.253)" class="fillred"/>
                                        </svg>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="ft20 ftblack ftLH26 margT20" ><?php echo $starter->_get_lexique("Merci pour le business") ;?></p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="ft40 ftblack ftLH46 alignR alignL-sm margT20 margT0-sm" ><?php echo count($stats->statistiques->a_data_mpb);?></p>
                                    </div>
                                    <div class="col-12">
                                        <p class="ft40 ftblack ftLH46 alignR margT20 margT0-sm" ><?php echo ($stats->statistiques->mpb_amount != "" ? $stats->statistiques->mpb_amount : 0) . "€";?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="blocContent cursor" data-uri="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['statistiques']['referer'] . '/' . $starter->mods['statistiques']['modules']['listing_invite']['referer'];?>.html">
                            <div class="back1 pad20 relative">
                                <div class="triangled absolute t-0 r-0"></div>
                                <div class="row">
                                    <div class="col-12">
                                        <svg class="" xmlns="http://www.w3.org/2000/svg" width="23.292" height="23.177" viewBox="0 0 23.292 23.177">
                                        <g transform="translate(-23.538 -140.507)">
                                            <path data-name="Tracé 91" d="M43.49,160.07c-.145-3.574-3.327-7.769-7.484-9.029a5.564,5.564,0,1,0-4.977,0c-4.161,1.262-7.341,5.457-7.486,9.028a6.889,6.889,0,0,0,.023.9,2.642,2.642,0,0,0,2.5,2.718H40.97a2.642,2.642,0,0,0,2.5-2.718,6.888,6.888,0,0,0,.022-.9m-14.53-14a4.557,4.557,0,1,1,4.557,4.557,4.556,4.556,0,0,1-4.557-4.557m13.5,14.843a1.643,1.643,0,0,1-1.49,1.762H26.064a1.643,1.643,0,0,1-1.491-1.762,5.968,5.968,0,0,1-.023-.8c.161-3.952,4.423-8.434,8.955-8.439h.01c4.539,0,8.807,4.486,8.968,8.439a5.817,5.817,0,0,1-.023.8" class="fillred"/>
                                            <path data-name="Tracé 92" d="M46.829,149.632H44.278v-2.551h-.852v2.551H40.874v.852h2.552v2.551h.852v-2.551h2.551Z" class="fillred"/>
                                        </g>
                                        </svg>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="ft20 ftblack ftLH26 margT20" ><?php echo $starter->_get_lexique("Invitation(s) envoyée(s)") ;?></p>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <p class="ft40 ftblack ftLH46 alignR alignL-sm margT20 margT0-sm" ><?php echo count($stats->statistiques->a_data_invite);?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-12">
                        <div class="back1 pad20 relative">
                            <div class="row">
                                <div class="col-12">
                                    <svg class="" xmlns="http://www.w3.org/2000/svg" width="22.77" height="23.031" viewBox="0 0 22.77 23.031">
                                        <path id="Tracé_79" data-name="Tracé 79" d="M44.992,23.357a2.334,2.334,0,0,0-1.9-.972H36.986a.228.228,0,0,1-.181-.088.222.222,0,0,1-.048-.2l1.248-5.965A2.4,2.4,0,0,0,37.4,14a2.395,2.395,0,0,0-3.723.316l-5.328,7.942a.234.234,0,0,1-.195.1h-.159A1.52,1.52,0,0,0,26.484,21h-2.3a1.526,1.526,0,0,0-1.524,1.525V34.052a1.526,1.526,0,0,0,1.524,1.525h2.3a1.525,1.525,0,0,0,1.5-1.262h.38a.239.239,0,0,1,.152.057l1.6,1.36a2.324,2.324,0,0,0,1.5.552H39.97A2.331,2.331,0,0,0,42.178,34.7l3.128-9.237a2.341,2.341,0,0,0-.314-2.107M26.965,34.052a.481.481,0,0,1-.481.481h-2.3a.48.48,0,0,1-.48-.481V22.528a.481.481,0,0,1,.48-.481h2.3a.482.482,0,0,1,.481.481Zm17.352-8.924-3.129,9.239a1.287,1.287,0,0,1-1.218.874H31.616a1.281,1.281,0,0,1-.828-.3l-1.6-1.36a1.278,1.278,0,0,0-.828-.306h-.307V23.4h.095a1.28,1.28,0,0,0,1.062-.566L34.54,14.9a1.349,1.349,0,0,1,2.442,1.027l-1.246,5.966a1.276,1.276,0,0,0,1.25,1.539H43.1a1.289,1.289,0,0,1,1.22,1.7" transform="translate(-22.658 -13.253)" class="fillred"/>
                                    </svg>
                                </div>
                                <div class="col-md-6 col-12">
                                    <p class="ft20 ftblack ftLH26 margT20" ><?php echo $starter->_get_lexique("CA généré") ;?></p>
                                </div>
                                <div class="col-md-6 col-12">
                                    <p class="ft40 ftblack ftLH46 alignR alignL-sm margT20 margT0-sm" ><?php echo ($stats->statistiques->total_amount) . "€";?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>