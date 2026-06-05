<?php
header('Content-type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header("Cache-Control: max-age=3600, no-cache, no-store, must-revalidate, private"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("X-XSS-Protection: 1"); 
header("strict-transport-security: max-age=600");
header("Set-Cookie: name=value; httpOnly" );
header('X-Frame-Options: SAMEORIGIN');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $starter->_get_lexique('Gestion des droits',1);?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>!locked/css/reset.css" media="all" />
    <link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>templates/<?php echo $starter->s_template;?>/modules/admin/!locked/css/main.css" media="all" />
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>templates/<?php echo $starter->s_template;?>/modules/plugins/special/<?php echo $s_form_plugin;?>/css/main.css" media="all" />

<script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT;?>!locked/lib/jquery/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT;?>templates/<?php echo $starter->s_template;?>/modules/plugins/special/<?php echo $s_form_plugin;?>/js/main.js"></script>

<?php
$icompt=1; 
if($insert){?>
<script language="javascript" type="text/javascript">
    parent.setField('<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$s_form_field]['champ'];?>','<?php echo $s_items; ?>');
</script>
<?php } ?>
</head>

<body>

    <div id="form_div">
        
        <form name="rules_form" id="rules_form" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
        
            <!--<h1><?php echo $starter->_get_lexique('Gestion des droits');?></h1>-->

            <div class="addon_detail">
            
                <div class="addon_list">
                
                    <div class="addon_element">
        
                        <div class="back_group">
                        
                            <div class="back_list">
<?php if($starter->utils->is__countable($a_data) && count($a_data) > 1){?>                
                                <div class="back_element">
            
                                    <h1><?php echo $starter->_get_lexique('Gestion des droits des chartes',1);?></h1>
                        
                                    <ul id="auth_charte">
                                        <!--<li>
                                        
                                            <input autocomplete="OFF"  type="checkbox" id="rulec_0" name="rules_chartesId[]" value="0" />
                                            
                                            <span><?php //echo $aLocales['backoffice']['select_all']['label'];?></span>
                                            
                                        </li>-->
<?php 
    foreach($a_data as $key => $val){
        if(!is_array($val))
            $val = (array)$val;
        ?>  
                                        <li class="bk_<?php echo $icompt;?>">
                                            
                                            <label class="nav-element">
                                            
                                                <input autocomplete="OFF"  type="checkbox" id="rulec_<?php echo $val['tree_id'];?>" name="rules_chartesId[]" value="<?php echo $val['tree_id'];?>" <?php if(isset($a_items->rules_chartesId)) {if(!empty($s_action) && ($s_action == "edit" && in_array($val['tree_id'],$a_items->rules_chartesId)) || ($s_action == "add" && in_array($val['tree_id'],$a_items->rules_chartesId))){echo 'checked="checked"';}}?>/>
                                                
                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">
                                                                    
                                                <span><?php echo $val['tree_label'];?></span>
                                                
                                            </label>
                               
                                        </li>
<?php 
        $icompt = ($icompt==1?0:1);
    
}?>
                                    </ul>
                                    
                                </div>
<?php }
if($starter->utils->is__countable($a_group) && count($a_group) > 1){?>                
                                <div class="back_element">
            
                                    <h1><?php echo $starter->_get_lexique('Gestion des droits des groupes',1);?></h1>
                        
                                    <ul id="auth_group">
                                        <!--<li>
                                        
                                            <input autocomplete="OFF"  type="checkbox" id="rulec_0" name="rules_chartesId[]" value="0" />
                                            
                                            <span><?php //echo $aLocales['backoffice']['select_all']['label'];?></span>
                                            
                                        </li>-->
<?php 
    foreach($a_group as $key => $val){?>  
                                        <li class="bk_<?php echo $icompt;?>">
                                            
                                            <label class="nav-element">
                                            
                                                <input autocomplete="OFF"  type="checkbox" id="ruleg_<?php echo $val['group_id'];?>" name="rules_groupId[]" value="<?php echo $val['group_id'];?>" <?php 
                                                if(isset($a_items->rules_groupId)){
                                                if(!empty($s_action) && (($s_action == "edit" && in_array($val['group_id'],$a_items->rules_groupId)) || ($s_action == "add" ) && in_array($val['group_id'],$a_items->rules_groupId))){echo 'checked="checked"';}}?>/>
                                                
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">
                    
                                                <span><?php echo $val['group_name'];?></span>
                                                
                                            </label>
                               
                                        </li>
<?php 
        $icompt = ($icompt==1?0:1);
    }?>
                                    </ul>
                                    
                                </div>sssssssssssssssssssssssssssss
<?php }
if($starter->utils->is__countable($a_tree) && count($a_tree) > 0){?> 
                                <div class="back_element">
                        
                                    <h1><?php echo $starter->_get_lexique("Gestion de l'arborescence",1);?></h1>
                                    
                                    <ul id="auth_tree">
<?php  
    foreach($a_tree as $key => $val){?>  
                                        <li class="bk_0">
                                            
                                            <label class="nav-element"> 
<?php 
        if(isset($val['children']) && $starter->utils->is__countable($val['children']) && count($val['children'])>0){?>
                                                <span class="open-close"></span>
<?php 
        }?>
                                                <input autocomplete="OFF"  type="checkbox" id="rulet_<?php echo $val['tree_id'];?>" name="rules_treeId[]" value="<?php echo $val['tree_id'];?>" <?php if(isset($a_items->rules_treeId)){if(!empty($s_action) && (($s_action == "edit"  && in_array($val['tree_id'],$a_items->rules_treeId)) || ($s_action == "add" ) && in_array($val['tree_id'],$a_items->rules_treeId))){echo 'checked';}}?> />
                                                
                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">                    
                                                <span class="title"><?php echo $val['tree_label'];?></span>
                                                
                                            </label>
<?php 
        if(isset($val['children']) && $starter->utils->is__countable($val['children']) && count($val['children'])>0){?>
                                            <ul>
<?php 
            foreach($val['children'] as $children => $value){?>
                                                <li class="bk_1">
                                                
                                                    <label class="nav-element">
<?php 
                if(isset($value['children']) && $starter->utils->is__countable($value['children']) &&count($value['children'])>0){?>
                                                        <span class="open-close"></span>
<?php 
                }?>
                                                        <input autocomplete="OFF"  type="checkbox" id="rulet_<?php echo $value['tree_id'];?>" name="rules_treeId[]" value="<?php echo $value['tree_id'];?>" <?php if(isset($a_items->rules_treeId)){if(!empty($s_action) && (($s_action == "edit" && in_array($value['tree_id'],$a_items->rules_treeId)) || ($s_action == "add") && in_array($value['tree_id'],$a_items->rules_treeId))){echo 'checked';}}?>/>
                                                        
                                                        <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                        <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">
                                                                                    
                                                        <span><?php echo $value['tree_label'];?></span>
                                                 
                                                     </label>
<?php 
                if(isset($value['children']) && $starter->utils->is__countable($value['children']) && count($value['children'])>0){?>
                                                    <ul>
<?php 
                    foreach($value['children'] as $child => $childval){?>
                                                        <li class="bk_0">
                                             
                                                            <label class="nav-element">
<?php 
                        if(isset($childval['children']) && $starter->utils->is__countable($childval['children']) && count($childval['children'])>0){?>
                                                                <span class="open-close"></span>
<?php 
                        }?>
                                                                 <input autocomplete="OFF"  type="checkbox" id="rulet_<?php echo $childval['tree_id'];?>" name="rules_treeId[]" value="<?php echo $childval['tree_id'];?>" <?php if(isset($a_items->rules_treeId)){if(!empty($s_action) && (($s_action == "edit" && $starter->utils->is__countable($a_items)&& count($a_items)>0 && in_array($childval['tree_id'],$a_items->rules_treeId)) || ($s_action == "add" && $starter->utils->is__countable($a_items)&& count($a_items)>0) && in_array($childval['tree_id'],$a_items->rules_treeId))){echo 'checked';}}?>/>
                                                                 
                                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">       
                                                                 <span><?php echo $childval['tree_label'];?></span>
                                                                 
                                                            </label>
<?php 
                        if(isset($childval['children']) && $starter->utils->is__countable($childval['children'])>0){?>
                                                            <ul>
<?php 
                            foreach($childval['children'] as $item => $element){?>
                                                                <li class="bk_1">
                    
                                                                    <label class="nav-element">
<?php 
                                if(isset($element['children']) && $starter->utils->is__countable($element['children'])>0){?>
                                                                        <span class="open-close"></span>
<?php 
                                }?>

                                                                        <input autocomplete="OFF"  type="checkbox" id="rulet_<?php echo $element['tree_id'];?>" name="rules_treeId[]" value="<?php echo $element['tree_id'];?>" <?php if(isset($a_items->rules_treeId)){ if(!empty($s_action) && (($s_action == "edit" && $starter->utils->is__countable($a_items) && count($a_items)>0 && in_array($element['tree_id'],$a_items->rules_treeId)) || ($s_action == "add" && $starter->utils->is__countable($a_items) && count($a_items)>0) && in_array($element['tree_id'],$a_items->rules_treeId))){echo 'checked';}}?>/>
                                                                        
                                                                        <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                                        <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">                
                                                                        <span><?php echo $element['tree_label'];?></span>
                                                                    
                                                                    </label>
<?php 
                                if(isset($element['children']) && $starter->utils->is__countable($element['children'])>0){?>
                                                                    <ul>
<?php 
                                    foreach($element['children'] as $_item => $_element){?>
                                                                        <li class="bk_1">
                            
                                                                            <label class="nav-element">
        
                                                                                <input autocomplete="OFF"  type="checkbox" id="rulet_<?php echo $_element['tree_id'];?>" name="rules_treeId[]" value="<?php echo $_element['tree_id'];?>" <?php if(isset($a_items->rules_treeId)){if(!empty($s_action) && (($s_action == "edit" && $starter->utils->is__countable($a_items) && count($a_items)>0 && in_array($_element['tree_id'],$a_items->rules_treeId)) || ($s_action == "add" && $starter->utils->is__countable($a_items) && count($a_items)>0) && in_array($_element['tree_id'],$a_items->rules_treeId))){echo 'checked';}}?>/>
                                                                                 
                                                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">       
                                                                                <span><?php echo $_element['tree_label'];?></span>
                                                                    
                                                                            </label>
                                                            
                                                                        </li>
<?php 
                                    }?>
                                                                    </ul>                                                                    
<?php 
                                }?>
                                                                </li>
<?php 
                            }?>
                                                            </ul>
<?php 
                        }?>              
                                                        </li>
<?php 
                    }?>
                                                    </ul>
<?php 
                }?>              
                                                </li>
<?php 
            }?>
                                            </ul>
<?php 
        }?>             
                                        </li>
<?php 
    }?>                            
                                    </ul>
                
                                </div>
<?php 
}?>          
                                <div class="back_element">
                            
                                    <h1><?php echo $starter->_get_lexique('Gestion des droits du backoffice',1);?></h1>
                                    
                                    <ul id="auth_backoffice">
                                    
                                        <!--<li>
                                        
                                            <input autocomplete="OFF"  type="checkbox" id="ruleb_0" name="rules_treeId[]" value="0" />
                                            
                                            <span><?php //echo $aLocales['backoffice']['select_all']['label'];?></span>
                                            
                                        </li>-->
<?php 
    foreach($starter->database->configs as $_page){
        foreach($_page['content'] as $_module){

            $_currentConf = array();
            $_tmp_module = $_module['id'];
            if(isset($a_items->rules_backId->$_tmp_module))
                $_currentConf = $a_items->rules_backId;
            if(is_array($_currentConf) && $starter->utils->is__countable($_currentConf) && count($_currentConf) > 0)
                $_currentConf = $_currentConf[$_module['id']];
            elseif(is_object($_currentConf))
                $_currentConf = $_currentConf->$_tmp_module;
                ?>
                                        <li class="group bk_<?php echo $icompt;?>">
                                            
                                            <h2 class="title"><?php echo $_module['name'] . ' : ' ;?></h2>
    <?php
            foreach($_module['content']  as $_config){
                $_tmp_config = $_config['id'];
                if($_module['name'] != $_config['name']){?> 
                        <h3 class="title"><?php echo $_config['name'];?></h3>
    <?php
                }?>
                                            <div class="rule_content nav-element">
                                            
                                                <h4><?php echo $starter->_get_lexique('Fonctionnalités autorisées',1);?> :</h4>
    <?php       if(!empty($_config['actions'])){
                    $iCompt = 1;
                    foreach($_config['actions'] as $_action){?>
                    
                                                <label class="last-element">
                                                   
                                                    <input autocomplete="OFF"  type="checkbox" data-module="<?php echo $_module['id'];?>" data-config="<?php echo $_config['id'];?>" id="ruleb_<?php echo $_module['id'];?>_<?php echo $_config['id'];?>_<?php echo $iCompt;?>" name="rules_backId[<?php echo $_module['id'];?>][<?php echo $_config['id'];?>][]" value="<?php echo $starter->_get_lexique($_action,1);?>" <?php if($s_action == "edit" && ((is_array($_currentConf) && isset($_currentConf[$_config['id']]) && in_array($_action, (array)$_currentConf[$_config['id']])) || (isset($_currentConf->$_tmp_config ) &&  in_array($_action, $_currentConf->$_tmp_config )))){echo 'checked="checked"';}?> />
                        
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">
    
                                                    <span><?php echo $starter->_get_lexique($_action,1);?></span>
                                                    
                                                </label>
    <?php 
                        $iCompt++;
                    }
                }?>
    <?php   
                if(!empty($_config['more_actions'])){
                    foreach($_config['more_actions'] as $_action){?>
                                                <label class="last-element">
                                           
                                                    <input autocomplete="OFF"  type="checkbox" data-module="<?php echo $_module['id'];?>" data-config="<?php echo $_config['id'];?>" id="ruleb_<?php echo $_module['id'];?>_<?php echo $_config['id'];?>_<?php echo $iCompt;?>" name="rules_backId[<?php echo $_module['id'];?>][<?php echo $_config['id'];?>][]" value="<?php echo $starter->_get_lexique($_action,1);?>" <?php if($s_action == "edit" && ((is_array($_currentConf) && isset($_currentConf[$_config['id']]) && in_array($_action, (array)$_currentConf[$_config['id']])) || (isset($_currentConf->$_tmp_config ) &&  in_array($_action, $_currentConf->$_tmp_config )))){echo 'checked="checked"';}?> />
                                                
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">
                                                    <span><?php echo $starter->_get_lexique($_action, 1);?></span>
                                                    
                                                </label>
    <?php 
                        $iCompt++;
                    }
                }?>
                                            </div>
<?php       if($_config['champs'] != 0 && !empty($_config['champs'])){?>
                                            <div class="rule_content nav-element">
                                            
                                                <h4><?php echo $starter->_get_lexique('Champs autorisés', 1);?> :</h4>
    <?php
                foreach($_config['champs'] as $val){
                    if(!isset($val['verif']) || !in_array('mandatory', $val['verif'])){?>
                                                <label class="last-element">
                                                    
                                                    <input autocomplete="OFF"  type="checkbox" data-module="<?php echo $_module['id'];?>" data-config="<?php echo $_config['id'];?>" id="rulebf_<?php echo $_module['id'];?>_<?php echo $_config['id'];?>_<?php echo $val['champ'];?>" name="rules_backId[<?php echo $_module['id'];?>][<?php echo $_config['id'];?>][]" value="<?php echo $val['champ'];?>" 
                                                    <?php if($s_action == "edit" && ((is_array($_currentConf) && isset($_currentConf[$_config['id']]) && in_array($val['champ'], $_currentConf[$_config['id']])) || (isset($_currentConf->$_tmp_config ) && in_array($val['champ'], (array)$_currentConf->$_tmp_config )) || (isset($_currentConf->$_tmp_module[$_tmp_config] ) &&  in_array($val['champ'], (array)$_currentConf->$_tmp_module[$_tmp_config] )))){
                                                        echo 'checked="checked"';
                                                    }?> />
                                                
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">
                                                
                                                    <span><?php echo $val['title'] ;?></span>
                                                    
                                                </label>
    <?php 
                    }
                }?>
                                            </div>
<?php 
            }?>
<?php  
            if(isset($_config['external'][0]['languages'][$starter->i_lang]) && $_config['external'][0]['languages'][$starter->i_lang] != 0 && !empty($_config['external'][0]['languages'][$starter->i_lang])){?>
                                            <div class="rule_content nav-element">
      <?php 
                foreach($_config['external'][0]['languages'][$starter->i_lang] as $val){
                    if(!isset($val['verif']) || !in_array('mandatory', $val['verif'])){?>
                                                <label class="last-element">
                                                    
                                                    <input autocomplete="OFF"  type="checkbox" data-module="<?php echo $_module['id'];?>" data-config="<?php echo $_config['id'];?>" id="rulebf_<?php echo $_module['id'];?>_<?php echo $_config['id'];?>_<?php echo $val['champ'];?>" name="rules_backId[<?php echo $_module['id'];?>][<?php echo $_config['id'];?>][]" value="<?php echo $val['champ'];?>" 
                                                    <?php if($s_action == "edit" && ((is_array($_currentConf) && isset($_currentConf[$_config['id']]) && in_array($val['champ'], $_currentConf[$_config['id']])) || (isset($_currentConf->$_tmp_config ) && in_array($val['champ'], (array)$_currentConf->$_tmp_config )) || (isset($_currentConf->$_tmp_module[$_tmp_config] ) &&  in_array($val['champ'], (array)$_currentConf->$_tmp_module[$_tmp_config] )))){
                                                        echo 'checked="checked"';
                                                    }?> />
                                                
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                    <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">
                                                
                                                    <span><?php echo $val['title'] ;?></span>
                                                    
                                                </label>
<?php 
                    }
                }?>
                                            </div>
<?php 
            }
        }?>
                                        </li>

<?php   
        $icompt = ($icompt==1?0:1);
    }
}?>
                                    </ul>
                                    
                                </div>
                                
                            </div>
                                
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
                
        </form>
           
    </div>

</body>
</html>