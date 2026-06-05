<div id="right-content">

	<!--Top menu-->
	<div class="content-bloc">
		<form name="engine_form" id="engine_form" action="<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/admin.html?' . $base_order_link;?>" method="GET" enctype="multipart/form-data">
            <input type="hidden" name="token" id="token" value="<?php echo $starter->token; ?>" />
			<input autocomplete="off" type="hidden" id="page" name="page" value="<?php echo $s_form_page;?>" />
			<input autocomplete="off" type="hidden" id="module" name="module" value="<?php echo $s_module;?>" />
			<input autocomplete="off" type="hidden" id="config_id" name="config_id" value="<?php echo $s_config;?>" />
			<input autocomplete="off" type="hidden" id="addon" name="addon" value="<?php echo $s_addon;?>" />
			<input autocomplete="off" type="hidden" id="action" name="action" value="<?php echo $s_action;?>" />
			<input autocomplete="off" type="hidden" id="iConfig" name="iConfig" value="<?php echo $s_config;?>" />

			<input autocomplete="off" type="hidden" id="sKey" name="sKey" value="<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle'];?>" />
			<input autocomplete="off" type="hidden" id="search" name="search" value="<?php echo (isset($s_search) ? '&search=' . $s_search : '');?>" />
			<input autocomplete="off" type="hidden" id="del" name="del" value="" />
			<input autocomplete="off" type="hidden" id="isort" name="isort" value="" />
			<input autocomplete="off" type="hidden" id="sort" name="sort" value="" />
			<div id="top-content">
<?php if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['optim_search']) && !empty($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['optim_search'])){?>
				<div class="filter-bar <?php echo isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['optim_search']) ? 'open' : ''?>">
					<span><?php echo $starter->_get_lexique('Filtrer par'); ?> : </span>
<?php $iCompt = 0;	
	foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['optim_search'] as $key => $val){
		if($_SESSION['user_info']['user_statut'] == 0 || ((is_array($_currentConf) && isset($_currentConf[$s_config]) && ((is_array($_currentConf[$s_config]) && !in_array($val['champ'],$_currentConf[$s_config])) || ($val['champ'] != $_currentConf[$s_config] && !is_array($_currentConf[$s_config])))) || (is_object($_currentConf) && isset($_currentConf->$s_config) && ((is_array($_currentConf->$s_config) && !in_array($val['champ'],$_currentConf->$s_config)) || ($val['champ'] != $_currentConf->$s_config && !is_array($_currentConf->$s_config)))))){?>
					<div class="search_tri_content">
						<input autocomplete="off" id="<?php echo $val['champ'];?>" type="hidden" value="<?php echo (isset($_GET[$val['champ']]) ? htmlentities($_GET[$val['champ']]) : '');?>" name="<?php echo $val['champ'];?>" />  
<?php
		if($val['type'] == 'radio'){?>
							<dl class="dropy">
								<dt class="dropy__title">
									<span><?php echo $val['title']; ?></span>
								</dt>
								<dd class="dropy__content">
									<ul>
										<li>
											<a class="dropy__header " onclick="sendFormSearch('<?php echo $val['champ'];?>','');"><?php echo $val['title']; ?></a>
										</li>
										<?php
										foreach($val['data'] as $item => $value){?>					 
											<li>
												<a onclick="sendFormSearch('<?php echo $val['champ'];?>',<?php echo $item;?>);" <?php echo (isset($_GET['optim_' . $val['champ']]) && $_GET['optim_' . $val['champ']] == $item ? 'class="selected"' : (isset($_GET[$val['champ']]) && $_GET[$val['champ']] == $item ? 'class="selected"' : ''));?>>
													<?php echo $value;?>
												</a>
											</li>
										
										<?php 
										}?>
									</ul>
								</dd>
							</dl>
			<!--<span><?php echo $val['title']; ?> : </span>
<?php			
			foreach($val['data'] as $item => $value){?>
						<button type="button" class="search-field<?php echo (!$item ? ' first-field' : '');?>" onclick="sendFormSearch('<?php echo $val['champ'];?>',<?php echo $item;?>);"><?php echo $value;?></button>
<?php 
			}?>
							-->
		<?php
		}
		elseif($val['type'] == 'field_list'){?>
						<dl class="dropy">
							<dt class="dropy__title">
								<span><?php echo isset($_GET[$val['champ']]) && isset($val['data'][$_GET[$val['champ']]]) ? $val['data'][$_GET[$val['champ']]] : $starter->_get_lexique($val['title'],1);
										?></span>
							</dt>
							<dd class="dropy__content">
								<ul>
									<li>
										<a class="dropy__header " onclick="sendFormSearch('<?php echo $val['champ'];?>','');"><?php echo $starter->_get_lexique($val['title'],1);?></a>
									</li>
<?php 
			foreach($val['data'] as $item => $value){?> 
									<li><a <?php echo (isset($_GET['optim_' . $val['champ']]) && $_GET['optim_' . $val['champ']] == $item ? 'class="selected"' : (isset($_GET[$val['champ']]) && $_GET[$val['champ']] == $item ? 'class="selected"' : ''));?> onclick="sendFormSearch('<?php echo $val['champ'];?>',<?php echo $item;?>);"><?php echo $value;?></a></li>
<?php 
			} ?>
								</ul>
							</dd>
							<input autocomplete="off" type="hidden" name="first"> 
						</dl>
<?php 
		} ?>
					</div>      
<?php	
	}
}?>
				</div>
