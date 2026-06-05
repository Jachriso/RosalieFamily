<section class="padB80">
    <div class="container">
        <div class="overview relative flex alignfC">
            <div class="inlineb">
                <div class="title margH20 padV5 ">
                    <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'];?>" class="flex alignfC">
                        <svg id="alarm" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.265,10.714,8.433,19.7a.861.861,0,0,0,1.3,0,1.081,1.081,0,0,0,0-1.427L2.212,10,9.73,1.723A1.082,1.082,0,0,0,9.73.3a.861.861,0,0,0-1.3,0L.265,9.286A1.094,1.094,0,0,0,.265,10.714Z" transform="translate(6 2)" fill="#383838"/></svg>
                        <span class="ftblack ft20 margL5 "> <?php echo $starter->_get_lexique("Mes trajets");?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form action="" class="form margT20" id="blocForm" name="blocForm" method="POST">
        <input type="hidden" name="adherent" id="adherent" value="" />
        <input type="hidden" name="ref" id="ref" value="" />
        <div class="relative">
            <div class="backgreyl padH20 padB40 brad30 ">
                <div class="container margT20">
                    <div class="row gx-4 gy-4 flex fullH">
                        <div class="col-12">
                            <p class="margB0"><?php echo $starter->_get_lexique("Mes trajets conducteur");?></p>
                        </div>
