<?php 
class MenuController extends Starter
{
	public $menu = array();
	public $authTree = '';
	public $authChartes = '';
	public $authBack = '';
	public $authGroup = '';
	public $where = array();
	public $level = array();
	public $current = array();
	public $breadcrumb = array();
	public $breadcrumbTree = array();
	public $s_referer;

	function __construct() {
    }

 	public function lookForParents($_a_data = array(), $b_breadcrumb = true, $b_back = false)
	{
		global $starter ;
		if($b_breadcrumb) 
		{
			if(!empty($_a_data['detail_referer'])) 
			{
				$this->breadcrumb[$_a_data['tree_level']] = $_a_data['detail_referer'];
				$this->breadcrumbTree[$_a_data['tree_level']] = '<a href="' . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . implode('/',$this->breadcrumb) . '.html">' . (!empty($_a_data['detail_label']) ? $_a_data['detail_label'] : $_a_data['tree_label']) . '</a>';
			}
		}
		$a_data_query = array(
			'lang' => array($starter->i_lang,PDO::PARAM_INT),
			'tree_id' => array(intval($_a_data['tree_parent']),PDO::PARAM_INT),
		);		
		$s_query = "
			SELECT t0.*, t1.*
			FROM tree AS t0
			INNER JOIN tree_detail AS t1
			ON t1.detail_tree = t0.tree_id
			WHERE lang = :lang
			AND t0.archive = 0";
		
		if(!$b_back)
			$s_query .= "
				AND online = 1";		
		if(isset($_SESSION['user_info']['user_statut']) &&  $_SESSION['user_info']['user_statut'] != 0 && isset($starter->needauth) && $starter->needauth){
			$a_data_query = array(
				'authTree' => array($starter->authTree,PDO::PARAM_STR),
			);	
			$s_query .= "
				AND tree_id IN (:authTree)";
		}

		$s_query .= "
			AND tree_id = :tree_id
			ORDER BY _order";
		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Menu&rquest=getParent', $_data);
						
			$o_result = $curlApiRequest;
		}else{
			$a_parents = $starter->database->prepare_query($s_query,$a_data_query);
		}
		
