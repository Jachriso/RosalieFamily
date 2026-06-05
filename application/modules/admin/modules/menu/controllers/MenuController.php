<?php 
class AdminMenu extends Starter
{
    private $_a_lang = array();
    public $a_lang = array();
    public $a_config_data = array();
    public $a_config_page = array();
    public $a_config_rules;


	function __construct() {
        $this->initVars();
    }

    private function initVars()
    {
    	global $starter;
    	
    	$this->a_config_rules = ($_SESSION['user_info']['user_statut'] == "0" ? 0 : (!empty(json_decode($_SESSION['user_info']["user_rules"])->rules_backId) ? json_decode($_SESSION['user_info']["user_rules"])->rules_backId : ''));

    	if($starter->isApi )
			$this->requestApiContent();
		else
			$this->requestContent();

    }

    private function requestApiContent()
    {
    	global $starter;
		
		// CRL code
		$curlApiRequest = $starter->_get_langue();
				
		$this->_a_lang = $curlApiRequest;

		$this->sortData();
    }

    private function requestContent()
    {
    	global $starter;

		$s_query = "
			SELECT lang_ref, lang_id
			FROM langs 
			WHERE online = 1
			AND archive = 0";

		$this->_a_lang = $starter->database->prepare_query($s_query,array(), 'multiple', 'lang_id');

		$this->sortData();
    }

    private function sortData()
    {
    	global $starter;
    	foreach($this->_a_lang as $key => $val){
			if(!is_array($val))
				$val = (array)$val;
			
			$s_link = preg_replace('#(/[a-z]{2})/#','/' . $val['lang_ref'] . '/',$_SERVER['REQUEST_URI']);
			$s_link = preg_replace('#&val_id=(.*)#','',$s_link);
			$s_link = preg_replace('#action=(.*)#','action=list',$s_link);
		    $val['referer'] = $starter->HTTP_DOMAIN . $s_link;
			$this->a_lang[] = $val;
		}
		foreach($starter->database->configs as $page => $config){
			foreach($config['content'] as $module => $val){
				$_tmp_val = $val['id'];
				if(!in_array($config['group'],$this->a_config_page) && ($_SESSION['user_info']['user_statut'] == "0" || ((!is_array($this->a_config_rules) && isset($this->a_config_rules->$_tmp_val)) || (is_array($this->a_config_rules) && isset($this->a_config_rules[$val['id']])))))
					$this->a_config_page[] = $config['group'];
				if(in_array($config['group'],$this->a_config_page) && ($_SESSION['user_info']['user_statut'] == "0" || ((!is_array($this->a_config_rules) && isset($this->a_config_rules->$_tmp_val)) || (is_array($this->a_config_rules) && isset($this->a_config_rules[$val['id']])))))
					$_a_config_data[$page][$module] = $val;
			}
			if(isset($_a_config_data[$page]))
				usort($_a_config_data[$page],  array($starter->utils,'fonctionComparaison'));
		}
		if($starter->utils->is__countable($_a_config_data) && count($_a_config_data) > 0)
			foreach($_a_config_data as $page => $config){
				foreach($config as $module => $val){
					$_tmp_val = $val['id'];
					if($_SESSION['user_info']['user_statut'] != "0" && !is_array($this->a_config_rules))
						$_tmp = (array)$this->a_config_rules->$_tmp_val;
					elseif($_SESSION['user_info']['user_statut'] != "0")
						$_tmp = $this->a_config_rules[$val['id']];
					foreach($val['content'] as $element => $item){				
						if($_SESSION['user_info']['user_statut'] == "0" || isset($_tmp[$item['id']])){
							$this->a_config_data[$page][$val['id']]['name'] = $val['name'];
							$this->a_config_data[$page][$val['id']]['content'][] = $item;
						}
					}
				}
			}

		if(empty($s_form_page))
			$s_form_page = current($this->a_config_page);

		ksort($this->a_config_data);
		
		//OUTPUT

		//CSS
		$starter->a_css[] = array('rel' => 'stylesheet', 'media' => 'all', 'href'=> '/templates/' . $starter->s_template . '/modules/admin/modules/menu/css/main.css');

		//JS
		$starter->a_js[] 	= array("src"=> '/templates/' . $starter->s_template . '/modules/admin/modules/menu/js/main.js');
    }
}
?>
