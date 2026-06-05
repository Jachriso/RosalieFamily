<section class="padB80">
    <div class="container">
        <div class="overview relative">
            <div class="title margH20 padV5 alignC">
                <h1><?php echo $starter->_get_lexique("Team parents solidaires, en route ?");?></h1>
            </div>
        </div>
    </div>
    <form action="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['covoiturages']['referer'];?>.html" class="form margT20" id="blocForm" name="blocForm" method="POST">
        <div class="relative">
            <div class="backgreyl padH20 padB40 brad30 ">
                <div class="container">
                    <div class="row gy-4 gx-4">
                        <!-- <div class="col-12">
                            <div class="alignC margT20">
                                <p><?php //echo $starter->_get_lexique("Qui es-tu aujourd'hui ?");?><br>
                                <?php //echo $starter->_get_lexique("Choisis ton rôle :");?></p>
                            </div>
                        </div> -->
<?php if(count($covoiturages->covoiturage->a_data ) > 0){?>
                        <div class="col-md-6 col-sd-12">
                            <div class="alignC">
                                <button id="" name="covoiturage_type" value="2" class="CTA CTAFirst" ><?php echo $starter->_get_lexique("Je suis parent conducteur");?></button>
                                <p><?php echo $starter->_get_lexique("Je propose mon aide");?></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sd-12">
                            <div class="alignC">
                                <button id="" name="covoiturage_type" value="1" class="CTA CTAFirst" ><?php echo $starter->_get_lexique("Je suis parent utilisateur");?></button>
                                <p><?php echo $starter->_get_lexique("J'ai besoin d'aide pour emmener mon enfant");?></p>
                            </div>
                        </div>
<?php }else{?>
                        <div class="col-12">
                            <div class="alignC">
                                
                                <p><?php echo $starter->_get_lexique("Vous devez avoir des adhérents validés afin de pouvoir utiliser nos services.");?></p>
                            </div>
                        </div>
<?php }?>
                        <!-- <div class="col-md-6 col-sd-12">
                            <div class="alignC">
                                <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['new_covoiturage']['referer'];?>.html?covoiturage_type=1" class="CTA CTAFirst ft20 " ><?php echo $starter->_get_lexique("Je suis parent conducteur");?></a>
                                <p><?php echo $starter->_get_lexique("Je propose mon aide");?></p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sd-12">
                            <div class="alignC">
                                <a href="<?php echo (count($covoiturages->covoiturage->a_data ) > 0 ? $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'] . '/' . $starter->mods['covoiturages']['modules']['new_covoiturage']['referer'].".html?covoiturage_type=2" : 'javascript:void(0)');?>" class="CTA CTAFirst ft20  <?php echo (count($covoiturages->covoiturage->a_data ) > 0 ? '' : 'locked');?>" ><?php echo $starter->_get_lexique("Je suis parent utilisateur");?></a>
                                <p><?php echo $starter->_get_lexique("J'ai besoin d'aide pour emmener mon enfant");?></p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="container">
        <div class="overview relative">
            <div class="title margH20 padV5 alignC">
                <p><?php echo $starter->_get_lexique("Chez Rosalie Family, chacun peut donner ou recevoir un petit coup de main");?> ❤️<br>
                <?php echo $starter->_get_lexique("Rosalie t’aide à faire moins de trajets… ou à les rendre plus joyeux");?> 🚗🎶<br>
                <?php echo $starter->_get_lexique("Ici, on partage plus que des trajets. On s’aide entre parents");?> 🙌</p>
            </div>
        </div>
    </div>
</section>