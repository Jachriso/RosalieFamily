<?php

class indexation extends starter{
	
	public $aIndex			= array();
	
	public function __construct(){}
	
	public function setindexation($structure){

		foreach($structure->database->configs as $key => $val)
		{
			foreach($val['content'] as $content => $module)
			{
				foreach($module['content'] as $element => $config)
				{
					if($config['index'])
					{
						$_code = (!empty($config['indexCode']) ? $config['indexCode'] : $config['code']);

						if(!is_array($this->aIndex[$_code]))
							$this->aIndex[$_code] = array();
						
						$this->aIndex[$_code]['table'] = $config['table'];
						$this->aIndex[$_code]['key'] = $config['cle'];
						$this->aIndex[$_code]['code'] = $_code;
						
						foreach($config['champs'] as $item => $field)
						{
							$_field = (!empty($field['index_field']) ? $field['index_field'] : $field['champ']);
							
							if(isset($field['is_index']) && !in_array($_field, $this->aIndex[$_code]['champs'])){								
								if($field['type'] == "field_list" && isset($field['table_link']) && $field['is_index'] != "UnIndexed")
									$this->aIndex[$_code]['champs'][$_field] = array($field['champ']=>"linked");
								else
									$this->aIndex[$_code]['champs'][$field['champ']] = $field['is_index'];
							}
						}
						
						foreach($config['external'] as $item)
						{
							$this->aIndex[$_code]['external']['table'] = $item['table'];
							$this->aIndex[$_code]['external']['key'] = $item['key'];
							
							if(isset($item['languages']))
							{
								foreach($item['languages'] as $langs => $languages )
								{
									foreach($languages as $_item => $_value)
									{
										if(isset($_value['is_index']) && !in_array($_item, $this->aIndex[$_code]['external']['champs'])){
											if($_value['is_index'] == "Text")
												$this->aIndex[$_code]['external']['champs'][$_item . '_' . $item['code']] = array($_item=>$_value['is_index']);
											else
												$this->aIndex[$_code]['external']['champs'][$_item . '_' . $item['code'] . '_return'] = array($_item=>$_value['is_index']);
										}
									}
								}
							}
						}
					}
				}
			}
		}
		/*if($_SERVER['REMOTE_ADDR'] == "80.12.90.95")
		{
			$structure->utils->do_dump($this->aIndex);
			exit();
		}*/		
	}
		
