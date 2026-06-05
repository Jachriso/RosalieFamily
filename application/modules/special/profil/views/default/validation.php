<div class="pad20">
    <div class="alignC">
        <img src="<?php echo $starter->MEDIA_PATH;?>logo.png" class="picto h40" style="" alt="<?php echo $starter->_get_lexique("Rosalie") ;?>">
    </div>
    <div class="margT20">
        <div class="alignC">
            <h1 class="bolder"><?php echo $starter->_get_lexique("Validation d'un adhérent.");?></h1>
        </div>
        <div class="alignC">
            <form action="<?php echo $starter->HTTP_DOMAIN . ($_SERVER['REDIRECT_URL']); ?>" id="form_authenticate" name="form_authenticate" method="post" class="">
<?php  if(!isset($_SESSION['WARNING'])){?>              
                <h3 class="" ><?php echo $starter->_get_lexique('Veuilez copier le mot de passe ci-dessous et le coller dans le formulaire disponible');?> <a href="<?php echo $starter->HTTP_ROOT;?>" class=""><?php echo $starter->_get_lexique('ici');?>.</a><br />
                <?php echo $starter->_get_lexique('Pensez à personnaliser votre mot de passe dans la page profil.');?></h3>
    <?php }?>
                <fieldset >
                    <?php  if(isset($_SESSION['WARNING'])){?>
                        <div class="">
                            <h4 class="">
                            <img src="<?= $starter->MEDIA_PATH;?>interface/warning.svg" alt="" class="icon inline-svg fill-white margin-right1">
                            <?php echo implode(', ',$_SESSION['WARNING']['content']);?></h4>
                        </div>
                    <?php 
                    } 
                    else{?>
                    <div class="">
                        <div class="">
                            <input autocomplete="off" class="alignC" readonly="readonly" type="text" maxlength="50" value="<?php echo $login->forgotPassword->uniqPass; ?>" />
                        </div>
                    </div>
                    <?php
                    }?>
                </fieldset>
            </form>
        </div>
    </div>
</div>