<div id="right-content">
	<div class="content-bloc">
		<form name="engine_form" id="engine_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="token" id="token" value="<?php echo $starter->token; ?>" />
			<div id="top-content">
				<div id="picto_menu">
					<svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="burger"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M2.5,15.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,23.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,7.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
				</div>
				<?php if($starter->utils->is__countable($o_conf['external'] && count($o_conf['external']) > 0)){?>
					<ul>
						<li rel="1">
							<h2><?php echo $o_conf['name'];?></h2>
						</li>
						<?php if(isset($o_conf['external']) && $starter->utils->is__countable($o_conf['external']) && count($o_conf['external']) > 0 && is_array($o_conf['external'])){
							$i_special = 2;


								foreach($o_conf['external'] as $element){
									if(isset($element['special'])){?>
										<li rel="<?php echo $i_special;?>">
											<h2><?php echo $element['title'];?></h2>
										</li>
									<?php }
									$i_special++;
								}

						}?>
					</ul>
				<?php } 
				if(!isset($o_conf['mode']) || $o_conf['mode'] != "unique"){?>
				<div id="menu-items">
					<a id="back" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') ;?>admin?page=<?php echo $s_form_page;?>&module=<?php echo $s_module;?>&config_id=<?php echo intval($s_config);?>&addon=<?php echo $starter->database->configs[$s_form_page]['content'][$s_module]['content'][intval($s_config)]['addon'];?>&action=list">
						<svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="chevron"><path id="chevron1" d="M20,12.643l-5,5l-5,-5" style="fill:none;stroke:#b3c1e3;stroke-width:1px;"/></g></svg>
						<span>Retour à la liste</span>
						<span>Retour</span>
					</a>
				</div>
				<?php }?>
				<div class="small_form-submit">
					<a href="javascript:void(0);" onclick="document.forms['engine_form'].submit()" class="btn valid">
						<?php echo $starter->_get_lexique('Enregistrer',1);?>
					</a>
				</div>
			</div>
			<div class="final-content">
				<div class="form_info content-col">
					<div class="obligatory">
						<svg class="picto" width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;"><g id="obligatory"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><g><path d="M16,9.2l0.898,2.764l2.906,0l-2.351,1.708l0.898,2.764l-2.351,-1.708l-2.351,1.708l0.898,-2.764l-2.351,-1.708l2.906,0l0.898,-2.764Z" style="fill:#fff;"/></g></g></svg>
						<span><?php echo $starter->_get_lexique('Champs obligatoires',1);?></span>
					</div> 
<?php if(isset($_SESSION['WARNING'])){?>								
					<div class="<?php echo $_SESSION['WARNING']['type'];?>">
						<svg class="picto" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="error"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><g><path d="M5.287,24.5l10.215,-19l10.215,18.971l-20.43,0.029Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M15.5,17l0.5,-5l-1,0l0.5,5Z" style="fill:#fff;stroke:#fff;stroke-width:1px;"/><circle cx="15.5" cy="20.5" r="1.5" style="fill:#fff;"/></g></g></svg>
						<span><?php echo implode(',',$_SESSION['WARNING']['content']);?></span>
						<svg class="picto close" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="close-wh"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><g id="close"><path d="M10,10l10,10" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M20,10l-10,10" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></g></svg>
					</div>				
				<?php 	}?>	
				</div>
				<input autocomplete="off" type="hidden" name="<?php $o_conf['cle'];?>" value="<?php echo (isset($a_data[$o_conf['cle']]) ? $a_data[$o_conf['cle']] : '');?>" />
				<div class="content-col" rel="1">
					<div class="form_bloc">
						<h1>
							<?php echo $o_conf['name'] . ($s_action == "add" ? ' : ' . $starter->_get_lexique('Ajout',1) : ($s_action == "edit" ? ' : ' . $starter->_get_lexique('Modification',1) : ''));?>
						</h1>
						<div class="bloc_element">
							<ul>
							<?php 
							foreach($o_conf['champs'] as $key => $val){
								if($val['type'] != "hidden" && $val['type'] != "notvisible" && ($_SESSION['user_info']['user_statut'] == 0 || ((is_array($_currentConf) && isset($_currentConf[$s_config]) && in_array($val['champ'],$_currentConf[$s_config])) || (!is_array($_currentConf) && isset($_currentConf->$s_config) && in_array($val['champ'],$_currentConf->$s_config)) || (isset($val['verif']) && in_array('mandatory', $val['verif']))))){?>
									<li class="list_field <?php echo $val['type']; if(isset($val['vtype']) && $val['vtype'] == "inside") echo ' full'?> ">
										<?php  
										include dirname( __FILE__) . '/../../plugins/modules/' . (isset($val['origin']) ? 'special/' : '') . $val['type'] . '/views/index.php' ; ?>
									</li>
								<?php 
								}
							}?>
							</ul>
						</div>
					</div>
					<?php 

					if(isset($o_conf['external']) && $starter->utils->is__countable($o_conf['external']) && count($o_conf['external']) > 0 && is_array($o_conf['external']))
						foreach($o_conf['external'] as $element){
							foreach($element['languages'] as $item => $value){?>
								<div class="form_bloc">
									<h1><?php echo $starter->_get_lexique('Version ',1);?>
									<?php //echo $starter->a_config_lang->$item->lang_ref;?></h1>
									<div class="bloc_element">
										<ul>
											<?php
										foreach($value as $key => $val){
												if($val['type'] != "hidden" && $val['type'] != "notvisible" && ($_SESSION['user_info']['user_statut'] == 0 || ((is_array($_currentConf) && isset($_currentConf[$s_config]) && in_array($val['champ'],$_currentConf[$s_config])) || (!is_array($_currentConf) && isset($_currentConf->$s_config) && in_array($val['champ'],$_currentConf->$s_config)) || (isset($val['verif']) && !in_array('mandatory', $val['verif']))))){?>
												<li class="list_field <?php echo $val['type'];?>">
													<?php  
													if(isset($val['switchtype']) && isset($aData['translation_field']) )
														include dirname( __FILE__) . '/../../plugins/modules/' . (isset($val['origin']) ? 'special/' : '') . $val['switchtype'][$aData['translation_field']] . '/views/index.php' ;
													else
														include dirname( __FILE__) . '/../../plugins/modules/' . (isset($val['origin']) ? 'special/' : '') . $val['type'] . '/views/index.php' ; ?>
												</li>
												<?php 			}
										}?>
										</ul>
									</div>
								</div>
							<?php	
							}
						}
						?>
					</div>
					<?php if(isset($o_conf['special']) && $starter->utils->is__countable($o_conf['special']) && count($o_conf['special']) > 0 && is_array($o_conf['special'])){
						$i_special = 2;
						foreach($o_conf['special'] as $element){
							if(isset($element['special']))?>
								<div class="content-col not-first" rel="<?php echo $i_special;?>">
									<?php foreach($element['special'] as $item => $value){?>
										<h1><?php echo $value['title'];?></h1>
										<ul>
											<?php foreach($value['champs'] as $key => $val){
												if($val['type'] != "hidden"){?>
													<li class="list_field 4">
														<?php  include dirname( __FILE__) . '/../../plugins/modules/' . (isset($val['origin']) ? 'special/' : '') . $val['type'] . '/edit.php' ; ?>
													</li>
												<?php }
											}?>
										</ul>
									<?php }?>
								</div>
								<?php
							$i_special++;
						}
					}?>
			</div>
		</form>
	</div>
</div>