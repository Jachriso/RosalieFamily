    <nav class="navbar nav-bt navbar-light navbar-expand fixed-bottom backblack ">
        <div class="relative fullW ">
            <!-- <div class="absolute centerW t--45">
                <a class="addCovoit" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['new_covoiturage']['referer'];?>.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="41" viewBox="0 0 40 41"><g data-name="Groupe 66" transform="translate(-315 -728)"><g transform="translate(315 728)"><circle data-name="Oval Copy" cx="20" cy="20" r="20" fill="rgba(244,132,83,0.29)"/></g><text data-name="Matching Ride Givers" transform="translate(335 760)" fill="#f48453" font-size="35" font-family="Agrandir-Regular, Agrandir"><tspan x="-9.975" y="0">+</tspan></text></g></svg>
                </a>
            </div> -->
            <ul class="nav nav-justified w-100" id="myTab" role="tablist">
<?php 
    foreach($a_menu as $key => $val) { 
        if(!empty($val['detail_referer']) && $val['tree_on_menu'] == 1 && $val['tree_private'] == 1 ){?>
            <li class="nav-item" role="presentation">
                <a class="nav-link ftwhite" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . (!empty($val['detail_referer']) ? $val['detail_referer'] . (empty($val['detail_text']) || ! $val['tree_isnav'] ? '': '') : '') ;?>.html">
                    <div class="margB10">
                        <?php echo (!empty($val['tree_icon']) ? $val['tree_icon'] : '') ;?>
                    </div>
                    <span class="ft12"><?php echo (!empty($val['detail_label']) ? $val['detail_label'] : $val['tree_label']) ;?></span>
                </a>
            </li>
<?php }
}?>
            <li class="nav-item" role="presentation">
                <a class="nav-link ftwhite" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'] ;?>.html">
                    <div class="margB5">
                       <img src="<?php echo $starter->MEDIA_PATH;?>profil.png" class="w50" />
                    </div>
                    <span class="ft12">Profil</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>