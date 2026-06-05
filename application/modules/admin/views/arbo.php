<div id="right-content">
    <div class="content-bloc">
        <dic id="top-content">
            <div id="picto_menu">
                    <svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="burger"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M2.5,15.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,23.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,7.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
            </div>
            <div id="menu-items">           
                <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=add" >
                    <div class="small_form-submit btn">                     
                        <span><?php echo $starter->_get_lexique('Ajouter',1);?></span>                     
                    </div>
                 </a>
            </div>
        </dic>
        <div class="final-content">
            <div class="content-col">
                <form name="engine_form" id="engine_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
                    <input autocomplete="off" type="hidden" id="sort" name="sort" value="" />
                    <input autocomplete="off" type="hidden" id="isort" name="isort" value="" />
                    <input autocomplete="off" type="hidden" id="del" name="del" value="" />
                    <input autocomplete="off" type="hidden" id="nav" name="nav" value="<?php echo $s_form_nav ;?>" />
                    <input autocomplete="off" type="hidden" id="page" name="page" value="<?php echo $s_form_page;?>" />
                    <input autocomplete="off" type="hidden" id="module" name="module" value="<?php echo $s_module;?>" />
                    <input autocomplete="off" type="hidden" id="iConfig" name="iConfig" value="<?php echo $s_config;?>" />
                    <input autocomplete="off" type="hidden" id="sKey" name="sKey" value="<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle'];?>" />
                    
                    <div class="list-content">

                        <div class="title-list">
<?php 
foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['champs'] as $key => $val){
    if(isset($val['on_list']) && $val['on_list'] && ($_SESSION['user_info']['user_statut'] == 0 || (is_array($_currentConf) && isset($_currentConf[$s_config]) && ((is_array($_currentConf[$s_config]) && !in_array($val['champ'],$_currentConf[$s_config])) || $val['champ'] != $_currentConf[$s_config] )) || (!is_array($_currentConf) && isset($_currentConf->$s_config) && ((is_array($_currentConf->$s_config) && !in_array($val['champ'],$_currentConf->$s_config)) || $val['champ'] != $_currentConf->$s_config )))){?>
                            <div class="item-element <?php if($val['type'] == "checkbox") echo 'check';?> <?php echo (isset($val['priority']) ? 'priority_'.$val['priority'] : '');?>" >
<?php 
        if(!isset($a_config[$s_config]['special_addon']) || $a_config[$s_config]['special_addon'] != "tree"){?>
                                <a href="<?php echo $starter->HTTP_ROOT . $starter->s_lang ;?>/admin.html?page=<?php echo $s_form_page;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $s_addon;?>&module=<?php echo $s_module;?>&action=list&search=<?php echo (!empty($s_search) ? $s_search : '');?>&sort=<?php echo ($val['type'] == "field_list" && isset($val['champ_link']) ? $val['champ_link'] : $val['champ']);?>&isort=<?php echo (empty($s_form_isort) ? "DESC" : ($s_form_isort == "ASC" ? "DESC" : "ASC"));?>">
<?php 
        }?>
                                    <?php echo $val['title'];?>
                                    <span class="ico ico-sort-<?php echo ($s_form_isort == "ASC" && $val['champ'] == $s_form_sort ? "ASC" : "DESC");?>"></span>
<?php
        if(!isset($a_config[$s_config]['special_addon']) || $a_config[$s_config]['special_addon'] != "tree"){?>
                                </a>
<?php  
        }?>
                            </div>
<?php 
    }
}                   
if($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['external'] != false)
    foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['external'] as $key)
    {
        if(isset($key['languages']) && !empty($key['languages']))
        {
            foreach($key['languages'] as $element => $languages)
            {
                if($starter->i_lang == $element)
                    foreach($languages as $item => $value)
                    {?>
                            <div class="item-element <?php echo (isset($value['priority']) ? 'priority_'.$value['priority'] : '');?>" >
                                <a href="<?php echo $starter->HTTP_ROOT . $starter->s_lang ;?>/admin.html?page=<?php echo $s_form_page;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $s_addon;?>&module=<?php echo $s_module;?>&action=list&search=<?php echo (!empty($s_search) ? $s_search : '');?>&sort=<?php echo ($value['type'] == "field_list" && isset($value['champ_link']) ? $value['champ_link'] : $item);?>&isort=<?php echo (empty($s_form_isort) ? "DESC" : ($s_form_isort == "ASC" ? "DESC" : "ASC"));?>">

                                    <?php echo $value['title'];?>
                                            
                                    <span class="ico ico-sort-<?php echo ($s_form_isort == "ASC" && $value['champ'] == $s_form_sort ? "ASC" : "DESC");?>"></span>                              
                                </a>
                            </div>
<?php           
                    }
            }
                        }
        }?>
                            <div class="action">
