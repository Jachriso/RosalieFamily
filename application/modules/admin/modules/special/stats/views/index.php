<div id="right-content">
    <div class="content-bloc">
        <form id="form_stat" name="form_stat" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">                                
            <input autocomplete="off" id="action" name="action" type="hidden" value="">        
            <input autocomplete="off" id="sType" name="sType" type="hidden" value="">
            <div id="top-content">
                <div id="picto_menu">
                    <svg width="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="burger"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M2.5,15.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,23.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,7.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
                </div>
                <div class="small_form-submit">
                </div>
            </div>
            <div class="final-content">
                <div class="form_info content-col">
<?php if(isset($_SESSION['WARNING'])){?>                                
                    <div class="<?php echo $_SESSION['WARNING']['type'];?>">
                        <svg class="picto" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="error"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><g><path d="M5.287,24.5l10.215,-19l10.215,18.971l-20.43,0.029Z" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M15.5,17l0.5,-5l-1,0l0.5,5Z" style="fill:#fff;stroke:#fff;stroke-width:1px;"/><circle cx="15.5" cy="20.5" r="1.5" style="fill:#fff;"/></g></g></svg>
                        <span><?php echo implode(',',$_SESSION['WARNING']['content']);?></span>
                        <svg class="picto close" width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="close-wh"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><g id="close"><path d="M10,10l10,10" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M20,10l-10,10" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></g></svg>
                    </div>
                </div>
<?php }?>
                <div class="content-col" rel="1">
                    <div class="form_bloc">
<?php 
if($_SESSION['user_info']['user_statut'] == "0" || (!is_array($a_config_rules) && isset($a_config_rules->$_key)) || (is_array($a_config_rules) &&isset($a_config_rules[$_key]))){?>                          
                        <h1><?php echo $starter->_get_lexique('Statistiques',1);?></h1>
                        
                        <div class="bloc_element">
                            <ul>
                                <li class="list_field">
                                    <label for="tree_label">
                                        <span class="name_label"><?php echo $starter->_get_lexique('Période du',1);?></span>
                                        <input autocomplete="off" class="underline date_" name="date_start" id="date_start" type="text" value="<?php echo $s_form_date_start;?>" />

                                    </label>
                                </li>
                                <li class="list_field">
                                    <label for="tree_label">
                                        <span class="name_label"><?php echo $starter->_get_lexique('au',1);?></span>
                                        <input autocomplete="off" class="underline date_" name="date_end" id="date_end" type="text" value="<?php echo $s_form_date_end;?>" />

                                    </label>
                                </li>
                                    <li class="no-label">
                                        <a href="javascript:void(0);" onclick="document.forms['form_stat'].submit()" class=" btn dark">
                                            <?php echo $starter->_get_lexique('Valider',1);?>
                                        </a>
                                    </li>
                            </ul>
<?php if($starter->utils->is__countable($_POST) && count($_POST) > 0){?>
                            <div class="modulechart">
                                <script type="text/javascript">
                                    window.onload = function () {                                       
<?php foreach($starter->stats as $key => $renderstats){     
                                    include dirname( __FILE__ ) . '/' . $renderstats->type . '.php';?>            
<?php } ?>
                                    }
                                </script>
<?php foreach($starter->stats as $key => $renderstats){ ?>
                                <div id="chartContainer_<?php echo $key;?>" style="height: 300px; width: 100%;"></div>    
<?php } ?>
                            </div>
<?php }
}?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>