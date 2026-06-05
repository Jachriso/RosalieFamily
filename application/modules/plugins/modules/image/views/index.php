<?php 
$_SESSION['specialdir'] = (isset($starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['path']) ? $starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['path'] : '') . (isset($starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['special_path']) && !empty($starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['special_path']) ? $starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['special_path'] : '');?>

											<label for="<?php echo $val['champ'];?>">

												<span class="name_label">
												<?php echo $val['title'];?>                                                
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
													<span class="obligatory"><?php echo '*' ;?></span>
<?php }?>
												</span>

											</label>

<?php if(isset($val['vtype']) && $val['vtype'] == "inside"){?>
                                            <iframe class="auto-height" src="<?php echo $starter->HTTP_ROOT;?>plugins/<?php echo $val['type'];?>.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&lang=<?php echo $starter->s_lang;?>&ilang=<?php echo $starter->i_lang;?>&config=<?php echo $s_config;?>&field=<?php echo $key; ?>&specialdir=<?php echo $_SESSION['specialdir']; ?>&embed=true" frameborder="0" height="100%" width="100%"></iframe>
<?php }else{?>
											<div class="small_form-field">
												
												<a id="upload_link_<?php echo $key; ?>" class="fancybox-iframe" href="<?php echo $starter->HTTP_ROOT;?>plugins/<?php echo $val['type'];?>.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&lang=<?php echo $starter->s_lang;?>&ilang=<?php echo $starter->i_lang;?>&config=<?php echo $s_config;?>&field=<?php echo $key; ?>&specialdir=<?php echo $_SESSION['specialdir']; ?>" >

													<img src="<?php echo $starter->MEDIA_PATH . '/interface/upload.svg';?>" alt="add file" />

												</a>  

												<?php if(!empty($starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['special_path']) && is_dir(dirname( __FILE__) .'/../../../../web/content/bdd/' .  $_SESSION['specialdir'])){?>
												<a id="view_link_<?php echo $val['key']; ?>" class="fancybox-iframe" href="<?php echo $starter->HTTP_ROOT;?>plugins/<?php echo $val['type'];?>.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&lang=<?php echo $starter->s_lang;?>&ilang=<?php echo $starter->i_lang;?>&config=<?php echo $s_config;?>&field=<?php echo $key; ?>">

													<img src="<?php echo $starter->MEDIA_PATH . '/interface/preview.svg';?>" alt="<?php echo $starter->_get_lexique('Voir le fichier :');?>" />

												</a>
											</div>
	<?php }
	}?>
	<input autocomplete="OFF" type="hidden" name="<?php echo $val['champ']; ?>" id="<?php echo $val['champ']; ?>" value="<?php echo (isset($_POST[$val['champ']]) && !empty($_POST[$val['champ']]) ? $_POST[$val['champ']] : (isset($aData[$val['champ']]) && !empty($aData[$val['champ']]) ? $aData[$val['champ']] : (isset($starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['special_path']) ? $starter->_configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$val['champ']]['special_path'] : ''))); ?>" />
