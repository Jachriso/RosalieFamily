<section class="padB80">
    <div class="container">
        <div class="overview relative flex alignfC">
            <div class="inlineb">
                <div class="title margH20 padV5 ">
                    <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['covoiturages']['referer'];?>" class="flex alignfC">
                        <svg id="alarm" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.265,10.714,8.433,19.7a.861.861,0,0,0,1.3,0,1.081,1.081,0,0,0,0-1.427L2.212,10,9.73,1.723A1.082,1.082,0,0,0,9.73.3a.861.861,0,0,0-1.3,0L.265,9.286A1.094,1.094,0,0,0,.265,10.714Z" transform="translate(6 2)" fill="#383838"/></svg>
                        <span class="ftblack ft20 margL5"> <?php echo $starter->_get_lexique("Nouveau covoiturage");?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form action="" class="form margT20" id="blocForm" name="blocForm" method="POST">
        <div class="padH20 padV40">
            <div class="container padH0">
                <div class="row g-3">
<?php if( !isset($_GET['covoiturage_type']) ){?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="<?php echo (isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_type"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_type"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['covoiturage_type'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_type"]['field'];?>" class="inputBox">
                                <select data-type="select" name="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_type']['field'];?>" id="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_type']['field'];?>" class="fullW" required="required">
<?php foreach ($covoiturages->covoiturage->a_fields['fields']['covoiturage_type']['data'] AS $key => $val) {?>
                                    <option value="<?php echo $key;?>" <?php echo ((isset($_POST['covoiturage_type']) && $_POST['covoiturage_type'] == $key) || (isset($_GET['covoiturage_type']) && $_GET['covoiturage_type'] == $key) || (isset($value['covoiturage_type']) && $value['covoiturage_type'] == $key) ? 'selected="selected"' : '');?> > <?php echo $val;?></option>
<?php }?>
                                </select>
                                <span class="ftblack margB0"><?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_type"]['label'];?></span>
                            </label>
                        </div>
                    </div>
<?php }else{?>
                    <input type="hidden" name="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_type']['field'];?>" id="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_type']['field'];?>" value="<?php echo $_GET['covoiturage_type'];?>"/>
<?php }?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="<?php echo (isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_date"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_date"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['covoiturage_date'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_date"]['field'];?>" class="relative">
                                <span class="ftgrey margB0 inputBox"><?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_date"]['label'];?></span>
                                <input autocomplete="OFF" class="fullW <?php if(isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_date"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_date"]['verif'])){echo 'mandatoryfield';}?>"  id="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_date"]['field'];?>" min="<?php echo date('Y-m-d');?>" name="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_date"]['field'];?>" type="date" value="<?php echo (isset($_POST['covoiturage_date']) ? $_POST['covoiturage_date'] : (isset($covoiturages->covoiturage->a_data['covoiturage_date']) ? $covoiturages->covoiturage->a_data['covoiturage_date'] : '')); ?>" />
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 covoiturage_add_start">
                        <div class="<?php echo (isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_add_start"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_add_start"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['covoiturage_add_start'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_add_start"]['field'];?>" class="inputBox">
                                <select data-type="select" name="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_add_start']['field'];?>" id="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_add_start']['field'];?>" class="h70 fullW" required="required">
