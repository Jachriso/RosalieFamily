<?php
// Init vars
$a_data = array();
$_a_tmp_cat = array();
$s_html = '';
$s_pages = '';
$i_range = (isset($_GET['viewnbpage']) ? htmlentities($_GET['viewnbpage']) : 10);
$i_start = 0;
$i_pages = 1;
$s_search = isset($_GET['search_field']) ? htmlentities(strtolower($_GET['search_field'])) : (isset($_GET['search_download']) ? htmlentities(strtolower($_GET['search_download'])) : '');
$s_lexique_search_value = $s_search ;
$s_searchCat = isset($_GET['searchCatAdd']) ? htmlentities(stripslashes($_GET['searchCatAdd'])) : '';
$s_searchCharte = isset($_GET['searchCharteAdd']) ? htmlentities(stripslashes($_GET['searchCharteAdd'])) : '';
$i_searchCase = 0;
$_a_charte = $_aCharte;
$_a_cat = $_aCat;
$_a_data = $a_data;

$a_data_query = array(
	'lang' => array($starter->i_lang,PDO::PARAM_INT),
);
$s_query ="
	SELECT t0.*, t1.detail_label AS detail_download_label, t1.detail_text AS detail_download_text, t1.detail_referer AS detail_download_referer
	FROM download AS t0
	INNER JOIN download_detail AS t1
	ON t1.detail_download = t0.download_id
	WHERE t0.online = 1
	AND archive = 0
	AND lang = :lang
	ORDER BY download_label DESC";

$_a_data = $starter->database->prepare_query($s_query, $a_data_query, 'multiple', 'download_id');

foreach($_a_data as $key => $val)
	if(in_array($val['download_category'], $_a_cat))
		$a_data[] = $val;					

