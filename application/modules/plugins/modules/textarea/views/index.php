<label for="<?php echo $val['champ'];?>">
	<span class="name_label"><?php echo $val['title'];?>
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
        <span class="obligatory"><?php echo '*' ;?></span>
<?php }?>
    </span>
    <textarea type="text" name="<?php echo $val['champ'];?>" id="<?php echo $val['champ'];?>" class="mceNoEditor <?php echo (isset($val['class']) ? $val['class'] : '');?> <?php if(isset($checkForm->a_errors[$val['champ']])){echo 'on_error';}?>"/><?php if($s_action == "edit"){echo (isset($aData[$val['champ']]) ? $aData[$val['champ']] : '');}elseif($s_action == "add" && isset($_POST[$val['champ']])){echo $_POST[$val['champ']];}?></textarea>
</label>