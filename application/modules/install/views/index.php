
            <div id="right-content">
            
                <div class="content-bloc">
                    
                    <div class="final-content">
           
                        <div class="content-col">
                        
                            <h1 class="screen-reader-text">Configurer la connexion à votre base de données</h1>
                            
                            <form name="engine_form" id="engine_form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
                            
                                <ul>
                                        
                                    <li class="list_field">
                                    
                                        <label for="dbname">
                                                
                                            <span class="name_label"><?php echo $a_fields['dbname']["label"];?></span>
                                        
                                            <input autocomplete="off" class="<?php if(isset($starter->checkForm->a_errors['dbname'])){echo 'on_error';}?>" name="dbname" id="dbname" size="25" type="text"  value="<?php echo isset($_POST['dbname']) ? $_POST['dbname'] : ''; ?>" />
                                        
                                        </label>
                                        
                                    </li>
                                        
                                    <li class="list_field">
                                    
                                        <label for="uname">
                                                
                                            <span class="name_label"><?php echo $a_fields['uname']["label"];?></span>
                                        
                                            <input autocomplete="off" class="<?php if(isset($starter->checkForm->a_errors['uname'])){echo 'on_error';}?>" name="uname" id="uname" size="25" type="text"  value="<?php echo isset($_POST['uname']) ? $_POST['uname'] : ''; ?>" />
                                        
                                        </label>
                                        
                                    </li>
                                        
                                    <li class="list_field">
                                    
                                        <label for="pwd">
                                                
                                            <span class="name_label"><?php echo $a_fields['pwd']["label"];?></span>
                                        
                                            <input class="<?php if(isset($starter->checkForm->a_errors['pwd'])){echo 'on_error';}?>" autocomplete="off" name="pwd" id="pwd" size="25" type="text"  value="<?php echo isset($_POST['pwd']) ? $_POST['pwd'] : ''; ?>" />
                                        
                                        </label>
                                        
                                    </li>
                                        
                                    <li class="list_field">
                                    
                                        <label for="dbhost">
                                                
                                            <span class="name_label"><?php echo $a_fields['dbhost']["label"];?></span>
                                        
                                            <input autocomplete="off" class="<?php if(isset($starter->checkForm->a_errors['dbhost'])){echo 'on_error';}?>" name="dbhost" id="dbhost" size="25" type="text"  value="<?php echo isset($_POST['dbhost']) ? $_POST['dbhost'] : ''; ?>" />
                                        
                                        </label>
                                        
                                    </li>
                                        
                                    <li class="list_field">
                                    
                                        <label for="prefix">
                                                
                                            <span class="name_label"><?php echo $a_fields['prefix']["label"];?></span>
                                        
                                            <input autocomplete="off" class="<?php if(isset($starter->checkForm->a_errors['prefix'])){echo 'on_error';}?>" name="prefix" id="prefix" size="25" type="text"  value="<?php echo isset($_POST['prefix']) ? $_POST['prefix'] : ''; ?>" />
                                        
                                        </label>
                                        
                                    </li>
                                        
                                    <li class="list_field">
                                    
                                        <label for="language">
                                                
                                            <span class="name_label"><?php echo $a_fields['language']["label"];?></span>
                                        
                                            <input autocomplete="off" class="<?php if(isset($starter->checkForm->a_errors['language'])){echo 'on_error';}?>" name="language" id="language" size="25" type="text"  value="<?php echo isset($_POST['language']) ? $_POST['language'] : ''; ?>" />
                                        
                                        </label>
                                        
                                    </li>
                                    
                                </ul>
                                
                            </form>
                            
                            <div class="big-button">

                                <a onclick="document.forms['engine_form'].submit()" href="javascript:void(0);">Valider</a>
                                
                            </div>

                        </div>
                        
                    </div>
                        
                </div>
                
             </div>
