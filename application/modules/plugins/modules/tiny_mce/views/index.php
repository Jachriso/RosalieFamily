<label for="<?php echo $val['champ'];?>">
	<span class="name_label">
		<?php echo $val['title'];?>
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
        <span class="obligatory"><?php echo '*' ;?></span>
<?php }?>
    </span>
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
    <span class="obligatory"><?php echo $starter->_get_lexique('*') ;?></span>
<?php }?>
</label>                                            
<textarea name="<?php echo $val['champ'];?>" id="<?php echo $val['champ'];?>" class="isTyni <?php echo $key;?>" ><?php echo ($s_action == "edit" ? $aData[$val['champ']] : (isset($_POST[$val['champ']]) ? $_POST[$val['champ']] : ''));?></textarea>
