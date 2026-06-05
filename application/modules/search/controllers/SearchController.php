<?php 
class Search extends Starter
{
    public $a_data = array();
    public $a_include_pages = array();

    public $s_search = "";
    public $s_form_type_download "";
    public $i_nb_result = 0;

	function __construct() {
        $this->initVars();
    }

    private function initVars()
    {
    	$this->s_search = (isset($_GET['search_field']) ? (strtolower($_GET['search_field'])) : '');
		$this->s_form_type_download = (isset($_GET['type-download']) ? htmlentities($_GET['type-download']) : '');
		$this->requestContent();
    }

    private function requestContent()
    {
    	global $starter;
		$a_list = array();
    	require_once LIBRARY_PATH . '/menu.class.php' ;

    	if(!empty($this->s_search))
		{
			switch($starter->lucene_index){
				case 'index' :
					set_include_path(LIBRARY_PATH . '/zend-lucene/');
					require_once "Zend/Search/Lucene.php";

					/*if (!preg_match('#^[+-]#',strtolower($this->s_search)))
						$this->s_search = "+" . $this->s_search;
					*/
					if(preg_match('# #',$this->s_search))
					{
						$b_multiple_search = true;
						$_a_multiple_seach = explode(' ', $this->s_search);
					
						foreach($_a_multiple_seach as $val)
						{
							if(preg_match('#\+#', $val))
								$a_multiple_seach['AND'][] = preg_replace('#\+#','', $val);
							elseif(preg_match('#\-#',$val))
								$a_multiple_seach['NOT'][] = preg_replace('#\-#','', $val);
							else
								$a_multiple_seach['OPTIONAL'][] = $val;
						}
					}elseif(preg_match('#\-#',$this->s_search))
					{
						$b_multiple_search = true;
						$a_multiple_seach['NOT'] = explode('-', $this->s_search);	
						if(empty($a_multiple_seach['NOT'][0]))
							unset($a_multiple_seach['NOT'][0]);		
					}elseif(preg_match('#\+#',$this->s_search))
					{
						$b_multiple_search = true;
						$a_multiple_seach['AND'] = explode('+', $this->s_search);	
						if(empty($a_multiple_seach['AND'][0]))
							unset($a_multiple_seach['AND'][0]);		
					}						
					$index = Zend_Search_Lucene::open($starter->lucene_index);
					if($b_multiple_search)
					{
						$query = new Zend_Search_Lucene_Search_Query_MultiTerm();		
						if(isset($a_multiple_seach['AND']))
							foreach($a_multiple_seach['AND'] as $val)
							{
								if(isset($starter->mods['lexique']) && $starter->mods['lexique'])
								{
									$a_data_query = array(
										'search_list' => array($val,PDO::PARAM_STR),
									);
									$s_query = "
										SELECT * FROM search
										WHERE search_list LIKE '%:search_list%'";
									
									$_tmp = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');
									if($_tmp != 0)
										foreach($_tmp as $key => $value)
											$query->addTerm(new Zend_Search_Lucene_Index_Term($value), true);
									else
										$query->addTerm(new Zend_Search_Lucene_Index_Term($val), true);
								}
								else
									$query->addTerm(new Zend_Search_Lucene_Index_Term($val), true);					
							}
							if(isset($a_multiple_seach['NOT']))
								foreach($a_multiple_seach['NOT'] as $val)
									$query->addTerm(new Zend_Search_Lucene_Index_Term($val), false);
							
							if(isset($a_multiple_seach['OPTIONAL']))
								foreach($a_multiple_seach['OPTIONAL'] as $val)
									$query->addTerm(new Zend_Search_Lucene_Index_Term($val), null);
					}
					else
					{
						if(isset($starter->mods['lexique']) && $starter->mods['lexique'])
						{
							$a_data_query = array(
								'search_list' => array($this->s_search,PDO::PARAM_STR),
							);
							$s_query = "
								SELECT * 
								FROM search
								WHERE search_list LIKE '%:search_list%";
								
							$_tmp = $starter->database->prepare_query($s_query,$a_data_query, 'miltiple');
							
							$query = new Zend_Search_Lucene_Search_Query_MultiTerm();

							foreach($_tmp as $key => $val)
								$query->addTerm(new Zend_Search_Lucene_Index_Term($val),null);
						}
						else
						{
							$term  = new Zend_Search_Lucene_Index_Term($this->s_search);
							$query = new Zend_Search_Lucene_Search_Query_Wildcard($term);	
						}
					}
					$hits  = $index->find($query);

					foreach ($hits as $hit) {
						if($hit->lang == $starter->i_lang && ($s_form_type_download == 1 || $s_form_type_download == $hit->indexType))
						{
							$_tmp = array('score' => $hit->score);
							$_tmp['uri_referer'] = preg_replace('#,#','/',$hit->uriReferer);
							$_tmp['docId'] = $hit->docId;

							if(isset($starter->indexation->aIndex[$hit->indexType]['champs']))
							{	
								foreach($starter->indexation->aIndex[$hit->indexType]['champs'] as $field => $index)
									if(!is_array($index))
										$_tmp[$field] = $hit->$field;

								if(isset($starter->indexation->aIndex[$hit->indexType]['external']['champs']) && $starter->utils->is__countable($starter->indexation->aIndex[$hit->indexType]['external']['champs']) && count($starter->indexation->aIndex[$hit->indexType]['external']['champs']) > 0)
									foreach($starter->indexation->aIndex[$hit->indexType]['external']['champs'] as $field => $index)
									{
										$_keyIndex = array_shift(array_keys($index));
										$_tmp[$_keyIndex] = $hit->$_keyIndex;
									}

								foreach($starter->indexation->aIndex[$hit->indexType]['champs'] as $field => $index)
								{
									if(is_array($index)){
										foreach($starter->indexation->aIndex[$field]['champs'] as $_field => $_index)
											if(!is_array($_index))
												$_tmp[$_field] = $hit->$_field;
											else
											{
												$_keyIndex = array_shift(array_keys($_index));
												$_tmp[$_keyIndex] = $hit->$_keyIndex;
											}
										if(isset($starter->indexation->aIndex[$field]['external']['champs']) && $starter->utils->is__countable($starter->indexation->aIndex[$field]['external']['champs']) && count($starter->indexation->aIndex[$field]['external']['champs']) > 0)
											foreach($starter->indexation->aIndex[$field]['external']['champs'] as $_field => $_index)
												$_tmp[$_field] = $hit->$_field;
									}
								}	
							}			
							$_a_data[$hit->indexType][] = $_tmp;
						}
					}
						
					$_tmp = array();

					$s_query ="
						SELECT tree_id
						FROM tree
						WHERE online = 1
						AND archive = 0";		
					$_a_dataTree = $starter->database->prepare_query($s_query, array(), 'multiple' ,'tree_id');
					foreach($_a_dataTree as $key => $val){
						$a_dataTree[] = $key;
					}
					foreach($_a_data['tree'] as $key => $val)
					{
						if(in_array($val['docId'],$a_dataTree))
							$_tmp['tree'][] = $val;
					}
					if(isset($starter->mods['download']) && $starter->mods['download'])	
					{
						$s_query ="
							SELECT download_id
							FROM download
							WHERE online = 1
							AND archive = 0";		
						$_a_dataDownload = $starter->database->prepare_query($s_query, array(), 'multiple', 'download_id');

						foreach($_a_dataDownload as $key => $val){
							$a_dataDownload[$key] = $key;
						}
						foreach($_a_data['download'] as $key => $val)
						{
							if(in_array($val['docId'],$a_dataDownload))
								$_tmp['download'][] = $val;		
						}
					}
					$this->a_data = $_tmp;

			 	break;

				default:
			 	case '':
			 		$a_data_query = array(
						'search' => array('%' . $this->s_search . '%', PDO::PARAM_STR),
					);
			 		$s_query = "
						SELECT * 
						FROM search
						WHERE search_list LIKE :search";
					$_tmp = $starter->database->prepare_query($s_query,$a_data_query, 'multiple');
					
					foreach($_tmp as $key => $val){
						$_s_list = json_decode($val['search_list']);
						$a_list[] = $_s_list->item;
					}

					foreach($a_list as $key => $val){
						foreach($val as $item){
							if( $item != $this->s_search)
							{
								$a_data_query['item'] = array('%' . $item . '%', PDO::PARAM_STR);
								$_s_condition_tree .= " OR tree_label LIKE :item
									OR detail_label LIKE :item
									OR detail_text LIKE :item";

								if(isset($starter->mods['download']) && $starter->mods['download'])	
									$_s_condition_download .= " OR download_label LIKE :item
										OR t1.detail_label LIKE :item
										OR t1.detail_info LIKE :item
										OR t1.detail_text LIKE :item
										OR category_label LIKE :item
										OR t3.detail_label LIKE :item";

								if(isset($starter->mods['news']) && $starter->mods['news'])	
									$_s_condition_news .= " OR news_title LIKE :item
										OR t1.detail_label LIKE :item			
										OR t1.detail_abstract LIKE :item
										OR t1.detail_text LIKE :item
										OR category_label LIKE :item
										OR t3.detail_label LIKE :item";
							}
						}
					}
					$a_data_query['lang']= array($starter->i_lang, PDO::PARAM_INT);

					$s_query = "
						SELECT t0.*, t1.*
						FROM tree AS t0
						LEFT OUTER JOIN tree_detail AS t1
						ON t1.detail_tree = t0.tree_id
						WHERE tree_isnav = 0 
						AND online = 1 
						AND archive = 0
						AND lang = :lang" ;

					if($_SESSION['user_info']['user_statut'] != 0){
						$a_data_query['authTree'] = array($auth->authTree, PDO::PARAM_SSTR);
						$s_query .= "
							AND tree_id IN (:authTree)";
					}
					$s_query .= "
						AND (
							tree_label LIKE :search
							OR detail_label LIKE :search
							OR detail_text LIKE :search";

					if(!empty($_s_condition_tree))
						$s_query .= $_s_condition_tree	;

					$s_query .="
						)";
					$_tmp = $starter->database->prepare_query($s_query, $a_data_query, 'multiple');

					foreach($_tmp as $key => $val){
						$_parents = $menu->lookForParents($val);
						$val['global_referer'] = implode('/',$menu->breadcrumb) . '.html';
						$val['label'] = (!empty($val['detail_label']) ? $val['detail_label'] : $val['tree_label']);
						$menu->breadcrumb = array();
						$this->a_data['tree'][] = $val;
					}
					if(isset($this->a_data['tree'])) 
						$this->i_nb_tree = ($starter->utils->is__countable($a_data['tree']) ? count($this->a_data['tree']) : 0);

					if(isset($starter->mods['download']) && $starter->mods['download'])
					{
						$a_data_query = array(
							'lang' => array($starter->i_lang, PDO::PARAM_INT),
							'search' => array($this->s_search, PDO::PARAM_STR),
						);
						$s_query ="
							SELECT t0.*, t1.*, t2.*, t3.detail_referer AS detail_category_referer, t3.detail_label AS detail_category_label
							FROM download AS t0
							LEFT OUTER JOIN ownload_detail AS t1
							ON t1.detail_download = t0.download_id
							LEFT OUTER JOIN download_categories AS t2
							ON t2.category_id = t0.download_category
							LEFT OUTER JOIN download_categories_detail AS t3
							ON t3.detail_category = t2.category_id
							WHERE t0.online = 1
							AND t2.online = 1
							AND t0.archive = 0
							AND t2.archive = 0
							AND t1.lang = :lang
							AND t3.lang = :lang";
						
						$s_query .= "
							AND (
								download_label LIKE '%search%'
								OR download_label LIKE :search
								OR t1.detail_label LIKE '%search%'
								OR t1.detail_info LIKE '%search%'
								OR t1.detail_text LIKE '%search%'
								OR category_label LIKE '%search%'
								OR t3.detail_label LIKE '%search%'";

						if(!empty($_s_condition_download))
							$s_query .= $_s_condition_download	;
						
						$s_query .="
							)";
						$_tmp = $starter->database->prepare_query($s_query, $a_data_query, 'multiple');
						if($starter->utils->is__countable($_tmp) && count($_tmp) >= 1)
						foreach($_tmp as $key => $val){
							$val['label'] = (!empty($val['detail_label']) ? $val['detail_label'] : $val['download_label']);
							$this->a_data['download'][] = $val;
						}
						if(isset($this->a_data['download'])) 
							$this->i_nb_download = ($starter->utils->is__countable($this->a_data['download']) ? count($this->a_data['download']) : 0);
					}

					if(isset($starter->mods['news']) && $starter->mods['news'])
					{
						$a_data_query = array(
							'lang' => array($starter->i_lang, PDO::PARAM_INT),
							'search' => array($this->s_search, PDO::PARAM_STR),
						);

						$s_query ="
							SELECT t0.*, t1.*, t2.*, t3.detail_referer AS detail_category_referer, t3.detail_label AS detail_category_label
							FROM news AS t0
							LEFT OUTER JOIN news_detail AS t1
							ON t1.detail_news = t0.news_id
							LEFT OUTER JOIN news_categories AS t2
							ON t2.category_id = t0.news_category
							LEFT OUTER JOIN news_categories_detail AS t3
							ON t3.detail_category = t2.category_id
							WHERE t0.online = 1
							AND t2.online = 1
							AND t0.archive = 0
							AND t2.archive = 0
							AND t1.lang = :lang
							AND t3.lang = :lang";
						
						$s_query .= "
							AND (
								news_label LIKE '%search%'
								OR news_label LIKE :search
								OR t1.detail_label LIKE '%search%'
								OR t1.detail_info LIKE '%search%'
								OR t1.detail_text LIKE '%search%'
								OR category_label LIKE '%search%'
								OR t3.detail_label LIKE '%search%'";

						if(!empty($_s_condition_news))
							$s_query .= $_s_condition_news	;
						
						$s_query .="
							)";
						$_tmp = $starter->database->prepare_query($s_query, $a_data_query, 'multiple');
						if($starter->utils->is__countable($_tmp) && count($_tmp) >= 1)
						foreach($_tmp as $key => $val){
							$val['label'] = (!empty($val['detail_label']) ? $val['detail_label'] : $val['news_label']);
							$this->a_data['news'][] = $val;
						}
						if(isset($this->a_data['news'])) 
							$this->i_nb_news = ($starter->utils->is__countable($this->a_data['news']) ? count($this->a_data['news']) : 0);
					}
			 	break;
			}	
		}

		$this->view();
    }

