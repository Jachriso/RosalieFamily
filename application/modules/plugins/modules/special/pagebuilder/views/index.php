<span class="name_label">
	<?php echo $val['title'];?>
</span>
<?php if(isset($val['vtype']) && $val['vtype'] == "inside"){?>
	<iframe class="auto-height" src="<?php echo $starter->HTTP_ROOT;?>plugins/<?php echo $val['type'];?>.html?field=<?php echo $val['champ'];?>&fieldedit=<?php echo $val['champedit'];?>&ilang=<?php echo $item;?>&data=<?php echo $s_form_valId  ;?>&templates=<?php echo $val['templates'];?>&grids=<?php echo $val['grids'];?>&part=<?php echo $element["table"];?>&key=<?php echo $element["key"];?>" frameborder="0" height="100%" width="100%"></iframe>
<?php 
}
else{?>
	<div class="small_form-field">

		<a id="upload_link_<?php echo $key; ?>" class="fancybox-iframe" href="<?php echo $starter->HTTP_ROOT;?>plugins/<?php echo $val['type'];?>.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&lang=<?php echo $starter->s_lang;?>&ilang=<?php echo $starter->i_lang;?>&config=<?php echo $s_config;?>&field=<?php echo $key; ?>&action=<?php echo $s_action;?>&val_id=<?php echo $s_form_valId;?>">

			<?php echo $starter->_get_lexique('Page Builder');?>

		</a>

	</div>
<?php 
} ?>
<textarea style="display:none;" name="<?php echo $val['champ'];?>" id="<?php echo $val['champ'];?>">
	<?php echo ($s_action == "edit" ? (isset($aData[$val['champ'] ]) ? $aData[$val['champ']] : '') : (isset($_POST[$val['champ']]) ? $_POST[$val['champ']] : ''));?>
</textarea>

<textarea style="display:none;" name="<?php echo $val['champedit'] ;?>" id="<?php echo $val['champedit'];?>">
	<?php echo ($s_action == "edit" ? (isset($aData[$val['champedit']]) ? $aData[$val['champedit']] : '') : (isset($_POST[$val['champedit']]) ? $_POST[$val['champedit']] : ''));?>
</textarea>