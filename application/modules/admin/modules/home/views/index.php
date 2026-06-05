            
            <div id="right-content">
            
                <div class="content-bloc">

                    <div id="top-content">

                        <div id="picto_menu">
                            <svg width="100%" height="100%" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:1.5;"><g id="burger"><rect x="0" y="0" width="30" height="30" style="fill:none;"/><path d="M2.5,15.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,23.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/><path d="M2.5,7.5l25,0" style="fill:none;stroke:#fff;stroke-width:1px;"/></g></svg>
                        </div>
                        
                    </div>
                    
                    <div class="final-content">
<?php 
foreach($starter->database->configs as $key => $val){
	foreach($starter->database->configs[$key]['content'] as $_key => $_val){
		if(isset($_val['content'])) foreach($_val['content'] as $item => $config){
			if(isset($config['is_home']) && $config['is_home']){?>
                        <div class="quick-access">
                        	
                            <!--<a href="<?php //echo HTTP_ROOT . $s_lang;?>/admin.html?page=Seenk&config_id=9&module=timesheet&action=list">
                            
                                <img src="../../../../../../content/static/clock.png" />
								
								<?php //echo //$a_translation['backoffice']['timesheet']['home']['label'];?>
                                
                            </a>-->
                            
                        </div>
<?php 		}
		}
	}
}?>                        
                    </div>
                    
                </div>
                
            </div>