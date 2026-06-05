                                            <label for="<?php echo $val['champ'];?>">
											   
                                                <div class="small_form-field">
                                                    <a id="upload_link_<?php echo $key; ?>" data-modal="popinModule" class="popup-button button" data-class="full" data-link="<?php echo $starter->HTTP_ROOT;?>plugins/<?php echo $val['type'];?>.html?page=<?php echo htmlentities($_GET['page']);?>&module=<?php echo htmlentities($_GET['module']);?>&config_id=<?php echo htmlentities($_GET['config_id']);?>&lang=<?php echo $starter->s_lang;?>&ilang=<?php echo $starter->i_lang;?>&config=<?php echo $s_config;?>&field=<?php echo $key; ?>&action=<?php echo htmlentities($_GET['action']);?>&val_id=<?php echo (isset($_GET['val_id']) ? htmlentities($_GET['val_id']) : '');?>" > <span class="name_label">
                                                    <?php echo $val['title'];?>
<?php if(isset($val['verif']) && in_array('mandatory',$val['verif'])){?>
                                                    <span class="obligatory">*</span>
<?php }?>                                       </span>
                                                    </a>
                                                </div>
                                                <input type="hidden" name="<?php echo $val['champ']; ?>" id="<?php echo $val['champ']; ?>" value="<?php echo (isset($_POST[$val['champ']]) && !empty($_POST[$val['champ']]) ? htmlentities($_POST[$val['champ']]) : (isset($aData[$val['champ']]) && !empty($aData[$val['champ']]) ? htmlentities($aData[$val['champ']]) :'') ); ?>" />
                                            </label>