if($starter->utils->is__countable($_GET) && count($_GET) > 2 || !empty($s_search))
{
	switch($starter->lucene_index){
		case 'index' :
			set_include_path(LIBRARY_PATH . '/zend-lucene/');
			require_once "Zend/Search/Lucene.php";
			
			if(preg_match('# #',$s_search))
			{
				$b_multiple_search = true;
				$_a_multiple_seach = explode(' ', $s_search);
			
				foreach($_a_multiple_seach as $val)
				{
					if(preg_match('#\+#', $val))
						$a_multiple_seach['AND'][] = preg_replace('#\+#','', $val);
					elseif(preg_match('#\-#',$val))
						$a_multiple_seach['NOT'][] = preg_replace('#\-#','', $val);
					else
						$a_multiple_seach['OPTIONAL'][] = $val;
				}
				
			}elseif(preg_match('#\-#',$s_search))
			{
				$b_multiple_search = true;
				$a_multiple_seach['NOT'] = explode('-', $s_search);	
				if(empty($a_multiple_seach['NOT'][0]))
					unset($a_multiple_seach['NOT'][0]);		
			}elseif(preg_match('#\+#',$s_search))
			{
				$b_multiple_search = true;
				$a_multiple_seach['AND'] = explode('+', $s_search);	
				if(empty($a_multiple_seach['AND'][0]))
					unset($a_multiple_seach['AND'][0]);		
			}
			
			Zend_Search_Lucene_Analysis_Analyzer::setDefault(
				new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive()
			);
			$index = Zend_Search_Lucene::open($starter->lucene_index);
			$index->optimize();
			if($b_multiple_search)
			{
				$query = new Zend_Search_Lucene_Search_Query_MultiTerm();
				
				if(isset($a_multiple_seach['AND']))
					foreach($a_multiple_seach['AND'] as $val)
					{
						if(isset($starter->mods['lexique']) && $starter->mods['lexique'])
						{
							$a_data_query = array(
								'search_list' => array('%' . $val . '%',PDO::PARAM_STR),
							);
							$s_query = "
								SELECT * FROM search
								WHERE search_list LIKE :search_list";
							
							$_tmp = $starter->database->prepare_query($s_query,$a_data_query,'multiple');
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
						'search_list' => array('%' . $s_search . '%',PDO::PARAM_STR),
					);
					$s_query = "
						SELECT * FROM search
						WHERE search_list LIKE :search_list";
						
					$_tmp = $starter->database->prepare_query($s_query,$a_data_query,'multiple');
					
					$query = new Zend_Search_Lucene_Search_Query_MultiTerm();
					
					foreach($_tmp as $key => $val)
						$query->addTerm(new Zend_Search_Lucene_Index_Term($val),null);
				}
				else
				{
					$term  = new Zend_Search_Lucene_Index_Term($s_search);
					$query = new Zend_Search_Lucene_Search_Query_Wildcard($term);	
				}
			}

			$hits  = $index->find($query);

			foreach ($hits as $hit) {

				if($hit->lang == $starter->i_lang && $hit->indexType == "download")
				{
					$_tmp = array('score' => $hit->score);
					$_tmp['uri_referer'] = preg_replace('#,#','/',$hit->uriReferer);
					$_tmp['docId'] = $hit->docId;

					if(isset($starter->indexation->aIndex[$hit->indexType]['champs']))
					{	
						foreach($starter->indexation->aIndex[$hit->indexType]['champs'] as $field => $index)
							if(!is_array($index))
								$_tmp[$field] = $hit->$field;
							else
							{
								$_keyIndex = array_shift(array_keys($index));
								$_tmp[$_keyIndex] = $hit->$_keyIndex;
							}

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
					
					$_a_data[] = $_tmp;
				}
			}
			
			$_tmp = array();
			$__a_dataDownload = array();
			$s_query ="
				SELECT download_id, is_promoted
				FROM download
				WHERE download_online = 1
				AND archive = 0
				ORDER BY is_promoted DESC";		
			$_a_dataDownload = $starter->database->prepare_query($s_query,array(),'','download_id');
			foreach($_a_dataDownload as $key => $val){
				$a_dataDownload[$key] = $key;
			}
			foreach($_a_dataDownload as $key => $val){
				$__a_dataDownload[$key] = $val;
			}

			if( $starter->utils->is__countable($_a_data) && count($_a_data) > 0)
				foreach($_a_data as $key => $val)
				{
					if(in_array($val['docId'],$a_dataDownload))
					{
						$val['is_promoted'] = $__a_dataDownload[$val['docId']]['is_promoted'] ;
						$_tmp[] = $val;
					}
			}
			
			$a_data = $_tmp;
		break;

		default :
	 	case '':
			if(!empty($s_search[0]) && $s_search != strtolower($starter->_get_lexique('Recherche')))
				$i_searchCase += 1;
			
			if(!empty($s_searchCat[0]))
				$i_searchCase += 2;
			
			if(!empty($s_searchCharte[0]))
				$i_searchCase += 4;
				

			if($i_searchCase != 0)
			{
				$_a_data = array();
				switch($i_searchCase){
						
						case 1:

							$_a_charte = array();
							foreach($a_charte as $_key => $_val)
								if(preg_match('#' . $s_search . '#',strtolower($_val['detail_label'])) || preg_match('#' . $s_search . '#',strtolower($_val['tree_label'])))
									$_a_charte[] = $_val['charte_id'];
							
							$_a_cat = array();
							foreach($a_cat as $_key => $_val)
								if(preg_match('#' . $s_search . '#',strtolower($_val['detail_label'])) || preg_match('#' . $s_search . '#',strtolower($_val['category_label'])))
									$_a_cat[] = $_val['category_id'];

							foreach($a_data as $key => $val)
								if(in_array($val['download_category'], $_aCat) && (in_array($val['download_category'], $_a_cat) || preg_match('#' . $s_search . '#',strtolower($val['detail_download_label'])) || preg_match('#' . $s_search . '#',strtolower($val['download_label'])) || preg_match('#' . $s_search . '#',strtolower($val['detail_download_text']))))
									$_a_data[] = $val;
							
						break;
						
						case 2:
							$_a_tmp_cat = json_decode($s_searchCat);
							$_a_tmp_cat = $_a_tmp_cat[0];
							$_a_tmp_cat = $_a_tmp_cat->index;

							foreach($a_data as $key => $val)
								if(in_array($val['download_category'], $_a_cat) && in_array($val['download_category'], $_a_tmp_cat))
									$_a_data[] = $val;					
						break;
						
						case 3:
							$_a_charte = array();
							foreach($a_charte as $_key => $_val)
								if(preg_match('#' . $s_search . '#',$_val['detail_label']) || preg_match('#' . $s_search . '#',strtolower($_val['tree_label'])))
									$_a_charte[] = $_val['charte_id'];
												
							$_a_tmp_cat = json_decode($s_searchCat);
							$_a_tmp_cat = $_a_tmp_cat[0];
							$_a_tmp_cat = $_a_tmp_cat->index;
								
							foreach($a_data as $key => $val)
								if(in_array($val['download_category'], $_aCat) && (in_array($val['download_category'], $_a_tmp_cat) || preg_match('#' . $s_search . '#',strtolower($val['detail_download_label'])) || preg_match('#' . $s_search . '#',strtolower($val['download_label'])) || preg_match('#' . $s_search . '#',strtolower($val['detail_download_text']))))
									$_a_data[] = $val;
						break;
						
						case 4:
							$_a_tmp_charte = json_decode($s_searchCharte);
							$_a_tmp_charte = $_a_tmp_charte[0];
							$_a_tmp_charte = $_a_tmp_charte->index;
								
							foreach($a_data as $key => $val)
								if(in_array($val['download_category'], $_a_cat) )
									$_a_data[] = $val;
						break;
						
						case 5:
							$_a_tmp_charte = json_decode($s_searchCharte);
							$_a_tmp_charte = $_a_tmp_charte[0];
							$_a_tmp_charte = $_a_tmp_charte->index;

							$_a_cat = array();
							foreach($a_cat as $_key => $_val)
								if((preg_match('#' . $s_search . '#',$_val['detail_label']) || preg_match('#' . $s_search . '#',strtolower($_val['category_name']))))
									$_a_cat[] = $_val['category_id'];
								
							foreach($a_data as $key => $val)
								if(in_array($val['download_category'], $_aCat) && (in_array($val['download_category'], $_a_cat) || preg_match('#' . $s_search . '#',strtolower($val['detail_download_label'])) || preg_match('#' . $s_search . '#',strtolower($val['download_label'])) || preg_match('#' . $s_search . '#',strtolower($val['detail_download_text']))))
									$_a_data[] = $val;
						break;
						
						case 6:
							$_a_tmp_charte = json_decode($s_searchCharte);
							$_a_tmp_charte = $_a_tmp_charte[0];
							$_a_tmp_charte = $_a_tmp_charte->index;
							
							$_a_tmp_cat = json_decode($s_searchCat);
							$_a_tmp_cat = $_a_tmp_cat[0];
							$_a_tmp_cat = $_a_tmp_cat->index;
							foreach($a_data as $key => $val)
								if(in_array($val['download_category'], $_a_cat) && in_array($val['download_category'], $_a_tmp_cat))
									$_a_data[] = $val;
						break;
						
						case 7:
							$_a_tmp_charte = json_decode($s_searchCharte);
							$_a_tmp_charte = $_a_tmp_charte[0];
							$_a_tmp_charte = $_a_tmp_charte->index;

							$_a_tmp_cat = json_decode($s_searchCat);
							$_a_tmp_cat = $_a_tmp_cat[0];
							$_a_tmp_cat = $_a_tmp_cat->index;
								
							foreach($a_data as $key => $val)					
								if(in_array($val['download_category'], $_aCat) && in_array($val['download_category'], $_a_tmp_cat) && (in_array($val['download_category'], $_a_cat) || preg_match('#' . $s_search . '#',strtolower($val['detail_download_label'])) || preg_match('#' . $s_search . '#',strtolower($val['download_label'])) || preg_match('#' . $s_search . '#',strtolower($val['detail_download_text']))))
									$_a_data[] = $val;
						break;
					}
				$a_data = $_a_data;
				
			}
		break;
	}
}

$i_total = ($starter->utils->is__countable($a_data) ? count($a_data) : 0);
$i_nb_pages = ceil(($starter->utils->is__countable($a_data) ? count($a_data) : 0) / $i_range);
?>