<?php 
        if(in_array('edit',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions']) || in_array('delete',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'])){?>
                                <span><?php echo $starter->_get_lexique('actions',1);?></span>
<?php 
        }?>
                           </div>
                        </div>
                    


                        <ul class="result-list menu-niv1">
                            
<?php $i = 0; 
$iNiv1 = 0;
foreach($aData as $key => $val){$iNiv1++;?>
                                <li class="list_item bk_<?php echo $i;?>"> 
                                    <div class="online">
                                        <?php   
                                        if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['online']) ){?>

                                            <input autocomplete="off" type="hidden" id="online-<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" name="online" value="<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" />

                                            <span id="switch-<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" rel="online" class="switch ico switch-<?php echo (empty($val['online']) ? "0" : $val['online']);?>">
                                                <span><?php echo $val['online'];?></span>
                                                <svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="checked"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M12,15.514l2.057,2.057l3.943,-5.142" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/></g></svg>
                                                <svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="uncheck"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,12l-6,6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,18l-6,-6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/></g></svg>
                                            </span>
                                        <?php 
                                        }
                                        ?>
                                    </div>
                                
                                    <div class="list-element line">
<?php 
    if(isset($val['children']) && $starter->utils->is__countable($val['children']) && count($val['children']) > 0){?>
                                                <div class="open-close <?php echo (in_array($val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']], $a_open_menu) ? 'open' : '');?>">
                                                    <svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="chevron-dark"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path id="chevron" d="M20,12.643l-5,5l-5,-5" style="fill:none;stroke:#36384a;stroke-width:1px;"/></g></svg>
                                                </div>
<?php 
    }else{?>
                                                <div class="no-child">&nbsp;</div>
<?php   
    }?>
<?php 
	$iComptElt = 0; 
	foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['champs'] as $field => $value){
        if(isset($value['on_list']) && $value['on_list'] && ($_SESSION['user_info']['user_statut'] == 0 || (isset($_currentConf[$s_config]) && !in_array($value['champ'],$_currentConf[$s_config])))){
             if($value['type'] == "image"){?>

                                    <div class="item-element <?php echo ($iComptElt == 0 ? 'first' : '');?> <?php echo (isset($value['priority']) ? 'priority_'.$value['priority'] : '');?>" >
                                        
                                        <a class="fancybox" href="<?php echo $starter->CDN_PATH . $val[$value['champ']];?>">
                                            <img src="<?php echo $starter->CDN_PATH . $val[$value['champ']];?>" height="30" />
                                        </a>
                                    
                                    </div>
<?php 
			}else{?>
                                    <div class="item-element <?php echo ($iComptElt == 0 ? 'first' : '');?> <?php echo (isset($value['priority']) ? 'priority_'.$value['priority'] : '');?>" >
    
                                        <span class="item-text"><?php echo ($value['type'] == "field_list" && isset($value['champ_link']) ? $val[$value['champ_link']] : ($value['type'] == "field_list" && !isset($value['champ_link']) && isset($value['data']) ? $value['data'][$val[$value['champ']]] : $val[$value['champ']]));?></span>
                                        
                                    </div>
<?php
			}
    		$iComptElt ++;
        }
    }?>
                                    <div class="action">
<?php 
$i = ($i==1?0:1);
if(is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions']))
	foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'] as $action){
		if($_SESSION['user_info']['user_statut'] == 0 || (isset($_currentConf[$s_config]) && in_array($action,$_currentConf[$s_config]))){
			switch($action){
				default :?>
                                        <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
                                    
                                            <span class="ico ico-<?php echo $action;?>"><?php echo $action;?></span>
                                            
                                        </a>
<?php
				break;
				case 'delete' :?>
                                        <a href="javascript:deleteItem('<?php echo $starter->_get_lexique('Etes-vous certains de vouloir supprimer cet élément ?',1);?>','<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>');">
                                        
                                            <span class="ico ico-<?php echo $action;?>"><?php echo $action;?></span>
                                            
                                        </a>
<?php
				break;
			?>
<?php	} 
	}
}?>
                                     </div>
                                                                    
                                </li>
<?php 
}?>
                            </ul>
                            
                        </div>
                        
                        <div class="clear"></div>
<?php if(isset($s_pagination_nav)) {?>                  
                        <ul class="pagination" >
                        
						    <?php echo implode('', $s_pagination_nav) ;?>
                            
                        </ul>
                        
                        <div class="clear"></div>
<?php }?>

                    </form>
                    
                </div>
                
            </div>
