<?php 
// IF cache activ
if($starter->iscache && (!isset($_GET['level1']) || (isset($_GET['level1']) && $_GET['level1'] != "admin")))
{
	// get uri name
	$_cache = (is_file(APPLICATION_PATH . '/../cache/' . $starter->s_lang . '/' . (!empty($starter->s_level1) ? $starter->s_level1 : 'home') . (isset($starter->s_level2) && !empty($starter->s_level2) ? '/' . $starter->s_level2 : '') . (isset($starter->s_level3) && !empty($starter->s_level3) ? '/' . $starter->s_level3 : '') . (isset($starter->s_level4) && !empty($starter->s_level4) ? '/' . $starter->s_level4 : '') . (isset($starter->s_level5) && !empty($starter->s_level5) ? '/' . $starter->s_level5 : '') . '/index.cache') ? APPLICATION_PATH . '/../cache/' . $starter->s_lang . '/' . (!empty($starter->s_level1) ? $starter->s_level1 : 'home') . (isset($starter->s_level2) && !empty($starter->s_level2) ? '/' . $starter->s_level2 : '') . (isset($starter->s_level3) && !empty($starter->s_level3) ? '/' . $starter->s_level3 : '') . (isset($starter->s_level4) && !empty($starter->s_level4) ? '/' . $starter->s_level4 : '') . (isset($starter->s_level5) && !empty($starter->s_level5) ? '/' . $starter->s_level5 : '') . '/index.cache' : false);

	// if uri name exist, get laps time refresh
	if($_cache != false)
		$modif_ago = time() - filemtime($_cache);
}

$starter->utils->getmeta($starter->i_level);	
// controller
// if no cache activ, get file from database

