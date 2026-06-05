<div id="overlay">
    <div id="overlay_content">
        <h1 class="sendFriend"><?php echo $starter->_get_lexique('Partager la page');?></h1>
        <div class="grey_bloc">
            <form id="sendFriendForm" name="sendFriendForm" action="" method="post">
                <input autocomplete="OFF" name="form_uri" id="form_uri" value="<?php echo htmlentities($send_to_friend->s_form_shareduri);?>" type="hidden">
                <div>
                    <label for="<?php echo $send_to_friend->a_fields['form_email_sender']['fieldname'];?>" class=""><?php echo $send_to_friend->a_fields['form_email_sender']['label'];?></label>
                    <input autocomplete="OFF" name="<?php echo $send_to_friend->a_fields['form_email_sender']['fieldname'];?>" id="<?php echo $send_to_friend->a_fields['form_email_sender']['fieldname'];?>" type="<?php echo $send_to_friend->a_fields['form_email_sender']['type'];?>" class="" placeholder="<?php echo isset($send_to_friend->a_fields['form_email_sender']['default_value']) ? $send_to_friend->a_fields['form_email_sender']['default_value'] : $send_to_friend->a_fields['form_email_sender']['label'];?>" />
                </div>
                <div>
                    <label for="<?php echo $send_to_friend->a_fields['form_email_receiver']['fieldname'];?>"><?php echo $starter->_get_lexique('E-mail du destinataire');?></label>
                    <input autocomplete="OFF" class="" name="<?php echo $send_to_friend->a_fields['form_email_receiver']['fieldname'];?>" id="<?php echo $send_to_friend->a_fields['form_email_receiver']['fieldname'];?>" type="<?php echo $send_to_friend->a_fields['form_email_receiver']['type'];?>" placeholder="<?php echo isset($send_to_friend->a_fields['form_email_receiver']['default_value']) ? $send_to_friend->a_fields['form_email_receiver']['default_value'] : $send_to_friend->a_fields['form_email_receiver']['label'];?>" />                    
                </div>
                <div id="send-block">
                    <a href="javascript:void(0);" onclick="sendSenderForm();return false;"><?php echo $starter->_get_lexique('envoyer');?></a>
                </div>
                <div id="form_result"></div>
                <div id="submit_img" style="display: none; clear: both; padding: 10px 0px 0px;">
                    <img src="<?php echo $starter->MEDIA_PATH;?>interface/ajax-loader.gif" />
                </div>
            </form>
        </div>
    </div>
</div>