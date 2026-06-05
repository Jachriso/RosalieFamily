<label for="<?php echo $val['champ'];?>">
	<span class="name_label">
		<?php echo $val['title'];?>
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
        <span class="obligatory"><?php echo '*' ;?></span>
<?php }?>
    </span>
    <input autocomplete="OFF" type="text" name="<?php echo $val['champ'];?>" id="<?php echo $val['champ'];?>" class="<?php echo $key;?> small_text <?php if(isset($checkForm->a_errors[$val['champ']])){echo 'on_error';}?> <?php echo (isset($val['special_type']) && $val['special_type'] == 'isAutocompleteCity' ? 'isAutocompleteCity' : '');?>" value="<?php echo ($s_action == "edit" ? (isset($aData[$val['champ']]) ? $aData[$val['champ']] : '') : (isset($_POST[$val['champ']]) ? $_POST[$val['champ']] : ''));?>" <?php if(isset($val['champ'])){?> <?php if(isset($val['maxlength'])){?>maxlength="<?php echo $val['maxlength'];?>"<?php }}?> <?php if(isset($val['verif']) && in_array('readonly',$val['verif'])){?> readonly<?php }?>/>
</label>