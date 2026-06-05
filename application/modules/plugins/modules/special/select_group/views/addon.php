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
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT . "templates/" . $starter->s_template;?>/modules/admin/!locked/css/main.css" media="all" />
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT. "templates/" . $starter->s_template;?>/modules/plugins/special/<?php echo $s_form_plugin;?>/css/main.css" media="all" />

<script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT;?>!locked/lib/jquery/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT;?>templates/<?php echo $starter->s_template;?>/modules/plugins/special/<?php echo $s_form_plugin;?>/js/main.js"></script>
<script language="javascript" type="text/javascript">
        var oItemDownloads = '';

        //var oItemDownloads = '<?php isset($a_items->addonsId) ? print_r( implode(', ',$a_items->addonsId)) : '';?>';
</script>
<?php
$icompt=1; 
if($insert){?>
<script language="javascript" type="text/javascript">
    parent.setField('<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'][$s_form_field]['champ'];?>','<?php echo $s_items; ?>');
    parent.fancyboxClose();
    parent.$.fancybox.close();
</script>
<?php } ?>
</head>

<body>

    <div id="form_div">
        
        <form name="rules_form" id="rules_form" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post">
            <input autocomplete="OFF"  type="hidden" value="" id="data" name="data" />

            <div class="addon_detail">
            
                <div class="addon_list">
                
                    <div class="addon_element">
        
                        <div class="back_group">
                        
                            <div class="back_list">
<?php if($starter->utils->is__countable($a_data) && count($a_data) > 1){?>                
                                <div class="back_element">
                        
                                    <ul>
<?php
    foreach($a_data as $key => $val){?>  
                                        <li class="item_downloads bk_<?php echo $icompt;?>">
                                            
                                            <label class="nav-element">

                                                <input autocomplete="OFF"  type="checkbox" id="download_<?php echo $val['group_id'];?>" name="addonsId[]" value="<?php echo $val['group_id'];?>" <?php echo ($starter->utils->is__countable($_a_items) && count($_a_items) > 0 && in_array($val['group_id'], $a_items->addonsId) ? 'checked="checked"' : '' )?>/>
                                                
                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>checked.svg" alt="">
                                                <img class="picto" src="<?php echo $starter->ASSETS_PATH?>uncheck.svg" alt="">
                                                                    
                                                <span><?php echo $val['group_name'];?></span>
                                                
                                            </label>
                               
                                        </li>
<?php 
        $icompt = ($icompt==1?0:1);
    }?>
                                    </ul>
                                    
                                </div>
<?php 
}?>          
                            </div>
             
                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
                
        </form>
           
    </div>

</body>
</html>