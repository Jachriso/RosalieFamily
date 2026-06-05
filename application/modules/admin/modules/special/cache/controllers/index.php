<?php
// init vars
$i_purge = (isset($_POST['purge_all']) && !empty($_POST['purge_all']) ? 1 : 0);
$s_purge = (isset($_POST['url']) && !empty($_POST['url'] && isset($_POST['purge_url']) && $_POST['purge_url']) ? ($_POST['url']) : '');

if($starter->utils->is__countable($_POST) && count($_POST) > 0)
{
	if($i_purge)
	{
		$a_cache = APPLICATION_PATH . '/../cache/';
		$starter->utils->delTree($a_cache);
	}
	else if (!empty($s_purge))
	{
		$s_purge = preg_replace('#' . $starter->HTTP_ROOT . $starter->s_lang . '/#','',$s_purge);
		   $dirname = APPLICATION_PATH . '/../cache/' . $s_purge;
		array_map('unlink', glob("$dirname/*.*"));
	}
	else if (isset($_POST['generate_cache']))
	{
		$menu = new menu();

		$s_query = "
			SELECT t0.*, t1.*
			FROM tree AS t0
			INNER JOIN tree_detail AS t1
			ON t1.detail_tree = t0.tree_id
			WHERE t0.online = 1
			AND t0.archive = 0";
		
		$_tmp = $starter->database->prepare_query($s_query, array(), 'multiple');

		foreach($_tmp as $key => $val)
		{
			if($val['tree_parent'] != 0)
			{
				$menu->lookForParents($val);
				$s_path = implode('/',$menu->breadcrumb);
			}else
				$s_path = $val['detail_referer'];
			
			ob_start();
							
			if(!$starter->b_curl) 
				$s_cache_template 		= 	file_get_contents($starter->HTTP_ROOT . $_a_lang[$val['lang']]['lang_ref'] . '/' . $s_path) ;
			else
				$s_cache_template 		= 	$starter->utils->curl_load($starter->HTTP_ROOT . $_a_lang[$val['lang']]['lang_ref'] . '/' . $s_path) ;
				
			print eval('?>'. $s_cache_template);
				
			$xHTML = ob_get_contents();
			ob_end_clean();	
		}

	}
}

// rel files


//CSS

$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/modules/admin/modules/special/cache/css/main.css');
// JS

//output
$include_page = '/modules/admin/modules/special/cache/views/index.php' ;

?>