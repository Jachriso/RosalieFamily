<?php if(isset($starter->mods['send_to_friend']) && isset($starter->b_mail) && $starter->b_mail){?>
                                <a id="forgot_password" class="share fancybox-iframe_light" rel="<?php echo $starter->HTTP_DOMAIN . $_SERVER['REQUEST_URI'];?>" href="<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->mods['send_to_friend']['referer'];?>.html"><?php echo $starter->_get_lexique('Partager');?></a>
<?php }?>

<?php if(isset($starter->b_print) && $starter->b_print){?>
                                <a href="javascript:window.print();" class="print"><?php echo $starter->_get_lexique('Imprimer');?></a>
<?php }?>                            
                    <h1 class="hidden-sm hidden-md hidden-lg"><?php echo (!empty($menu->current[$i_level]['detail_label']) ? $menu->current[$i_level]['detail_label'] : $menu->current[$i_level]['tree_label']);?></h1>

                        <form id="download_cat_form" class="download_cat_form bloc-blanc-contour" name="download_cat_form"  method="GET">
                            
                            <input autocomplete="OFF" type="hidden" value="<?php echo (isset($starter->_special_GET['searchCharteAdd']) ? htmlentities($starter->_special_GET['searchCharteAdd']) : '');?>" id="searchCharteAdd" name="searchCharteAdd" />
                            
                            <input autocomplete="OFF" type="hidden" value="<?php echo (isset($starter->_special_GET['searchCatAdd']) ? htmlentities($starter->_special_GET['searchCatAdd']) : '');?>" id="searchCatAdd" name="searchCatAdd" />
                            
                            <input autocomplete="OFF" type="hidden" value="0" id="currentPage" name="currentPage" />
                            
                            <input type="hidden" value="10" id="viewnbpage" name="viewnbpage" />
                                                    
                            <div id="form_content">
                                    
                                 <input autocomplete="OFF" type="hidden" value="<?php echo $s_lexique_search_value;?>" id="search_download" name="search_download"  placeholder="<?php echo $s_lexique_search;?>"/>
                                <div>
                                
                                    <h4><?php echo $s_lexique_categories;?></h4>
                                    
                                    <ul>
<?php foreach($a_cat as $key => $val){?>
                                        <li rel="<?php echo $val['category_id'];?>">
                                            
                                            <div class="">
                                                    
                                                <input autocomplete="OFF" disabled="disabled" class="cat_type" type="checkbox" name="cat_<?php echo $val['category_id'];?>" id="cat_<?php echo $val['category_id'];?>" value="<?php echo $val['category_id'];?>" <?php if(in_array($val['category_id'], $_a_tmp_cat)){?> checked="checked" <?php }?>/>
                                                
                                                <label for="cat_<?php echo $val['category_id'];?>">
                                                
                                                    <span class="ico-front ico-front-checkbox"></span>
                                                    
                                                    <?php echo (!empty($val['detail_label']) ? $val['detail_label'] : $val['category_name']);?>
                                                    
                                                </label>
                                                
                                            </div>
                                            
                                        </li>
<?php }?>
                                    </ul>
                        
                                </div>
                                
                                <hr/>
                                
                                                              
                            </div>
                        
                        </form>
             
                    
                  
                        <form id="download_form" class="download_form" name="download_form" action="<?php echo $starter->HTTP_DOMAIN . $_SERVER['REQUEST_URI'];?>" method="post">

                            <input autocomplete="OFF" type="hidden" id="file" name="file" value="" />

                         
                            <ul id="download_list" class="row">
<?php foreach($a_data as $key => $val){?>

                                <li style="<?php if($key>51){echo 'display:none;';}?>" id="li-<?php echo $key;?>" class="col-md-3 col-sm-4 col-xs-6 <?php if(isset($a_cart) && in_array($val['download_id'], $a_cart[0]->index)){?>in-caddie <?php }?>">
                                    

                                        <div class="dl-list-img">
                                                
                                            <a href="<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->s_level1 . '/' . $val['detail_download_referer'] . '.html';?>" >
                                                <img src="<?php echo (!empty($val['download_thumb']) ? $starter->CDN_PATH . 'downloads/thumbs/' . $val['download_thumb'] : $starter->MEDIA_PATH . 'static/picture.png');?>" alt="">
                                            </a>

                                        </div>

                                        <div class="list-info">

                                            <span class="title_support"><?php echo (!empty($val['detail_download_label']) ? $val['detail_download_label'] : $val['download_name']);?><br /></span>

                                            <span class="cat_support">

                                            <?php echo (!empty($val['download_category']) ? $a_cat[$val['download_category']]['detail_label_download_categories_detail'] : '') ;?>

                                            </span>

                                        </div>
                                        
                                        <div class="cart-actions">

                                            <a href="<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->s_level1 . '/' . $val['detail_download_referer'] . '.html';?>" class="voir">

                                                <?php echo $s_lexique_look;?>

                                            </a>

                                            <a href="<?php echo $starter->MEDIA_DOWNLOAD . $val['download_path'];?>" class="telecharger">

                                                <?php echo $s_lexique_dl;?>

                                            </a>

                                            <div class="add-delete">

                                                <a id="cart1_<?php echo $val['download_id'];?>" href='<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $menu->s_download;?>/telechargements_del/<?php echo $val['detail_download_referer'];?>.html?cartDel=<?php echo $val['download_id'];?>&cartType=ask' class="fancybox-iframe_light" style="pointer-events: none; <?php if(!isset($a_cart) || !in_array($val['download_id'], $a_cart[0]->index)){?>display:none;<?php }?>" >

                                                    <span class="ico-front ico-front-delete delete-list"><?php echo $s_lexique_delete ;?></span>

                                                </a>
                                              

                                                <a id="cart2_<?php echo $val['download_id'];?>" href='<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $menu->s_download;?>/telechargements_add.html?cartAdd=[{"index":[<?php echo $val['download_id'];?>]}]' class="fancybox-iframe_ultra-light" style="pointer-events: none; <?php if(isset($a_cart) && in_array($val['download_id'], $a_cart[0]->index)){?>display:none;<?php }?>" >

                                            
                                                    <span class="ico-front ico-front-plus add-list"><?php echo $s_lexique_add;?></span>

                                                </a>

                                            </div>

                                        </div>

                                    
                                </li>
<?php }?>
                            </ul>                             
<?php if($starter->utils->is__countable($a_data) && count($a_data) > 50){?>
                                    <a href="javascript:void(0);" ><?php echo $starter->_get_lexique('Voir plus');?></a>
<?php }?>
                        </form>
                    </div>
                </div><!-- /. Colonne droite -->
            
            </div>