<?php	
}?>
				<div id="top-bar">
				<div id="picto_menu">
					<svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="burger"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M2.5,15.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,23.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,7.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
				</div>
				<div id="menu-items">					

					<?php if(is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['more_actions']) && in_array('add',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['more_actions']) && ($_SESSION['user_info']['user_statut'] == 0 || ((is_array($_currentConf) && isset($_currentConf[$s_config]) && ((is_array($_currentConf[$s_config]) && in_array('add',$_currentConf[$s_config])) || $_currentConf[$s_config] == "add"))||(!is_array($_currentConf) && isset($_currentConf->$s_config) && ((is_array($_currentConf->$s_config) && in_array('add',$_currentConf->$s_config)) ))))){?>
					
						<!--Add button-->
						<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=add">

							<div class="add btn">
								<?php echo $starter->_get_lexique('Ajouter',1);?>
							</div>
						</a>
						
						<!--Search button-->
						<div class="search-button">
							<a href="javascript:void(0);" onclick="sendFormSearch();">
								<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="search"><g><circle cx="14" cy="14" r="5" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g><path d="M22,22l-4,-4" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
							</a>

						  <input autocomplete="off" class="search underline" type="text" placeholder="<?php echo $starter->_get_lexique('recherche',1);?>" id="search" name="search" value="<?php echo $s_search?>">
						</div>
					<?php 
					}
					if(isset($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['optim_search']) && !empty($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['optim_search']) && $starter->utils->is__countable($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['optim_search']) && count($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['optim_search']) > 0){?>
						<div id="toggle-filter">
							<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="filters"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M5,15.548l12,0" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M23,15.548l2,0" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M15,22.548l10,0" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M5,22.548l4,0" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><circle cx="20" cy="15.5" r="2.5" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><circle cx="12" cy="22.5" r="2.5" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M13,8.548l12,0" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M5,8.548l2,0" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><circle cx="10" cy="8.5" r="2.5" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/></g></svg>
							<span><?php echo $starter->_get_lexique('filtres'); ?></span>
						</div>

					
					<?php } ?>
				</div>
				<!--Filters-->
				<?php
				if(is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['more_actions']) && in_array('search',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['more_actions']) && ($_SESSION['user_info']['user_statut'] == 0 || (is_array($_currentConf) && isset($_currentConf[$s_config]) && ((is_array($_currentConf[$s_config]) && in_array('search',$_currentConf[$s_config])) || $_currentConf[$s_config] == "search")) || (!is_array($_currentConf) && isset($_currentConf->$s_config) && ((is_array($_currentConf->$s_config) && in_array('search',$_currentConf->$s_config)) || $_currentConf[$s_config] == "search")))){?>

				<?php 
				}?>
			</div>	
		</div>
	</form>
	<div class="final-content">
		<div class="content-col">
			<div class="clear"></div>
			<div class="list-content">
				<div class="title-list ">
					<span class="principal">Eléments : <?php echo ($starter->utils->is__countable($aData) ? count($aData) : 0) . (isset($i_total) && !empty($i_total) ? '/' . $i_total : '');?></span>
				</div>
				<div class="title-list">
					<?php 
					foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['champs'] as $key => $val){
						if(isset($val['on_list']) && $val['on_list'] && ($_SESSION['user_info']['user_statut'] == 0 || (is_array($_currentConf) && isset($_currentConf[$s_config]) && ((is_array($_currentConf[$s_config]) && !in_array($val['champ'],$_currentConf[$s_config])) || $val['champ'] != $_currentConf[$s_config] )) || (!is_array($_currentConf) && isset($_currentConf->$s_config) && ((is_array($_currentConf->$s_config) && !in_array($val['champ'],$_currentConf->$s_config)) || $val['champ'] != $_currentConf->$s_config )))){?>
							<div class="item-element <?php if($val['type'] == "checkbox") echo 'check';?>" <?php echo (isset($val['list_css']) && !empty($val['list_css']) ? 'style="' . $val['list_css'] . '"' : '');?>>
								<?php 
								if(!isset($a_config[$s_config]['special_addon']) || $a_config[$s_config]['special_addon'] != "tree"){?>
									<a href="<?php echo $starter->HTTP_ROOT . $starter->s_lang ;?>/admin.html?<?php echo $base_order_link;?>&isort=<?php echo (empty($s_form_isort) ? "DESC" : ($s_form_isort == "ASC" ? "DESC" : "ASC"));?>&sort=<?php echo (!empty($s_form_sort) ? $s_form_sort : ($val['type'] == "field_list" && isset($val['champ_link']) ? $val['champ_link'] : $val['champ'])) . (!empty($s_form_sort) && ((isset($val['champ_link']) && !in_array($val['champ_link'], $_base_order_link_sort)) || !in_array($val['champ'], $_base_order_link_sort)) ? ',' . ($val['type'] == "field_list" && isset($val['champ_link']) ? $val['champ_link'] : $val['champ']) : '');?>">

								<?php }?>
								<?php echo $val['title'];?>
								<span class="ico ico-sort-<?php echo ($s_form_isort == "ASC" && $val['champ'] == $s_form_sort ? "ASC" : "DESC");?>"></span>
								<?php
								if(!isset($a_config[$s_config]['special_addon']) || $a_config[$s_config]['special_addon'] != "tree"){?>
									</a>
								<?php }?>
							</div>
						<?php 
						}
					}?>
					<?php 
					
					if($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['external'] != false)
					foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['external'] as $key)
					{
					    if(isset($key['languages']) && !empty($key['languages']))
					    {
					        foreach($key['languages'] as $element => $languages)
					        {
					            if($starter->i_lang == $element)
					                foreach($languages as $item => $value)
					                {
					                	if(isset($value['on_list']) && $value['on_list']){?>
                                <div class="item-element" <?php echo (isset($value['list_css']) && !empty($value['list_css']) ? 'style="' . $value['list_css'] . '"' : '');?>>

                                    <a href="<?php echo $starter->HTTP_ROOT . $starter->s_lang ;?>/admin.html?<?php echo $base_order_link;?>&isort=<?php echo (empty($s_form_isort) ? "DESC" : ($s_form_isort == "ASC" ? "DESC" : "ASC"));?>&sort=<?php echo (!empty($s_form_sort) ? $s_form_sort : ($value['type'] == "field_list" && isset($value['champ_link']) ? $value['champ_link'] : $item) ) . (!empty($s_form_sort) && ((isset($value['champ_link']) && !in_array($value['champ_link'], $_base_order_link_sort)) || !in_array($item, $_base_order_link_sort)) ? ',' . ($value['type'] == "field_list" && isset($value['champ_link']) ? $value['champ_link'] : $item) : '');?>">

                                        <?php echo $value['title'];?>
                                            
                                        <span class="ico ico-sort-<?php echo ($s_form_isort == "ASC" && $value['champ'] == $s_form_sort ? "ASC" : "DESC");?>"></span>                              
                                    </a>
                                </div>
					<?php           	}
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
				<ul class="result-list" <?php echo (is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['more_actions']) && in_array('sort',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['more_actions']) ? 'id="itemSortable"' : '');?>>

				<?php $i = 0; 
				$iNiv1 = 0;
				foreach($aData as $key => $val){
					if(!is_array($val))
						$val = (array)$val;
					$iNiv1++;?>
					<li class="list_item <?php echo ($key == 0 ? 'first-list-item' : '');?>" rel="<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>"> 
					<?php 
						if((!isset($starter->sortable) || !$starter->sortable) && in_array('sort',$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions']) && ($_SESSION['user_info']['user_statut'] == 0 || (isset($_currentConf[$s_config]) && !in_array('sort',$_currentConf[$s_config])))){?>){?>
							<div class="sort-action">
								<?php 
								if($iNiv1!=1){?>
									<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . 'admin.html?page=' . $s_form_page . '&module=' . $s_module . '&config_id=' . intval($s_config) . '&addon=' . $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'] . '&action=sort&dsort=sort_up&val_id=' . $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
										<img src="<?php echo $starter->MEDIA_PATH;?>interface/sort_up.png" />

									</a>
								<?php 
								}else{?>
									<span style="display:block;width:18px;height:18px;float:left;"></span>
								<?php 
								}
								if($iNiv1 != ($starter->utils->is__countable($aData) ? count($aData) : 0)){?>
									<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . 'admin.html?page=' . $s_form_page . '&module=' . $s_module . '&config_id=' . intval($s_config) . '&addon=' . $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'] . '&action=sort&dsort=sort_down&val_id=' . $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>">
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
						$iComptElt = 0; 
						foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['champs'] as $field => $value){
							if(isset($value['on_list']) && $value['on_list'] && ($_SESSION['user_info']['user_statut'] == 0 || (is_array($_currentConf) && isset($_currentConf[$s_config]) && ((is_array($_currentConf[$s_config]) && !in_array($value['champ'],$_currentConf[$s_config])) || $value['champ'] != $_currentConf[$s_config] )) || (!is_array($_currentConf) && isset($_currentConf->$s_config) && ((is_array($_currentConf->$s_config) && !in_array($value['champ'],$_currentConf->$s_config)) || $value['champ'] != $_currentConf->$s_config )))){?>
								<div class="element-lign <?php if($value['type'] == 'checkbox') echo 'check';?>">
									<div class="responsive-label"><?php echo $value['title'];?></div>			
									<?php if($value['type'] == "checkbox"){?>
										<div class="item-element <?php echo ($iComptElt == 0 ? 'first' : '');?>" >

											<input autocomplete="off" type="hidden" id="<?php echo $value['champ'] . '-' . $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>" name="<?php echo $value['champ'];?>" value="<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>" />
											<span id="switch-<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>" rel="<?php echo $value['champ'];?>" class="switch ico switch-<?php echo (empty($val[$value['champ']]) ? "0" : $val[$value['champ']]);?>">
												<span><?php echo $val[$value['champ']];?></span>
												<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="checked"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/><path d="M12,15.514l2.057,2.057l3.943,-5.142" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/></g></svg>
                                                <svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="uncheck"><circle cx="15" cy="15" r="8" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,12l-6,6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/><path d="M18,18l-6,-6" style="fill:none;stroke:#ff8384;stroke-width:1px;"/></g></svg>
											</span>

										</div>
									<?php 
									}else if($value['type'] == "image" || $value['type'] == "cropper"){?>
										<div class="item-element <?php echo ($iComptElt == 0 ? 'first' : '');?>" >
											<a class="fancybox" href="<?php echo $starter->CDN_PATH . $val[$value['champ']];?>">
												<img src="<?php echo $starter->CDN_PATH . $val[$value['champ']];?>" height="30" />
											</a>
										</div>
									<?php 
									}else{?>
										<div class="item-element <?php echo ($iComptElt == 0 ? 'first' : '');?>" >
											<span class="item-text">&nbsp;<?php echo ($value['type'] == "field_list" && isset($value['champ_link']) ? $val[$value['champ_link']] : ($value['type'] == "field_list" && !isset($value['champ_link']) && isset($value['data']) ? $value['data'][$val[$value['champ']]] : $val[$value['champ']]));?></span>
										</div>
									<?php
									}
									$iComptElt ++;?>
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
							                {
					                			if(isset($value['on_list']) && $value['on_list']){?>
                                <div class="element-lign">
                                    
                                        <div class="responsive-label"><?php echo $value['title'];?></div>

                                        <div class="item-element <?php echo ($iComptElt == 0 ? 'first' : '');?>" >
        
                                            <span class="item-text">&nbsp;<?php echo ($value['type'] == "field_list" && isset($value['champ_link']) ? $val[$value['champ_link']] : ($value['type'] == "field_list" && !isset($value['champ_link']) && isset($value['data']) ? $value['data'][$val[$item]] : $val[$item]));?></span>
                                            
                                        </div>
                                    
                                    </div>

							<?php               	$iComptElt++;
												}
							                }
							        }
							    }
							}?>
							<div class="element-lign action">
								<div class="responsive-label"><?php echo $starter->_get_lexique('Actions',1);?></div>

								<div>

								<?php $i = ($i==1?0:1);
								if(is_array($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions']))
									foreach($starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['actions'] as $action){
										if($_SESSION['user_info']['user_statut'] == 0 || ((is_array($_currentConf) && isset($_currentConf[$s_config]) && ((is_array($_currentConf[$s_config]) && in_array($action,$_currentConf[$s_config])) || $action == $_currentConf[$s_config])) || (!is_array($_currentConf) && isset($_currentConf->$s_config) && ((is_array($_currentConf->$s_config) && in_array($action,$_currentConf->$s_config)) || $action == $_currentConf->$s_config)) )){
											switch($action){
												default :?>
													<a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin.html?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=<?php echo $action;?>&val_id=<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>"><svg class="" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="edit"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
													<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="editHov"><g><path d="M20.245,6.719l-12.374,12.375l3.535,3.535l12.375,-12.374l-3.536,-3.536Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M11.406,22.629l-4.419,0.884l0.884,-4.419" style="fill:none;stroke:#fff;stroke-width:1px;"/></g><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M11.406,19.094l8.594,-8.594" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
													</a>
												<?php
												break;
												case 'delete' :?>
													<a href="javascript:deleteItem('<?php echo $starter->_get_lexique('Etes-vous certains de vouloir supprimer cet élément ?',1);?>','<?php echo $val[$starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['cle']];?>');"><svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="delete"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M21.5,10.5l-13,0l0,-1.482l4.643,-1.334l0,-1.184l3.714,0l0,1.184l4.643,1.334l0,1.482Z" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#9ca1bd;stroke-width:1px;"/></g></svg>
														<svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="deleteHov"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M20.25,10.5l-10.5,0l1.05,13l8.4,0l1.05,-13Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M21.5,10.5l-12.216,-4.446l0.507,-1.393l4.819,0.334l0.405,-1.112l3.49,1.27l-0.405,1.112l3.907,2.843l-0.507,1.392Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M15,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M12.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M17.5,20.5l0,-7" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
													</a>
													<?php
												break;
												?>
												<?php	
												} 
											}
										}?>
									</div>
								</div>
								<div class="clear"></div>
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
				<?php
				}?>
			</div>
		</div>
	</div>