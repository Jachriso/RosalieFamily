<script language="javascript" type="text/javascript">
	var oOpenNav = '<?php print_r( implode(', ',$a_open_menu));?>';
</script>

<div id="right-content">
	<div class="content-bloc">
		<div id="top-content">
			<div id="picto_menu">
					<svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="burger"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M2.5,15.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,23.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,7.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
			</div>
			<div id="menu-items">			
				<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=add" >
					<div class="add btn">            			
						<?php echo $starter->_get_lexique('Ajouter',1);?>               
					</div>
			  </a>
			</div>
		</div>
		<div class="final-content">
			<div class="content-col">
				<form name="engine_form" id="engine_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
            		<input type="hidden" name="token" id="token" value="<?php echo $starter->token; ?>" />
					<input autocomplete="off" type="hidden" id="sort" name="sort" value="" />
					<input autocomplete="off" type="hidden" id="isort" name="isort" value="" />
					<input autocomplete="off" type="hidden" id="del" name="del" value="" />
					<input autocomplete="off" type="hidden" id="addon" name="addon" value="<?php echo $s_addon;?>" />
					<input autocomplete="off" type="hidden" id="nav" name="nav" value="<?php echo $s_form_nav;?>" />
					<input autocomplete="off" type="hidden" id="page" name="page" value="<?php echo $s_form_page;?>" />
					<input autocomplete="off" type="hidden" id="module" name="module" value="<?php echo $s_module;?>" />
					<input autocomplete="off" type="hidden" id="iConfig" name="iConfig" value="<?php echo $s_config;?>" />
					<input autocomplete="off" type="hidden" id="sKey" name="sKey" value="<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle'];?>" />
					
					<div class="list-content">
               	<ul class="result-list menu-niv1">
							<?php $i = 0; 
							$iNiv1 = 0;
							$iElement = 0;
							foreach($aData as $key => $val){
								$iNiv1++;
								$iNiv2 = 0;?>
								<li class="list_item <?php echo ($iElement == 0 ? 'first' : '');?>" rel="<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>">
									
									<div class="online">
										<?php	
										if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['online'])){?>

											<input autocomplete="off" type="hidden" id="online-<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" name="online" value="<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" />

											<span id="switch-<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" rel="online" class="switch ico switch-<?php echo (empty($val['online']) ? "0" : $val['online']);?>">
												<span><?php echo $val['online'];?></span>
												<svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="checked"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M12,15.514l2.057,2.057l3.943,-5.142" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/></g></svg>
												<svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="uncheck"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,12l-6,6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,18l-6,-6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/></g></svg>
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
	if((!isset($starter->sortable) || !$starter->sortable) && in_array('sort',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['actions'])){?>
                                                <div class="sort-action">
<?php 
		if($iNiv1!=1){?>
                                                    <a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . 'admin.html?page=' . $s_form_page . '&module=' . $s_module . '&config_id=' . $s_config . '&addon=' . $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'] . '&action=sort&dsort=sort_up&val_id=' . $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">
                                                        
                                                        <img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_up.png" />
                                                            
                                                    </a>
<?php 
		}else{?>
                                                    <span style="display:block;width:18px;height:18px;float:left;"></span>
<?php 
		}
		if($iNiv1 != ($starter->utils->is__countable($aData) ? count($aData) : 0)){?>
                                                    <a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . 'admin.html?page=' . $s_form_page . '&module=' . $s_module . '&config_id=' . $s_config . '&addon=' . $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'] . '&action=sort&dsort=sort_down&val_id=' . $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">
                                                        <img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_down.png" />
                                                            
                                                    </a>
<?php 
		}else{?>
                                                    <span style="display:block;width:18px;height:18px;float:right;"></span>
<?php 
		}?>
                                                </div>
<?php 
	}
	foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'] as $field => $value){
    	if(isset($value['on_list']) && $value['on_list']){
			if($value['type'] == "image"){?>
                                                <div class="item-element" <?php echo (isset($value['list_css']) && !empty($value['list_css']) ? 'style="' . $value['list_css'] . '"' : '');?>>
                                                	
                                                	<a class="fancybox" href="<?php echo $starter->CDN_PATH . $val[$value['champ']];?>">
			                                            <img src="<?php echo $starter->CDN_PATH . $val[$value['champ']];?>" height="30" />
			                                        </a>
                                                
                                                </div>
<?php 
			}elseif($value['type'] != "checkbox"){?>
														<div class="item-element" <?php echo (isset($value['list_css']) && !empty($value['list_css']) ? 'style="' . $value['list_css'] . '"' : '');?>>

															 <span class="item-text"><?php echo $val[$value['champ']];?></span>

														</div>
															<?php 	
															}
														}
													}?>
													
													
													
													<div class="action">
														<a class="more"><svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="more"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><circle cx="15.5" cy="15" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="22" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="8" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg></a>
													
														<?php 

														if(is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions']))
															foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'] as $action){
																if($_SESSION['user_info']['user_statut'] == 0 || (isset($_currentConf[$s_config]) && ((is_array($_currentConf[$s_config]) && in_array($action,$_currentConf[$s_config])) || $action == $_currentConf[$s_config]))){
																	switch($action){
																		default :?>
																		<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																			<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="edit"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																			<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="editHov"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#fff;stroke-width:1px;"/></g><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
																		</a>
																	<?php
																	break;

																	case 'preview' :?>
																		<a target="_blank" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&preview=<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $val['detail_referer'];?>">
																			<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																			<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>

																		</a>
																	<?php
																	break;

																	case 'delete' :?>
																		<a href="javascript:deleteItem('<?php echo $starter->_get_lexique('Etes-vous certains de vouloir supprimer cet élément ?',1);?>','<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>');">
																			<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="delete"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M21.5,10.5l-13,0l0,-1.482l4.643,-1.334l0,-1.184l3.714,0l0,1.184l4.643,1.334l0,1.482Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																			<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" ><g id="deleteHov"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M21.5,10.5l-12.216,-4.446l0.507,-1.393l4.819,0.334l0.405,-1.112l3.49,1.27l-0.405,1.112l3.907,2.843l-0.507,1.392Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
																		</a>
																	<?php
																	break;
																			
																	case 'duplicate' :?>
																		<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																			<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																			<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																		</a>
																	<?php
																	break;
																} 
															}
														}?>                                
													</div>
													
												</div>
												
												
												<?php 
												if(isset($val['children']) && $starter->utils->is__countable($val['children']) && count($val['children']) > 0){?>
													<ul class="menu-niv2 <?php if(in_array($val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']],$a_open_menu)){?>menuOpen<?php }?>">
														<?php	
														foreach($val['children'] as $children => $value){
															$iNiv2++;
															$iNiv3 = 0;?>
															<li class="list_item " rel="<?php echo $value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>">
															
															<div class="online">
																<?php 
																if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['online'])){?>
																	<input autocomplete="off" type="hidden" id="online-<?php echo $value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" name="online" value="<?php echo $value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" />

																	<span id="switch-<?php echo $value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" rel="online" class="switch ico switch-<?php echo (empty($value['online']) ? "0" : $value['online']);?>">
																		<span><?php echo $val['online'];?></span>
																		<svg width="100%"  viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="checked"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M12,15.514l2.057,2.057l3.943,-5.142" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/></g></svg>
																		<svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="uncheck"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,12l-6,6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,18l-6,-6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/></g></svg>
																	</span>
																<?php 		
																}
																?>
															</div>

															<div class="slist-element line">
																<?php 
																if(isset($value['children']) && $starter->utils->is__countable($value['children']) && count($value['children']) > 0){?>
																	<div class="open-close <?php echo (in_array($value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']], $a_open_menu) ? 'open' : '');?>">
																		<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="chevron-dark"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path id="chevron" d="M20,12.643l-5,5l-5,-5" style="fill:none;stroke:#36384a;stroke-width:1px;"/></g></svg>
																	</div>
																<?php 		
																}else{?>
																	<div class="no-child">&nbsp;</div>
																<?php
																}?>
																<?php 
																if((!isset($starter->sortable) || !$starter->sortable) && in_array('sort',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['actions'])){?>
																	<div class="sort-action">
																	<?php 
																	if($iNiv2!=1){?>
																		<a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'];?>&action=sort&dsort=sort_up&val_id=<?php echo $value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">
																			<img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_up.png" />
																		</a>
																	<?php 
																	}else{?>
																		<span style="display:block;width:18px;height:18px;float: left;"></span>
																	<?php 
																	}
																	if($iNiv2 != ($starter->utils->is__countable($val['children']) ? count($val['children']) : 0)){?>
																		<a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'];?>&action=sort&dsort=sort_down&val_id=<?php echo $value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">

																			 <img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_down.png" />

																		</a>
																	<?php 
																	}else{?>
																		<span style="display:block;width:18px;height:18px;float: right;"></span>
																	<?php 
																	}?>
																</div>
															<?php 
															}
															foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'] as $item => $field){
																if(isset($field['on_list']) && $field['on_list']){
																	if($field['type'] == "image"){?>
																		<div class="item-element" <?php echo (isset($field['list_css']) && !empty($field['list_css']) ? 'style="' . $field['list_css'] . '"' : '');?>>

																			<a class="fancybox" href="<?php echo $starter->CDN_PATH . $val[$value['champ']];?>">
									                                            <img src="<?php echo $starter->CDN_PATH . $val[$field['champ']];?>" height="30" />
									                                        </a>
																		</div>
																	<?php 
																	}elseif($field['type'] != "checkbox"){?>
																		<div class="item-element" <?php echo (isset($field['list_css']) && !empty($field['list_css']) ? 'style="' . $field['list_css'] . '"' : '');?>>
																			<span class="item-text"><?php echo $value[$field['champ']];?></span>
																		</div>
																	<?php 	
																	}
																}
															}?>
															
															<div class="action">
																<a class="more">
																	<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="more"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><circle cx="15.5" cy="15" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="22" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="8" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																	</a>
																
																<?php
																if(is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'])){
																	foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'] as $action){
																		if($_SESSION['user_info']['user_statut'] == 0 || (isset($_currentConf[$s_config]) && ((is_array($_currentConf[$s_config]) && in_array($action,$_currentConf[$s_config])) || $action ==$_currentConf[$s_config]))){
																			switch($action){
																				default :?>
																					<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																						<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="edit"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																						<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="edit"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																					</a>
																				<?php
																				break;

																				case 'preview' :?>
																					<a target="_blank" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&preview=<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $val['detail_referer'] .'/' . $value['detail_referer'];?>">
																						<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																						<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																					</a>


																				<?php
																				break;

																				case 'delete' :?>
																					<a href="javascript:deleteItem('<?php echo $starter->_get_lexique('Etes-vous certains de vouloir supprimer cet élément ?',1);?>','<?php echo $value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>');">
																						<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="delete"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M21.5,10.5l-13,0l0,-1.482l4.643,-1.334l0,-1.184l3.714,0l0,1.184l4.643,1.334l0,1.482Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																						<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" ><g id="deleteHov"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M21.5,10.5l-12.216,-4.446l0.507,-1.393l4.819,0.334l0.405,-1.112l3.49,1.27l-0.405,1.112l3.907,2.843l-0.507,1.392Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>

																					</a>
																				<?php
																				break;
																			
																				case 'duplicate' :?>
																					<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																						<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																						<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																					</a>
																				<?php
																				break;
																			} 
																		}
																	}
																}?>                                
															</div>
														</div>
														
														<?php 
														if(isset($value['children']) && $starter->utils->is__countable($value['children']) && count($value['children']) > 0){?>
															 <ul class="menu-niv3 <?php if(in_array($value[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']],$a_open_menu)){?>menuOpen<?php }?>">
															<?php
															foreach($value['children'] as $child => $childval){
																$iNiv3++;
																$iNiv4 = 0;?>
																	<li class="list_item " rel="<?php echo $childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>">

																		<div class="online">
																			<?php 
																			if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['online'])){?>

																				<input autocomplete="off" type="hidden" id="online-<?php echo $childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" name="online" value="<?php echo $childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" />

																				<span id="switch-<?php echo $childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" rel="online" class="switch ico switch-<?php echo (empty($childval['online']) ? "0" : $childval['online']);?>">
																					<span><?php echo $childval['online'];?></span>
																					<svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="checked"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M12,15.514l2.057,2.057l3.943,-5.142" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/></g></svg>
																					<svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="uncheck"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,12l-6,6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,18l-6,-6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/></g></svg>
																				</span>
																			<?php 
																			}?>
																		</div>

																		<div class="sslist-element line">
																			<?php 
																			if(isset($childval['children']) && $starter->utils->is__countable($childval['children']) && count($childval['children']) > 0){?>
																				<div class="open-close <?php echo (in_array($childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']], $a_open_menu) ? 'open' : '');?>">
																					<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="chevron-dark"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path id="chevron" d="M20,12.643l-5,5l-5,-5" style="fill:none;stroke:#36384a;stroke-width:1px;"/></g></svg>
																				</div>
																			<?php 				
																			}else{?>
																				<div class="no-child">&nbsp;</div>
																			<?php
																			}?>
																			<?php 
																			if((!isset($starter->sortable) || !$starter->sortable) && in_array('sort',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['actions'])){?>
																				<div class="sort-action">
																					<?php 
																					if($iNiv3!=1){?>
																						<a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'];?>&action=sort&dsort=sort_up&val_id=<?php echo $childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">

																							<img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_up.png" />

																						</a>
																					<?php 
																					}else{?>
																						<span style="display:block;width:18px;height:18px;float:left;"></span>
																					<?php 
																					}
																					if($iNiv3 != ($starter->utils->is__countable($value['children']) ? count($value['children']) : 0)){?>
																						<a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'];?>&action=sort&dsort=sort_down&val_id=<?php echo $childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">

																							<img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_down.png" />

																						</a>
																					<?php 
																					}else{?>
																						<span style="display:block;width:18px;height:18px;float: left;float:right;"></span>
																					<?php 
																					}?>
																				</div>
																			<?php 
																			}
																			foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'] as $item => $field){
																				if(isset($field['on_list']) && $field['on_list']){
																					if($field['type'] == "image"){?>
																						<div class="item-element" <?php echo (isset($field['list_css']) && !empty($field['list_css']) ? 'style="' . $field['list_css'] . '"' : '');?>>

																							<a class="fancybox" href="<?php echo $starter->CDN_PATH . $childval[$field['champ']];?>">
													                                            <img src="<?php echo $starter->CDN_PATH . $val[$field['champ']];?>" height="30" />
													                                        </a>

																						</div>
																					<?php 
																					}elseif($field['type'] != "checkbox"){?>
																						<div class="item-element" <?php echo (isset($field['list_css']) && !empty($field['list_css']) ? 'style="' . $field['list_css'] . '"' : '');?>>

																							<span class="item-text"><?php echo $childval[$field['champ']];?></span>

																						</div>
																					<?php 	
																					}
																				}
																			}?>
																			
																			<div class="action">
																				<a class="more">
																					<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="more"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><circle cx="15.5" cy="15" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="22" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="8" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																					</a>
	
																				<?php
																				if(is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'])){
																					foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'] as $action){
																						if($_SESSION['user_info']['user_statut'] == 0 || (isset($_currentConf[$s_config]) && in_array($action,$_currentConf[$s_config]))){
																							switch($action){
																								default :?>
																									<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																										<svg class="picto color3" width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="edit"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																										<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="editHov"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#fff;stroke-width:1px;"/></g><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
																									</a>
																								<?php
																								break;

																								case 'preview' :?>
																									<a target="_blank" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&preview=<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $val['detail_referer'] . '/' . $value['detail_referer'] . '/' . $childval['detail_referer'];?>">
																										<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																										<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>

																									</a>
																								<?php
																								break;

																								case 'delete' :?>
																									<a href="javascript:deleteItem('<?php echo $starter->_get_lexique('Etes-vous certains de vouloir supprimer cet élément ?',1);?>','<?php echo $childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>');">
																										<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="delete"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M21.5,10.5l-13,0l0,-1.482l4.643,-1.334l0,-1.184l3.714,0l0,1.184l4.643,1.334l0,1.482Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																										<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" ><g id="deleteHov"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M21.5,10.5l-12.216,-4.446l0.507,-1.393l4.819,0.334l0.405,-1.112l3.49,1.27l-0.405,1.112l3.907,2.843l-0.507,1.392Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
																									</a>
																								<?php
																								break;	
																			
																								case 'duplicate' :?>
																									<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																										<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																										<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																									</a>
																								<?php
																								break;				
																							} 
																						}
																					}
																				}?>                                

																			</div>
																		</div>

																	
