<label for="<?php echo $val['champ'];?>">
	<span class="name_label">
		<?php echo $val['title'];?>            
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
        <span class="obligatory"><?php echo ' * ' ;?></span>
<?php }?>
    </span>
    <input autocomplete="off" type="date" value="<?php if($s_action == "edit"){echo $aData[$val['champ']];}elseif($s_action == "add" && isset($_POST[$val['champ']])){echo $_POST[$val['champ']];}?>" id="<?php echo $val['champ'];?>" name="<?php echo $val['champ'];?>" class="date_" />
</label>