
                                            <label for="<?php echo $val['champ'];?>">
                                            
                                                <span class="name_label">
                                                
                                                    <?php echo $val['title'];?>
                                                    
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
                                                    <span class="obligatory"><?php echo '*' ;?></span>
<?php }?>
                                                    
                                                </span>
                                            </label>
                                            
<?php if(isset($val['vtype']) && $val['vtype'] == "inside"){?>
                                            <iframe class="auto-height full" src="<?php echo $starter->HTTP_ROOT;?>plugins/<?php echo $val['type'];?>.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&lang=<?php echo $starter->s_lang;?>&ilang=<?php echo $starter->i_lang;?>&config=<?php echo $s_config;?>&field=<?php echo $key; ?>&action=<?php echo $s_action;?>&val_id=<?php echo (!empty($s_form_valId) ? $s_form_valId : '0');?>" frameborder="0" height="100%" width="100%"></iframe>
<?php }else{?>
                                            <div class="small_form-field">
                                                
                                                <a id="upload_link_<?php echo $key; ?>" class="fancybox-iframe" href="<?php echo $starter->HTTP_ROOT;?>plugins/<?php echo $val['type'];?>.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&lang=<?php echo $starter->s_lang;?>&ilang=<?php echo $starter->i_lang;?>&config=<?php echo $s_config;?>&field=<?php echo $key; ?>&action=<?php echo $s_action;?>&val_id=<?php echo (!empty($s_form_valId) ? $s_form_valId : '');?>" >
                                            
                                                    <?php echo $starter->_get_lexique('Gérer les droits');?>
                                                
                                                </a>
                                            
                                            </div>
<?php }?>
                                                
                                            <input autocomplete="OFF" type="hidden" name="<?php echo $val['champ']; ?>" id="<?php echo $val['champ']; ?>" value="<?php echo (isset($_POST[$val['champ']]) && !empty($_POST[$val['champ']]) ? htmlentities($_POST[$val['champ']]) : (isset($aData[$val['champ']]) && !empty($aData[$val['champ']]) ? htmlentities($aData[$val['champ']]) :'') ); ?>" />
