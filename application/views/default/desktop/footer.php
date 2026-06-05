<footer class="backblue fullW" >
    <div class="container px-0 maxW1640">
        <div class="py-5">
            <div class="row">
                <div class="col-6">
                    <ul class="">
<?php foreach($a_footer_menu as $pages => $page){?>
                        <li class="margB5 block">
                            <a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . $page['detail_referer'];?>" class="ft18 ftwhite ftr"><?php echo $page['detail_label'];?></a>
                        </li>
<?php }?>
                    </ul>
                </div>
      
                <div class="col-6">
                    <form>
                      <h5 class="ftwhite ft18"><?php echo $starter->_get_lexique('Subscribe to our newsletter');?></h5>
                      <p class="ftwhite"><?php echo $starter->_get_lexique("Monthly digest of what's new and exciting from us.");?></p>
                      <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                        <label for="newsletter1" class="visually-hidden"><?php echo $starter->_get_lexique('Email address');?></label>
                        <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                        <button class="CTA CTAWhite" type="button"><?php echo $starter->_get_lexique('Subscribe');?></button>
                      </div>
                    </form>
                </div>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-between py-4 my-4 border-top">
                <p><a href="<?php echo $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '');?>" class="ft20 ftwhite thin"><?php echo $starter->_get_lexique('Réseau Entrepreneurs Varois');?></a></p>
            </div>
        </div>
    </div>
</footer>