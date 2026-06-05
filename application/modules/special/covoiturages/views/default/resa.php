<section class="">
    <div class="container">
        <div class="overview relative flex alignfC">
            <div class="inlineb">
                <div class="title margH20 padV5 ">
                    <span class="ftblack ft20 margL5"> <?php echo $starter->_get_lexique("Ma réservation");?></span>
                </div>
            </div>
        </div>
    </div>
    <form action="" class="form margT20" id="blocForm" name="blocForm" method="POST">
        <input type="hidden" id="ref" name="ref" value="<?php echo (isset($_GET['ref']) ? $_GET["ref"] : '');?>" />
        <div class="padH20 padV40">
            <div class="container padH0">
                <div class="row g-3">
                    <div class="col-lg-4 col-md-6 col-12 adherent">
                        <div class="<?php echo (isset($covoiturages->covoiturage->a_fields['fields']["adherent"]['verif']) && in_array('mandatory',$covoiturages->covoiturage->a_fields['fields']["adherent"]['verif']) ? 'blocMandatory' : '') ;?> <?php if(isset($starter->checkForm->a_errors['adherent'])){echo 'bloc_on_error';}?>">
                            <label for="<?php echo $covoiturages->covoiturage->a_fields['fields']["adherent"]['field'];?>" class="inputBox">
                                <select data-type="select" name="<?php echo $covoiturages->covoiturage->a_fields['fields']['adherent']['field'];?>" id="<?php echo $covoiturages->covoiturage->a_fields['fields']['adherent']['field'];?>" class="fullW" required="required">
<?php foreach ($covoiturages->covoiturage->a_adherent AS $key => $val) {?>
                                    <option value="<?php echo $val['adherent_id'];?>" <?php echo ((isset($_POST['adherent']) && $_POST['adherent'] == $key) || (isset($val['adherent_id']) && $val['adherent_id'] == $key) ? 'selected="selected"' : '');?> > <?php echo $val['adherent_fname'] . " " . $val['adherent_lname']  . " " . $val['adherent_bday'] ;?></option>
<?php }?>
                                </select>
                                <span class="ftblack margB0"><?php echo $covoiturages->covoiturage->a_fields['fields']["adherent"]['label'];?></span>
                            </label>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="alignC margT20 form_result">
                                <button type="button" class="CTA CTAFirst" id="sendResa"><?php echo $starter->_get_lexique('Enregistrer');?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>