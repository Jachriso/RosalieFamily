<?php

class Utils extends Starter {
	
	public 		$default_pattern 			= '/';
	public 		$s_page_tag 				= "page_{TAG_PAGE}";
	public 		$headersError 				= true;
	public 		$pictos 					= array();
	
	public function __construct(){
	}
	
	public function customDump($content, $title=""){
	    echo '<div style="padding:10px;margin:10px;background:#EEEEEE"><pre><p>'.$title.'</p>';
	    print_r($content);
	    echo '</pre></div>';
	}
	
	public function fonctionComparaison($a, $b){
	    return $a['name'] > $b['name'] ? 1 : 0;
	}

	public function file_listing($path = '', $includepath = ''){
		$aFiles = array();
		if(is_dir($path))
		{
			$dir = opendir($path); 
			while($file = readdir($dir))
				if($file != '.' && $file != '..' && !is_dir($path.$file)) 
					$aFiles[] = (!empty($includepath) ? $includepath : '') . $file;
			closedir($dir);
			return $aFiles;
		}
		return array();
	}

	public function logGenerator($s_query, $values){
		$fichier = fopen(dirname( __FILE__ ) . '/../log/database/' . date("Y-m-d") . '.txt' , 'a+');
		fwrite($fichier, $_SESSION['user_info']['user_id'] . " : " . htmlspecialchars($s_query) . ' ' . $values);
		fclose($fichier);
	}
	public function delTree($current_dir, $except = 'cache') {
	    if($dir = @opendir($current_dir)) {
            while (($f = readdir($dir)) !== false) {
                if($f > '0' and filetype($current_dir.$f) == "file") {
                    unlink($current_dir.$f);
                } elseif($f > '0' and filetype($current_dir.$f) == "dir") {
                    $this->delTree($current_dir.$f."\\");
                }
            }
            closedir($dir);     
			if(basename(parse_url($current_dir, PHP_URL_PATH)) != $except)
	            rmdir($current_dir);
        }
	}


	public function password_hash($password, $salt) {
		$hash = hash('sha512', $password.$salt);
		/*$hash = sha1($password.$salt);*/
		return $hash;
	}
	
	public function password_verify($givenPassword, $salt, $existingPasswordHash, $s_date = '') {
		$hash = hash('sha512', $givenPassword.$salt);
		/*$hash = sha1($givenPassword.$salt);*/

		//exit($hash);
		return ($hash === $existingPasswordHash);
	}
	
	public function curl_load($url){
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);

	    //return the transfer as a string
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

	    // $output contains the output string
	    $response = curl_exec($ch);
		curl_close($ch);
		