<?php foreach ($covoiturages->covoiturage->a_fields['fields']['covoiturage_add_start']['data'] AS $key => $val) {?>
                                    <option value="<?php echo $key;?>" <?php echo ((isset($_POST['covoiturage_add_start']) && $_POST['covoiturage_add_start'] == $key) || (isset($value['covoiturage_add_start']) && $value['covoiturage_add_start'] == $key) ? 'selected="selected"' : '');?> > <?php echo $val;?></option>
<?php }?>
                                </select>
                                <span class="ftgrey margB0"><?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_add_start"]['label'];?></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="<?php echo (isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_add_end"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_add_end"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['covoiturage_add_end'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_add_end"]['field'];?>" class="inputBox">
                                <select data-type="select" name="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_add_end']['field'];?>" id="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_add_end']['field'];?>" class="fullW h70" required="required">
<?php foreach ($covoiturages->covoiturage->a_fields['fields']['covoiturage_add_end']['data'] AS $key => $val) {?>
                                    <option value="<?php echo $key;?>" <?php echo ((isset($_POST['covoiturage_add_end']) && $_POST['covoiturage_add_end'] == $key) || (isset($value['covoiturage_add_end']) && $value['covoiturage_add_end'] == $key) ? 'selected="selected"' : '');?> > <?php echo $val;?></option>
<?php }?>
                                </select>
                                <span class="ftgrey margB0"><?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_add_end"]['label'];?></span>
                            </label>
                        </div>
                    </div>
                    <!-- <div class="col-lg-4 col-md-6 col-12">
                        <div class="<?php //echo (isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_h_start"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_h_start"]['verif']) ? 'blocMandatory' : '') ;?> <?php /*if(isset($starter->checkForm->a_errors['covoiturage_h_start'])){echo 'bloc_on_error';}*/?>">
                            <label for="<?php //echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_h_start"]['field'];?>" class="inputBox">
                                <input autocomplete="OFF" class="fullW <?php /*if(isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_h_start"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_h_start"]['verif'])){echo 'mandatoryfield';}*/?>"  id="<?php //echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_h_start"]['field'];?>" name="<?php //echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_h_start"]['field'];?>" type="text" value="<?php //echo (isset($_POST['covoiturage_h_start']) ? $_POST['covoiturage_h_start'] : (isset($covoiturages->covoiturage->a_data['covoiturage_h_start']) ? $covoiturages->covoiturage->a_data['covoiturage_h_start'] : '')); ?>" />
                                <span class="ftgrey margB0"><?php //echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_h_start"]['label'];?></span>
                            </label>
                        </div>
                    </div> -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="<?php echo (isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_h_end"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_h_end"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['covoiturage_h_end'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_h_end"]['field'];?>" class="inputBox">
                                <input autocomplete="OFF" class="fullW <?php if(isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_h_end"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_h_end"]['verif'])){echo 'mandatoryfield';}?>"  id="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_h_end"]['field'];?>" name="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_h_end"]['field'];?>" type="time" value="<?php echo (isset($_POST['covoiturage_h_end']) ? $_POST['covoiturage_h_end'] : (isset($covoiturages->covoiturage->a_data['covoiturage_h_end']) ? $covoiturages->covoiturage->a_data['covoiturage_h_end'] : '')); ?>" />
                                <span class="ftgrey margB0"><?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_h_end"]['label'];?></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 covoiturage_nb_places">
                        <div class=" <?php echo (isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_nb_places"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_nb_places"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['covoiturage_nb_places'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_nb_places"]['field'];?>" class="inputBox">
                                <input autocomplete="OFF" class="fullW <?php if(isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_nb_places"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_nb_places"]['verif'])){echo 'mandatoryfield';}?>"  id="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_nb_places"]['field'];?>" min="0" max="8" name="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_nb_places"]['field'];?>" type="number" value="<?php echo (isset($_POST['covoiturage_nb_places']) ? $_POST['covoiturage_nb_places'] : (isset($covoiturages->covoiturage->a_data['covoiturage_nb_places']) ? $covoiturages->covoiturage->a_data['covoiturage_nb_places'] : '')); ?>" />
                                <span class="ftgrey margB0"><?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_nb_places"]['label'];?></span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 covoiturage_adherent">
                        <div class=" <?php echo (isset($covoiturages->covoiturage->a_fields['fields']["covoiturage_adherent"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["covoiturage_adherent"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['covoiturage_adherent'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_adherent"]['field'];?>" class="inputBox">
                                <select data-type="select" name="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_adherent']['field'];?>" id="<?php echo $covoiturages->covoiturage->a_fields['fields']['covoiturage_adherent']['field'];?>" class="fullW" required="required">
<?php foreach ($covoiturages->covoiturage->a_fields['fields']['covoiturage_adherent']['data'] AS $key => $val) {?>
                                    <option value="<?php echo $key;?>" <?php echo ((isset($_POST['covoiturage_adherent']) && $_POST['covoiturage_adherent'] == $key) || (isset($value['covoiturage_adherent']) && $value['covoiturage_adherent'] == $key) ? 'selected="selected"' : '');?> > <?php echo $val['adherent_fname'];?></option>
<?php }?>
                                </select>
                                <span class="ftblack margB0"><?php echo $covoiturages->covoiturage->a_fields['fields']["covoiturage_adherent"]['label'];?></span>
                            </label>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="alignC margT20">
                                <button type="button" class="CTA CTAFirst btnsubmit checkmandatory"><?php echo $starter->_get_lexique('Enregistrer');?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>