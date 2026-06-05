<main>
<?php if(isset($starter->b_breadcrumbTree) && $starter->b_breadcrumbTree){?>
                    <a href="<?php echo $starter->HTTP_ROOT . $starter->s_lang;?>.html"><?php echo $starter->_get_lexique("HOME");?></a> <?php echo '>';?>
					<?php echo implode(' > ',$menu->breadcrumbTree);?>
<?php }?>
                        <h1><?php echo $tree->a_data['label'];?></h1>
                        <ul class="header-tools">
<?php if(isset($starter->mods['send_to_friend']) && isset($starter->b_mail) && $starter->b_mail){?>
                            <li>
                                <a data-modal="popinModule" class="popup-button button" data-link="<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->mods['send_to_friend']['referer'];?>.html?shareduri=<?php echo $starter->HTTP_DOMAIN . $_SERVER['REQUEST_URI'];?>" ><?php echo $starter->_get_lexique("Partager");?></a>
                            </li>
<?php }?>
<?php if(isset($starter->b_print) && $starter->b_print){?>
                            <li>
                                <a href="javascript:window.print();" class="print"><?php echo $starter->_get_lexique("Imprimer");?></a>
                            </li>
<?php }?>
<?php if(isset($starter->b_pdf ) && $starter->b_pdf){?>
                            <li>
                                <a href="<?php echo $starter->HTTP_ROOT . $starter->s_lang . '/' . $starter->mods['pdf_printer']['referer'] . '/' . $a_breadCrumb[count($a_breadCrumb) - 1];?>.html" class="pdf"><?php echo $starter->_get_lexique("Impression PDF");?></a>
                            </li>
<?php }?>
						</ul>
                        <?php echo $tree->a_data['detail_text'];?>
</main>