if( (!$starter->iscache || !isset($_cache) || !$_cache || (isset($modif_ago) && $modif_ago > $starter->cacheTime)))
{
	require_once APPLICATION_PATH . '/configs/!locked/inc.vars.php' ;
	if(!$starter->is_install){
		$starter->s_default_view = 'install'; 
		//require_once APPLICATION_PATH . $starter->mods['working']['path'] ;
		//require_once APPLICATION_PATH . '/configs/inc.vars.php' ;
		require_once APPLICATION_PATH . '/controllers/!locked/index_' . $starter->s_default_view . '.php' ;
	}
	else{
		if($starter->extranet && isset($starter->mods['login']) && $starter->mods['login'] && (!isset($_GET['level1']) || ($_GET['level1'] != 'reset' && $_GET['level1'] != 'confirm')))
		{
			if($starter->s_level1 == 'logout')
				include APPLICATION_PATH . $starter->mods['login']['modules']['logout']['path'];
			elseif($starter->s_level1 == 'admin' || $starter->s_level1 == 'plugins')
			{
				if(!isset($_SESSION['user_info']))
				{
					//require_once APPLICATION_PATH . '/configs/inc.vars.php' ;
					require_once APPLICATION_PATH . $starter->mods['working']['path'] ;
					include APPLICATION_PATH . $starter->mods['login']['path'];
				}
				else
				{
					$starter->s_default_view = 'backoffice'; 
					require_once APPLICATION_PATH . $starter->mods['working']['path'] ;
					require_once APPLICATION_PATH . '/controllers/!locked/index_' . $starter->s_default_view . '.php' ;
				}
			}else
			{
				if(!isset($_SESSION['user_info']))
				{
					//require_once APPLICATION_PATH . '/configs/inc.vars.php' ;
					require_once APPLICATION_PATH . '/configs/!locked/frontoffice-inc.vars.php' ;
					require_once APPLICATION_PATH . $starter->mods['working']['path'] ;
					if(isset($starter->s_level1) && $starter->s_level1 == $starter->mods['subscribe']['referer'])
						include APPLICATION_PATH . $starter->mods['subscribe']['path'];
					else
						include APPLICATION_PATH . $starter->mods['login']['path'];
				}
				else
				{
					$starter->s_default_view = 'frontoffice';
					require_once APPLICATION_PATH . $starter->mods['working']['path'] ;
					require_once APPLICATION_PATH . '/controllers/!locked/index_' . $starter->s_default_view . '.php' ;
				}
			}
		}else 
		{
			if($starter->s_level1 == 'logout')
				include APPLICATION_PATH . $starter->mods['login']['modules']['logout']['path'];
			elseif($starter->s_level1 == 'admin' || $starter->s_level1 == 'plugins')
			{
				if(!isset($_SESSION['user_info']))
				{
					require_once APPLICATION_PATH . '/configs/!locked/frontoffice-inc.vars.php' ;
					require_once APPLICATION_PATH . $starter->mods['working']['path'] ;
					include APPLICATION_PATH . $starter->mods['login']['path'];
				}
				else
				{
					$starter->s_default_view = 'backoffice'; 
					require_once APPLICATION_PATH . $starter->mods['working']['path'] ;
					require_once APPLICATION_PATH . '/controllers/!locked/index_' . $starter->s_default_view . '.php' ;
				}
			}
			else{
				if($starter->s_level1 == $starter->mods['login']['referer'])
				{
					//require_once APPLICATION_PATH . '/configs/inc.vars.php' ;
					require_once APPLICATION_PATH . '/configs/!locked/frontoffice-inc.vars.php' ;
					require_once APPLICATION_PATH . $starter->mods['working']['path'] ;
					include APPLICATION_PATH . $starter->mods['login']['path'];
				}
				else
				{
					$starter->s_default_view = 'frontoffice';
					require_once APPLICATION_PATH . $starter->mods['working']['path'] ;
					require_once APPLICATION_PATH . '/controllers/!locked/index_' . $starter->s_default_view . '.php' ;
				}
			}
		}
	}
	foreach($starter->meta as $key => $val) 
		$a_meta[$key] = htmlentities($val) ;

// META
$starter->meta['title'] = (empty($starter->meta['title']) ? (!empty($starter->meta['detail_title']) ? $starter->meta['detail_title'] : $starter->meta['config_meta_title']) : '');
$starter->meta['description'] = (empty($starter->meta['description']) ? (!empty($starter->meta['detail_description']) ? $starter->meta['detail_description'] : $starter->meta['config_meta_description']) : '');
$starter->meta['image'] = (empty($starter->meta['config_meta_image']) ? $starter->meta['config_meta_image'] : '');

	// output rel files

	$_SESSION['rel']['js'] = $starter->a_js;

	$_SESSION['rel']['css'] = $starter->a_css;

	if(is_array($starter->a_include_pages) && $starter->utils->is__countable($starter->a_include_pages) && count($starter->a_include_pages) > 0)
	{
		if($starter->iscache && $starter->cache && (!isset($modif_ago) || $modif_ago < $starter->cacheTime))
		{
			ob_start();
			foreach($starter->a_include_pages as $key => $val)
			{
				if(!$starter->b_curl) 
					$s_cache_template 		= 	file_get_contents(APPLICATION_PATH . '/' . $val) ;
				else
					$s_cache_template 		= 	$starter->utils->curl_load(APPLICATION_PATH . '/' . $val) ;
					
				print eval('?>'. $s_cache_template);
				
			}
			if($starter->iscache && $starter->cache)
			{
				$xHTML = ob_get_contents();
				ob_end_clean();
				if(!is_dir(APPLICATION_PATH . '/../cache/' . $starter->s_lang . '/' .(!empty($starter->s_level1) ? '/' . $starter->s_level1 : '/home') . (isset($starter->s_level2) && !empty($starter->s_level2) ? '/' . $starter->s_level2 : '') . (isset($starter->s_level3) && !empty($starter->s_level3) ? '/' . $starter->s_level3 : '') . (isset($starter->s_level4) && !empty($starter->s_level4) ? '/' . $starter->s_level4 : '') . (isset($starter->s_level5) && !empty($starter->s_level5) ? '/' . $starter->s_level5 : '')))
					mkdir(APPLICATION_PATH . '/../cache/' . $starter->s_lang . '/' .(!empty($starter->s_level1) ? '/' . $starter->s_level1 : '/home') . (isset($starter->s_level2) && !empty($starter->s_level2) ? '/' . $starter->s_level2 : '') . (isset($starter->s_level3) && !empty($starter->s_level3) ? '/' . $starter->s_level3 : '') . (isset($starter->s_level4) && !empty($starter->s_level4) ? '/' . $starter->s_level4 : '') . (isset($starter->s_level5) && !empty($starter->s_level5) ? '/' . $starter->s_level5 : ''), 0644, true);
				if(!$_cache)
					$_cache = APPLICATION_PATH . '/../cache/' . $starter->s_lang . '/' .(!empty($starter->s_level1) ? '/' . $starter->s_level1 : '/home') . (isset($starter->s_level2) && !empty($starter->s_level2) ? '/' . $starter->s_level2 : '') . (isset($starter->s_level3) && !empty($starter->s_level3) ? '/' . $starter->s_level3 : '') . (isset($starter->s_level4) && !empty($starter->s_level4) ? '/' . $starter->s_level4 : '') . (isset($starter->s_level5) && !empty($starter->s_level5) ? '/' . $starter->s_level5 : '') . '/index.cache';	
				$fichier = fopen($_cache, 'w+');

			    fwrite($fichier, $xHTML);
			    fclose($fichier);
			}
		}
	}
}
if($starter->iscache && isset($_cache) && $_cache != false && isset($modif_ago) && $modif_ago < $starter->cacheTime)
{
	$output_cache = file_get_contents($_cache);
	// On affiche le cache
	echo $output_cache;
}else
	foreach($starter->a_include_pages as $key => $val){
		if(is_file(APPLICATION_PATH . $val))
			include APPLICATION_PATH . $val ;
	}	

// stats

if($starter->s_default_view == 'frontoffice' && isset($starter->mods['stats'])) {
	require_once APPLICATION_PATH . '/modules/special/stats/controllers/index.php' ;
}
?>
