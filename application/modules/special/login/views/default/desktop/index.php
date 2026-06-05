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
                            <h2 class="ft30 alignC"><?php echo $starter->_get_lexique("Se connecter");?></h2>
                            <p class="alignC"><?php echo $starter->_get_lexique("Vous n'avez pas encore de compte ?");?></p><p class="alignC"><a class="ft20 ftorange" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['subscribe']['referer'];?>.html"><?php echo $starter->_get_lexique('Inscrivez-vous');?></a></p>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="margT20">
                                <label for="<?php echo $login->a_fields['fields']['login']['field'];?>" class="">
                                    <input autocomplete="OFF" required="required" class="fullW <?php if(isset($starter->checkForm->a_errors['login'])){echo 'on_error';}?>"  id="<?php echo $login->a_fields['fields']['login']['field'];?>" name="<?php echo $login->a_fields['fields']['login']['field'];?>" type="text" maxlength="50" value="<?php echo isset($_POST['login']) ? htmlentities($_POST['login']) : ''; ?>" placeholder="<?php echo $login->a_fields['fields']['login']['label'];?>"/>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="margT20">
                                <label for="<?php echo $login->a_fields['fields']['password']['field'];?>" class="relative">
                                    <input required="required" autocomplete="OFF" class="fullW <?php if(isset($starter->checkForm->a_errors['password'])){echo 'on_error';}?>" id="<?php echo $login->a_fields['fields']['password']['field'];?>" name="<?php echo $login->a_fields['fields']['password']['field'];?>" type="password" value="" placeholder="<?php echo $login->a_fields['fields']['password']['label'];?>"/>
                                    <div class="password-icon">
                                        <i data-feather="eye"></i>
                                        <i data-feather="eye-off"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                        <!-- <div class="col-md-12 ">
                            <label for="user_remember" class="flex checkfield alignfC">
                                <input autocomplete="OFF"  type="checkbox" name="user_remember" id="user_remember" value="1" class="field-checkbox checkmarkbox" />
                                <span class="checkmarkbox"></span>
                                <span class="ft16 margL10"><?php echo $starter->_get_lexique('Se souvenir de moi');?></span>
                            </label>
                        </div> -->
                        <div class="col-md-12 margB20">
                            <a class="btn ft16 ftblack" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-type="iframe" data-link="<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->mods['forgot_password']['referer'];?>.html" href="javascript:void(0);"><?php echo $starter->_get_lexique('Mot de passe oublié');?></a>
                        </div>
                        <div class="col-md-12" >
                            <div class="alignC margT20" >
                                <button id="send" class="field-submit upper CTAFirst CTA fullW-sm" type="submit"><?php echo $starter->_get_lexique('Se connecter');?></button>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="title margH20 padV5 alignC">
                                <p><?php echo $starter->_get_lexique("Chez Rosalie Family, chacun peut donner ou recevoir un petit coup de main");?> ❤️<br>
                                <?php echo $starter->_get_lexique("Rosalie t’aide à faire moins de trajets… ou à les rendre plus joyeux");?> 🚗🎶<br>
                                <?php echo $starter->_get_lexique("Ici, on partage plus que des trajets. On s’aide entre parents");?> 🙌</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>