	public function storeindexation($_conf, $_id = ''){
		
		global $starter;

		set_include_path(dirname( __file__ ) . '/zend-lucene/');
		require_once "Zend/Search/Lucene.php";	
		
		$_code = (!empty($_conf['indexCode']) ? $_conf['indexCode'] : $_conf['code']);
		$_tmpId = (isset($_GET['val_id']) ? htmlentities($_GET['val_id']) : $_id);
												
		$s_query_select = "
			SELECT t0." . $_conf['cle'] ;
					
		$s_query_from = "
			FROM " . $_conf['table'] . " AS t0";

		$s_query_where = "						
			WHERE t0.archive = 0 AND t0.online = 1 AND " . $_conf['cle'] . " = '" . $_tmpId . "'";
		/*$s_query_where = "						
			WHERE t0.archive = 0 AND t0.online = 1 ";*/
						
		$iCompt = 0;

		foreach($this->aIndex[$_code]['champs'] as $field => $index)
		{
			if($index != "UnStored" && $index != "linked" && (!isset($this->aIndex[$field]['code']) || (isset($this->aIndex[$field]['code']) && $this->aIndex[$field]['code'] == $this->aIndex[$_code]['code'])))
				$s_query_select .= "
					, t0." . $field;
		}		
		
		if(isset($this->aIndex[$_code]['external']) && count($this->aIndex[$_code]['external']) > 0)
		{
			$iCompt++;
			foreach($this->aIndex[$_code]['external']['champs'] as $field => $index)
			{					
				$s_query_select .= "
					, t" . $iCompt . "." . array_shift(array_keys($index));				
			}
			
			$s_query_from .= "
				LEFT OUTER JOIN " . $this->aIndex[$_code]['external']['table'] . " AS t" . $iCompt . "
				ON  t" . $iCompt . "." . $this->aIndex[$_code]['external']['key'] . " = t0." . $this->aIndex[$_code]['key'];
		}
		
		foreach($this->aIndex[$_code]['champs'] as $field => $index)
		{
			if(is_array($index)){
				$s_query_select .= "
					, t0." . array_shift(array_keys($index));
													
				$iCompt ++;
				$s_query_select .= "
					, t" . $iCompt . "." . $this->aIndex[$field]['key'];
				foreach($this->aIndex[$field]['champs'] as $_field => $_index)
				{
					if($_index != "UnStored" )
						$s_query_select .= "
							, t" . $iCompt . "." . $_field;
				}
				$s_query_from .= "
					INNER JOIN " . $this->aIndex[$field]['table'] . " AS t" . $iCompt . "
					ON  t" . $iCompt . "." . $this->aIndex[$field]['key'] . " = t0." . array_shift(array_keys($index));
				
				$s_query_where .= "
					AND t" . $iCompt . ".archive = 0";	
						
				if(isset($this->aIndex[$field]['external']) && count($this->aIndex[$field]['external']) > 0)
				{
					$iComptExt = $iCompt;
					$iComptExt ++;
					
					foreach($this->aIndex[$field]['external']['champs'] as $_field => $_index)
					{					
						$s_query_select .= "
							, t" . $iComptExt . "." . array_shift(array_keys($_index)) . " AS " . $_field;
					}
					
					$s_query_from .= "
						LEFT OUTER JOIN " . $this->aIndex[$field]['external']['table'] . " AS t" . $iComptExt . "
						ON  (t" . $iComptExt . ".lang = t1.lang AND t" . $iComptExt . "." . $this->aIndex[$field]['external']['key'] . " = t" . ($iCompt) . "." . $this->aIndex[$field]['key'] . ')';
						
					$iCompt = $iComptExt;
				}
			}
		}	
		$s_query = $s_query_select . $s_query_from . $s_query_where ;

		$a_data = $starter->database->prepare_query($s_query, array(), 'multiple');

		require_once dirname( __FILE__ ) . "/menu.class.php";	
		$menu = new menu();
			
		set_include_path(dirname( __file__ ) . '/zend-lucene/');
		require_once "Zend/Search/Lucene.php";	
		
		try
		{
			$index = Zend_Search_Lucene::open($starter->lucene_index);
		}
		catch (Zend_Search_Lucene_Exception $e)
		{
			$index = Zend_Search_Lucene::create($starter->lucene_index);
		}
		
		$index->optimize();
		
		$query = new Zend_Search_Lucene_Search_Query_MultiTerm();
		$query->addTerm(new Zend_Search_Lucene_Index_Term($_tmpId, 'docId'),true);
		$query->addTerm(new Zend_Search_Lucene_Index_Term($_code, 'indexType'));
			
		$hits  = $index->find($query);
		$_del = false;
		
		foreach ($hits as $hit) {
			$_del = ($hit->docId == $_tmpId ? $hit->id : 'false');
			
			if($hit->docId == $_tmpId){
				$_del = $hit->id;
				$index->delete($_del);
			}
		}

		foreach($a_data as $_key => $val)
		{
			$document = new Zend_Search_Lucene_Document ();
			$document->addField(Zend_Search_Lucene_Field::Text('indexType', $_code));
			//$document->addField(Zend_Search_Lucene_Field::Keyword('docId', $val[$_conf['cle']])) ;	
			$document->addField(Zend_Search_Lucene_Field::Keyword('docId', $_tmpId)) ;	

			switch($_code){
				case 'tree':
					$_parents = $menu->lookForParents($val, true, false, $val['lang']);
					if(count($menu->breadcrumb) == $val['tree_level']) 
					{
						$_referer = implode(',',$menu->breadcrumb) . '.html';
						$document->addField(Zend_Search_Lucene_Field::Text('uriReferer', $_referer)) ;		
					}else
						$document->addField(Zend_Search_Lucene_Field::Text('uriReferer', '')) ;
					$menu->breadcrumb = array();
				break;
				
				case 'download':
					$document->addField(Zend_Search_Lucene_Field::Keyword('download_category', $val['download_category'])) ;
					$document->addField(Zend_Search_Lucene_Field::Keyword('download_charte', $val['download_charte'])) ;
					$_referer = $menu->s_download . '/' . $val['detail_referer'] . '.html';
					$document->addField(Zend_Search_Lucene_Field::Text('uriReferer', $_referer)) ;
				break;
				
				case 'creative_gallery':
					$document->addField(Zend_Search_Lucene_Field::Keyword('gallery_category', $val['gallery_category'])) ;
					$document->addField(Zend_Search_Lucene_Field::Keyword('gallery_cible', $val['gallery_cible'])) ;
					$document->addField(Zend_Search_Lucene_Field::Keyword('gallery_country', $val['gallery_country'])) ;
					$document->addField(Zend_Search_Lucene_Field::Keyword('gallery_entite', $val['gallery_entite'])) ;
					$_referer = $menu->s_creative . '/' . $val['detail_referer'] . '.html';
					$document->addField(Zend_Search_Lucene_Field::Text('uriReferer', $_referer)) ;
				break;
			}

			
			foreach($val as $__key => $_val )
			{
				$document->addField(Zend_Search_Lucene_Field::Text($__key, $_val, 'utf-8')) ;
			}
						
			$index->addDocument($document);
		}
		$index->commit();
	}
	/*
	public function getindexation($_conf){
		
	}*/
}?>