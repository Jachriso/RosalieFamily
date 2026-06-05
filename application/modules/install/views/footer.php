                    </div>
        
    </div>
	<script type="text/javascript">
		var sDomain = '<?php echo $starter->HTTP_ROOT; ?>' ;
		var sLang = '<?php echo $starter->s_lang; ?>' ;
		var b_sortable = '<?php echo $starter->sortable; ?>' ; 
			           
	</script>
<?php if(isset($sGlobals['rel_mode']) && $sGlobals['rel_mode'] & isset($_SESSION['rel']) && is_array($_SESSION['rel']) && $starter->utils->is__countable($_SESSION['rel']) && count($_SESSION['rel']) > 0) { ?>
        <script language="javascript" type="text/javascript" src="<?php echo $starter->HTTP_ROOT  . 'js/general/global-' . $s_rel_id . '.js'; ?>"></script>        
<?php } else { ?>
<?php foreach($starter->a_js as $key => $val){ ?>
        <script language="javascript" type="text/javascript" src="<?php echo $val['src']; ?>"></script>
<?php }  } ?>      
</body>

</html>
