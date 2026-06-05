
</div>

<?php if($starter->bdebug ) {?>
<div class="debugger">debug</div>
<?php }?>
<!--[if lt IE 9]>
        <script src="<?php echo $starter->HTTP_ROOT  . 'js/'; ?>css3-mediaqueries.min.js"></script>       
        <![endif]-->     
        <!--[if lt IE 9]> <script src="<?php echo $starter->HTTP_ROOT  . 'js/'; ?>html5.js"></script> <![endif]-->
            
        <script type="text/javascript">
            var sDomain = '<?php echo $starter->HTTP_ROOT; ?>' ;
            var sLang = '<?php echo $starter->s_lang; ?>' ;
			           
        </script>
<?php   foreach($starter->a_js_first as $key => $val){ ?>
        <script language="javascript" type="text/javascript" src="<?php echo $val['src']; ?>"></script>
<?php 
        }
	foreach($starter->a_js_out as $key => $val){ ?>
        <script language="javascript" type="text/javascript" src="<?php echo $val['src']; ?>"></script>
<?php }   ?>   
<?php if(isset($starter->b_minifier) && $starter->b_minifier & isset($_SESSION['rel']) && is_array($_SESSION['rel']) && $starter->utils->is__countable($_SESSION['rel']) && count($_SESSION['rel']) > 0) { ?>
        <script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT  . 'js/js-' . $s_rel_id . '.js'; ?>"></script>   
<?php } else { ?>
<?php foreach($starter->a_js as $key => $val){ ?>
        <script language="javascript" type="text/javascript" src="<?php echo $val['src']; ?>"></script>
<?php }  } ?>
		<?php if(!empty($starter->s_extended_js)) { ?>
		<script type="text/javascript" language="javascript"><?php echo $starter->s_extended_js ; ?></script>
<?php } ?>
    </body>
</html>