    public function view(){
    	global $starter;
		// VIEWS
		//return array(1,1,1,$this->s_include,1,1);
		$this->a_include_pages[] = '/views/' . (is_dir(APPLICATION_PATH . '/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/header.php' ;
		$this->a_include_pages[] = '/views/' . (is_dir(APPLICATION_PATH . '/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/top.php' ;
		$this->a_include_pages[] = '/modules/menu/views/' . (is_dir(APPLICATION_PATH .'/modules/menu/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/index.php' ;
		$this->a_include_pages[] = '/modules/search/views/' . (is_dir(APPLICATION_PATH .'/modules/search/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/index.php' ;
		$this->a_include_pages[] = '/views/' . (is_dir(APPLICATION_PATH . '/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/footer.php' ;
		$this->a_include_pages[] = '/views/' . (is_dir(APPLICATION_PATH . '/views/' . $starter->s_display) ? $starter->s_display : 'default') . '/footer.php' ;
    }
}
?>

<?php
/*
$_s_condition_tree = '';
$_s_condition_download = '';
$_s_condition_news = '';
$i_nb_tree = 0;
$i_nb_download = 0;
$i_nb_news = 0;
$i_nb_result = 0;
$b_breadcrumbTree = false;
$b_multiple_search = false;

// lexique vars
$s_lexique_look = $starter->_get_lexique('voir');
$s_lexique_delete = $starter->_get_lexique('Supprimer');
$s_lexique_add = $starter->_get_lexique('Ajouter');
$s_lexique_dl = $starter->_get_lexique('Télécharger');

// CONTENT


$i_nb_tree = ($starter->utils->is__countable($a_data['tree']) ? count($a_data['tree']) : 0);
$i_nb_download = ($starter->utils->is__countable($a_data['download']) ? count($a_data['download']) : 0);

$i_nb_result = $i_nb_tree + $i_nb_download + $i_nb_news;
*/
?>