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
    <title><?php echo $starter->_get_lexique('Upload de fichier', '1');?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>css/reset.css" media="all" />
    <link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>css/main.css" media="all" />
    <link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>css/back_main.css" media="all" />
    <script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT;?>lib/jquery/js/jquery.js"></script>
    <script language="javascript" src="<?php echo $starter->HTTP_ROOT;?>lib/fancybox/js/jquery.fancybox.js?v=2.1.5.js" type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT;?>js/main.js"></script>
    <script language="javascript" type="text/javascript" src="/templates/<?php echo $starter->s_template ;?>/modules/admin/!locked/js//admin/js/main.js'></script>

<?php if(isset($_FILES['file_uploaded']) && !$b_error){?>
    <script language="javascript" type="text/javascript">
        parent.setField('<?php echo $a_data['champ'];?>','<?php echo $s_filename ?>');
<?php if(isset($a_data['file_name'])){
		$_name = explode('.',$_FILES['file_uploaded']['name']);?>
        parent.setField('<?php echo $a_data['file_name'];?>','<?php echo $starter->utils->xtTraiter($_name[0]) . '.' . $_name[1]; ?>');
<?php }?>		
		parent.$.fancybox.close();     
        parent.fancyboxClose();   
    </script>
<?php } 
?>
</head>

<body>

    <div id="form_div">
    
        <h1><?php echo $starter->_get_lexique('Upload de fichier', '1');?></h1>
<?php if($b_error){?>
        <div><?php echo $s_error;?></div>
<?php }?>	
    
        <form name="upload_form" id="upload_form" action="?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&lang=<?php echo $starter->s_lang;?>&ilang=<?php echo $starter->i_lang;?>&field=<?php echo $s_form_field;?>" method="post" enctype="multipart/form-data">
       
            <input autocomplete="off" type="file" name="file_uploaded" id="file_uploaded" value="<?php echo (isset($_POST['file_uploaded']) && !empty($_POST['file_uploaded']) ? $_POST['file_uploaded'] : '' ); ?>" <?php if(isset($a_data['allowedFileTypes'])){?>accept="<?php echo implode(',',$a_data['allowedFileTypes']);?>"<?php }?>/>
            
            <div class="addon-info">
<?php if($b_error){?>
                <span class="error-info"><?php echo $s_error;?><br /></span><br />
<?php }?>
                <span class="info">
				
				    <?php echo $starter->_get_lexique('maxfilesize : ') . (isset($a_data['maxfilesize']) ? $starter->utils->displayBytesLabel($a_data['maxfilesize']) : $starter->utils->displayBytesLabel(1024000));?><br />
                
                </span>
            
                <span class="info">
				
				    <?php echo $starter->_get_lexique('extensions autorisées : ') . (isset($a_data['allowedFileExtensions']) ? $a_data['allowedFileExtensions'] : "jpeg,jpg,gif,png,zip");?>
                
                </span>
    
            </div>
    
            <div class="small-button">

                <a onclick="document.forms['upload_form'].submit()" href="javascript:void(0);"><?php echo $starter->_get_lexique('Valider');?></a>
                
            </div> 
            
        </form>
            
        <div class="clear"></div>
        
    </div>

</body>
</html>
