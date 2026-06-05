<section class="padB80">
    <div class="container">
        <div class="overview relative flex alignfC">
            <div class="inlineb">
                <div class="title margH20 padV5 ">
                    <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'];?>" class="flex alignfC">
                        <svg id="alarm" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.265,10.714,8.433,19.7a.861.861,0,0,0,1.3,0,1.081,1.081,0,0,0,0-1.427L2.212,10,9.73,1.723A1.082,1.082,0,0,0,9.73.3a.861.861,0,0,0-1.3,0L.265,9.286A1.094,1.094,0,0,0,.265,10.714Z" transform="translate(6 2)" fill="#383838"/></svg>
                        <span class="ftblack ft20 margL5"> <?php echo $starter->_get_lexique("Véhicule");?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form action="" class="form margT20" id="blocForm" name="blocForm" method="POST">
        <div class="padH20 padV40">
                <div class="container padH0">
                    <div class="row g-3">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="<?php echo (isset($profils->profil->a_fields['fields']["vehicule_label"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_label"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['vehicule_label'])){echo 'bloc_on_error';}?>">
                                <label for="<?php echo $profils->profil->a_fields['fields']["vehicule_label"]['field'];?>" class="inputBox">
                                    <input autocomplete="OFF" class="fullW <?php if(isset($profils->profil->a_fields['fields']["vehicule_label"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_label"]['verif'])){echo 'mandatoryfield';}?>"  id="<?php echo $profils->profil->a_fields['fields']["vehicule_label"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["vehicule_label"]['field'];?>" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["vehicule_label"]['maxlength'];?>" value="<?php echo (isset($_POST['vehicule_label']) ? $_POST['vehicule_label'] : (isset($profils->profil->a_data[0]['vehicule_label']) ? $profils->profil->a_data[0]['vehicule_label'] : '')); ?>" required="required"/>
                                    <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["vehicule_label"]['label'];?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["vehicule_immat"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_immat"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['vehicule_immat'])){echo 'bloc_on_error';}?>">
                                <label for="<?php echo $profils->profil->a_fields['fields']["vehicule_immat"]['field'];?>" class="inputBox">
                                    <input autocomplete="OFF" class="fullW <?php if(isset($profils->profil->a_fields['fields']["vehicule_immat"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_immat"]['verif'])){echo 'mandatoryfield';}?>"  id="<?php echo $profils->profil->a_fields['fields']["vehicule_immat"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["vehicule_immat"]['field'];?>" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["vehicule_immat"]['maxlength'];?>" value="<?php echo (isset($_POST['vehicule_immat']) ? $_POST['vehicule_immat'] : (isset($profils->profil->a_data[0]['vehicule_immat']) ? $profils->profil->a_data[0]['vehicule_immat'] : '')); ?>" required="required"/>
                                    <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["vehicule_immat"]['label'];?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["vehicule_km"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_km"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['vehicule_km'])){echo 'bloc_on_error';}?>">
                                <label for="<?php echo $profils->profil->a_fields['fields']["vehicule_km"]['field'];?>" class="inputBox">
                                    <input autocomplete="OFF" class="fullW <?php if(isset($profils->profil->a_fields['fields']["vehicule_km"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_km"]['verif'])){echo 'mandatoryfield';}?>" id="<?php echo $profils->profil->a_fields['fields']["vehicule_km"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["vehicule_km"]['field'];?>" type="number" maxlength="<?php echo $profils->profil->a_fields['fields']["vehicule_km"]['maxlength'];?>" step="0.1" value="<?php echo (isset($_POST['vehicule_km']) ? $_POST['vehicule_km'] : (isset($profils->profil->a_data[0]['vehicule_km']) ? $profils->profil->a_data[0]['vehicule_km'] : '')); ?>" required="required"/>
                                    <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["vehicule_km"]['label'];?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["vehicule_places"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_places"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['vehicule_places'])){echo 'bloc_on_error';}?>">
                                <label for="<?php echo $profils->profil->a_fields['fields']["vehicule_places"]['field'];?>" class="inputBox">
                                    <input step="0.1" autocomplete="OFF" class="fullW <?php if(isset($profils->profil->a_fields['fields']["vehicule_places"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_places"]['verif'])){echo 'mandatoryfield';}?>" id="<?php echo $profils->profil->a_fields['fields']["vehicule_places"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["vehicule_places"]['field'];?>" type="number" maxlength="<?php echo $profils->profil->a_fields['fields']["vehicule_places"]['maxlength'];?>" value="<?php echo (isset($_POST['vehicule_places']) ? $_POST['vehicule_places'] : (isset($profils->profil->a_data[0]['vehicule_places']) ? $profils->profil->a_data[0]['vehicule_places'] : '')); ?>" required="required"/>
                                    <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["vehicule_places"]['label'];?></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["vehicule_rehauss"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_rehauss"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['vehicule_rehauss'])){echo 'bloc_on_error';}?>">
                                <label for="<?php echo $profils->profil->a_fields['fields']["vehicule_rehauss"]['field'];?>" class="flex checkfield alignfC">
                                    <input autocomplete="OFF" class="field-checkbox checkmarkbox <?php if(isset($profils->profil->a_fields['fields']["vehicule_rehauss"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["vehicule_rehauss"]['verif'])){echo 'mandatoryfield';}?>" id="<?php echo $profils->profil->a_fields['fields']["vehicule_rehauss"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["vehicule_rehauss"]['field'];?>" type="checkbox" value="<?php echo (isset($_POST['vehicule_rehauss']) ? $_POST['vehicule_rehauss'] : (isset($profils->profil->a_data[0]['vehicule_rehauss']) ? $profils->profil->a_data[0]['vehicule_rehauss'] : '1')); ?>"/>
                                    <span class="checkmarkbox"></span>
                                    <span class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["vehicule_rehauss"]['label'];?></span>
                                </label>
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
            </form>
        </div>
    </div>
</section>