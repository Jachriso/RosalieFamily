<section class="padB80">
    <div class="container">
        <div class="overview relative flex alignfC">
            <div class="inlineb">
                <div class="title margH20 padV5 ">
                    <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'];?>" class="flex alignfC">
                        <svg id="alarm" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.265,10.714,8.433,19.7a.861.861,0,0,0,1.3,0,1.081,1.081,0,0,0,0-1.427L2.212,10,9.73,1.723A1.082,1.082,0,0,0,9.73.3a.861.861,0,0,0-1.3,0L.265,9.286A1.094,1.094,0,0,0,.265,10.714Z" transform="translate(6 2)" fill="#383838"/></svg>
                        <span class="ftblack ft20 margL5"> <?php echo $starter->_get_lexique("Mon profil");?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form action="" class="form margT20" id="blocForm" name="blocForm" method="POST">
        <div class="padH20 padV40">
            <div class="container padH0">
                <div class="row g-3">
                    <div class="col-lg-4 col-md-6 col-12 ">
                        <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["user_lastname"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_lastname"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['user_lastname'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $profils->profil->a_fields['fields']["user_lastname"]['field'];?>" class="">
                                <p class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["user_lastname"]['label'];?></p>
                                <input autocomplete="OFF" class="fullW <?php if(isset($profils->profil->a_fields['fields']["user_lastname"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_lastname"]['verif'])){echo 'mandatoryfield';}?>"  id="<?php echo $profils->profil->a_fields['fields']["user_lastname"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_lastname"]['field'];?>" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["user_lastname"]['maxlength'];?>" value="<?php echo (isset($_POST['user_lastname']) ? $_POST['user_lastname'] : (isset($profils->profil->a_data['user_lastname']) ? $profils->profil->a_data['user_lastname'] : '')); ?>" required="required"/>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 ">
                        <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["user_firstname"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_firstname"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['user_firstname'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $profils->profil->a_fields['fields']["user_firstname"]['field'];?>" class="">
                                <p class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["user_firstname"]['label'];?></p>
                                <input autocomplete="OFF" class="fullW <?php if(isset($profils->profil->a_fields['fields']["user_firstname"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_firstname"]['verif'])){echo 'mandatoryfield';}?>"  id="<?php echo $profils->profil->a_fields['fields']["user_firstname"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_firstname"]['field'];?>" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["user_firstname"]['maxlength'];?>" value="<?php echo (isset($_POST['user_firstname']) ? $_POST['user_firstname'] : (isset($profils->profil->a_data['user_firstname']) ? $profils->profil->a_data['user_firstname'] : '')); ?>" required="required"/>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 ">
                        <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["user_phone"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_phone"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['user_phone'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $profils->profil->a_fields['fields']["user_phone"]['field'];?>" class="">
                                <p class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["user_phone"]['label'];?></p>
                                <input autocomplete="OFF" class="fullW <?php if(isset($profils->profil->a_fields['fields']["user_phone"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_phone"]['verif'])){echo 'mandatoryfield';}?>" id="<?php echo $profils->profil->a_fields['fields']["user_phone"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_phone"]['field'];?>" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["user_phone"]['maxlength'];?>" value="<?php echo (isset($_POST['user_phone']) ? $_POST['user_phone'] : (isset($profils->profil->a_data['user_phone']) ? $profils->profil->a_data['user_phone'] : '')); ?>" required="required"/>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["user_email"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_email"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['user_email'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $profils->profil->a_fields['fields']["user_email"]['field'];?>" class="">
                                <p class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["user_email"]['label'];?></p>
                                <input autocomplete="OFF" class="fullW <?php if(isset($profils->profil->a_fields['fields']["user_email"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_email"]['verif'])){echo 'mandatoryfield';}?>" id="<?php echo $profils->profil->a_fields['fields']["user_email"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_email"]['field'];?>" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["user_email"]['maxlength'];?>" value="<?php echo (isset($_POST['user_email']) ? $_POST['user_email'] : (isset($profils->profil->a_data['user_email']) ? $profils->profil->a_data['user_email'] : '')); ?>" required="required"/>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="margT5 ">
                            <div class="blocField <?php if(isset($starter->checkForm->a_errors['password'])){echo 'bloc_on_error';}?>">
                                <label for="<?php echo $profils->profil->a_fields['fields']["password"]['field'];?>" class="has-tooltip">
                                    <p class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["password"]['label'];?></p>
                                    <input autocomplete="OFF" class="fullW" id="<?php echo $profils->profil->a_fields['fields']["password"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["password"]['field'];?>" type="password" value="<?php echo (isset($_POST['password']) ? $_POST['password'] : (isset($profils->profil->a_data['password']) ? $profils->profil->a_data['password'] : '')); ?>" required="required"/>
                                    <div class="meter">
                                        <div class="progress" id="password-strength-meter"></div>
                                        <input type="hidden" value="" id="zxcvbn" name="zxcvbn" />
                                    </div>
                                    <p class="tooltip ft16"><?php echo $starter->_get_lexique("Requirements : 12 caractères minimum, un caractère spécial, une majuscule et un chiffre.") ;?>
                                    </p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["user_address"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_address"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['user_address'])){echo 'bloc_on_error';}?>">
                            <input class="" type="hidden" id="<?php echo $profils->profil->a_fields['fields']["user_address"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_address"]['field'];?>" value="<?php echo (isset($_POST['user_address']) ? $_POST['user_address'] : (isset($profils->profil->a_data['user_address']) ? $profils->profil->a_data['user_address'] : '')); ?>"/>
                            <input class="" type="hidden" id="<?php echo $profils->profil->a_fields['fields']["user_street"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_street"]['field'];?>" value="<?php echo (isset($_POST['user_street']) ? $_POST['user_street'] : (isset($profils->profil->a_data['user_street']) ? $profils->profil->a_data['user_street'] : '')); ?>"/>
                            <input class="" type="hidden" id="<?php echo $profils->profil->a_fields['fields']["user_zipcode"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_zipcode"]['field'];?>" value="<?php echo (isset($_POST['user_zipcode']) ? $_POST['user_zipcode'] : (isset($profils->profil->a_data['user_zipcode']) ? $profils->profil->a_data['user_zipcode'] : '')); ?>"/>
                            <input class="" type="hidden" id="<?php echo $profils->profil->a_fields['fields']["user_city"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_city"]['field'];?>" value="<?php echo (isset($_POST['user_city']) ? $_POST['user_city'] : (isset($profils->profil->a_data['user_city']) ? $profils->profil->a_data['user_city'] : '')); ?>"/>
                            <label id="mapid_address" class="fullW">
                                <p class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["user_address"]['label'];?></p>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["user_addr2_label"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_addr2_label"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['user_addr2_label'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $profils->profil->a_fields['fields']["user_addr2_label"]['field'];?>" class="">
                                <p class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["user_addr2_label"]['label'];?></p>
                                <input autocomplete="OFF" class="fullW <?php if(isset($profils->profil->a_fields['fields']["user_addr2_label"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_addr2_label"]['verif'])){echo 'mandatoryfield';}?>" id="<?php echo $profils->profil->a_fields['fields']["user_addr2_label"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_addr2_label"]['field'];?>" type="text" maxlength="<?php echo $profils->profil->a_fields['fields']["user_addr2_label"]['maxlength'];?>" value="<?php echo (isset($_POST['user_addr2_label']) ? $_POST['user_addr2_label'] : (isset($profils->profil->a_data['user_addr2_label']) ? $profils->profil->a_data['user_addr2_label'] : '')); ?>" required="required"/>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-12">
                        <div class="margT5 <?php echo (isset($profils->profil->a_fields['fields']["user_address2"]['verif']) && in_array('mandatory',$profils->profil->a_fields['fields']["user_address2"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['user_address2'])){echo 'bloc_on_error';}?>">
                            <input class="" type="hidden" id="<?php echo $profils->profil->a_fields['fields']["user_address2"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_address2"]['field'];?>" value="<?php echo (isset($_POST['user_address2']) ? $_POST['user_address2'] : (isset($profils->profil->a_data['user_address2']) ? $profils->profil->a_data['user_address2'] : '')); ?>"/>
                            <input class="" type="hidden" id="<?php echo $profils->profil->a_fields['fields']["user_street2"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_street2"]['field'];?>" value="<?php echo (isset($_POST['user_street2']) ? $_POST['user_street2'] : (isset($profils->profil->a_data['user_street2']) ? $profils->profil->a_data['user_street2'] : '')); ?>"/>
                            <input class="" type="hidden" id="<?php echo $profils->profil->a_fields['fields']["user_zipcode2"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_zipcode2"]['field'];?>" value="<?php echo (isset($_POST['user_zipcode2']) ? $_POST['user_zipcode2'] : (isset($profils->profil->a_data['user_zipcode2']) ? $profils->profil->a_data['user_zipcode2'] : '')); ?>"/>
                            <input class="" type="hidden" id="<?php echo $profils->profil->a_fields['fields']["user_city2"]['field'];?>" name="<?php echo $profils->profil->a_fields['fields']["user_city2"]['field'];?>" value="<?php echo (isset($_POST['user_city2']) ? $_POST['user_city2'] : (isset($profils->profil->a_data['user_city2']) ? $profils->profil->a_data['user_city2'] : '')); ?>"/>
                            <label id="mapid_address2" class="fullW">
                                <p class="ftgrey margB0"><?php echo $profils->profil->a_fields['fields']["user_address2"]['label'];?></p>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="alignC margT20">
                            <button type="button" class="CTA CTAFirst btnsubmit checkmandatory"><?php echo $starter->_get_lexique('Enregistrer');?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>