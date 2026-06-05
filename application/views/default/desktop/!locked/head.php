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
<?php if(isset($starter->gtm) && !empty($starter->gtm)){?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $starter->gtm;?>');</script>
<!-- End Google Tag Manager -->
<?php }?>
        <base href="<?php echo $starter->HTTP_ROOT; ?>" />
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <title><?php echo $starter->meta['title']; ?></title>
        
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        
        <meta name="title" content="<?php echo $starter->meta['title']; ?>" />

        <meta name="description" content="<?php echo $starter->meta['description']; ?>" />

        <meta name="robots" content="noindex" />
        <meta name="googlebot" content="noindex">

        <meta name="revisit-after" content="2 days" />
        
        <meta property="og:image" content="<?php echo $starter->meta['image']; ?>"/>
        
        <meta property="og:title" content="<?php echo $starter->meta['title']; ?>" />
        
        <meta property="og:description" content="<?php echo $starter->meta['description']; ?>" />

        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $starter->MEDIA_PATH; ?>apple-icon-57x57.png">
        
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $starter->MEDIA_PATH; ?>apple-icon-60x60.png">
        
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $starter->MEDIA_PATH; ?>apple-icon-72x72.png">
        
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $starter->MEDIA_PATH; ?>apple-icon-76x76.png">
        
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $starter->MEDIA_PATH; ?>apple-icon-114x114.png">
        
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $starter->MEDIA_PATH; ?>apple-icon-120x120.png">
        
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $starter->MEDIA_PATH; ?>apple-icon-144x144.png">
        
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $starter->MEDIA_PATH; ?>apple-icon-152x152.png">
        
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $starter->MEDIA_PATH; ?>apple-icon-180x180.png">
        
        <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $starter->MEDIA_PATH; ?>android-icon-192x192.png">
        
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $starter->MEDIA_PATH; ?>favicon-32x32.png">
        
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $starter->MEDIA_PATH; ?>favicon-96x96.png">
        
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $starter->MEDIA_PATH; ?>favicon-16x16.png">
        
        <link rel="shortcut icon" href="<?php echo $starter->MEDIA_PATH; ?>favico.ico" type="image/x-icon" />
                
        <meta name="msapplication-TileColor" content="#ffffff">
        
        <meta name="msapplication-TileImage" content="<?php echo $starter->MEDIA_PATH; ?>ms-icon-144x144.png">
        
        <meta name="theme-color" content="#ffffff">

        <link rel="image_src" href="<?php echo $starter->meta['image']; ?>" />
<?php if(isset($starter->b_minifier) && $starter->b_minifier & isset($_SESSION['rel']) && is_array($_SESSION['rel']) && $starter->utils->is__countable($_SESSION['rel']) && count($_SESSION['rel']) > 0) { ?>
        <link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT  . 'css/css-' . $s_rel_id . '.css'; ?>" media="all" />
<?php } else { ?>
<?php foreach($starter->a_css as $key => $val){ ?>        
        <link rel="<?php echo $val['rel']; ?>" href="<?php echo $val['href']; ?>" media="<?php echo $val['media']; ?>" />
<?php }  
    foreach($starter->a_css_out as $key => $val){ ?>
        <link rel="<?php echo $val['rel']; ?>" href="<?php echo $val['href']; ?>" media="<?php echo $val['media']; ?>" <?php (isset($val['integrity']) ? 'integrity="$val[\'integrity\']"' : '')?> <?php (isset($val['crossorigin']) ? 'crossorigin="$val[\'crossorigin\']"' : '')?>/>
<?php }
}  if(!empty($starter->s_extended_css)) { ?>

        <style type="text/css">
        
            <?php echo $starter->s_extended_css . "\n"; ?>
        
        </style>
<?php } ?>
    </head>
    <body>