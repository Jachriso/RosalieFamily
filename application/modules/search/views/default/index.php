
            <div id="container" class="results container-fluid">
<?php if($search->i_nb_result == 0){?>
                <h1 class="col-md-12 col-sm-12 col-xs-12"><?php echo $starter->_get_lexique('Aucun résultat pour votre recherche.');?></h1>
<?php }else{?>
                <h1 class="col-md-12 col-sm-12 col-xs-12"><?php echo $search->i_nb_result . " " . ($search->i_nb_result > 1 ? $starter->_get_lexique('résultats pour') : $starter->_get_lexique('résultat pour'));?> <?php echo $starter->_get_lexique('"');?><?php echo htmlentities($s_search) ;?><?php echo $starter->_get_lexique('"');?></h1>
<?php if(isset($search->i_nb_download) && $search->i_nb_download > 0){?>
                <h2><?php echo $starter->_get_lexique('Téléchargements') . $starter->_get_lexique(' (') . $search->i_nb_download . $starter->_get_lexique(')');?></h2>
                <ul id="download_list">
<?php foreach($a_data['download'] as $key => $val){?>
                    <li id="li-XX" class="col-md-2 col-sm-4 col-xs-6">
                        <div class="dl-list-img">
                            <div class="link_img">
                                <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') .  $val['uri_referer'] ;?>" style="background-image: url('<?php echo (!empty($val['download_thumb']) ? $starter->CDN_PATH . 'downloads/thumbs/' . $val['download_thumb'] : $starter->MEDIA_PATH . 'static/picture.png');?>');"></a>
                                <img src="<?php echo $starter->MEDIA_PATH;?>interface/bg_telechargements.png" class="backg" alt="<?php echo (!empty($val['detail_label']) ? $val['detail_label'] : $val['download_name']);?>">
                            </div>
                        </div>
                        <div class="list-info">
                            <span class="title_support"><?php echo (!empty($val['detail_label']) ? $val['detail_label'] : $val['download_name']);?> <?php echo $starter->_get_lexique('-');?> <br /></span>
                            <span class="cat_support"><?php echo (!empty($val['detail_label_download_categories_detail']) ? $val['detail_label_download_categories_detail'] : $val['category_name']);?> <?php echo $starter->_get_lexique('-');?> <?php echo (!empty($val['detail_label_tree_detail']) ? $val['detail_label_tree_detail'] : $val['tree_label']);?></span>
                        </div>
                        <div class="cart-actions">
                            <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') .  $val['uri_referer'] ;?>" class="voir">
                                <?php echo $s_lexique_look;?>
                            </a>
                            <a href="<?php echo $starter->MEDIA_DOWNLOAD . $val['download_path'];?>" class="telecharger">
								<?php echo $s_lexique_dl;?>
                            </a>
                            <div class="add-delete">
                                <a id="cart1_<?php echo $val['docId'];?>" href='<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $menu->s_download;?>/telechargements_del/<?php echo $val['detail_download_referer'];?>.html?cartDel=<?php echo $val['docId'];?>&cartType=ask' class="fancybox-iframe_light" style=" <?php if(!isset($a_cart) || !in_array($val['docId'], $a_cart[0]->index)){?>display:none;<?php }?>" >
                                    <span class="ico-front ico-front-delete delete-list"><?php echo $s_lexique_delete ;?></span>
                                </a>
                                <a id="cart2_<?php echo $val['docId'];?>" href='<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $menu->s_download;?>/telechargements_add.html?cartAdd=[{"index":[<?php echo $val['docId'];?>]}]' class="fancybox-iframe_ultra-light" style=" <?php if(isset($a_cart) && in_array($val['docId'], $a_cart[0]->index)){?>display:none;<?php }?>" >
                                    <span class="ico-front ico-front-plus add-list"><?php echo $s_lexique_add;?></span>
                                
                                </a>
                                
                            </div>
                            
                        </div>
                                                    
                        <div class="clear"></div>
                        
                    </li>
<?php }?>
                </ul>
<?php }?>
                        
                <div class="clear"></div>

<?php if($i_nb_tree > 0){?>
                
                <h2><?php echo $starter->_get_lexique('Chartes') . $starter->_get_lexique(' (') . $i_nb_tree . $starter->_get_lexique(')');?></h2>

                <ul id="download_list">
<?php foreach($a_data['tree'] as $key => $val){?>
                    <li id="li-XX" class="col-md-2 col-sm-4 col-xs-6">
                    
                        <div class="dl-list-title">
                        
                            <div class="link_title">
                            
                                <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') .  $val['uri_referer'] ;?>"><?php echo (!empty($val['detail_label']) ? $val['detail_label'] : $val['tree_label']);?></a>                                
                            </div>
                        
                        </div>
                        
                        <div class="list-info">
                        
                            <span class="title_support"<?php echo (!empty($val['detail_label']) ? $val['detail_label'] : $val['tree_label']);?>><br /></span>
                            
                            <span class="cat_support"><?php echo strip_tags($val['detail_text']);?></span>
                        
                        </div>
                        
                        <div class="cart-actions">
                        
                            <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') .  $val['uri_referer'] ;?>" class="voir"><?php echo $starter->_get_lexique('Voir');?></a>
                            
                        </div>
                                                    
                        <div class="clear"></div>
                        
                    </li>
<?php }?>
                </ul>
<?php }?>

                <div class="clear"></div>
<?php if($i_nb_creative_gallery > 0){?>
                
                <h2><?php echo $starter->_get_lexique('Creative Gallery') . $starter->_get_lexique(' (') . $i_nb_creative_gallery . $starter->_get_lexique(')');?></h2>

                <ul id="download_list">
<?php foreach($a_data['creative_gallery'] as $key => $val){?>
                    <li id="li-XX" class="col-md-2 col-sm-4 col-xs-6">
                    
                        <div class="dl-list-img">
                        
                            <div class="link_img">
                            
                                <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') .  $val['uri_referer'] ;?>" style="background-image: url('<?php echo (!empty($val['gallery_cover']) ? $starter->CDN_PATH . $val['gallery_cover'] : $starter->MEDIA_PATH . 'static/picture.png');?>');"></a>
                                
                                <img src="<?php echo $starter->MEDIA_PATH;?>interface/bg_telechargements.png" class="backg" alt="<?php echo (!empty($val['detail_label']) ? $val['detail_label'] : $val['gallery_label']);?>">
                                
                                <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') .  $val['uri_referer'] ;?>" style="background-image: url('<?php echo $starter->CDN_PATH;?>downloads/thumbs/<?php echo $val['gallery_cover'];?>');"></a>
                                
                                <img src="<?php echo $starter->MEDIA_PATH;?>interface/bg_telechargements.png" class="<?php echo (!empty($val['detail_label']) ? $val['detail_label'] : $val['gallery_label']);?>" alt="">
                            
                            </div>
                        
                        </div>
                        
                        <div class="list-info">
                        
                            <span class="title_support"><?php echo (!empty($val['detail_label']) ? $val['detail_label'] : $val['gallery_label']);?> <br /></span>
                            
                            <span class="cat_support"><?php echo (!empty($val['detail_label_gallery_categories_detail']) ? $val['detail_label_gallery_categories_detail'] : $val['category_label']);?></span>
                            
                        </div>
                        
                        <div class="cart-actions">
                            
                            <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $menu->s_creative . '/' . $val['detail_referer'] . '.html';?>" class="voir">
                                        
                                <?php echo $s_lexique_look;?>
                                            
                            </a>
                            
                            <a href="<?php echo $starter->MEDIA_DOWNLOAD . $val['gallery_cover'];?>" class="telecharger">
                                        
								<?php echo $s_lexique_dl;?>
                                
                            </a>
                                                        
                            <div class="add-delete">
                            
                                <a id="cart1_<?php echo $val['docId'];?>" rel="<?php echo $val['detail_referer'];?>" class="del_cart" style=" <?php if(!isset($a_cart) || !in_array($val['docId'], $a_cart[0]->index)){?>display:none;<?php }?>" >
                                            
                                    <span class="ico-front ico-front-delete delete-list"><?php echo $s_lexique_delete ;?></span>
                                    
                                </a>
                                <a id="cart2_<?php echo $val['docId'];?>" rel="<?php echo $val['detail_referer'];?>" class="add_cart" style=" <?php if(isset($a_cart) && in_array($val['docId'], $a_cart[0]->index)){?>display:none;<?php }?>" >
                                    
                                    <span class="ico-front ico-front-plus add-list"><?php echo $s_lexique_add;?></span>
                                
                                </a>
                                
                            </div>
                            
                        </div>
                                                    
                        <div class="clear"></div>
                        
                    </li>
<?php }?>
                </ul>
<?php }?>

<?php }?>
                <div class="clear"></div>
            </div><!-- /. container fluid -->
                
            <div class="clear"></div>