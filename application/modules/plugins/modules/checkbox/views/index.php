<label for="<?php echo $val['champ'];?>">
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
    <span class="obligatory"><?php echo '*' ;?></span>
<?php }?>                                  
	<?php if(isset($val['icon']) && $val['icon'] == "online"){?>
	<input autocomplete="off" type="hidden" id="<?php echo $val['champ'];?>" name="<?php echo $val['champ'];?>" class="<?php if(isset($checkForm->a_errors[$val['champ']])){echo 'on_error';}?>" value="1" />
	<span id="switch-<?php echo (isset($aData[$val['champ']]) ? $aData[$val['champ']] : (isset($_POST[$val['champ']]) ? $_POST[$val['champ']] : "1"));?>" rel="<?php echo $val['champ'];?>" class="switchEdit ico switch-<?php echo (empty($aData[$val['champ']]) ? "0" : $aData[$val['champ']]);?>"><?php echo (isset($aData[$val['champ']]) ? $aData[$val['champ']] : (isset($_POST[$val['champ']]) ? $_POST[$val['champ']] : "0"));?></span>
<?php }else{?>
	<input autocomplete="off" type="checkbox" name="<?php echo $val['champ'];?>" id="<?php echo $val['champ'];?>" class="<?php if(isset($checkForm->a_errors[$val['champ']])){echo 'on_error';}?>" value="1" <?php if(!empty($s_action ) && (($s_action  == "edit" && isset($aData[$val['champ']]) && $aData[$val['champ']] == "1") || ($s_action  == "add" && isset($_POST[$val['champ']]) && $_POST[$val['champ']] == "0"))){echo 'checked="checked"';}?>/>
	<img class="checked" src="<?php echo $starter->ASSETS_PATH;?>checked.svg" alt="">
	<img class="uncheck" src="<?php echo $starter->ASSETS_PATH;?>uncheck.svg" alt="">
<?php }?>
	<span class="name_label"><?php echo $val['title'];?>
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
		<span class="obligatory"><?php echo '*' ;?></span>
<?php }?>
	</span>
</label>