		return $response;
	}
	
	public function generateRandomString($length = 10) {
		
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}

	public function displayBytesLabel($i_bytes)
	{
		$a_ext = array('bytes', 'Kb', 'Mb', 'Gb');
		$i_step = $i_bytes ;
		$s_return = '' ;
		for($i = 0; $i < count($a_ext); $i++){
			$i_step = $i_step / 1024 ;
			if($i_step < 1024) {
				$s_return = number_format($i_step, 2, '.', ' ') . ' ' . $a_ext[$i+1] ;
				$s_return = str_replace('.00', '', $s_return);
				return $s_return ;
			}
		}
	}
	
	public function displayUploadErrors($i_error = 4)
	{
		global $starter;
		
		$a_errors = array(
			'error_code'		=>	$i_error,
			'error_label'		=>	''
		);
		switch($i_error){
		
			case 0 :	
				$a_errors['error_label'] = $starter->_get_lexique("réussi");
			break;
			
			case 1 :
				$a_errors['error_label'] = $starter->_get_lexique("Le poids du fichier excède le poids autorisé");
			break;
			
			case 2 :
				$a_errors['error_label'] = $starter->_get_lexique("Le poids du fichier excède le poids autorisé");
			break;
			
			case 3 :
				$a_errors['error_label'] = $starter->_get_lexique("Echec du téléchargement");
			break;
			
			case 4 :
				$a_errors['error_label'] = $starter->_get_lexique("Aucun fichier téléchargé");
			break;
		
		}
		return $a_errors;
	}
	
	
	public function xtTraiter($s_string = '')
	{
		$s_string = str_replace("/","",$s_string);
		$s_string = str_replace(":","",$s_string);
		$s_string = str_replace(" ","_",$s_string);
		$s_string = str_replace(".","_",$s_string);
		$s_string = strtr($s_string,array("à"=>"a", "â"=>"a", "ä"=>"a", "î"=>"i", "ï"=>"i", "ô"=>"o", "ö"=>"0", "ù"=>"u", "û"=>"u", "ü"=>"u", "É"=>"e", "é"=>"e", "è"=>"e", "ê"=>"e", "ë"=>"e", "ç"=>"c"));
		$s_string = strtolower($s_string);
		$s_string = preg_replace("#[^a-z0-9_:.~\\\/]#","",$s_string);
		$s_string = stripslashes($s_string);
		return $s_string ;
	}

	public function word_wrap_cut($s_string = '', $i_limit = 200, $i_wrap_limit = 26, $s_wrap_separator = " ")
	{
		if(strlen($s_string) > $i_limit && $i_limit > 0)
		{
			$s_string = substr($s_string, 0, $i_limit);
			$i_limit = strrpos($s_string, ' ');
			if($i_limit > 0)
				$s_string = substr($s_string, 0, $i_limit);
			$s_string .= ' ...' ;
		$s_string = wordwrap($s_string, $i_wrap_limit, $s_wrap_separator, true);
		}
		return $s_string ;
	}
	
	public function not_found_page($b_strict = false)
	{
		global $starter;
		if(isset($_SERVER['HTTP_REFERER']) && preg_match("#google#", $_SERVER['HTTP_REFERER']) && !$b_strict) 
		{
			header("HTTP/1.1 301 Moved Permanently");
			header("Location:" . parent::HTTP_ROOT);
		}
		else 
		{
			header("HTTP/1.0 404 Not Found");
			header('Content-Type: text/html; charset=utf-8');
		    require_once APPLICATION_PATH . '/modules/errors/controllers/index.php';
		}
	}

    public function myErrorHandler($errno, $errstr, $errfile, $errline) {
	    if (!(error_reporting() & $errno)) {
	        // This error code is not included in error_reporting
	        return;
	    }

	    switch ($errno) {
	        case E_USER_ERROR:
		        echo "<p style=\"padding:10px\"><b>My ERROR</b> [$errno] $errstr<br />\n";
		        echo "  Fatal error on line $errline in file $errfile";
		        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
		        echo "Aborting...<br /></p>\n";
		        exit(1);
	        break;

		    case E_USER_WARNING:
		        echo "<p style=\"padding:10px\"><b>My WARNING</b> [$errno] <span style=\"color: #D9104E;\"> $errstr</span><br /></p>\n";
		    break;

		    case E_USER_NOTICE:
		        echo "<p style=\"padding:10px\"><b>My NOTICE</b> [$errno]<span style=\"color: #D9104E;\"> $errstr</span><br /></p>\n";
		    break;

		    default:
		        echo "<p style=\"padding:10px\"><b>Unknown error type</b>: [$errno] <span style=\"color: #D9104E;\"> $errstr</span><br /></p>\n";
		    break;
	    }

	    /* Don't execute PHP internal error handler */
	    return true;
	}
	
	public function set_nav($i_current_page = 1, $i_nb_pages = 1, $s_link_root = '', $a_uri_GET = '')
	{
		global $starter;
		$a_pages = array();
		$a_data = array();
		if($i_nb_pages > 1)
		{
			// pages
			for($i = 1; $i <= $i_nb_pages; $i++)
			{
				$_tmp = $s_link_root ;
				$a_data[$i] = array(
					'label'	=>	$i,
					'uri'	=>	$_tmp . ($i > 1 ? str_replace('{TAG_PAGE}', $i, '&navpage=' . $this->s_page_tag) : ''),
					'type'	=>	($i != $i_current_page ? 'link' : 'normal'),
					'class'	=>	($i != $i_current_page ? '' : 'active')
				);
			}
			
			$a_data[0] = array(
					'label'	=>	'<<',
					'uri'	=>	$_tmp ,
					'class' => ($i_current_page > 1 ? '' : ''),
					'class_a' => ($i_current_page > 1 ? '' : ''),
					'type'	=>	($i_current_page > 1 ? 'link' : 'normal')
			);
			$a_data[$i_nb_pages + 1] = array(
					'label'	=>	'>>',
					'uri'	=>	(isset($a_data[$i_nb_pages]) ? $a_data[$i_nb_pages]['uri'] : $a_data[$i_nb_pages]['uri']),
					'class' => ($i_current_page < $i_nb_pages ? '' : 'next'),
					'class_a' => ($i_current_page < $i_nb_pages ? 'next' : ''),
					'type'	=>	($i_current_page < $i_nb_pages ? 'link' : 'normal')
			);
			ksort($a_data);
			foreach($a_data as $key => $val)
			{
				if($key == 0 || $key == ($i_nb_pages + 1) || ($key >= ($i_current_page - 2) && $key <= ($i_current_page + 2)))
				{
					$s_pages = '<li' . (isset($val['class']) ? ' class="' . $val['class'] .'"' : '' ) . '>';
					if($val['type'] == 'link') $s_pages .= '<a class="page ' . (isset($val['class_a']) ? $val['class_a'] : '' ) . '" href="'. $val['uri'] . '">' . $val['label'] . '</a>';
					else if($val['class'] == 'active') $s_pages .= '<a class="page" href="javascript:void(0);">' . $val['label'] . '</a>';
					else $s_pages .= '<span>' . $val['label'] . '</span>';
					$s_pages .= '</li>';
					$a_pages[] = $s_pages ;
				}
			}
			
			return $a_pages ;
		}
	}
	
	public function load_file($file = '', $basehref = "")
	{
		if(!is_file(dirname(__FILE__) . '/../web/content/' . $file)) return 'https://dummyimage.com/300x300/000/FFF';
		else return $basehref . $file;
	}
	
	function parseTweet($text) 
	{
		$text = preg_replace('#http://[a-z0-9._/-]+#i', '$0', $text); //Liens
		$text = preg_replace('#@([a-z0-9_]+)#i', '@$1', $text); //pseudos
		$text = preg_replace('# \#([a-z0-9_-]+)#i', ' #$1', $text); //Hashtags
		$text = preg_replace('#https://[a-z0-9._/-]+#i', '$0', $text); //Liens
		return $text;
	}

	function getHolidays($year = null)
	{
  		if ($year === null)
			$year = intval(date('Y'));
		 
		$easterDate  = easter_date($year);
		$easterDay   = date('j', $easterDate);
		$easterMonth = date('n', $easterDate);
		$easterYear   = date('Y', $easterDate);

		$holidays = array(
			// Dates fixes
			mktime(0, 0, 0, 1,  1,  $year),  // 1er janvier
			mktime(0, 0, 0, 5,  1,  $year),  // Fête du travail
			mktime(0, 0, 0, 5,  8,  $year),  // Victoire des alliés
			mktime(0, 0, 0, 7,  14, $year),  // Fête nationale
			mktime(0, 0, 0, 8,  15, $year),  // Assomption
			mktime(0, 0, 0, 11, 1,  $year),  // Toussaint
			mktime(0, 0, 0, 11, 11, $year),  // Armistice
			mktime(0, 0, 0, 12, 25, $year),  // Noel

			// Dates variables
			mktime(0, 0, 0, $easterMonth, $easterDay + 2,  $easterYear),
			mktime(0, 0, 0, $easterMonth, $easterDay + 40, $easterYear),
			mktime(0, 0, 0, $easterMonth, $easterDay + 50, $easterYear),
		);

		sort($holidays);

		return $holidays;
	}	
	
	public function getHttpProtocol() {
		if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
		  if ($_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
			return 'https';
		  }
		  return 'http';
		}
		/*apache + variants specific way of checking for https*/
		if (isset($_SERVER['HTTPS']) &&
			($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] == 1)) {
		  return 'https';
		}
		/*nginx way of checking for https*/
		if (isset($_SERVER['SERVER_PORT']) &&
			($_SERVER['SERVER_PORT'] === '443')) {
		  return 'https';
		}
		return 'http';
	  }

	public  function getFullUrl() 
	{
	    if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS'])){
	    	$https = strlen($_SERVER['HTTPS']) != 0 && $_SERVER['HTTPS'] !== 'off';
	    }
	    $https="";
	    return ($https ? 'https://' : 'http://') . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] . ($https && $_SERVER['SERVER_PORT'] === 443 || $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) . substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
	}


	public function findString($text,$wordToSearch)
	{
	    $offset=0;
	    $pos=0;
	    while (is_integer($pos)){
	        $pos = strpos($text,$wordToSearch,$offset);
	        if (is_integer($pos)) {
	            $arrPos[] = $pos;
	            $offset = $pos+strlen($wordToSearch);
	        }
	    }
	    if (isset($arrPos)) {
	        return 1;
	    }
	    else {
	        return 0;
	    }
	}

	public function getmeta($i_level = 0){
		
		global $menu, $starter;
		$starter->meta['title'] = '';
		$starter->meta['description'] = '';
		$starter->meta['image'] = '';

		if(isset($menu) && count($menu->menu) > 0)
		{
			$starter->meta['title'] = (!empty($menu->current[$i_level]['detail_metatitle']) ? $menu->current[$i_level]['detail_metatitle'] : (!empty($starter->meta['detail_title']) ? $starter->meta['detail_title'] : (!empty($starter->meta['config_meta_title']) ? $starter->meta['config_meta_title'] : '')));
		
			$starter->meta['description'] = (!empty($menu->current[$i_level]['detail_metadesc']) ? $menu->current[$i_level]['detail_metadesc'] : (!empty($starter->meta['detail_description']) ? $starter->meta['detail_description'] : (!empty($starter->meta['config_meta_description']) ? $starter->meta['config_meta_description'] : '')));

			$starter->meta['image'] = (!empty($starter->meta['config_meta_image']) ? $starter->meta['config_meta_image'] : '');
		}
	}

	public function is__countable($var) {
        return (is_array($var) || $var instanceof Countable);
    }
    public function format_date($s_pattern = 'YYYY-mm-dd-HH-ii-ss', $s_date = '', $verbose = true, $separator = '.')
	{
		global $starter;
		$s_pattern = substr($s_pattern, 0, 19) ;
		$s_return = '' ;
		$a_lib = array(
					   'YYYY' 	=> array(0, 4),
					   'mm' 	=> array(5, 2),
					   'dd' 	=> array(8, 2),
					   'HH' 	=> array(11, 2),
					   'ii' 	=> array(14, 2),
					   'ss' 	=> array(17, 2),
					   'rdd'  => array(0,2),
					   'rmm'  => array(3,2),
					   'rYYYY'  => array(6,4),
				);
		$a_pattern = explode('-', $s_pattern) ;
		if(!empty($s_date))
			foreach($a_pattern as $key => $val)
			{
				if(!empty($val)){
					$_tmp = substr($s_date, $a_lib[$val][0], $a_lib[$val][1]) ;
					/*if(intval($_tmp) > 0)
					{*/
						if($val == 'mm' && isset($starter->month[intval($_tmp) -1]) && $verbose) $s_return .= $starter->month[intval($_tmp) -1] . ' ' ;
						else if($val === 'HH') $s_return .= $_tmp . 'h' ;
						else if($val === 'hh') $s_return .= $starter->database->get_lexique('à ') . ' ' . $_tmp . 'h' ;
						else  $s_return .= $_tmp . $separator ;
					}
					//}
			}
		
		$s_return = substr($s_return, 0, -1);
		return $s_return ;
	}

	public function addTpl($mytpl = array()) {

		global $starter;
		
		$type = $mytpl['type'];
		$s_tpl_file = (isset($mytpl['file']) ? $mytpl['file'] : '');
		$s_tpl_file_svg = (isset($mytpl['file_svg']) ? $mytpl['file_svg'] : '');
		$s_template = '';
		$context = stream_context_create(
		    array(
		        "http" => array(
		            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
		        )
		    )
		);

		switch($type){
			default :
			case 'code':
				if(!empty($s_tpl_file)){
					if(!isset($this->pictos[$s_tpl_file])){
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file];
				}elseif(!empty($s_tpl_file_svg)){
					if(!isset($this->pictos[$s_tpl_file_svg])){
						$s_template = $s_tpl_file_svg;
					}else
						$s_template = $this->pictos[$s_tpl_file_svg];
				}

				if(isset($mytpl["inline_type"]) && !empty($mytpl["inline_type"])){
					if(!isset($this->pictos[$mytpl["inline_type"]])){
						if(!$starter->b_curl)
							$svg_template = file_get_contents($mytpl["inline_type"], false, $context);
						else
							$svg_template = $starter->utils->curl_load($mytpl["inline_type"]) ;
					}else
						$svg_template = $this->pictos[$mytpl["inline_type"]];

					$s_template = preg_replace("#{SVG}#", $svg_template, $s_template);
				}elseif(isset($mytpl["inline_type_svg"]) && !empty($mytpl["inline_type_svg"])){
					if(!isset($this->pictos[$mytpl["inline_type_svg"]])){
						$svg_template = $mytpl["inline_type_svg"] ;
					}else
						$svg_template = $this->pictos[$mytpl["inline_type_svg"]];

					$s_template = preg_replace("#{SVG}#", $svg_template, $s_template);
				}else
					$s_template = preg_replace("#{SVG}#", '', $s_template);

				if(isset($mytpl['BUTTON'])){
					$s_template = preg_replace("#{BUTTON}#", $mytpl['BUTTON'], $s_template);
				}

				if(isset($mytpl['NAME'])){
					$s_template = preg_replace("#{NAME}#", $mytpl['NAME'], $s_template);
				}

				foreach($mytpl['content'] AS $key => $val){
					$s_template = preg_replace("#{".$key."}#", $val, $s_template);
				}
			break;

			case 'file':
				$s_template = '<img class="'.(isset($mytpl["CLASS"]) ? $mytpl["CLASS"] : '').'" src=' . $s_tpl_file . ' width="'.(isset($mytpl["width"]) ? $mytpl["width"] : '').'" height="'.(isset($mytpl["height"]) ? $mytpl["height"] : '').'" style="'.(isset($mytpl["style"]) ? $mytpl["style"] : '').'"/>';
			break;
		}
		
		return $s_template;
	}

	public function addAccordion($a_accordion = array()) {

		global $starter;
		$context = stream_context_create(
		    array(
		        "http" => array(
		            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
		        )
		    )
		);
		
		$s_template = '';
		foreach($a_accordion['steps'] AS $key => $val){
			if(count($val) > 0){
				$s_tpl_file = $a_accordion['file'];
				if(!isset($this->pictos[$s_tpl_file])){
					if(!$starter->b_curl)
						$s_template .= file_get_contents($s_tpl_file, false, $context);
					else
						$s_template .= $starter->utils->curl_load($s_tpl_file) ;
				}else
					$s_template = $this->pictos[$s_tpl_file];

				$s_template = preg_replace("#{X}#", $key, $s_template);			
				$s_template = preg_replace("#{STATUS}#", isset($val['STATUS']) ? $val['STATUS'] : '', $s_template);

				if(isset($val['warning'])){
					if(!isset($this->pictos[$val['warning']["file"]])){
						if(!$starter->b_curl)
							$svg_template = file_get_contents($val['warning']["file"], false, $context);
						else
							$svg_template = $starter->utils->curl_load($val['warning']["file"]) ;
					}else
						$svg_template = $this->pictos[$val['warning']["file"]] ;

					$s_template = preg_replace("#{SVGWARNING}#", $svg_template, $s_template);
					$s_template = preg_replace("#{SVGCLASS}#", $val['warning']['SVGCLASS'], $s_template);
					$s_template = preg_replace("#{FILLCLASS}#", $val['warning']['FILLCLASS'], $s_template);
				}else
					$s_template = preg_replace("#{SVGWARNING}#", "", $s_template);

				if(isset($val['svg'])){
					if(isset($val['svg']["file"])){
						if(!isset($this->pictos[$val['svg']["file"]])){
							if(!$starter->b_curl)
								$svg_template = file_get_contents($val['svg']["file"], false, $context);
							else
								$svg_template = $starter->utils->curl_load($val['svg']["file"]) ;
						}else
							$svg_template = $this->pictos[$val['svg']["file"]] ;
					}elseif(isset($val['svg']["file_svg"])){
						if(!isset($this->pictos[$val['svg']["file_svg"]])){
							$svg_template = $val['svg']["file_svg"] ;
						}else
							$svg_template = $this->pictos[$val['svg']["file_svg"]] ;
					}

					$svg_template = preg_replace("#{SVGCLASS}#", $val['svg']['SVGCLASS'], $svg_template);
					$svg_template = preg_replace("#{FILLCLASS}#", $val['svg']['FILLCLASS'], $svg_template);
					
					$s_template = preg_replace("#{SVG}#", $svg_template, $s_template);
				}else{
					$s_template = preg_replace("#{SVG}#", "", $s_template);
				}
				$s_template = preg_replace("#{LABEL}#", $val['LABEL'], $s_template);
				$s_template = preg_replace("#{COUNT}#", !empty($val['COUNT']) ? '('.$val['COUNT'].')' : '', $s_template);
				$s_template = preg_replace("#{DESCRIPTION}#", $val['DESCRIPTION'], $s_template);
				$s_template = preg_replace("#{BODYCLASS}#", $val['BODYCLASS'], $s_template);

				$title_template = '';
				if(isset($val['titles']['steps']) && count($val['titles']['steps']) > 0){
					foreach($val['titles']['steps'] AS $_key => $_val){
						$s_tpl_file = $val['titles']['file'];
						if(!isset($this->pictos[$s_tpl_file])){
							if(!$starter->b_curl)
								$title_template .= file_get_contents($s_tpl_file, false, $context);
							else
								$title_template .= $starter->utils->curl_load($s_tpl_file) ;
						}else
							$title_template .= $this->pictos[$s_tpl_file] ;

						$title_template = preg_replace("#{WIDTH}#", $_val['WIDTH'], $title_template);
						$title_template = preg_replace("#{LABEL}#", $_val['LABEL'], $title_template);
					}
				}
				$s_template = preg_replace("#{ACCORDION_TITLES}#", $title_template, $s_template);
				$content_template = '';
				if(isset($val['contents']['steps']) && count($val['contents']['steps']) > 0){
					foreach($val['contents']['steps'] AS $_key => $_val){
						$content_template .= '<div></div><div class="brad10 backWhite pad20 margV5 inlineb blocLink relative" data-link="{LINK}" data-status="{STATUS}">';
						$s_tpl_file = $val['contents']['file'];
						if(!isset($this->pictos[$s_tpl_file])){
							if(!$starter->b_curl)
								$_content_template = file_get_contents($s_tpl_file, false, $context);
							else
								$_content_template = $starter->utils->curl_load($s_tpl_file) ;
						}else
							$_content_template = $this->pictos[$s_tpl_file] ;

						foreach($_val['steps'] AS $__val){
							$content_template .= $_content_template;
							
							if(isset($__val['svg'])){
								if(isset($val['__val']["file"])){
									if(!isset($this->pictos[$val['__val']["file"]])){
										if(!$starter->b_curl)
											$svg_template = file_get_contents($__val['svg']["file"], false, $context);
										else
											$svg_template = $starter->utils->curl_load($val['__val']["file"]) ;
									}else
										$svg_template = $this->pictos[$val['__val']["file"]] ;
								}if(isset($val['__val']["file_svg"])){
									if(!isset($this->pictos[$val['__val']["file_svg"]])){
										$svg_template = $val['__val']["file_svg"] ;
									}else
										$svg_template = $this->pictos[$val['__val']["file_svg"]] ;
								}
								$svg_template = preg_replace("#{SVGCLASS}#", $__val['svg']['SVGCLASS'], $svg_template);
								$svg_template = preg_replace("#{FILLCLASS}#", $__val['svg']['FILLCLASS'], $svg_template);
								
								$content_template = preg_replace("#{SVG}#", $svg_template, $content_template);
							}else{
								$content_template = preg_replace("#{SVG}#", "", $content_template);
							}

							$content_template = preg_replace("#{LINK}#", $_val['LINK'], $content_template);
							$content_template = preg_replace("#{STATUS}#", isset($_val['STATUS']) ? $_val['STATUS'] : '', $content_template);
							$content_template = preg_replace("#{WIDTH}#", $__val['WIDTH'], $content_template);
							$content_template = preg_replace("#{LABELBEFORE}#", $__val['LABELBEFORE'], $content_template);
							$content_template = preg_replace("#{LABELAFTER}#", $__val['LABELAFTER'], $content_template);
						}
						$content_template .= "</div>";
					}
				}
				$s_template = preg_replace("#{ACCORDION_CONTENT}#", $content_template, $s_template);
			}
		}

		return $s_template;
	}

	public function addForm($a_form = array(), $a_data = array()) {

		global $starter;
		$output = '';
		$a_output = array();
		$context = stream_context_create(
		    array(
		        "http" => array(
		            "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
		        )
		    )
		);
		if(isset($a_form['groups'])){
			foreach($a_form['groups'] AS $key => $field){
				$s_template = '';
				$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/title/title.phtml';
				
				if(!isset($this->pictos[$s_tpl_file])){
					if(!$starter->b_curl)
						$s_template = file_get_contents($s_tpl_file, false, $context);
					else
						$s_template = $starter->utils->curl_load($s_tpl_file) ;
				}else
					$s_template = $this->pictos[$s_tpl_file] ;

				$s_template = preg_replace("#{LABEL}#", $field, $s_template);

				$a_output[$key]['label'] = $s_template;
			}
		}
		$i_section = 0;
		foreach($a_form['fields'] AS $key => $field){
			$s_template = '';
			switch($field['type']){
				case 'checkbox':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/checkbox/checkbox.phtml';
				
					if(!isset($this->pictos[$s_tpl_file])){		
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/checkbox/checkbox_content.phtml';
					$s_template_field = '';
					
					foreach($field['data'] AS $data => $value){
						if(!isset($this->pictos[$s_tpl_file])){	
							if(!$starter->b_curl)
								$s_template_field .= file_get_contents($s_tpl_file, false, $context);
							else
								$s_template_field .= $starter->utils->curl_load($s_tpl_file) ;
						}else
							$s_template_field = $this->pictos[$s_tpl_file] ;

						$s_template_field = preg_replace("#{FIELD_ID}#", $field['field'].$data, $s_template_field);
						$s_template_field = preg_replace("#{FIELD}#", $field['field'], $s_template_field);
						$s_template_field = preg_replace("#{CLASS}#", $field['dataclass'], $s_template_field);
						$s_template_field = preg_replace("#{CHECKED}#", (isset($_POST[$field['field']]) && $_POST[$field['field']] == $data ? "checked" : (isset($_GET[$field['field']]) && $_GET[$field['field']] == $data ? "checked" : (isset($a_data[$field['field']]) && $a_data[$field['field']] == $data ? "checked" : '' ))), $s_template_field);
						$s_template_field = preg_replace("#{VALUE}#", $data, $s_template_field);
						$s_template_field = preg_replace("#{DATA}#", $value, $s_template_field);
					}

					$s_template = preg_replace("#{CONTENT}#", $s_template_field, $s_template);
					
				break;

				case 'date':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/date/date.phtml';
					
					if(!isset($this->pictos[$s_tpl_file])){			
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{PLACEHOLDER}#", (isset($field['placeholder']) ? $field['placeholder'] : ''), $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{VALUE}#", (isset($_POST[$field['field']]) ? $_POST[$field['field']] : (isset($a_data[$field['field']]) ? $a_data[$field['field']] : '' )), $s_template);
					$s_template = preg_replace("#{MAXLENGTH}#", (isset($field['maxlength']) ? $field['maxlength'] : ''), $s_template);
					$s_template = preg_replace("#{MINLENGTH}#", (isset($field['minlength']) ? $field['minlength'] : ''), $s_template);
					$s_template = preg_replace("#{MIN}#", (isset($field['min']) ? $field['min'] : ''), $s_template);
					$s_template = preg_replace("#{MAX}#", (isset($field['max']) ? $field['max'] : ''), $s_template);
					
				break;

				case 'dropzone':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/dropzone/dropzone.phtml';
					
					if(!isset($this->pictos[$s_tpl_file])){			
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{INFO}#", $field['info'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{BLOCCLASS}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " blocMandatory" : ''), $s_template);
					$s_template = preg_replace("#{MANDATORY}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " mandatoryfield" : ''), $s_template);
					$s_template = preg_replace("#{MAXFILE}#", $field['maxfile'], $s_template);
					$s_template = preg_replace("#{FILESIZE}#", $field['maxSize'], $s_template);
					$s_template = preg_replace("#{DROPCOLOR}#", isset($field['dropcolor']) ? $field['dropcolor'] : '', $s_template);
					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{VALUE}#", (isset($_POST[$field['field']]) ? $_POST[$field['field']] : (isset($a_data[$field['field']]) ? $a_data[$field['field']] : '' )), $s_template);

					if(isset($a_data[$field['field']])){
						$content = explode(',',$a_data[$field['field']]);
						if( count($content) >= $field['maxfile'] && !empty($content[0])){
							$s_template = preg_replace("#{MAXFILESREACHED}#", "dz-max-files-reached", $s_template);
						}
					}

					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/dropzone/dropzone_content.phtml';
					$s_template_field = '';
					$dropcontent = array();
					if(isset($_POST[$field['field']]) && !empty($_POST[$field['field']]))
						$dropcontent =  explode(',',$_POST[$field['field']]);
					elseif(isset($a_data[$field['field']]) && !empty($a_data[$field['field']]))
						$dropcontent =  explode(',',$a_data[$field['field']]);

					if(count($dropcontent)>0){
						foreach($dropcontent AS $value){
							if(!isset($this->pictos[$s_tpl_file])){
								if(!$starter->b_curl)
									$s_template_field .= file_get_contents($s_tpl_file, false, $context);
								else
									$s_template_field .= $starter->utils->curl_load($s_tpl_file) ;							
							}else
								$s_template_field = $this->pictos[$s_tpl_file] ;

							$s_template_field = preg_replace("#{IDDROP}#", $value, $s_template_field);
							$s_template_field = preg_replace("#{FILENAME}#", $value, $s_template_field);
						}
					}
					$s_template = preg_replace("#{CONTENT}#", $s_template_field, $s_template);

				break;

				case 'number':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/number/number.phtml';
					
					if(!isset($this->pictos[$s_tpl_file])){	
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{FIELDLENGTH}#", (isset($field['fieldlength']) ? $field['fieldlength'] : ''), $s_template);
					$s_template = preg_replace("#{PLACEHOLDER}#", (isset($field['placeholder']) ? $field['placeholder'] : ''), $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{BLOCCLASS}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " blocMandatory" : ''), $s_template);
					$s_template = preg_replace("#{MANDATORY}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " mandatoryfield" : ''), $s_template);
					$s_template = preg_replace("#{VALUE}#", (isset($_POST[$field['field']]) ? $_POST[$field['field']] : (isset($a_data[$field['field']]) ? $a_data[$field['field']] : '' )), $s_template);
					$s_template = preg_replace("#{MAXLENGTH}#", (isset($field['maxlength']) ? $field['maxlength'] : ''), $s_template);
					$s_template = preg_replace("#{MINLENGTH}#", (isset($field['minlength']) ? $field['minlength'] : ''), $s_template);
					$s_template = preg_replace("#{STEP}#", (isset($field['step']) ? $field['step'] : ''), $s_template);
					$s_template = preg_replace("#{VERIFNUMBER}#", (isset($field['verifnumber']) ? "this.value=this.value.replace(/[^0-9]/g,'');" : ''), $s_template);
					$s_template = preg_replace("#{MAXCHAR}#", (isset($field['maxchar']) ? 'if(this.value.length>='.$field['maxchar'].') { this.value = this.value.slice(0,'.$field['maxchar'].'); }' : ''), $s_template);
					
				break;

				case 'password':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/password/password.phtml';
					
					if(!isset($this->pictos[$s_tpl_file])){	
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{PLACEHOLDER}#", (isset($field['placeholder']) ? $field['placeholder'] : ''), $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{VALUE}#", (isset($_POST[$field['field']]) ? $_POST[$field['field']] : (isset($a_data[$field['field']]) ? $a_data[$field['field']] : '' )), $s_template);
					$s_template = preg_replace("#{BLOCCLASS}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " blocMandatory" : ''), $s_template);
					$s_template = preg_replace("#{MAXLENGTH}#", (isset($field['maxlength']) ? $field['maxlength'] : ''), $s_template);
					$s_template = preg_replace("#{MANDATORY}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " mandatoryfield" : ''), $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					

					if(isset($field['options'])){
						foreach($field['options'] AS $info => $option){
							switch($option){
								case 'tooltip':
									$s_template = preg_replace("#{LABELCLASS}#", "has-tooltip", $s_template);
									$s_option = '<div class="meter"><div class="progress" id="password-strength-meter"></div><input type="hidden" value="" id="zxcvbn" name="zxcvbn" /></div><p class="tooltip">' . $starter->_get_lexique('Exigence : 12 caractères minimum, un caractère spécial, une miniscule, une majuscule et un chiffre.') . '</p>';
									$s_template = preg_replace("#{OPTIONS}#", $s_option, $s_template);
								break;
							}
						}	
					}else{
						$s_template = preg_replace("#{LABELCLASS}#", "", $s_template);
						$s_template = preg_replace("#{OPTIONS}#", "", $s_template);
					}

					
				break;

				case 'radio':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/radio/radio.phtml';
					
					if(!isset($this->pictos[$s_tpl_file])){
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{DATAVALUE}#", (isset($field['datavalue']) ? $field['datavalue'] : ''), $s_template);
					$s_template = preg_replace("#{DATALINKED}#", (isset($field['datalinked']) ? $field['datalinked'] : ''), $s_template);
					$s_template = preg_replace("#{BLOCCLASS}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " blocMandatory" : ''), $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/radio/radio_content.phtml';
					$s_template_field = '';
					
					foreach($field['data'] AS $data => $value){
						if(!isset($this->pictos[$s_tpl_file])){
							if(!$starter->b_curl)
								$s_template_field .= file_get_contents($s_tpl_file, false, $context);
							else
								$s_template_field .= $starter->utils->curl_load($s_tpl_file) ;
						}else
							$s_template_field = $this->pictos[$s_tpl_file] ;

						$s_js = '';
						if(isset($field['child'])){
							$s_js .= $field['child']['event'] .  '="';
							$functions = explode(',',$field['child']['action']);
							foreach($functions AS $function){
								$s_js .=  $function . '(\'' . $field['child']['field'] . '\', ' . $field['child']['key'] . (!empty($field['child']['conditions']) ? ', ' . $field['child']['conditions'] : '') . ');';
							}
							$s_js .= '"';
						}

						$s_template_field = preg_replace("#{JS}#", $s_js, $s_template_field);
						$s_template_field = preg_replace("#{FIELD_ID}#", $field['field'].$data, $s_template_field);
						$s_template_field = preg_replace("#{FIELD}#", $field['field'], $s_template_field);
						$s_template_field = preg_replace("#{CLASS}#", $field['dataclass'], $s_template_field);
						$s_template_field = preg_replace("#{CHECKED}#", (isset($_POST[$field['field']]) && $_POST[$field['field']] == $data ? "checked" : (isset($_GET[$field['field']]) && $_GET[$field['field']] == $data ? "checked" : (isset($field['linkedfield']) && isset($a_data[$field['linkedfield']]) && $a_data[$field['linkedfield']] == $data ? "checked" : (isset($a_data[$field['field']]) && $a_data[$field['field']] == $data ? "checked" : '' ) ))), $s_template_field);
						$s_template_field = preg_replace("#{VALUE}#", $data, $s_template_field);
						$s_template_field = preg_replace("#{DATA}#", $value, $s_template_field);
						$s_template_field = preg_replace("#{RADIOCLASS}#", (isset($field['RADIOCLASS']) ? $field['RADIOCLASS'] : ''), $s_template_field);
						$s_template_field = preg_replace("#{LINKED}#", (isset($field['linkedfield']) ? $field['linkedfield'] : ''), $s_template_field);
						$s_template_field = preg_replace("#{MANDATORY}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " mandatoryfield" : ''), $s_template_field);
						$s_template_field = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template_field);
					}

					$s_template = preg_replace("#{CONTENT}#", $s_template_field, $s_template);
					
				break;

				case 'select':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/select/select.phtml';
					
					if(!isset($this->pictos[$s_tpl_file])){
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{FIELDCLASS}#", $field['fieldclass'], $s_template);
					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{BLOCCLASS}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " blocMandatory" : ''), $s_template);
					$s_template = preg_replace("#{MANDATORY}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " mandatoryfield" : ''), $s_template);
					
					$s_js = '';
					if(isset($field['child'])){
						$s_js = $field['child']['event'] . '="' . $field['child']['action'] . '(\'' . $field['child']['field'] . '\', ' . $field['child']['key'] . ');" data-start="' . $field['child']['action'] . '(\'' . $field['child']['field'] . '\',' . $field['child']['key'] . ')"';
					}
					$s_template = preg_replace("#{JS}#", $s_js, $s_template);

					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/select/option.phtml';
					$s_template_field = '';
					foreach($field['data'] AS $data => $value){	
						if(!isset($this->pictos[$s_tpl_file])){			
							if(!$starter->b_curl)
								$s_template_field .= file_get_contents($s_tpl_file, false, $context);
							else
								$s_template_field .= $starter->utils->curl_load($s_tpl_file) ;
						}else
							$s_template_field = $this->pictos[$s_tpl_file] ;

						if(isset($field['parent'])){
							$s_template_field = preg_replace("#{DATAVALUE}#", $value['datavalue'], $s_template_field);
							$s_template_field = preg_replace("#{DATALINKED}#", $field['field'], $s_template_field);
							$s_template_field = preg_replace("#{VALUE}#", $data, $s_template_field);
							$s_template_field = preg_replace("#{LABEL}#", $value['label'], $s_template_field);
						}
						else{
							$s_template_field = preg_replace("#{DATAVALUE}#", '', $s_template_field);
							$s_template_field = preg_replace("#{VALUE}#", $data, $s_template_field);
							$s_template_field = preg_replace("#{LABEL}#", $value, $s_template_field);
						}

						if((isset($_GET[$field['field']]) && $_GET[$field['field']] == $data) || (isset($_POST[$field['field']]) && $_POST[$field['field']] == $data) || (isset($a_data[$field['field']]) && $a_data[$field['field']] == $data)){
							$s_template_field = preg_replace("#{SELECTED}#", 'selected="selected"', $s_template_field);
						}
						else{
							$s_template_field = preg_replace("#{SELECTED}#", '', $s_template_field);
						}
						
					}

					$s_template = preg_replace("#{CONTENT}#", $s_template_field, $s_template);
					
				break;

				case 'special_date':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/special_date/date.phtml';
					
					if(!isset($this->pictos[$s_tpl_file])){		
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{DATALINKED}#", $field['linkedfield'], $s_template);
					$s_template = preg_replace("#{PLACEHOLDER}#", (isset($field['placeholder']) ? $field['placeholder'] : ''), $s_template);
					$s_template = preg_replace("#{BLOCCLASS}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " blocMandatory" : ''), $s_template);
					$s_template = preg_replace("#{MANDATORY}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " mandatoryfield" : ''), $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['linkedfield']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{VALUE}#", (isset($_POST[$field['field']]) ? $_POST[$field['field']] : (isset($a_data[$field['field']]) ? $a_data[$field['field']] : '' )), $s_template);
					$s_template = preg_replace("#{MAXLENGTH}#", (isset($field['maxlength']) ? $field['maxlength'] : ''), $s_template);
					$s_template = preg_replace("#{MINLENGTH}#", (isset($field['minlength']) ? $field['minlength'] : ''), $s_template);
					$s_template = preg_replace("#{RADIOCLASS}#", (isset($field['RADIOCLASS']) ? $field['RADIOCLASS'] : ''), $s_template);
					$s_template = preg_replace("#{MIN}#", (isset($field['min']) ? $field['min'] : ''), $s_template);
					$s_template = preg_replace("#{MAX}#", (isset($field['max']) ? $field['max'] : ''), $s_template);

					foreach($field['data'] AS $data => $value){
						$s_template = preg_replace("#{FROM_ID}#", $field['linkedfield'].$data, $s_template);
						$s_template = preg_replace("#{FROM}#", $field['linkedfield'], $s_template);
						$s_template = preg_replace("#{CHECKED}#", (isset($_POST[$field['linkedfield']]) && $_POST[$field['linkedfield']] == $data ? "checked" : (isset($_GET[$field['linkedfield']]) && $_GET[$field['linkedfield']] == $data ? "checked" : (isset($a_data[$field['field']]) && !empty($a_data[$field['field']] && $a_data[$field['field']] != 1)  ? "checked" : '' ))), $s_template);
						
						$s_template = preg_replace("#{VALUEFROM}#", $data, $s_template);
						$s_template = preg_replace("#{DATA}#", $value, $s_template);
					}
					
				break;

				case 'text':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/text/text.phtml';
					
					if(!isset($this->pictos[$s_tpl_file])){	
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{DATAVALUE}#", (isset($field['datavalue']) ? $field['datavalue'] : ''), $s_template);
					$s_template = preg_replace("#{DATALINKED}#", (isset($field['datalinked']) ? $field['datalinked'] : ''), $s_template);
					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{BLOCCLASS}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " blocMandatory" : ''), $s_template);
					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{INFO}#", isset($field['info']) ? $field['info'] : '', $s_template);
					$s_template = preg_replace("#{ONKEYDOWN}#", (isset($field['onkeydown']) ? ($field['onkeydown'] == "alpha" ? "return /[a-z]/i.test(event.key)" : ($field['onkeydown'] == "alpha+" ? "return /[a-z-éèàçùîïöôû ]/i.test(event.key)" : '')) : ''), $s_template);
					$s_template = preg_replace("#{ONINPUT}#", (isset($field['oninput']) ? ($field['oninput'] == "tel" ? "this.value=this.value.replace(/[^0-9]/g,'');" : ($field['oninput'] == "num" ? "this.value=this.value.replace(/[^0-9]/g,'');" : '')) : ''), $s_template);
					$s_template = preg_replace("#{PLACEHOLDER}#", (isset($field['placeholder']) ? $field['placeholder'] : ''), $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{VALUE}#", (isset($_POST[$field['field']]) ? $_POST[$field['field']] : (isset($a_data[$field['field']]) ? $a_data[$field['field']] : '' )), $s_template);
					$s_template = preg_replace("#{MAXLENGTH}#", (isset($field['maxlength']) ? $field['maxlength'] : ''), $s_template);
					$s_template = preg_replace("#{MINLENGTH}#", (isset($field['minlength']) ? $field['minlength'] : ''), $s_template);
					$s_template = preg_replace("#{MANDATORY}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " mandatoryfield" : ''), $s_template);
					$s_template = preg_replace("#{DISPLAYMINLENGTH}#", (isset($field['ismaxlength']) && isset($field['ismaxlength']) && $field['ismaxlength'] ? '' : 'hide'), $s_template);
					$s_template = preg_replace("#{MAXLENGTHFIELD}#", (isset($field['ismaxlength']) && isset($field['ismaxlength']) && $field['ismaxlength'] ? 'maxlengthField' : ''), $s_template);

				break;

				case 'textarea':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/textarea/textarea.phtml';

					if(!isset($this->pictos[$s_tpl_file])){	
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{INFO}#", isset($field['info']) ? $field['info'] : '', $s_template);
					$s_template = preg_replace("#{PLACEHOLDER}#", (isset($field['placeholder']) ? $field['placeholder'] : ''), $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{VALUE}#", (isset($_POST[$field['field']]) ? $_POST[$field['field']] : (isset($a_data[$field['field']]) ? $a_data[$field['field']] : '' )), $s_template);
					$s_template = preg_replace("#{MAXLENGTH}#", (isset($field['maxlength']) ? $field['maxlength'] : ''), $s_template);
					$s_template = preg_replace("#{MAXLENGTHFIELD}#", (isset($field['maxlength']) ? 'maxlengthField' : ''), $s_template);

					$s_template = preg_replace("#{DISPLAYMINLENGTH}#", (isset($field['ismaxlength']) && isset($field['ismaxlength']) && $field['ismaxlength'] ? '' : 'hide'), $s_template);

				break;

				case 'textboxlist':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/textboxlist/text.phtml';
					
					if(!isset($this->pictos[$s_tpl_file])){	
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{INFO}#", isset($field['info']) ? $field['info'] : '', $s_template);
					if(!isset($_POST[$field['field']]) && (!isset($a_data[$field['field']]) || empty($a_data[$field['field']])) ){
						$s_template = preg_replace("#{PLACEHOLDER}#", (isset($field['placeholder']) ? $field['placeholder'] : ''), $s_template);
					}
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{VALUE}#", (isset($_POST[$field['field']]) ? $_POST[$field['field']] : (isset($a_data[$field['field']]) ? $a_data[$field['field']] : '' )), $s_template);
					$s_template = preg_replace("#{MAXLENGTH}#", (isset($field['maxlength']) ? $field['maxlength'] : ''), $s_template);
					$s_template = preg_replace("#{MINLENGTH}#", (isset($field['minlength']) ? $field['minlength'] : ''), $s_template);
					
				break;

				case 'tiny_mce':
					$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/tiny_mce/tiny_mce.phtml';

					if(!isset($this->pictos[$s_tpl_file])){		
						if(!$starter->b_curl)
							$s_template = file_get_contents($s_tpl_file, false, $context);
						else
							$s_template = $starter->utils->curl_load($s_tpl_file) ;
					}else
						$s_template = $this->pictos[$s_tpl_file] ;

					$s_template = preg_replace("#{FIELD}#", $field['field'], $s_template);
					$s_template = preg_replace("#{CLASS}#", $field['class'], $s_template);
					$s_template = preg_replace("#{LABEL}#", $field['label'], $s_template);
					$s_template = preg_replace("#{PLACEHOLDER}#", (isset($field['placeholder']) ? $field['placeholder'] : ''), $s_template);
					$s_template = preg_replace("#{ERROR}#", (isset($starter->checkForm->a_errors[$field['field']]) ? 'bloc_on_error' : ''), $s_template);
					$s_template = preg_replace("#{VALUE}#", (isset($_POST[$field['field']]) ? $_POST[$field['field']] : (isset($a_data[$field['field']]) ? $a_data[$field['field']] : '' )), $s_template);
					$s_template = preg_replace("#{MAXLENGTH}#", (isset($field['maxlength']) ? $field['maxlength'] : ''), $s_template);
					$s_template = preg_replace("#{MINLENGTH}#", (isset($field['minlength']) ? $field['minlength'] : ''), $s_template);
					$s_template = preg_replace("#{BLOCCLASS}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " blocMandatory" : ''), $s_template);
					$s_template = preg_replace("#{MANDATORY}#", (isset($field['verif']) && in_array("mandatory",$field['verif']) ? " mandatoryfield" : ''), $s_template);
					$s_template = preg_replace("#{DISPLAYMINLENGTH}#", (isset($field['ismaxlength']) && isset($field['ismaxlength']) && $field['ismaxlength'] ? '' : 'hide'), $s_template);
					$s_template = preg_replace("#{MAXLENGTHFIELD}#", (isset($field['ismaxlength']) && isset($field['ismaxlength']) && $field['ismaxlength'] ? 'maxlengthField' : ''), $s_template);
					
				break;
			}
			$s_template_section = '';
			if(isset($field['section']) && isset($field['sectionclass']) && $field['section'] > $i_section){
				$s_tpl_file = APPLICATION_PATH . '/modules/special/templates/FORM/separator/separator.phtml';
				if(!isset($this->pictos[$s_tpl_file])){		
					if(!$starter->b_curl)
						$s_template_section = file_get_contents($s_tpl_file, false, $context);
					else
						$s_template_section = $starter->utils->curl_load($s_tpl_file) ;
				}else
					$s_template_section = $this->pictos[$s_tpl_file] ;

				$s_template_section = preg_replace("#{CLASS}#", $field['sectionclass'], $s_template_section);
			}
			$a_output[$field['group']]['fields'][] = $s_template_section . $s_template;
		}
		foreach($a_output AS $key => $group){
			if(isset($group['label']))
				$output .= $group['label'];
			foreach($group['fields'] AS $data => $field){
				$output .= $field;
			}
		}
		return $output;
	}
	
/* end of class */
}
?>
