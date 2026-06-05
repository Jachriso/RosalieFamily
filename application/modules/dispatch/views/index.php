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