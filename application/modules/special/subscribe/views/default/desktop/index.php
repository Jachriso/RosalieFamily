<div class="fullvH nooverflow">
    <div class="">
        <div class="w50pc inlineb fullvH hide-md w100pc-md floatL">
            <div class="relative fullH nooverflow">
                <div class="absolute t-0 l-0 backgrounded opac5 fullH fullW"></div>
                <img class="object-fitC object-pos1 fullW-sm fullH fullW" src="<?php echo $starter->MEDIA_PATH;?>background.jpg" alt="<?php echo $starter->_get_lexique("Connexion");?>">
            </div>
        </div>
        <div class="w50pc inlineb w100pc-md relative z100">
            <div class="alignC margT60 margH20">
                <img class="object-fitC" src="<?php echo $starter->MEDIA_PATH;?>logo.svg" alt="<?php echo $starter->_get_lexique("Rosalie Family");?>">
                <p class="alignC"><?php echo $starter->_get_lexique('Rosalie Family');?></p>
            </div>
            <form action="<?php echo $starter->HTTP_DOMAIN . $_SERVER['REQUEST_URI']; ?>" id="form_authenticate" name="form_authenticate" method="post" class="padH20 fullW-lg centerH">
                <div class="container margT20 gx-5 relative">
                    <div class="row ">
                        <div class="col-12">
                            <h2 class="ft30 alignC"><?php echo $starter->_get_lexique("Créer un compte");?></h2>
                            <p class="alignC"><?php echo $starter->_get_lexique('Vous avez déjà un compte ?');?></p><p class="alignC"><a class="ft20 ftorange" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['login']['referer'];?>.html"><?php echo $starter->_get_lexique('Connectez-vous');?></a></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="margT20">
                                <label for="<?php echo $subscribe->a_fields['fields']['user_fname']['field'];?>" class="">
                                    <input autocomplete="OFF" required="required" class="fullW <?php if(isset($starter->checkForm->a_errors['user_fname'])){echo 'on_error';}?>"  id="<?php echo $subscribe->a_fields['fields']['user_fname']['field'];?>" name="<?php echo $subscribe->a_fields['fields']['user_fname']['field'];?>" type="text" maxlength="50" value="<?php echo isset($_POST['user_fname']) ? htmlentities($_POST['user_fname']) : ''; ?>" placeholder="<?php echo $subscribe->a_fields['fields']['user_fname']['label'] . (isset($subscribe->a_fields['fields']['user_fname']['verif']) && in_array('mandatory', $subscribe->a_fields['fields']['user_fname']['verif']) ? '*': '');?>"/>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="margT20">
                                <label for="<?php echo $subscribe->a_fields['fields']['user_lname']['field'];?>" class="">
                                    <input autocomplete="OFF" required="required" class="fullW <?php if(isset($starter->checkForm->a_errors['user_lname'])){echo 'on_error';}?>"  id="<?php echo $subscribe->a_fields['fields']['user_lname']['field'];?>" name="<?php echo $subscribe->a_fields['fields']['user_lname']['field'];?>" type="text" maxlength="50" value="<?php echo isset($_POST['user_lname']) ? htmlentities($_POST['user_lname']) : ''; ?>" placeholder="<?php echo $subscribe->a_fields['fields']['user_lname']['label'] . (isset($subscribe->a_fields['fields']['user_lname']['verif']) && in_array('mandatory', $subscribe->a_fields['fields']['user_lname']['verif']) ? '*': '');?>"/>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="margT20">
                                <label for="<?php echo $subscribe->a_fields['fields']['user_email']['field'];?>" class="">
                                    <input autocomplete="OFF" required="required" class="fullW <?php if(isset($starter->checkForm->a_errors['user_email'])){echo 'on_error';}?>"  id="<?php echo $subscribe->a_fields['fields']['user_email']['field'];?>" name="<?php echo $subscribe->a_fields['fields']['user_email']['field'];?>" type="text" maxlength="50" value="<?php echo isset($_POST['user_email']) ? htmlentities($_POST['user_email']) : ''; ?>" placeholder="<?php echo $subscribe->a_fields['fields']['user_email']['label'] . (isset($subscribe->a_fields['fields']['user_email']['verif']) && in_array('mandatory', $subscribe->a_fields['fields']['user_email']['verif']) ? '*': '');?>"/>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="margT20">
                                <label for="<?php echo $subscribe->a_fields['fields']['password']['field'];?>" class=" has-tooltip">
                                    <input required="required" autocomplete="OFF" class="fullW <?php if(isset($starter->checkForm->a_errors['password'])){echo 'on_error';}?>" id="<?php echo $subscribe->a_fields['fields']['password']['field'];?>" name="<?php echo $subscribe->a_fields['fields']['password']['field'];?>" type="password" value="" placeholder="<?php echo $subscribe->a_fields['fields']['password']['label'] . (isset($subscribe->a_fields['fields']['password']['verif']) && in_array('mandatory', $subscribe->a_fields['fields']['password']['verif']) ? '*': '');?>"/>
                                    <div class="meter">
                                        <div class="progress" id="password-strength-meter"></div>
                                        <input type="hidden" value="" id="zxcvbn" name="zxcvbn" />
                                    </div>
                                    <p class="tooltip ftmstb ft16 ftgrey"><?php echo $starter->_get_lexique('Exigence : 12 caractères minimum, un caractère spécial, une miniscule, une majuscule et un chiffre.') ;?>
                                    </p>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="margT20">
                                <label for="<?php echo $subscribe->a_fields['fields']['password_confirm']['field'];?>" class="">
                                    <input required="required" autocomplete="OFF" class="fullW <?= isset($checkForm->a_errors['password_confirm']) ? 'error' : ''?>" type="password" name="<?php echo $subscribe->a_fields['fields']['password_confirm']['field'];?>" id="<?php echo $subscribe->a_fields['fields']['password_confirm']['field'];?>" value="" placeholder="<?php echo $subscribe->a_fields['fields']['password_confirm']['label'] . (isset($subscribe->a_fields['fields']['password_confirm']['verif']) && in_array('mandatory', $subscribe->a_fields['fields']['password_confirm']['verif']) ? '*': '');?>"/>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="alignC margT20">
                                <button id="send" class="field-submit upper CTAFirst CTA fullW-sm" type="submit"><?php echo $starter->_get_lexique("Je m'inscris");?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>