		if(!$a_parents && $_a_data['tree_level'] == 1)
		{
			if($b_breadcrumb) 
			{
				if(!empty($_a_data['detail_referer']))
				{
					$this->breadcrumb[$_a_data['tree_level']] = $_a_data['detail_referer'];
					$this->breadcrumbTree[$_a_data['tree_level']] = '<a href="' . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . implode('/',$this->breadcrumb) . '">' . (!empty($_a_data['detail_label']) ? $_a_data['detail_label'] : $_a_data['tree_label']) . '</a>';
					ksort($this->breadcrumb);
					ksort($this->breadcrumbTree);
				}
			}
			return $a_parents;
		}
		elseif($a_parents['tree_parent'] == 0 && $_a_data['tree_level'] == 1){
			if($b_breadcrumb) 
			{
				if(!empty($a_parents['detail_referer'])) 
				{
					$this->breadcrumb[$a_parents['tree_level']] = $a_parents['detail_referer'];
					$this->breadcrumbTree[$a_parents['tree_level']] = '<a href="' . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . implode('/',$this->breadcrumb) . '">' . (!empty($a_parents['detail_label']) ? $a_parents['detail_label'] : $a_parents['tree_label']) . '</a>';
					ksort($this->breadcrumb);
					ksort($this->breadcrumbTree);
				}
			}
			return $a_parents;
		}
		elseif(isset($a_parents['tree_parent'])) {
			if($b_breadcrumb){
				if(!empty($a_parents['detail_referer'])) {
					$this->breadcrumb[$a_parents['tree_level']] = $a_parents['detail_referer'];
					$this->breadcrumbTree[$a_parents['tree_level']] = '<a href="' . $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '') . implode('/',$this->breadcrumb) . '">' . (!empty($a_parents['detail_label']) ? $a_parents['detail_label'] : $a_parents['tree_label']) . '</a>';
				}
			}				
			if($a_parents['tree_id'] != $_a_data['tree_id']) 
				return $this->lookForParents($a_parents, $b_breadcrumb, $b_back);
		}
		else
			return '';
		ksort($this->breadcrumb);
		ksort($this->breadcrumbTree);
		
	}

	public function getCurrent()
    {
    	global $starter;

    	$s_referer = (!empty($starter->s_level5) ? $starter->s_level5 : (!empty($starter->s_level4) ? $starter->s_level4 : (!empty($starter->s_level3) ? $starter->s_level3 : (!empty($starter->s_level2) ? $starter->s_level2 : $starter->s_level1))));
    	$i_lang = $starter->i_lang;
    	$config_home = $starter->meta['config_home'];

    	if($starter->isApi ){
	    	$a_data_query = array();
			$a_data_query['lang'] =  $i_lang;
			$a_data_query['referer'] = $s_referer;
			$a_data_query['config_home'] = $config_home;
	
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Menu&rquest=getCurrent', $a_data_query, 'POST', false);

			if(!$curlApiRequest)
				$starter->utils->not_found_page();
			else
				$a_data = $curlApiRequest;
		}else{
			$a_data_query = array(
	    		'lang' => array($i_lang,PDO::PARAM_INT),
	    		'referer' => array($s_referer,PDO::PARAM_STR),
			);

			$s_query = "
				SELECT t0.tree_label, t0.tree_icon, t1.detail_label, t1.detail_referer, t1.detail_text
				FROM tree AS t0
				INNER JOIN tree_detail AS t1
				ON t1.detail_tree = t0.tree_id
				WHERE online = 1
				AND archive = 0
				AND t1.lang = :lang";

			$s_query .= " 
				AND detail_referer = :referer";
			$a_data = $starter->database->prepare_query($s_query,$a_data_query);

			if(!$a_data) {
				$a_data_query = array(
					'lang' => array($i_lang,PDO::PARAM_INT),
	    			'referer' => array($s_referer,PDO::PARAM_STR),
					'config_home' => array($config_home,PDO::PARAM_INT),
				);
				$s_query .= " 
					AND tree_id = :config_home";
				$a_data = $starter->database->prepare_query($s_query,$a_data_query);
				if(!$a_data) 
					$starter->utils->not_found_page();
			}
		}
		return $a_data;
    }
    
	/**************************************************************************************************
	*	getTree :  
	*	input : 
	*	output : variable de classe "menu" (ARRAY)
	**************************************************************************************************/
	public function getTree($i_level = 1, $i_id = 0, $b_back = false, $i_tree_id = 0, $ref = '')
	{
		global $starter;
		foreach($this->breadcrumb as $key => $val)
		{
			if($key>$i_level)
			{
				unset($this->breadcrumb[$key]);
				empty($this->breadcrumb[$key]);
			}
		}
		$_menu_items = array();
		$a_data_query = array(
			'lang' => array($starter->i_lang,PDO::PARAM_INT),
		);
		$s_query = "
			SELECT t0.*, t1.*
			FROM tree AS t0
			INNER JOIN tree_detail AS t1
			ON t1.detail_tree = t0.tree_id
			WHERE lang = :lang
			AND t0.archive = 0";
		
		if(!$b_back)
			$s_query .= "
				AND online = 1";
		
		if(!isset($_SESSION['user_info']))
			$s_query .= "
				AND tree_private = 0";
		
		if(isset($_SESSION['user_info']['user_statut']) && $_SESSION['user_info']['user_statut'] != 0 && isset($starter->needauth) && $starter->needauth){

			$tmp = json_decode($_SESSION['user_info']['user_rules']);
			$tmp = $tmp->rules_treeId;
			$tmp = json_decode($tmp);

			if(isset($tmp) && count($tmp)>0){
				//$a_data_query['authTree'] = array($starter->authTree,PDO::PARAM_STR);
				$s_query .= " 
					AND t0.tree_id IN (" . implode(',', $tmp ).")";
			}
		}

		if(isset($this->where) && !empty($this->where)) {
			$s_query .= " AND (" . $this->where . ")";
		}

		if($i_tree_id != 0){
			$a_data_query['tree_id'] = array(intval($i_tree_id),PDO::PARAM_INT);
			$s_query .= "
				AND t0.tree_id = :tree_id ";			
		}
		elseif($i_id != 0){
			$a_data_query['tree_level'] = array($i_level,PDO::PARAM_INT);
			$a_data_query['tree_parent'] = array(intval($i_id),PDO::PARAM_INT);
			$s_query .= " 
				AND t0.tree_level = :tree_level
				AND t0.tree_parent = :tree_parent";
		}
		else{
			$a_data_query['tree_level'] = array($i_level,PDO::PARAM_INT);
			$s_query .= " 
				AND t0.tree_level = :tree_level";
		}

		$s_query .= "
			ORDER BY t0._order 
		";

		if($starter->isApi ){
			$_data = array();
			$_data['squery'] = $s_query;
			$_data['data'] = json_encode($a_data_query);
			
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Menu&rquest=getTree', $_data);
						
			$o_result = $curlApiRequest;
		}else{
			$o_result = $starter->database->prepare_query($s_query, $a_data_query, 'multiple');
		}

		$s_referer = (isset($_GET['level'.$i_level]) ? htmlentities($_GET['level'.$i_level]) : '');

		if($o_result!=false)
		{
			foreach($o_result as $key => $liste)
			{
				if(!is_array($liste))
					$liste = (array)$liste;
				$liste['tree_active'] = false ;
				unset($this->where);
				$referer = (!empty($ref) ? $ref . '/' : '') . $liste['detail_referer'];
				$liste['general_referer'] = $referer;

				if($liste['tree_isnav'] != 0 && ( $liste['tree_module'] == 0 || $liste['tree_module'] == 1 ))
					$liste['children'] = $this->getTree($i_level+1, $liste['tree_id'], $b_back, 0, $referer);
				elseif($liste['tree_isnav'] != 0 && !$b_back){
					$liste['children'] = array();
					$modlist = $this->getModuleReferer($liste['tree_module']);
					if(isset($starter->mods[$modlist['module_path']]['modules'])){
						$modlist = $starter->mods[$modlist['module_path']]['modules'];
						foreach($modlist as $mod => $list){
							if(isset($list['onMenu']) && !empty($list['onMenu'])){
								$liste['children'][] = array(
									'detail_referer' => $list['referer'],
									'tree_on_menu' => $list['onMenu'],
									'tree_label' => (isset($list['title']) ? $list['title'] : $list['referer']),
									'tree_icon' => (isset($list['picto']) ? $list['picto'] : ''),
								);
							}
						}
					}
				}
				if((!empty($s_referer) && $liste['detail_referer'] == $s_referer) || (empty($s_referer) && $starter->meta['config_home'] == $liste['tree_id'])) 
				{
					$this->current[$i_level] = $liste ; // current var update
					if(!empty($liste['detail_referer'])) 
						$this->breadcrumb[$liste['tree_level']] = $liste['detail_referer'];
					if(isset($liste['children']) && count($liste['children'])>0)
						$this->breadcrumbTree[$liste['tree_level']] = (!empty($liste['detail_label']) ? $liste['detail_label'] : $liste['tree_label']);
					else 
						$this->breadcrumbTree[$liste['tree_level']] = "<strong>" . (!empty($liste['detail_label']) ? $liste['detail_label'] : $liste['tree_label']) . "</strong>";
					$liste['tree_active'] = true ;
				}
				$_menu_items[$liste['tree_id']] = $liste ;
				if($i_level == 1) 
					$this->menu[$liste['tree_id']] = $liste ;
			}
		}

		ksort($this->breadcrumb);
		ksort($this->breadcrumbTree);
		return $_menu_items ;
	}

	/**************************************************************************************************
	*	getModuleReferer :  
	*	input : 
	*	output : variable de classe "menu" (ARRAY)
	**************************************************************************************************/
	public function getModuleReferer($module)
	{
		global $starter;
		$a_data_query = array(
			'module_id' => array($module,PDO::PARAM_INT),
		);
		$s_query = "
			SELECT module_path
			FROM tree_module
			WHERE module_id = :module_id
			AND online = 1
			AND archive = 0";

		$o_result = $starter->database->prepare_query($s_query, $a_data_query);

		return $o_result ;		
	}

	/**************************************************************************************************
	*	getModule :  
	*	input : 
	*	output : variable de classe "menu" (ARRAY)
	**************************************************************************************************/
	public function getModule($module = '', $slevel2 = '')
	{
		global $starter;
		foreach($starter->mods[$module]['modules']  as $key => $val){
			if($val['referer'] == $slevel2){
				if(!empty($val['name']))
					return $val['name'];
				else
					return $val['referer'];
			}
		}	
	}

	/**************************************************************************************************
	*	getModules :  
	*	input : 
	*	output : variable de classe "menu" (ARRAY)
	**************************************************************************************************/
	public function getModules($referer = '')
	{
		global $starter;
		foreach($starter->mods  as $key => $val){
			if($val['referer'] == $referer){				
				if(!empty($val['name'])){
					return $val['name'];
					break;
				}
				else{
					return $val['referer'];
					break;
				}
			}
		}
		return $referer;
	}
	/**************************************************************************************************
	*	getBreadCrumb :  
	*	input : 
	*	output : variable de classe "menu" (ARRAY)
	**************************************************************************************************/
	public function getBreadCrumb()
	{
		global $starter;
		$a_breadcrumb = array();
		$_s_breadcrumb = preg_replace('#.html#','',$_SERVER['REQUEST_URI']);
		$_a_breadcrumb = explode('/',$_s_breadcrumb);
		$_a_breadcrumb = array_slice($_a_breadcrumb, 2);
		foreach($_a_breadcrumb as $key => $val)		
			if(!empty($val))
				$a_breadcrumb[] = $val;		
				
		return $a_breadcrumb ;		
	}
	/**************************************************************************************************
	*	formatBreadCrumb :  
	*	input : 
	*	output : variable de classe "menu" (ARRAY)
	**************************************************************************************************/
	public function formatBreadCrumb($a_breadcrumb = array())
	{
		global $starter;
		$_s_referer = $starter->HTTP_ROOT . ($starter->b_multilang ? $starter->s_lang . '/' : '');

		foreach($a_breadcrumb  as $key => $val)
		{
			$_s_referer .=  $val . ".html";
			//echo $key . " ";
			if($key < (count($this->breadcrumbTree)-1))
				$this->breadcrumbTree[$key+1] = '<a href="' .  $_s_referer . '">' . strip_tags($this->breadcrumbTree[$key+1]) . '</a>';
			
		}
		$iCompt = 1;
		foreach($this->breadcrumbTree as $key => $val){
			if($iCompt > count($a_breadcrumb))
			{	
				empty($this->breadcrumbTree[$key]);
				unset($this->breadcrumbTree[$key]);
			}
			$iCompt++;
		}
	}
	/**************************************************************************************************
	*	changeLevel :  
	*	input : 
	*	output : variable de classe "menu" (ARRAY)
	**************************************************************************************************/
	public function changeLevel($aTree, $_newLevel)
	{
		global $starter;
		foreach($aTree as $key => $val)
		{
			$a_data_query = array(
				'tree_level' => array(intval($_newLevel),PDO::PARAM_INT),
				'tree_id' => array(intval($val['tree_id']),PDO::PARAM_INT),
			);

			$s_query ="
				UPDATE tree
				SET tree_level = :tree_level
				WHERE tree_id = :tree_id";
			$o_result = $starter->database->prepare_query($s_query, $a_data_query);
			if($_newLevel <= 4)
			{
				$this->changeLevel($aTree['children'], $_newLevel+1);
			}
		}
	}

	public function getDownload($tree_id = 0){

		global $starter;
		if($starter->isApi ){
	    	$_data = array();
			$_data['tree_id'] = $tree_id;

			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Menu&rquest=getDownload', $_data);

			$a_data = $curlApiRequest;
		}else{
			$a_data_query = array(
				'tree_id' => array($tree_id,PDO::PARAM_INT),
			);

			$s_query = "
				SELECT tree_downloads
				FROM tree
				WHERE tree_id = :tree_id";

			$a_data = $starter->database->prepare_query($s_query,$a_data_query);
		}
		return $a_data;
	}

    public function getFooter()
    {
    	global $starter;
    	
		$a_langue = array();
		$b_breadcrumbTree = true;
		$s_switchMenu = '';
		$a_switchMenu = array();
		$uri = array();
		$b_prehome = true;

		$a_breadCrumb = $this->getBreadCrumb();
		$this->formatBreadCrumb($a_breadCrumb);

    	if($starter->isApi ){
    		$_data = array();
			$_data['lang'] = $starter->i_lang;
		
			// CRL code
			$curlApiRequest = $starter->sendCurlRequest($starter->ApiUri . '?ctrl=Menu&rquest=FooterMenu', $_data);
					
			$a_data = $curlApiRequest;
    	}else{

	    	$a_data_query = array(
				'lang' => array($starter->i_lang,PDO::PARAM_INT),
			);

			$s_query = "
				SELECT tree_label, tree_icon, detail_tree, detail_label, lang, detail_referer
				FROM tree AS t0
				INNER JOIN tree_detail AS t1
				ON t1.detail_tree = t0.tree_id
				WHERE t0.online = 1
				AND t0.tree_on_menu = 2
				AND t1.lang = :lang
				ORDER BY t0._order";
			$a_data = $starter->database->prepare_query($s_query, $a_data_query, 'multiple');

			$s_query = "
				SELECT lang_ref, lang_translation	lang_name, lang_herit
				FROM langs
				WHERE online = 1";
			$a_langue = $starter->database->prepare_query($s_query, array(), 'multiple');

			/*Prepare translation*/
			$iCompt = 1;
			foreach($a_breadCrumb as $key)
			{
				if(!empty($key))
				{
					$a_data_query = array(
						'lang' => array($starter->i_lang,PDO::PARAM_INT),
						'referer' => array($key,PDO::PARAM_STR),
					);

					$s_query = "
						SELECT t0.tree_id
						FROM tree AS t0
						INNER JOIN tree_detail AS t1
						ON t1.detail_tree = t0.tree_id
						WHERE t0.online = 1
						AND t1.detail_referer = :referer
						AND lang = :lang";
					
					$_tmp = $starter->database->prepare_query($s_query, $a_data_query);
					
					if($_tmp != false)
					{
						$a_data_query = array(
							'lang' => array($starter->i_lang,PDO::PARAM_INT),
							'tree_id' => array($_tmp['tree_id'],PDO::PARAM_INT),
						);
						$s_query = "
							SELECT t0.tree_module, t1.detail_referer
							FROM tree AS t0
							INNER JOIN tree_detail AS t1
							ON t1.detail_tree = t0.tree_id
							WHERE t0.tree_id = :tree_id
							AND lang != :lang";

						$_tmp = $starter->database->prepare_query($s_query, $a_data_query);

						if($_tmp != false)
							$a_switchMenu[$iCompt] = $_tmp['detail_referer'];
						else 
							$a_switchMenu[$iCompt] = $key;
						
						if($iCompt == (($starter->utils->is__countable($a_breadCrumb) ? count($a_breadCrumb) : 0)-1))
							if($_tmp != false &&  $_tmp['tree_module'] == 0)
								$_end = ".html";
					}
					$iCompt++;
				}			
			}
		}
		if( $starter->utils->is__countable($a_switchMenu) && count($a_switchMenu) > 0 )
			$s_switchMenu = '/' . implode('/',$a_switchMenu);

		$_uri = explode('/',$_SERVER['REQUEST_URI']);
		if($starter->utils->is__countable($_uri) && count($_uri) > 0)
			foreach($_uri as $key => $val)
				if(!empty($val))
					$uri[] = $val;
		$_level = "s_level" . (($starter->utils->is__countable($uri) ? count($uri) : 0) - 1);

		if($starter->utils->is__countable($a_switchMenu) && count($a_switchMenu) != (($starter->utils->is__countable($uri) ? count($uri) : 0)- 1) && (($starter->utils->is__countable($uri) ? count($uri) : 0) - 1) > 0)
			$s_switchMenu .= (!empty($s_switchMenu) && substr($s_switchMenu,-1) != '/' ? '/' : '') . (isset($starter->$_level) ? $starter->$_level : '');

		if(substr($_SERVER['REQUEST_URI'],-1) == '/')
			$s_switchMenu .= '/';
		elseif((($starter->utils->is__countable($uri) ? count($_uri) : 0) - 1) > 0)
			$s_switchMenu .= '.html';

		return $a_data;
    }
}
?>
