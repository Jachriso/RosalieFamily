            
            <div id="right-content">
            
                <div class="content-bloc">
                    
                    <div class="final-content">

                        <div class="content-col">
                        	
                            <form name="engine_form" id="engine_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
                                                
                                <div class="small_form-submit">
                                    
                                    <button type="submit" name="purge_all" id="purge_all" value="1"/><?php echo $starter->_get_lexique('Purger tout le cache')?></button>

                                </div>

                                <div class="clear"></div>

                                <div class="small_form-submit">

                                    <label for="purge_url">

                                        <input autocomplete="off" name="url" id="url" class="detail_label small_text " value="" maxlength="255" type="text">

                                        <button type="submit" name="purge_url" id="purge_url" value="1"><?php echo $starter->_get_lexique('Purger cette url')?></button>

                                    </label>
                                    
                                </div>  

                                <div class="small_form-submit">
                                    
                                    <button type="submit" name="generate_cache" id="generate_cache" value="1"><?php echo $starter->_get_lexique('Précharger le cache')?></button>

                                </div>                            

                            </form>
                            
                        </div>
                       
                    </div>
                    
                </div>
                
            </div>