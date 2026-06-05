<section class="padB80">
    <div class="container">
        <div class="overview relative flex alignfC">
            <div class="inlineb">
                <div class="title margH20 padV5 ">
                    <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'];?>" class="flex alignfC">
                        <svg id="alarm" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M.265,10.714,8.433,19.7a.861.861,0,0,0,1.3,0,1.081,1.081,0,0,0,0-1.427L2.212,10,9.73,1.723A1.082,1.082,0,0,0,9.73.3a.861.861,0,0,0-1.3,0L.265,9.286A1.094,1.094,0,0,0,.265,10.714Z" transform="translate(6 2)" fill="#383838"/></svg>
                        <span class="ftblack ft20 margL5 "> <?php echo $starter->_get_lexique("Les adhérents de ma structure");?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <form action="" class="form margT20" id="blocForm" name="blocForm" method="POST">
        <input type="hidden" name="adherent" id="adherent" value="" />
        <input type="hidden" name="ref" id="ref" value="" />
        <div class="relative">
            <div class="backgreyl padH20 padB40 brad30 ">
                <div class="container margT20">
                    <div class="row gx-4 gy-4 flex fullH">
<?php foreach($associations->association->a_data AS $key => $val){?>
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="brad15 fullH bshadow0_5 pad20">
                                <div class="flex">
                                    <div class="inlineb margL5">
<?php
    if($val['_valid'] == 0){?>
                                        <a class="margB0" href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $starter->mods['profil']['referer'] . '/' . $starter->mods['profil']['modules']['validation']['referer'] . '/' . $val['tokenad'];?>"><?php echo $val['adherent_fname'] . " " . $val['adherent_lname']. ' <span class="bolder">' . $starter->_get_lexique("En attente de validation");?></span></a>
<?php 
    }else{?>
                                        <p class="margB0"><?php echo $val['adherent_fname'] . " " . $val['adherent_lname']. ' <span class="bolder">' . ($val['_valid'] == 1 ? $starter->_get_lexique("Validé") : $starter->_get_lexique("Refusé"));?></span></p>
<?php 
    }?>
                                    </div>
                                </div>
                            </div>
                        </div> 
<?php 
}?>  
                    </div>
                </div> 
            </div>
        </form>
    </div>
</section>