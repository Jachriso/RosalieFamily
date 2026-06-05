<?php
header('Content-type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header("Cache-Control: max-age=3600, no-cache, no-store, must-revalidate, private"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("X-XSS-Protection: 1; mode=block"); 
header("strict-transport-security: max-age=600");
header("Set-Cookie: name=value;  domain=" . $_SERVER['SERVER_NAME'] . "; httpOnly" );
header('X-Frame-Options: SAMEORIGIN');
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html xmlns="http://www.w3.org/1999/xhtml" class="ie6 oldbrowser" lang="<?php echo $starter->s_lang; ?>" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 7]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie7 oldbrowser" lang="<?php echo $starter->s_lang; ?>" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if IE 8]>    <html xmlns="http://www.w3.org/1999/xhtml" class="ie8 oldbrowser" lang="<?php echo $starter->s_lang; ?>" xmlns:fb="http://ogp.me/ns/fb#"> <![endif]-->
<!--[if gt IE 8]><!--> <html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $starter->s_lang; ?>" > <!--<![endif]-->

    <head>  

        <base href="<?php echo $starter->HTTP_ROOT; ?>" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="width=device-width, user-scalable=no">

        <meta name="title" content="<?php echo $starter->meta['title']; ?>" />

        <meta name="description" content="<?php echo $starter->meta['description']; ?>" />

		<title><?php echo $starter->meta['title']; ?></title>

        <meta name="robots" content="noindex" />
        
        <meta name="googlebot" content="noindex">

        

        <link rel="apple-touch-icon" sizes="57x57" href="/content/static/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/content/static/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/content/static/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/content/static/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/content/static/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/content/static/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/content/static/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/content/static/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/content/static/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/content/static/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/content/static/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/content/static/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/content/static/favicon-16x16.png">
        <link rel="manifest" href="/content/static/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/content/static/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <link rel="shortcut icon" href="content/static/favicon.ico" type="image/x-icon" />
	
<?php foreach($starter->a_css as $key => $val){ ?>
        
        <link rel="<?php echo $val['rel']; ?>" href="<?php echo $val['href']; ?>" media="<?php echo $val['media']; ?>" />
<?php }  ?>


    </head>
    
    <body>
