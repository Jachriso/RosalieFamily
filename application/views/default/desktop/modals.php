<?php if(isset($_SESSION['WARNING'])){?>
<div class="modal" id="infoWarning" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable popin">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="">
                    <h1 class="ft30 ftr ftblue"><?php echo $_SESSION['WARNING']['title'];?></h1>
                </div>
                <div class="separator2 margV10"></div>
<?php if($_SESSION['WARNING']['type'] == "error"){?>
                <div class="margT20 ft20 ftred ftr padV20 flex">
                    <img class="pcito margR5" src="<?php echo $starter->MEDIA_PATH . 'picto_error.svg';?>">
                    <?php echo $starter->database->get_lexique("Erreur(s) détectée(s)");?> :
                </div>
                <div class="margT20 ft20 ftblue ftr">
                    <?php echo implode('.<br /> ',$_SESSION['WARNING']['content']);?>
                </div>
<?php }elseif($_SESSION['WARNING']['type'] == "success"){?>
                <div class="margT20 ft20 ftblue ftr padV20 padH40 flex">
                    <img class="pcito margR5" src="<?php echo $starter->MEDIA_PATH . 'picto_success.svg';?>">
<?php if(!empty($_SESSION['WARNING']['content'])){?>
                    <?php echo implode('.<br /> ',$_SESSION['WARNING']['content']);?>
<?php }?>
                </div>
<?php }?>
<?php if(isset($_SESSION['WARNING']['CTA'])){?>
                <div class="margT20">  
<?php if(isset($_SESSION['WARNING']['CTA']['type']) && $_SESSION['WARNING']['CTA']['type'] == "modal"){?>
                    <a class="btn ft16 ftr ftblue block underline" data-bs-toggle="modal" data-bs-target="#dynamicModal" data-link="<?php echo $_SESSION['WARNING']['CTA']['uri'];?>" data-type="<?php echo $_SESSION['WARNING']['CTA']['iframe']?>" href="javascript:void(0);"><?php echo $_SESSION['WARNING']['CTA']['title'] ;?>
                    </a>
<?php }elseif(isset($_SESSION['WARNING']['CTA']['type']) && $_SESSION['WARNING']['CTA']['type'] == "sendActiv"){?>
                    <button id="sendActiv" class="CTA CTAGreen ft18 ftm" type="button" data-info="<?php echo $_SESSION['WARNING']['CTA']['uri'];?>" data-value="<?php echo $_SESSION['WARNING']['CTA']['data'];?>"><?php echo $_SESSION['WARNING']['CTA']['title'];?></button>
                    <div id="submit_img" style="display: none; clear: both; padding: 10px 0px 0px;">
                        <img src="<?php echo $starter->MEDIA_PATH;?>interface/ajax-loader.gif" />
                    </div>
                    <div id="form_result" class="margT20 ft20 ftblue ftr"></div>
<?php }else{?>
                    <a class="btn ft16 ftr ftblue block underline" href="<?php echo $_SESSION['WARNING']['CTA']['uri'] ;?>"><?php echo $_SESSION['WARNING']['CTA']['title'] ;?>
                    </a>
<?php }?>
                </div>
<?php }?>
            </div>
        </div>
    </div>
</div>
<button class="btn btn-primary autopopin hide"  data-bs-toggle="modal" data-bs-target="#infoWarning" style=""></button>
<?php }else{?>
<div class="modal" id="infoAccount" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable popin">
        <div class="modal-content">
            <div class="modal-header">
                <h1></h1>
                <button type="button" class="absolute t-10 r-10 btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="ft20 ftblue ftb margB0 alignC"><?php echo $starter->database->get_lexique("Vous devez être connecté pour débloquer cette fonctionnalité.");?></p>
            </div>
        </div>
    </div>
</div>
 <?php }?>
<div class="modal" id="dynamicModal" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer"></div>
        </div>
    </div><!-- Button trigger modal -->
</div>
<div id="template-container" class="hide">
    <div class="dz-preview">
        <div class="dz-image centerH" >
            <img data-dz-thumbnail="" />
        </div>
        <div class="dz-details">
            <div class="dz-size"><span data-dz-size=""></span></div>
            <div class="dz-filename"><span data-dz-name=""></span></div>
        </div>
        <div class="absolute center z20 pointer defaultremoveDrop" data-value="">
            <div class="w50 h50">
                <svg data-dz-remove="" version="1.1" class="h20 center relative" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 26 28" style="enable-background:new 0 0 26 28;" xml:space="preserve"><g><path class="fillwhite" d="M22,23c0,2.1-0.9,3-3,3H7c-2.1,0-3-0.9-3-3V7H2v16c0,3.2,1.8,5,5,5h12c3.2,0,5-1.8,5-5V7h-2V23z"></path><rect x="17" y="9" class="fillwhite" width="2" height="14"></rect><rect x="12" y="9" class="fillwhite" width="2" height="14"></rect><rect x="7" y="9" class="fillwhite" width="2" height="14"></rect><path class="fillwhite" d="M17,4V0H9v4H0v2h26V4H17z M15,4h-4V2h4V4z"></path></g></svg>
            </div> 
        </div>
    </div>
</div>