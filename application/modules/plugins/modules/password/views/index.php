<label for="<?php echo $val['champ'];?>">
	<span class="name_label">
		<?php echo $val['title'];?>
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
        <span class="obligatory"><?php echo '*' ;?></span>
<?php }?>
    </span>
    <input autocomplete="OFF" type="password" name="<?php echo $val['champ'];?>" id="<?php echo $val['champ'];?>" class="small_text <?php if(isset($checkForm->a_errors[$val['champ']])){echo 'on_error';}?>" <?php if(isset($val['champ'])){?> <?php if(isset($val['maxlength'])){?>maxlength="<?php echo $val['maxlength'];?>"<?php }}?> <?php if(isset($val['verif']) && in_array('readonly',$val['verif'])){?> readonly="readonly"<?php }?>/>
</label>