<section class="padB80">
    <div class="container">
        <div class="overview relative flex alignfC">
            <div class="inlineb">
                <div class="title margH20 padV5 ">
                    <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'];?>" class="flex alignfC">
                        <svg id="alarm" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.265,10.714,8.433,19.7a.861.861,0,0,0,1.3,0,1.081,1.081,0,0,0,0-1.427L2.212,10,9.73,1.723A1.082,1.082,0,0,0,9.73.3a.861.861,0,0,0-1.3,0L.265,9.286A1.094,1.094,0,0,0,.265,10.714Z" transform="translate(6 2)" fill="#383838"/></svg>
                        <span class="ftblack ft20 margL5"> <?php echo $starter->_get_lexique("Mes enfants");?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form action="" class="form margT20" id="blocForm" name="blocForm" method="POST">
        <input type="hidden" id=adherents name="adherents" value="<?php echo isset($_POST['adherents']) ? $_POST['adherents'] : (isset($profils->profil->a_data) ? count($profils->profil->a_data) : 0);?>">
        <div class="padH20 padV40">
            <div class="container padH0">
                <div class="row gy-5">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="flex">
                            <div class="listbtnAdherent"><?php 
if(isset($_POST['adherents']) || count($profils->profil->a_data) > 0){
    $iComptEnd = 1;
    $iCompt = (isset($_POST['adherents']) ? intval($_POST['adherents']) : count($profils->profil->a_data));
    for($i=1;$i<=$iCompt;$i++){?><button type="button" class="CTA3 <?php echo $i != 1 ? 'CTAOrangeOutline' : 'CTAOrange';?> margR10 margB10 btnX" data-value="<?php echo $iComptEnd;?>" id="btn_<?php echo $iComptEnd;?>"><?php echo $iComptEnd;?></button><?php $iComptEnd++;
    }
}?></div>
                            <button type="button" class="margB10" id="addTpl"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="41" viewBox="0 0 40 41"><g data-name="Groupe 66" transform="translate(-315 -728)"><g transform="translate(315 728)"><circle data-name="Oval Copy" cx="20" cy="20" r="20" fill="rgba(244,132,83,0.29)"/></g><text data-name="Matching Ride Givers" transform="translate(335 760)" fill="#f48453" font-size="35" font-family="Agrandir-Regular, Agrandir"><tspan x="-9.975" y="0">+</tspan></text></g></svg></button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="bAdherents">
