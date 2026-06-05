<section class="padB80">
    <div class="container">
        <div class="overview relative flex alignfC">
            <div class="inlineb">
                <div class="title margH20 padV5 ">
                    <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'];?>" class="flex alignfC">
                        <svg id="alarm" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.265,10.714,8.433,19.7a.861.861,0,0,0,1.3,0,1.081,1.081,0,0,0,0-1.427L2.212,10,9.73,1.723A1.082,1.082,0,0,0,9.73.3a.861.861,0,0,0-1.3,0L.265,9.286A1.094,1.094,0,0,0,.265,10.714Z" transform="translate(6 2)" fill="#383838"/></svg>
                        <span class="ftblack ft20 margL5 "> <?php echo $starter->_get_lexique("Trajets disponibles");?></span>
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
<!--                <div class="alignC margT20">
                    <div class="">
                        <label for="covoiturage_type" class="nowdt">
                            <p class="ftblack margB0"><?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_type"]['label'];?></p>
                            <select data-type="select" name="covoiturage_type" id="covoiturage_type" class="fullW covoiturage_type" >
    <?php foreach ($covoiturages->covoiturage->a_fields['fields']['covoiturage_type']['data'] AS $key => $val) {?>
                                <option value="<?php echo $key;?>" <?php echo ((isset($_POST['covoiturage_type']) && $_POST['covoiturage_type'] == $key) || (isset($_GET['search']) && $_GET['search'] == $key) ? 'selected="selected"' : '');?> > <?php echo $val;?></option>
    <?php }?>
                            </select>
                        </label>
                    </div>
                </div>

                 <div class="container margT20">
                    <div class="row gx-3 gy-3">                        
                        <div class="col-lg-4 col-md-6 col-4">
                            <div class="alignC">
                                <a href="" class=""><?php echo $starter->_get_lexique("Conducteurs");?></a>
                            </div>
                        </div>                      
                        <div class="col-lg-4 col-md-6 col-4">
                            <div class="alignC">
                                <a href="" class=""><?php echo $starter->_get_lexique("Favoris");?></a>
                            </div>
                        </div>                      
                        <div class="col-lg-4 col-md-6 col-4">
                            <div class="alignC">
                                <a href="" class=""><?php echo $starter->_get_lexique("Contacts");?></a>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="alignC margT20">
                    <div class="">
<?php if($_POST['covoiturage_type'] == 1){?>
                        <div class="col-md-6 col-sd-12">
                            <div class="alignC">
                                <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['new_covoiturage']['referer'].".html?covoiturage_type=2";?>" class="CTA CTAFirst ft20  <?php echo (count($covoiturages->covoiturage->a_data ) > 0 ? '' : 'locked');?>" ><p>+</p><?php echo $starter->_get_lexique("Je fais une demande d'accompagnateur");?></a>
                                <p></p>
                            </div>
                        </div>
<?php }else{?>
                        <div class="col-md-6 col-sd-12">
                            <div class="alignC">
                                <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['new_covoiturage']['referer'];?>.html?covoiturage_type=1" class="CTA CTAFirst ft20 " ><p>+</p><?php echo $starter->_get_lexique("Je propose mon aide");?></a>
                                <p></p>
                            </div>
                        </div>
<?php }?>
                    </div>
                </div>
                <div class="container margT20">
                    <div class="row gx-4 gy-4 flex fullH">
<?php foreach($covoiturages->covoiturage->a_data AS $key => $val){
    if(intval($val['places']) > 0){?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="<?php echo ($val['covoiturage_type'] == 1 ? "" : "" );?> brad15 fullH bshadow0_5 pad20">
                                <div class="flex">
                                    <div class="inlineb">
                                        <img class="w45" src="<?php echo (is_file(ROOT_PATH . 'content/bdd/' . $_SESSION['user_info']['user_avatar']) ? $starter->CDN_PATH . $val['user_avatar'] : $starter->MEDIA_PATH . 'avatar.png');?>" />
                                    </div>
                                    <div class="inlineb margL5">
                                        <p class="margB0"><?php echo $val['user_firstname'] . " " . $val['user_lastname'];?></p>
<?php if(!empty($val['adherent_fname']) && $val['covoiturage_type'] == 2){?>
                                        <p class="margB0 ft16">(<?php echo $val['adherent_fname'] . " " . $val['adherent_lname'];?>)</p>
<?php } ?>
                                        <div class="backgreyHight brad20 ftwhite ft12 inlineb padV3 padH20 ftOpen"><?php echo $covoiturages->covoiturage->a_assoc[$val['covoiturage_add_end']]['label'] ;?></div>
                                    </div>
                                </div>
                                <div class="">
                                    <?php echo ($val['covoiturage_type'] == 1 ? $starter->_get_lexique("Conducteur") : $starter->_get_lexique("Passager") );?>
                                </div>
                                <div class="ftOpen ft12 ftgreyLight2">
                                    <?php echo $starter->_get_lexique("Trajet de");?>
                                    <?php echo ($val['covoiturage_add_start'] == 1 ? $val['user_street'] . ', ' . $val['user_city'] : $val['user_street2'] . ', ' . $val['user_city2']);?> 
                                    <?php echo $starter->_get_lexique("vers");?>
                                    <?php echo $covoiturages->covoiturage->a_assoc[$val['covoiturage_add_end']]['addr'];?><BR>
                                    <?php echo $starter->_get_lexique("le") . " " . $starter->utils->format_date("dd-mm-YYYY", $val['covoiturage_date'],true, " ");?>
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
                                    </div>
                                </div>
                                <!--<div class="">
                                <a href=""><?php echo $starter->_get_lexique("Contact");?></a>
                                </div>-->
                                <div class="margT20">
 <?php if($val['covoiturage_type'] == 1){?>
                                    <a class="btn CTA CTAFirst ft14" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-type="iframe" data-link="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['resa_covoiturage']['referer'];?>.html?ref=<?php echo $val['ref'];?>" href="javascript:void(0);"><?php echo $starter->_get_lexique("Je réserve");?></a>
<?php }else{ ?>
                                    <button type="button" name="<?php echo "resa_".$key;?>" data-id="<?php echo $key;?>" data-uri="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['resa_covoiturage']['referer'];?>.html?ref=<?php echo $val['ref'];?>" data-ref="<?php echo $val['ref'];?>" id="<?php echo "resa_".$key;?>" class="btnresa CTA CTAFirst ft14"><?php echo $starter->_get_lexique("Je me propose");?></button>
<?php } ?>
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