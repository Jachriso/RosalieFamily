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
	<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>!locked/lib/bootstrap/css/bootstrap.min.css" media="all" />
    <link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>templates/<?php echo $starter->s_template;?>/modules/admin/!locked/css/main.css" media="all" />
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>templates/<?php echo $starter->s_template;?>/modules/plugins/special/<?php echo $s_form_plugin;?>/css/main.css" media="all" />

<script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT;?>!locked/lib/jquery/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT;?>!locked/lib/bootstrap/js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT;?>templates/<?php echo $starter->s_template;?>/modules/plugins/special/<?php echo $s_form_plugin;?>/js/main.js"></script>
<script language="javascript" type="text/javascript">
	var oItemDownloads = '<?php echo (isset($a_items->downloadsId) ? print_r( implode(',',$a_items->downloadsId)) : '');?>';
</script>
</head>

<body>
	<div class="pluginContainer">
		<div class="closebtn">
			<img src="<?php echo $starter->MEDIA_PATH;?>interface/close.svg" alt="">
		</div>
		<form name="download_form" id="download_form" action="<?php echo $starter->HTTP_DOMAIN . $_SERVER['REQUEST_URI'];?>" method="post">
			<input type="hidden" value='<?php if(isset($_GET['data'])){echo $_GET['data'];}?>' id="data" name="data" />
			<div class="row">
				<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
					<div class="row pad30 fullListing">
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
							<div >
								<h1><?php echo $starter->_get_lexique('Sélectionner des fichiers');?></h1>
								<span><?php echo $starter->_get_lexique('Ajouter ou supprimer des téléchargements associés');?></span>
							</div>
						</div>
						<div class="col-xl-2 col-lg-4 col-md-4 col-sm-12">
							<div class="pad30">
								<span class="inputsearch">
									<input type="text" placeholder="<?php echo $starter->_get_lexique('Recherche');?>" value="<?php echo $s_search;?>" name="search_download" id="search_download">
								</span>
							</div>
						</div>
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">						
							<div class="pad30">
								<button class="<?php echo (!empty($s_download_name) ? 'active': '');?>" type="button" onclick="javascript:pagination('<?php echo $starter->HTTP_ROOT;?>plugins/select_media_downloads.html?page=<?php echo $_GET['page'];?>&module=<?php echo $_GET['module'];?>&config=<?php echo $_GET['config'];?>&config_id=<?php echo $_GET['config_id'];?>&lang=<?php echo $_GET['lang'];?>&ilang=<?php echo $_GET['ilang'];?>&field=<?php echo $_GET['field'];?>&action=<?php echo $_GET['action'];?>&download_name=<?php echo  $s_download_name_sort;?>');">
				                    <?php echo $starter->_get_lexique('alphabétique',0);?><span class="ico2-sort-<?php echo ($s_download_name_sort == 'DESC' ? 'ASC' : 'DESC') ;?>"></span>
				                </button>
							</div>
						</div>
<?php 
if(count($a_data_full ) > 0)
	foreach($a_data_full as $key => $val){?>
						<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
							<div class="listcontainer <?php echo $val['download_id'];?> <?php echo (count((array)$a_items)>0 && in_array($val['download_id'], $a_items->downloadsId) ? 'active' : '' )?>" data-id="<?php echo $val['download_id'];?>">
								<div class="eltinteract">
									<div class="thumbcontainer">
									    <div class="thumb centerVH">
									    	<img src="<?php echo $starter->CDN_PATH . 'mcith/mcith_' . $val['download_thumb'];?>" alt="">
										</div>
									    <div class="square-img"></div>
									</div>
									<div class="listingTxt">
										<span><?php echo $val['download_label'];?></span>
									</div>
								</div>
								<div class="deleteButton">
									<a href="javascript:deleteItem('Etes-vous certains de vouloir supprimer cet élément ?','3');">
										<img src="<?php echo $starter->MEDIA_PATH;?>interface/delete.svg" alt="">
									</a>
								</div>
							</div>
						</div>
<?php 	
	}
?>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 fullH">
					<div class="pad30 rightContent">
						<div class="listingTitle">
							<span><?php echo $starter->_get_lexique('Fichier(s) sélectionné(s)');?></span>
						</div>
						<div class="fileListing">
						<?php 
foreach($a_data as $key => $val){?>
							<div class="listcontainer <?php echo $val['download_id'];?> <?php echo (count((array)$a_items)>0 && in_array($val['download_id'], $a_items->downloadsId) ? 'active' : '' )?>" data-id="<?php echo $val['download_id'];?>">
								<div class="eltinteract">
									<div class="thumbcontainer ">
									    <div class="thumb centerVH">
									    	<img src="<?php echo $starter->CDN_PATH . 'mcith/mcith_' . $val['download_thumb'];?>" alt="">
										</div>
									    <div class="square-img"></div>
									</div>
									<div class="listingTxt">
										<span><?php echo $val['download_label'];?></span>
									</div>
								</div>
								<div class="deleteButton">
									<a href="javascript:deleteItem('Etes-vous certains de vouloir supprimer cet élément ?','3');">
										<img src="<?php echo $starter->MEDIA_PATH;?>interface/delete.svg" alt="">
									</a>
								</div>
							</div>
<?php }?>
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="bottomSidebar">
			<div class="row">
				<div class="col-xl-9 col-lg-9 col-md-8 col-sm-12">
					<div class="toolbarcontainer pad30">
						<span class="compteur" data-info="<?php echo $iCompt;?>"><?php echo $iCompt;?></span>
						<span>&nbsp;<?php echo $starter->_get_lexique('fichier(s) sélectionné(s)');?></span>
					</div>
				</div>
				<div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
					<div class="actions pad20">
						<a href="javascript:void(0);" class="btn error" id="cencelBTN"><?php echo $starter->_get_lexique('Annuler');?></a>
						<a href="javascript:void(0);" class="btn valid" id="saveForm"><?php echo $starter->_get_lexique('Sélectionner');?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>