<?php 
foreach($covoiturages->covoiturage->a_data AS $key => $val){
    if (($val['covoiturage_type'] == 2 && $val["user_resa_id"] == $_SESSION['user_info']['user_id']) || ($val['covoiturage_type'] == 1 && $val['user'] == $_SESSION['user_info']['user_id'])){?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="brad15 fullH bshadow0_5 pad20">
                                <div class="flex">
                                    <div class="inlineb">
                                        <img class="w45" src="<?php echo (is_file(ROOT_PATH . 'content/bdd/' . $_SESSION['user_info']['user_avatar']) ? $starter->CDN_PATH . $val['user_avatar'] : $starter->MEDIA_PATH . 'avatar.png');?>" />
                                    </div>
                                    <div class="inlineb margL5">
                                        <p class="margB0"><?php if($val['covoiturage_type'] == 2){?>
                                    <?php echo $starter->_get_lexique("Réservation");?>
<?php }else{?>
                                    <?php echo $starter->_get_lexique("Offre");?>
<?php }?></p>
                                        <div class="backgreyHight brad20 ftwhite ft12 inlineb padV3 padH20 ftOpen"><?php echo $covoiturages->covoiturage->a_assoc[$val['covoiturage_add_end']]['label'] ;?></div>
                                    </div>
                                </div>
                                <div class="">
<?php if($val['covoiturage_type'] == 2){?>
                                    <?php echo $val["adherent_fname"] ;?>
<?php }?>
                                </div>
                                <div class="">

                                </div>
                                <div class="ftOpen ft12 ftgreyLight2 margT10">
                                    <?php //echo $starter->_get_lexique("Trajet de");?>
                                    <?php //echo $val['covoiturage_add_start'];?>
                                    <?php echo $starter->_get_lexique("Trajet le");?>
                                    <?php echo $starter->utils->format_date("dd-mm-YYYY",$val['covoiturage_date']);?>
                                    <?php echo $starter->_get_lexique("vers");?>
                                    <?php echo $covoiturages->covoiturage->a_assoc[$val['covoiturage_add_end']]['addr'];?>
                                </div>
                                <div class="container p-0 margT20">
                                    <div class="row gx-4 gy-4">
                                        <div class="col-4">
                                            <div class="ft17 flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26.297" height="30.855" viewBox="0 0 26.297 30.855"><defs><clipPath id="clip-path"><rect id="Rectangle_7" data-name="Rectangle 7" width="26.297" height="30.855" fill="none"/></clipPath></defs><g data-name="Groupe 11" transform="translate(0)"><path data-name="Tracé 10" d="M2.8,0v28.05H0v2.8H8.415v-2.8H5.61V0Z" transform="translate(0 0)" fill="#f48453"/><g data-name="Groupe 10" transform="translate(0)"><g data-name="Groupe 9" clip-path="url(#clip-path)"><path id="Tracé_11" data-name="Tracé 11" d="M50.129,21.131l-3.773-6.3,3.773-6.3c.2-.365,1.161-2.118,1.161-2.118h-19.2v16.83H51.377s-.991-1.684-1.248-2.118m-5.566-.177H34.755V8.9H46.4s-1.112,2.24-1.226,2.452l-2.109,3.766,2.2,3.67c.15.253,1.34,2.168,1.34,2.168Z" transform="translate(-25.08 -5.016)" fill="#f48453"/></g></g></g></svg>
                                                <span class="ftLH15 margL5"><?php echo $val['covoiturage_h_end'] . " " . $starter->_get_lexique("Arrivée") ;?></span>
                                            </div>
                                        </div>
<?php if($val['covoiturage_type'] == 1){?>
                                        <div class="col-4">
                                            <div class="ft17 flex">
                                                <svg data-name="Groupe 15" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="27.933" height="27.933" viewBox="0 0 27.933 27.933"><defs><clipPath id="clip-path1"><rect data-name="Rectangle 11" width="27.933" height="27.933" fill="none"></rect></clipPath></defs><g data-name="Groupe 14" clip-path="url(#clip-path1)"><path data-name="Tracé 13" d="M19.311,1.063a13.966,13.966,0,1,0,8.622,12.9,13.966,13.966,0,0,0-8.622-12.9M13.964,2.877A11.275,11.275,0,0,1,25.128,12.55a1.946,1.946,0,0,1-1.838.2l-4.327-1.767a13.147,13.147,0,0,0-9.992,0L4.643,12.755a1.936,1.936,0,0,1-1.838-.2A11.275,11.275,0,0,1,13.964,2.877M12.256,22.136l-.351,3.28A12.927,12.927,0,0,1,3.468,17.5l3.618-.443a4.63,4.63,0,0,1,5.17,5.077m1.708-4.461a3.074,3.074,0,1,1,3.078-3.069,3.073,3.073,0,0,1-3.078,3.069m2.106,7.741-.349-3.264A4.606,4.606,0,0,1,20.865,17.1l3.6.441a12.861,12.861,0,0,1-8.394,7.874" transform="translate(0 0)" fill="#f48453"></path></g></svg>
                                                <span class="ftLH15 margL5"><?php echo $val['places'] . " " . ($val['places'] == "1" ? $starter->_get_lexique("Place") : $starter->_get_lexique("Places"));?></span>
                                            </div>
                                        </div>
<?php } ?>
<?php if($val['valid_cond'] !='' && $val['valid_cond'] == 0){ ?>
                                        <div class="margT20">
                                            <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' .  $starter->mods['covoiturages']['modules']['validation']['referer'];?>.html?ref=<?php echo $val['resa_ref'];?>&inline" class="CTA"><?php echo $starter->_get_lexique("Valider la réservation") ;?></a>
                                        </div>
<?php } ?>
<?php if($val['valid_passager'] !='' && $val['valid_passager'] == 0){ ?>
                                        <div class="margT20">
                                            <p class="ft15"><?php echo $starter->_get_lexique("En attente de validation par l'adhérent") ;?></p>
                                        </div>
<?php }elseif($val['valid_passager'] == 1){ ?>
                                        <div class="margT20">
                                            <p class="ft15"><?php echo $starter->_get_lexique("Validé par l'adhérent") ;?></p>
                                        </div>
<?php } ?>
<?php if($val['covoiturage_date'] <= date('Y-m-d') && !empty($val['resa_id']) && $val['valid_passager'] == 1 && $val['resa_id'] == 1 && $val['valid_trajet'] != 1){ ?>
                                        <div class="margT20">
                                            <button type="button" class="CTA covoitEnd" data-value="<?php echo $val['resa_ref'];?>" value="1"><?php echo $starter->_get_lexique("Adhérent arrivé à bon port") ;?></button>
                                        </div>
<?php } ?>
                                    </div>
                                </div>
                                <!--<div class="">
                                <a href=""><?php echo $starter->_get_lexique("Contact");?></a>
                                </div>-->
                                <div class="margT20">
                                 </div>
                            </div>
                        </div> 
<?php }
}?>  
                    <div class="row gx-4 gy-4 flex fullH">
                        <div class="col-12">
                            <p class="margB0"><?php echo $starter->_get_lexique("Mes trajets passager");?></p>
                        </div>