<?php 
					if(isset($childval['children']) && $starter->utils->is__countable($childval['children']) && count($childval['children']) > 0){?>
                                                            <ul class="menu-niv4 <?php if(in_array($childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']],$a_open_menu)){?>menuOpen<?php }?>">
<?php					foreach($childval['children'] as $lastchild => $lastchildval){
							$iNiv4++;
							$iNiv5 = 0;?>
                                                                <li class="list_item " rel="<?php echo $lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>">
                                                                	
                                                                	<div class="online">
                                                                		<?php 
																							if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['online'])){?>

																								<input autocomplete="off" type="hidden" id="online-<?php echo $lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" name="online" value="<?php echo $lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" />

																								<span id="switch-<?php echo $lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" rel="online" class="switch ico switch-<?php echo (empty($lastchildval['online']) ? "0" : $lastchildval['online']);?>">

																								<span><?php echo $lastchildval['online'];?></span>
																									<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="checked"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M12,15.514l2.057,2.057l3.943,-5.142" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/></g></svg>
																									<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="uncheck"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,12l-6,6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,18l-6,-6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/></g></svg>



																								</span>
																							<?php 
																							}
																							?>
                                                                	</div>
                                                                   
																					  	<div class="ssslist-element line">
<?php if(isset($lastchildval['children']) && $starter->utils->is__countable($lastchildval['children']) && count($lastchildval['children']) > 0){?>
                                                                <div class="open-close <?php echo (in_array($childval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']], $a_open_menu) ? 'open' : '');?>">
                                                                	<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="chevron-dark"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path id="chevron" d="M20,12.643l-5,5l-5,-5" style="fill:none;stroke:#36384a;stroke-width:1px;"/></g></svg>
                                                                </div>
<?php 				}else{?>
                                                                <div class="no-child">&nbsp;</div>
<?php 				}?>
<?php 
							if((!isset($starter->sortable) || !$starter->sortable) && in_array('sort',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['actions'])){?>
                                                                        <div class="sort-action">
<?php 
								if($iNiv4!=1){?>
                                                                            <a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'];?>&action=sort&dsort=sort_up&val_id=<?php echo $lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">
                                                                            
                                                                                <img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_up.png" />
                                                                                
                                                                            </a>
<?php 
								}else{?>
                                                                            <span style="display:block;width:18px;height:18px;float:left;"></span>
<?php 
								}
								if($iNiv4 != ($starter->utils->is__countable($childval['children']) ? count($childval['children']) : 0 )){?>
                                                                            <a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'];?>&action=sort&dsort=sort_down&val_id=<?php echo $lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">
                                                                        
                                                                                <img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_down.png" />
                                                                                
                                                                            </a>
<?php 
								}else{?>
                                                                            <span style="display:block;width:18px;height:18px;float: left;float:right;"></span>
<?php 
								}?>
                                                                        </div>
<?php 
							}
							foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'] as $item => $field){
								if(isset($field['on_list']) && $field['on_list']){
									if($field['type'] == "image"){?>
                                                                        <div class="item-element" <?php echo (isset($field['list_css']) && !empty($field['list_css']) ? 'style="' . $field['list_css'] . '"' : '');?>>
                                                                        	
                                                                        	<a class="fancybox" href="<?php echo $starter->CDN_PATH . $lastchildval[$field['champ']];?>">
									                                            <img src="<?php echo $starter->CDN_PATH . $val[$field['champ']];?>" height="30" />
									                                        </a>
                                                                        
                                                                        </div>
<?php 
									}elseif($field['type'] != "checkbox"){?>
                                                                        <div class="item-element" <?php echo (isset($field['list_css']) && !empty($field['list_css']) ? 'style="' . $field['list_css'] . '"' : '');?>>
                                        
                                                                            <span class="item-text"><?php echo $lastchildval[$field['champ']];?></span>
                                                                            
                                                                        </div>
																							<?php 	
																							}
																						}
																					}?>

							<div class="action">
                                                       	<a class="more">
                                                       		<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="more"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><circle cx="15.5" cy="15" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="22" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="8" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
                                                       		</a>
																			<?php
																			if(is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'])){
																				foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'] as $action){
																					if($_SESSION['user_info']['user_statut'] == 0 || (isset($_currentConf[$s_config]) && in_array($action,$_currentConf[$s_config]))){
																						switch($action){
																							default :?>
																								<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																									<svg class="picto color3" width="100%"  viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="edit"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																									<svg class="picto color3" width="100%"  viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="edit"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																								</a>
																							<?php
																							break;

																							case 'preview' :?>
                                                                        <a target="_blank" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&preview=<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $val['detail_referer'] . '/' . $value['detail_referer'] . '/' . $childval['detail_referer'] . '/' . $lastchildval['detail_referer'];?>">
                                                                            <svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
                                                                            <svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
                                                                        </a>
																							<?php
																							break;
																							case 'delete' :?>
                                                						<a href="javascript:deleteItem('<?php echo $starter->_get_lexique('Etes-vous certains de vouloir supprimer cet élément ?',1);?>','<?php echo $lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>');">
																				<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="delete"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M21.5,10.5l-13,0l0,-1.482l4.643,-1.334l0,-1.184l3.714,0l0,1.184l4.643,1.334l0,1.482Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																				<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" ><g id="deleteHov"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M21.5,10.5l-12.216,-4.446l0.507,-1.393l4.819,0.334l0.405,-1.112l3.49,1.27l-0.405,1.112l3.907,2.843l-0.507,1.392Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
                                                                            </a>
																							<?php
																							break;						
																			
																							case 'duplicate' :?>
																								<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																									<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																									<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																								</a>
																							<?php
																							break;
																						}
																					}
																				}
																			}?>                                
																		</div>
																	</div>
                                                        
																	  
																		<?php
																		if(isset($lastchildval['children']) && $starter->utils->is__countable($lastchildval['children']) && count($lastchildval['children']) > 0){?>
                                                                    <ul class="menu-niv5 <?php if(in_array($lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']],$a_open_menu)){?>menuOpen<?php }?>">
<?php					foreach($lastchildval['children'] as $_lastchild => $_lastchildval){
							$iNiv5++;?>
                                                                        <li class="list_item " rel="<?php echo $_lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>">
                                                                        
                                                                        	<div class="online">
                                                                        		<?php 
																										if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs']['online'])){?>

																											<input autocomplete="off" type="hidden" id="online-<?php echo $_lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" name="online" value="<?php echo $_lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" />

																											<span id="switch-<?php echo $_lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>" rel="online" class="switch ico switch-<?php echo (empty($_lastchildval['online']) ? "0" : $_lastchildval['online']);?>">
																												<span><?php echo $_lastchildval['online'];?></span>
																												<svg width="100%"  viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="checked"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M12,15.514l2.057,2.057l3.943,-5.142" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/></g></svg>
																												<svg width="100%"  viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="uncheck"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,12l-6,6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,18l-6,-6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/></g></svg>
																											</span>
																										<?php 
																										}?>
                                                                        	</div>
                                                                
                                                                            <div class="sssslist-element line">
<?php 
							if((!isset($starter->sortable) || !$starter->sortable) && in_array('sort',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['actions'])){?>
                                                                                <div class="sort-action">
<?php 
								if($iNiv5!=1){?>
                                                                                    <a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'];?>&action=sort&dsort=sort_up&val_id=<?php echo $_lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">
                                                                                    
                                                                                        <img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_up.png" />
                                                                                        
                                                                                    </a>
<?php 
								}else{?>
                                                                                    <span style="display:block;width:18px;height:18px;float:left;"></span>
<?php 
								}
								if($iNiv5 != ($starter->utils->is__countable($lastchildval['children']) ? count($lastchildval['children']) : 0)){?>
                                                                                    <a href="javascript:sendEndLoadPage('<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo $s_config;?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['addon'];?>&action=sort&dsort=sort_down&val_id=<?php echo $_lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['cle']];?>');">
                                                                                
                                                                                        <img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_down.png" />
                                                                                        
                                                                                    </a>
<?php 
								}else{?>
                                                                                    <span style="display:block;width:18px;height:18px;float: left;float:right;"></span>
<?php 
								}?>
                                                                                </div>
<?php 
							}
							foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][$s_config]['champs'] as $item => $field){
								if(isset($field['on_list']) && $field['on_list']){
									if($field['type'] == "image"){?>
                                                                                <div class="item-element" <?php echo (isset($field['list_css']) && !empty($field['list_css']) ? 'style="' . $field['list_css'] . '"' : '');?>>
                                                                                	                                                                        	
		                                                                        	<a class="fancybox" href="<?php echo $starter->CDN_PATH . $_lastchildval[$field['champ']];?>">
											                                            <img src="<?php echo $starter->CDN_PATH . $val[$field['champ']];?>" height="30" />
											                                        </a>
                                                                                
                                                                                </div>
<?php 
									}elseif($field['type'] != "checkbox"){?>
                                                                                <div class="item-element" <?php echo (isset($field['list_css']) && !empty($field['list_css']) ? 'style="' . $field['list_css'] . '"' : '');?>>
                                                
                                                                                    <span class="item-text"><?php echo $_lastchildval[$field['champ']];?></span>
                                                                                    
                                                                                </div>
<?php 	
									}
								}
							}?>
																			 			<div class="action">
																			 				<a class="more">
																			 					<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="more"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><circle cx="15.5" cy="15" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="22" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="15.5" cy="8" r="2" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>

																			 					</a>
																							<?php
																							if(is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'])){
																								foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'] as $action){
																									if($_SESSION['user_info']['user_statut'] == 0 || (isset($_currentConf[$s_config]) && in_array($action,$_currentConf[$s_config]))){
																										switch($action){
																											default :?>
																												<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $_lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																													<svg class="picto color3" width="100%"  viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="edit"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																													<svg class="picto color3" width="100%"  viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																												</a>
																											<?php
																											break;

																											case 'preview' :?>
																												<a target="_blank" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&preview=<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $val['detail_referer'] . '/' . $value['detail_referer'] . '/' . $childval['detail_referer'] . '/' . $lastchildval['detail_referer'] . '/' . $_lastchildval['detail_referer'];?>">
																													<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																													<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="preview"><path d="M15,9.433c3.135,0 6.256,2.186 8.15,3.818c0.506,0.44 0.797,1.078 0.797,1.749c0,0.671 -0.291,1.309 -0.797,1.749c-1.894,1.632 -5.015,3.818 -8.15,3.818c-3.135,0 -6.256,-2.186 -8.15,-3.818c-0.506,-0.44 -0.797,-1.078 -0.797,-1.749c0,-0.671 0.291,-1.309 0.797,-1.749c1.894,-1.632 5.015,-3.818 8.15,-3.818Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><circle cx="14.972" cy="15" r="2.75" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																												</a>
																											<?php
																											break;

																											case 'delete' :?>
																													<a href="javascript:deleteItem('<?php echo $starter->_get_lexique('Etes-vous certains de vouloir supprimer cet élément ?',1);?>','<?php echo $_lastchildval[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>');">
																				<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="delete"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M21.5,10.5l-13,0l0,-1.482l4.643,-1.334l0,-1.184l3.714,0l0,1.184l4.643,1.334l0,1.482Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																				<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" ><g id="deleteHov"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M21.5,10.5l-12.216,-4.446l0.507,-1.393l4.819,0.334l0.405,-1.112l3.49,1.27l-0.405,1.112l3.907,2.843l-0.507,1.392Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
																													</a>
																												<?php
																												break;
																			
																												case 'duplicate' :?>
																													<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
																														<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																														<svg class="picto color3" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="duplicate"><path d="M17.5,10.5l0,-4l-10,0l0,13l5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M22.5,23.5l0,-13l-10,0l0,13l10,0Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,14.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,16.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15.5,18.5l4,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,10.5l2.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,12.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M10.5,14.5l1.5,0" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
																													</a>
																												<?php
																												break;
																											?>
																											<?php		
																											}
																										} 
																									}
																								}?>    
																							</div>
																				 			</div>
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
							$i = ($i==1?0:1);
							$iElement ++;
							}?>
						</ul> 
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
