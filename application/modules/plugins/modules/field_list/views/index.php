<label for="<?php echo $val['champ'];?>">
	<span class="name_label"><?php echo $val['title'];?>
	<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
		<span class="obligatory"><?php echo '*' ;?></span>
		<?php }?>
	</span>
	<select name="<?php echo $val['champ']; ?>" id="<?php echo $val['champ']; ?>" size="1" <?php echo (isset($val['js_callback']) && !empty($val['js_callback']) ? 'onchange="javascript:' . $val['js_callback'] . ';"' : '');?>>
		<?php if(!isset($val['verif']) || !in_array('mandatory',$val['verif'])){?>
			<option value="0"><?php echo $starter->_get_lexique('Sélectionner');?></option>
		<?php } ;?>
		<?php if($starter->utils->is__countable($val['data']) && count($val['data']) > 0){
			foreach($val['data'] as $option => $value){

			$nb_nbsp = '';
			if(isset($a_list_view[$option]) && isset($val['list_view']) && $val['list_view'] == "arbo"	)
				if($a_list_view[$option][0] == '2')
					$nb_nbsp = 'style="padding-left:10px;"';

				elseif($a_list_view[$option][0] == '3')
					$nb_nbsp = 'style="padding-left:20px;"';

			elseif($a_list_view[$option][0] == '4')
			$nb_nbsp = 'style="padding-left:30px;"';?>
			<option <?php echo $nb_nbsp; ?> value="<?php echo $option; ?>"<?php echo ((isset($aData[$val['champ']]) && $aData[$val['champ']] == $option) || (isset($_POST[$val['champ']]) && $_POST[$val['champ']] == $option)  ? ' selected="selected"' : ''); ?>><?php echo $value; ?></option>
			<?php } ?>
		<?php } ?>
	</select>
	<img src="<?php echo $starter->ASSETS_PATH?>chevron.svg" alt=""/>
</label>