<?php foreach($covoiturages->covoiturage->a_data AS $key => $val){
    if (($val['covoiturage_type'] == 1 && $val["user_resa_id"] == $_SESSION['user_info']['user_id']) || ($val['covoiturage_type'] == 2 && $val['user'] == $_SESSION['user_info']['user_id'])){?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="brad15 fullH bshadow0_5 pad20">
                                <div class="flex">
                                    <div class="inlineb">
                                        <img class="w45" src="<?php echo (is_file(ROOT_PATH . 'content/bdd/' . $_SESSION['user_info']['user_avatar']) ? $starter->CDN_PATH . $val['user_avatar'] : $starter->MEDIA_PATH . 'avatar.png');?>" />
                                    </div>
                                    <div class="inlineb margL5">
                                        <p class="margB0"><?php echo $val['user_firstname'] . " " . $val['user_lastname'];?></p>
                                        <div class="backgreyHight brad20 ftwhite ft12 inlineb padV3 padH20 ftOpen"><?php echo $covoiturages->covoiturage->a_assoc[$val['covoiturage_add_end']]['label'] ;?></div>
                                    </div>
                                </div>
                                <div class="">
                                    <?php echo $val["adherent_fname"] ;?>
                                </div>
                                <div class="ftOpen ft12 ftgreyLight2">
                                    <?php //echo $starter->_get_lexique("Trajet de");?>
                                    <?php //echo $val['covoiturage_add_start'];?>
                                    <?php echo $starter->_get_lexique("Trajet le");?>
                                    <?php echo $starter->utils->format_date("dd-mm-YYYY",$val['covoiturage_date']);?>
                                    <?php echo $starter->_get_lexique("vers");?>
                                    <?php echo $covoiturages->covoiturage->a_assoc[$val['covoiturage_add_end']]['addr'];?>
                                </div>
                                <div class="container p-0 margT20">
                                    <div class="row gx-4 gy-4">
                                        <div class="col-4">
                                            <div class="ft17 flex">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26.297" height="30.855" viewBox="0 0 26.297 30.855"><defs><clipPath id="clip-path"><rect id="Rectangle_7" data-name="Rectangle 7" width="26.297" height="30.855" fill="none"/></clipPath></defs><g data-name="Groupe 11" transform="translate(0)"><path data-name="Tracé 10" d="M2.8,0v28.05H0v2.8H8.415v-2.8H5.61V0Z" transform="translate(0 0)" fill="#f48453"/><g data-name="Groupe 10" transform="translate(0)"><g data-name="Groupe 9" clip-path="url(#clip-path)"><path id="Tracé_11" data-name="Tracé 11" d="M50.129,21.131l-3.773-6.3,3.773-6.3c.2-.365,1.161-2.118,1.161-2.118h-19.2v16.83H51.377s-.991-1.684-1.248-2.118m-5.566-.177H34.755V8.9H46.4s-1.112,2.24-1.226,2.452l-2.109,3.766,2.2,3.67c.15.253,1.34,2.168,1.34,2.168Z" transform="translate(-25.08 -5.016)" fill="#f48453"/></g></g></g></svg>
                                                <span class="ftLH15 margL5"><?php echo $val['covoiturage_h_end'] . " " . $starter->_get_lexique("Arrivée") ;?></span>
                                            </div>
                                        </div>
 <?php  if($val['valid_passager'] != '' && $val['valid_passager'] == 0){ ?>
                                        <div class="margT20">
                                            <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' .  $starter->mods['covoiturages']['modules']['validation']['referer'];?>.html?ref=<?php echo $val['resa_ref'];?>&inline" class="CTA"><?php echo $starter->_get_lexique("Valider la réservation") ;?></a>
                                        </div>
<?php } ?>
<?php if($val['valid_cond'] !='' && $val['valid_cond'] == 0){ ?>
                                        <div class="margT20">
                                            <p class="ft15"><?php echo $starter->_get_lexique("En attente de validation par le conducteur") ;?></p>
                                        </div>
<?php }elseif($val['valid_cond'] == 1){ ?>
                                        <div class="margT20">
                                            <p class="ft15"><?php echo $starter->_get_lexique("Validé par le conducteur") ;?></p>
                                        </div>
<?php } ?>
 <?php if($val['covoiturage_date'] <= date('Y-m-d H:i:s') && !empty($val['resa_id']) && $val['valid_passager'] == 1 && $val['resa_id'] == 1 && $val['valid_trajet'] != 1){ ?>
                                        <div class="margT20">
                                            <button type="button" class="CTA covoitEnd" data-value="<?php echo $val['resa_ref'];?>" value="1"><?php echo $starter->_get_lexique("Adhérent arrivé à bon port") ;?></button>
                                        </div>
<?php } ?>
                                    </div>
                                </div>
                                <!--<div class="">
                                <a href=""><?php echo $starter->_get_lexique("Contact");?></a>
                                </div>-->
                                <div class="margT20">
                                 </div>
                            </div>
                        </div> 
<?php }
}?>  
                    </div>
                </div> 
            </div>
        </form>
    </div>
</section>