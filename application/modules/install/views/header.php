<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml" class="ie6 oldbrowser" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7 oldbrowser" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 8]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie8 oldbrowser" lang="en" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if gt IE 8]><!--> <html xmlns="http://www.w3.org/1999/xhtml" lang="en" > <!--<![endif]-->

    <head>  

        <base href="<?php echo $starter->HTTP_ROOT; ?>" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="width=device-width, user-scalable=no">

        <meta name="title" content="CMS installation" />

        <meta name="description" content="CMS installation" />

		<title>CMS installation</title>

        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        
        <link rel="icon" type="image/jpg" href="favicon.jpg" />     
	
        <!--[if IE 7]> <link rel="stylesheet" href="css/general/ie7-fix.css" type="text/css" media="screen" /> <![endif]-->
        <!--[if IE 8]> <link rel="stylesheet" href="css/general/ie8-fix.css" type="text/css" media="screen" /> <![endif]-->
<?php foreach($starter->a_css as $key => $val){ ?>
        
        <link rel="<?php echo $val['rel']; ?>" href="<?php echo $val['href']; ?>" media="<?php echo $val['media']; ?>" />
<?php }  ?>


    </head>
    
    <body>
        
        