<?php 
if(isset($_POST['adherents']) || count($profils->profil->a_data) > 0){
    if(empty($_POST))  
        $a_ads = $profils->profil->a_data;
    else
        $a_ads = $_POST;
    $iCompt = 1;
    foreach($a_ads As $key => $val){?>
                            <div class="template-container_<?php echo $iCompt;?> template_container <?php echo $iCompt != 1 ? 'hide' : '';?>">
                                <div class="backwhite brad15 fullH pad20 relative">
                                    <div class="absolute t-0 r-0">
                                        <div class="deleteAdherent cursor" data-index="<?php echo $iCompt;?>">
                                            <svg width="30" height="30" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="delete"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M21.5,10.5l-13,0l0,-1.482l4.643,-1.334l0,-1.184l3.714,0l0,1.184l4.643,1.334l0,1.482Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
                                        </div>
                                    </div>
                                    <div class="row gy-3">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                            <div class="">
                                                <label for="<?php echo $profils->profil->a_fields['fields']["adherent_fname"]['field'];?>_<?php echo $iCompt;?>" class="inputBox">
                                                    <input type="hidden" id=adherent_ref_<?php echo $iCompt;?> name="adherent_ref_<?php echo $iCompt;?>" value="<?php echo (!empty($val['adherent_id']) ? $val['adherent_id'] : '');?>">
                                                    <input autocomplete="OFF" class="fullW" id="<?php echo $profils->profil->a_fields['fields']["adherent_fname"]['field'];?>_<?php echo $iCompt;?>" name="<?php echo $profils->profil->a_fields['fields']["adherent_fname"]['field'];?>_<?php echo $iCompt;?>" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["adherent_fname"]['maxlength'];?>" value="<?php echo (isset($_POST['adherent_fname_'.$iCompt]) ? $_POST['adherent_fname_'.$iCompt] : (!empty($val['adherent_fname']) ? $val['adherent_fname'] : '' ));?>" required="required"/>
                                                    <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["adherent_fname"]['label'];?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                            <div class="">
                                                <label for="<?php echo $profils->profil->a_fields['fields']["adherent_lname"]['field'];?>_<?php echo $iCompt;?>" class="inputBox">
                                                    <input autocomplete="OFF" class="fullW " id="<?php echo $profils->profil->a_fields['fields']["adherent_lname"]['field'];?>_<?php echo $iCompt;?>" name="<?php echo $profils->profil->a_fields['fields']["adherent_lname"]['field'];?>_<?php echo $iCompt;?>" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["adherent_lname"]['maxlength'];?>" value="<?php echo (isset($_POST['adherent_lname_'.$i]) ? $_POST['adherent_lname_'.$i] : (!empty($val['adherent_lname']) ? $val['adherent_lname'] : '' ));?>" required="required"/>
                                                    <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["adherent_lname"]['label'];?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                            <div class="">
                                                <label for="<?php echo $profils->profil->a_fields['fields']["adherent_bday"]['field'];?>_<?php echo $iCompt;?>" class="">
                                                    <span class="ftgrey margB0 inputBox"><?php echo $profils->profil->a_fields['fields']["adherent_bday"]['label'];?></span>
                                                    <input autocomplete="OFF" class="fullW" id="<?php echo $profils->profil->a_fields['fields']["adherent_bday"]['field'];?>_<?php echo $iCompt;?>" name="<?php echo $profils->profil->a_fields['fields']["adherent_bday"]['field'];?>_<?php echo $iCompt;?>" type="date" max="<?php echo date('Y-m-d');?>" value="<?php echo (isset($_POST['adherent_bday_'.$i]) ? $_POST['adherent_bday_'.$i] : (!empty($val['adherent_bday']) ? $val['adherent_bday'] : '' ));?>"/>
                                                    
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                                            <div class="">
                                                <label for="<?php echo $profils->profil->a_fields['fields']['asso']['field'];?>_<?php echo $iCompt;?>" class="inputBox">
                                                    <select multiple="multiple" data-type="select" name="<?php echo $profils->profil->a_fields['fields']['asso']['field'];?>_<?php echo $iCompt;?>[]" id="<?php echo $profils->profil->a_fields['fields']['asso']['field'];?>_<?php echo $iCompt;?>" class="hauto fullW" >
                        <?php foreach ($profils->profil->associations AS $_key => $_val) {?>
                                                        <option value="<?php echo $_val['association_id'];?>" <?php echo ((isset($_POST['asso_'.$iCompt]) && $_POST['asso_'.$iCompt] == $_val['association_id']) || (in_array($_val['association_id'],$val['assos'])) ? 'selected="selected"' : '');?> > <?php echo $_val['association_label'];?></option>
                        <?php }?>
                                                    </select>
                                                    <span class="ftblack margB0"><?php echo $profils->profil->a_fields['fields']["asso"]['label'];?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 ">
                        <?php foreach ($profils->profil->a_data_asso[$key]['assos'] AS $_key => $_val) {?>
                                            <div><?php echo $profils->profil->associations[$_val['asso']]['association_label'] . " " . ($_val['valid'] == 1 ? 'validé' : ( $_val['valid'] == 2 ? 'refusé' : 'en attente'));?></div>
                        <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
<?php  $iCompt++;
    }
}?>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="alignC margT20">
                                <button type="button" class="CTA CTAFirst btnsubmit checkmandatory"><?php echo $starter->_get_lexique('Enregistrer');?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<div class="template-container">
    <div class="template-container_{X} template_container hide">
        <div class="backwhite brad15 fullH pad20 relative">
            <div class="absolute t-0 r-0">
                <div class="deleteAdherent cursor" data-index="{X}">
                    <svg width="30" height="30" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="delete"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M21.5,10.5l-13,0l0,-1.482l4.643,-1.334l0,-1.184l3.714,0l0,1.184l4.643,1.334l0,1.482Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
                </div>
            </div>
            <div class="row gy-3">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                    <div class="">
                        <label for="<?php echo $profils->profil->a_fields['fields']["adherent_fname"]['field'];?>_{X}" class="inputBox">
                            <input type="hidden" id=adherent_ref_{X} name="adherent_ref_{X}" value="">
                            <input autocomplete="OFF" class="fullW" id="<?php echo $profils->profil->a_fields['fields']["adherent_fname"]['field'];?>_{X}" name="<?php echo $profils->profil->a_fields['fields']["adherent_fname"]['field'];?>_{X}" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["adherent_fname"]['maxlength'];?>" value="" required="required"/>
                            <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["adherent_fname"]['label'];?></span>
                        </label>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                    <div class="">
                        <label for="<?php echo $profils->profil->a_fields['fields']["adherent_lname"]['field'];?>_{X}" class="inputBox">
                            <input autocomplete="OFF" class="fullW " id="<?php echo $profils->profil->a_fields['fields']["adherent_lname"]['field'];?>_{X}" name="<?php echo $profils->profil->a_fields['fields']["adherent_lname"]['field'];?>_{X}" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["adherent_lname"]['maxlength'];?>" value="" required="required"/>
                            <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["adherent_lname"]['label'];?></span>
                        </label>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                    <div class="">
                        <label for="<?php echo $profils->profil->a_fields['fields']["adherent_bday"]['field'];?>_{X}" class="inputBox">
                            <input autocomplete="OFF" class="fullW" id="<?php echo $profils->profil->a_fields['fields']["adherent_bday"]['field'];?>_{X}" name="<?php echo $profils->profil->a_fields['fields']["adherent_bday"]['field'];?>_{X}" type="date" max="<?php echo date('Y-m-d');?>" value=""/>
                            <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["adherent_bday"]['label'];?></span>
                        </label>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
                    <div class="">
                        <label for="<?php echo $profils->profil->a_fields['fields']['asso']['field'];?>_{X}" class="inputBox">
                            <select multiple data-type="select" name="<?php echo $profils->profil->a_fields['fields']['asso']['field'];?>_{X}[]" id="<?php echo $profils->profil->a_fields['fields']['asso']['field'];?>_{X}" class="fullW hauto" >
<?php foreach ($profils->profil->associations AS $key => $val) {?>
                                <option value="<?php echo $val['association_id'];?>" > <?php echo $val['association_label'];?></option>
<?php }?>
                            </select>
                            <span class="ftblack margB0"><?php echo $profils->profil->a_fields['fields']["asso"]['label'];?></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>