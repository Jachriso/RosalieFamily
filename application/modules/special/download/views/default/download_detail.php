            <div id="general-message"></div>
            
            <div id="container"  class="container-fluid">
                <div class="buttons">
                                <a href="<?php echo $_SERVER["HTTP_REFERER"];?>" class="actus_back button picto">
                                    <img src="<? echo $starter->MEDIA_PATH.'interface/chevron_left_red.png'; ?>" alt="">
                                    <img src="<? echo $starter->MEDIA_PATH.'interface/chevron_left_white.png'; ?>" alt="">
                                    <?php echo $starter->_get_lexique('Retour à la liste');?>
                                </a>
                            </div>
                <div class="row"><!-- entete avec titre -->

                    
                    

                    <div class="col-md-9 col-sm-9">
                    
                        <h1><?php echo (!empty($a_data['detail_download_label']) ? $a_data['detail_download_label'] : $a_data['download_label']);?></h1>
                    
                    </div>

                    <div class="col-md-3 col-sm-3 hidden-xs">
                    
                        <ul class="header-tools">
                            <?php if(isset($starter->mods['send_to_friend']) && isset($starter->b_mail) && $starter->b_mail){?>
                            <li>
                        
                                <a id="forgot_password" class="share fancybox-iframe_light2" rel="<?php echo $starter->HTTP_DOMAIN . $_SERVER['REQUEST_URI'];?>" href="<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->mods['send_to_friend']['referer'];?>.html?shareduri=<?php echo $starter->HTTP_DOMAIN . $_SERVER['REQUEST_URI'];?>"><?php echo $starter->_get_lexique('Partager');?></a>
                        
                            </li>
                            <?php }?>

                            <?php if(isset($starter->b_print) && $starter->b_print){?>
                            <li>
                            
                                <a href="javascript:window.print();" class="print"><?php echo $starter->_get_lexique('Imprimer');?></a>
                                
                            </li>
                            <?php }?>
                        </ul>
                        
                    </div>

                </div><!-- /.entete avec titre -->

                <div class="row"><!-- contenu -->

                    <div class="col-md-9 col-sm-9 col-xs-6"><!-- slider -->
                        <div class="bloc-blanc-contour">
                            <?php if(!empty($a_data['download_content'])){?>
                            <ul class="bxslider">
                            <?php foreach($a_carrousel as $key => $val){?>



                                <li>

                                    <div>

                                        <img src="<?php echo $starter->CDN_PATH . 'downloads/cover/' . $a_data['download_content'] . '/' . $val;?>"  alt="<?php echo $val;?>" title="<?php echo $val;?>" class="picture" />



                                    </div>

                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                                                
                            <div id="bx-pager" class="row">
                                <?php foreach($a_carrousel as $key => $val){?>
                                <div class="col-md-3 col-sm-4 col-xs-6">
                                    <div class="bloc-blanc-contour">
                                    <a data-slide-index="<?php echo intval($key);?>" href="javascript:void(0);" class="">
                                        <!--<img src="<?php echo $starter->CDN_PATH . 'downloads/cover/' . $a_data['download_content'] . '/thumbs/' . $val;?>"  alt="<?php echo intval($key+1);?>" title="<?php echo intval($key+1);?>" class="picture" />
                                        <span style="background-image:url('<?php echo $starter->CDN_PATH . 'downloads/cover/' . $a_data['download_content'] . '/thumbs/' . $val;?>');">test</span>-->

                                        <span style="background-image:url('<?php echo $starter->CDN_PATH . 'downloads/cover/' . $a_data['download_content'] . '/thumbs/' . $val;?>');"></span>
                                    </a>
                                    </div>
                                </div>
                                <?php } ?>
                                

                            </div>
                            <!--<?php

                                echo "<pre>";
                                print_r($a_data);
                                echo "</pre>";

                            ?>-->
                            
                            
                    </div>
                    <?php } ?>
                    <div class="col-md-3 col-sm-3 col-xs-6 metas">

                        <div class="content bloc-blanc-contour">
                                
                            <span class="title">
                                                        
                                <strong><?php echo $starter->_get_lexique('Catégorie :');?> </strong> <?php echo $s_category;?>
                                
                            </span>
                            
                            <!--<span class="nbr"><strong>Nombre d'éléments :</strong> </span>-->
                            
                            <span class="poids">
                            
                                <strong><?php echo $starter->_get_lexique('Poids :');?> </strong> <?php echo $s_size;?>
                                
                            </span>
                            
                            <div class="warning">
                            
                                
                                
                            </div>
                            
                            <?php if(!empty($a_data['download_path'])){?>
                            <a href="<?php echo $starter->MEDIA_DOWNLOAD . $a_data['download_path'];?>" class="dlwnd button picto"> 
                                <img src="<? echo $starter->MEDIA_PATH.'interface/icn_telecharger_red@2x.png'; ?>" alt="">
                                <img src="<? echo $starter->MEDIA_PATH.'interface/icn_telecharger_wh@2x.png'; ?>" alt="">
                                <?php echo $starter->_get_lexique('Télécharger');?> 
                            </a>                
                            <?php }?>
                            
                            <a id="cart1_<?php echo $a_data['download_id'];?>" href='<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $menu->s_download;?>/telechargements_del/<?php echo $a_data['detail_download_referer'];?>.html?cartDel=<?php echo $a_data['download_id'];?>&cartType=ask' class="fancybox-iframe_light del_cart button picto" style=" <?php if(!isset($a_cart) || !in_array($a_data['download_id'], $a_cart[0]->index)){?>display:none;<?php }?>" >
                                <img src="<? echo $starter->MEDIA_PATH.'interface/icn_del_red@2x.png'; ?>" alt="">
                                <img src="<? echo $starter->MEDIA_PATH.'interface/icn_del_wh@2x.png'; ?>" alt="">
                                <?php echo $s_lexique_delete ;?>
                                
                            </a>
                            
                            <a id="cart2_<?php echo $a_data['download_id'];?>" href='<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $menu->s_download;?>/telechargements_add.html?cartAdd=[{"index":[<?php echo $a_data['download_id'];?>]}]' class="fancybox-iframe_ultra-light add_cart button picto" style=" <?php if(isset($a_cart) && in_array($a_data['download_id'], $a_cart[0]->index)){?>display:none;<?php }?>" > 
                                <img src="<? echo $starter->MEDIA_PATH.'interface/icn_panier_red@2x.png'; ?>" alt="">
                                <img src="<? echo $starter->MEDIA_PATH.'interface/icn_panier_wh@2x.png'; ?>" alt="">
                                <?php echo $s_lexique_add;?>
                            
                            </a>
                            
                        </div>
                        
                    </div>
                    
                </div><!-- /.contenu -->

            </div>
                
        <div class="clear"></div>