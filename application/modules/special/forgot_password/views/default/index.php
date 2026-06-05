<div id="overlay">
    <div id="overlay_content">

        <h1><?php echo $starter->_get_lexique('Mot de passe oublié ?');?></h1>
    
        <div class="ft13"><?php echo $starter->_get_lexique('Vous allez recevoir les instructions pour réinitialiser votre mot de passe.');?></div>
                
        <div class="">
            <form id="sendPassWord" name="sendPassWord" action="" method="post">
                <label for="user_email" class="inputBox margT20">
                    <input autocomplete="OFF" class="" name="user_email" type="text" id="user_email" maxlength="" value="<?php echo (isset($_POST['user_email']) ? $_POST['detail_label'] :  ''); ?>" required="required"/>
                    <span><?php echo $login->forgotPassword->a_fields['user_email']['label'];?></span>
                </label>
                
                <div id="form_result" class="ft13 minH20"></div>       
                <div id="send-block">
                
                    <a href="javascript:void(0);" class="CTA CTAFirst" onclick="sendForgotPassWordForm();return false;"><?php echo $starter->_get_lexique('Envoyer');?></a>
                    
                </div>
                <div id="submit_img" style="display: none; clear: both; padding: 10px 0px 0px;">
                    <img src="<?php echo $starter->MEDIA_PATH;?>interface/ajax-loader.gif" />
                </div>
                    
                <div id="form_result"></div>
            
            </form>
        </div>
    </div>
</div>