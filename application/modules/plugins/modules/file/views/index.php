
<label for="<?php echo $val['champ'];?>">

	<span class="name_label">
		<?php echo $val['title'];?>
		<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
			<span class="obligatory"><?php echo '*' ;?></span>
		<?php }?>
		<div class="info">
			<img src="<?php echo $starter->MEDIA_PATH;?>interface/info.svg" alt="info">
			<div class="pop-up">
				<div class="bubble-left"></div>
				
				<?php echo $starter->_get_lexique('maxfilesize : ') . (isset($val['maxfilesize']) ? $starter->utils->displayBytesLabel($val['maxfilesize']) : $starter->utils->displayBytesLabel(1024000));?><br />
				
				<?php echo $starter->_get_lexique('extensions autorisées : ') . (isset($val['allowedFileExtensions']) ? $val['allowedFileExtensions'] : "jpeg,jpg,gif,png,zip");?>
			</div>
		</div>

	</span>
	
	<div class="actions">
	
		<a id="del_link_<?php echo $val['champ']; ?>" <?php echo (($s_action == "add") || (isset($aData[$val['champ']]) && empty($aData[$val['champ']])) ? 'style="display:none;"' : '');?> href="javascript:void(0);" onclick="javascript:deleteImg('<?php echo $starter->_get_lexique('Confirmer la suppression :');?>','<?php echo $val['champ']; ?>');">
			<img src="<?php echo $starter->MEDIA_PATH . '/interface/close.svg';?>" alt="<?php echo $starter->_get_lexique('Supprimer le fichier :');?>" />
		</a>
	</div>
	
	
	<input autocomplete="off" type="hidden" name="<?php echo $val['champ']; ?>" id="<?php echo $val['champ']; ?>" value="<?php echo (isset($aData[$val['champ']]) && !empty($aData[$val['champ']]) ? $aData[$val['champ']] : '' ); ?>" />
	<?php if(isset($val['file_name'])){?>
		<input autocomplete="off" type="text" readonly="readonly" name="<?php echo $val['file_name']; ?>" id="<?php echo $val['file_name']; ?>" value="<?php echo (isset($aData[$val['file_name']]) && !empty($aData[$val['file_name']]) ? $aData[$val['file_name']] : '' ); ?>" />
	<?php }?>

	
	
	<label for="file_uploaded" class="btn small_text">
		<?php echo (isset($aData[$val['file_name']]) && !empty($aData[$val['file_name']]) ? $aData[$val['file_name']] : $starter->_get_lexique('Choisir un fichier') ); ?>
	</label>
	<input autocomplete="off" type="file" name="file_uploaded" id="file_uploaded" value="<?php echo (isset($_POST['file_uploaded']) && !empty($_POST['file_uploaded']) ? $_POST['file_uploaded'] : '' ); ?>" <?php if(isset($a_data['allowedFileTypes'])){?>accept="<?php echo implode(',',$a_data['allowedFileTypes']);?>"<?php }?>/>

</label>
