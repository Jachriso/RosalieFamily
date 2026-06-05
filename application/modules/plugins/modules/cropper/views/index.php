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
					<?php echo $starter->_get_lexique('maxfilesize : ') . (isset($val['maxfilesize']) ? $starter->utils->displayBytesLabel($val['maxfilesize']) : $starter->utils->displayBytesLabel(1024000));?><br/>
					<?php echo $starter->_get_lexique('extensions autorisées : ') . (isset($val['allowedFileExtensions']) ? $val['allowedFileExtensions'] : "jpeg,jpg,gif,png,zip");?><br/>
					<?php echo $starter->_get_lexique('dimensions minimum : ') . (isset($val['width']) && isset($val['height']) ? $val['width'] . " * " . $val['height'] : "100*100");?>
			</div>
		</div>
	</span>
</label>
<?php if(isset($val['vtype']) && $val['vtype'] == "inside"){
	$targ_w = (isset($val['width']) ? $val['width'] : 100);
	$targ_h = (isset($val['height']) ? $val['height'] : 100);
?>
<script type="text/javascript">
	var _aspectRatio = <?php echo $targ_w . '/' . $targ_h ;?>;
</script>
<?php
	$extensionsResult = null;
	if(isset($val['allowedFileExtensions'])){			
		$tmpExtensionsArray = explode(",", $val['allowedFileExtensions']);
		$extensionsArrayCount = count($tmpExtensionsArray);
		if( $extensionsArrayCount > 0){
			$virgule = ',';
			foreach ($tmpExtensionsArray as $key=>$oneExtension) {
				if($key == $extensionsArrayCount - 1){
					$virgule = null;
				}
				$extensionsResult .= '.'.$oneExtension.$virgule;
			}
		}
	}else{
		$extensionsResult = '.jpeg,.jpg,.gif,.png';
	}
	$conf_data = array(	's_module'		=>	$s_module,
						's_form_page'	=>	$s_form_page,
						's_form_field'	=>	$val['champ'],
						's_config'		=>	$s_config
	);?>
<div id="vignette-upload" href="#" class="add-zone fileinput-button" data-confData="<?php echo htmlentities( json_encode($conf_data), ENT_QUOTES,  "UTF-8" ); ?>"  style="width:40px;height:40px;background-image:url(<?php echo $starter->MEDIA_PATH . '/interface/add.svg';?>);" data-uploadURL="<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/admin.html?action=ajax&case=vignette_upload'; ?>" data-acceptedFiles="<?php echo $extensionsResult; ?>" data-maxFilesize="<?php echo isset($val['maxfilesize']) ? $val['maxfilesize'] : 1024000; ?>"></div>
<div class="container" id="cropper-container">
	<input autocomplete="off" type="hidden" class="form-control" id="dataX" name="dataX" placeholder="x">
	<input autocomplete="off" type="hidden" class="form-control" name="dataY" id="dataY" placeholder="y">
	<input autocomplete="off" type="hidden" class="form-control" name="dataWidth" id="dataWidth" placeholder="width">
	<input autocomplete="off" type="hidden" class="form-control" name="dataHeight" id="dataHeight" placeholder="height">	
	<div class="cropper-preview-container clearfix">
		<div class="img-container">
			<img id="imgToCrop" src="" alt="Picture">
		</div>
		<div class="docs-preview">
			<p>PREVIEW</p>
			<div class="img-preview preview-lg"></div>
			<div id="result"></div>
			<div class="cropper-validate-container">
				<input autocomplete="off" type="hidden" id="action" name="action" value="crop"/>
				<input autocomplete="off" type="hidden" id="file" name="file" value=""/> 
				<div class="small-button">
					<a class="submit-cropper" href="#"><?php echo $starter->_get_lexique("Rogner l'image");?></a>
				</div>
			</div>
			<button type="button" id="buttonCrop">Crop</button>
		</div>
	</div>
	<div class="clear"></div>
	<input type="hidden" name="<?php echo $val['champ'];?>" value="">
</div>
<?php }else{?>
<div class="small_form-field add-zone fileinput-button">
	<a id="upload_link_<?php echo $val['champ']; ?>" data-modal="popinModule" class="popup-button button" data-link="<?php echo $starter->HTTP_ROOT ;?>plugins/<?php echo $val['type'];?>.html?page=<?php echo htmlentities($_GET['page']);?>&module=<?php echo htmlentities($_GET['module']);?>&config_id=<?php echo htmlentities($_GET['config_id']);?>&lang=<?php echo $starter->s_lang;?>&ilang=<?php echo $starter->i_lang;?>&config=<?php echo $s_config;?>&field=<?php echo $key; ?>" >
		<img src="<?php echo $starter->MEDIA_PATH . '/interface/add.svg';?>" alt="add file" />

	</a>  
</div>
<?php 
}?>
<input autocomplete="OFF" type="hidden" name="<?php echo $val['champ']; ?>" id="<?php echo $val['champ']; ?>" value="<?php echo (isset($_POST[$val['champ']]) && !empty($_POST[$val['champ']]) ? $_POST[$val['champ']] : (isset($aData[$val['champ']]) && !empty($aData[$val['champ']]) ? $aData[$val['champ']] : (isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['special_path']) ? $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['special_path'] : ''))); ?>" />
