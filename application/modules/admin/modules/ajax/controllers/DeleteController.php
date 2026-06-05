<?php
require_once APPLICATION_PATH . '/controllers/!locked/BackController.php';
class Delete extends Starter
{
	private $a_output = array();

	function __construct() {
        $this->init();
    }

    private function init(){
    	global $starter;
 		
		$s_module = (isset($_POST['module']) ? $_POST['module'] : '');
		$s_page = (isset($_POST['page']) ? $_POST['page'] : '');
		$s_config = (isset($_POST['iConfig']) ? $_POST['iConfig'] : '');
		$s_item	= (isset($_POST['iItem']) ? $_POST['iItem'] : '');
		$s_key = (isset($_POST['ikey']) ? $_POST['ikey'] : '');
		$s_addon = (isset($_POST['addon']) ? $_POST['addon'] : '');
		$s_token = (isset($_POST['token']) ? $_POST['token'] : '');

		$request = new BackController();

		if($s_config == '' || $s_item == '' || $s_key == '' )
		{
			$s_html = $starter->_get_lexique("erreur de mise à jour",1);
			$this->a_output['response_message'] = $s_html ;
			$this->a_output['response_code'] = 1 ;

			// output
			$this->view();
		}
		$o_conf = (isset($starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config]) ? $starter->database->configs[$s_page]['content'][$s_module]['content'][$s_config] : '');

		switch($s_addon)
		{
			case 'default':
				if($starter->archiv){
					$request->updateContent($s_item, $o_conf, $s_key);
				}
				else{
					$request->deleteContent($s_item, $o_conf, $s_key);
					
					if(isset($o_conf['external']) && !empty($o_conf['external']))	
					{
						foreach($o_conf['external'] as $key => $val)
						{
							$request->deleteContent($s_item, $val, $val['key']);
						}
					}	
				}

				if(in_array("sort", $o_conf['actions'])){
					$aData = $request->sortContent($o_conf['cle'], $o_conf['table'], $o_conf['tri']);
					$starter->database->sort_table($s_page, $s_config, $s_module, 'delete', $aData, '', '');
				}
				
				$s_html = $starter->_get_lexique("mise à jour ok",1);
				$this->a_output['response_message'] = $s_html ;
				$this->a_output['response_field'] = $s_item ;
				$this->a_output['response_value'] = 1 ;
				$this->a_output['response_code'] = 0 ;

				// output
				$this->view();
			break;

			case 'tree':
				$_aData = $request->selectTree($s_item, $o_conf, $s_key);
				require_once APPLICATION_PATH . '/controllers/!locked/MenuController.php';
				$menu = new MenuController();
				$_aData = $menu->getTree($_aData['tree_level'], 0, true, $s_item);

				if($starter->archiv){
					$request->updateContent($s_item, $o_conf, $s_key);
				}
				else{
					$request->deleteContent($s_item, $o_conf, $s_key);

					if(isset($o_conf['external']) && !empty($o_conf['external']))
					{
						foreach($o_conf['external'] as $key => $val)
						{
							$request->deleteContent($s_item, $val, $val['key']);
						}
					}
				}

				if(isset($_aData[$s_item]['children']) && $_aData[$s_item]['children'] > 0){
					foreach($_aData[$s_item]['children'] as $element => $child )
					{
						if($starter->archiv){
							$request->updateContent($child['tree_id'], $o_conf, $o_conf['cle']);
						}
						else{
							$request->deleteContent($child['tree_id'], $o_conf, $o_conf['cle']);

							if(isset($o_conf['external']) && !empty($o_conf['external']))	
							{
								foreach($o_conf['external'] as $key => $val)
								{
									$request->deleteContent($child['tree_id'], $val, $val['key']);
								}
							}
						}

						if($child['children'] > 0)
							foreach($child['children'] as $element => $secondChild )
							{
								if($starter->archiv){
									$request->updateContent($secondChild['tree_id'], $o_conf, $o_conf['cle']);
								}
								else{
									$request->deleteContent($secondChild['tree_id'], $o_conf, $o_conf['cle']);

									if(isset($o_conf['external']) && !empty($o_conf['external']))	
									{
										foreach($o_conf['external'] as $key => $val)
										{
											$request->deleteContent($secondChild['tree_id'], $val, $val['key']);
										}
									}
								}

								if($secondChild['children'] > 0)
									foreach($secondChild['children'] as $element => $thirdChild )
									{
										if($starter->archiv){
											$request->updateContent($thirdChild['tree_id'], $o_conf, $o_conf['cle']);
										}
										else{
											$request->deleteContent($thirdChild['tree_id'], $o_conf, $o_conf['cle']);

											if(isset($o_conf['external']) && !empty($o_conf['external']))	
											{
												foreach($o_conf['external'] as $key => $val)
												{
													$request->deleteContent($thirdChild['tree_id'], $val, $val['key']);
												}
											}
										}
										
										if($thirdChild['children'] > 0)
											foreach($thirdChild['children'] as $element => $lastChild )
											{
												if($starter->archiv){
													$request->updateContent($lastChild['tree_id'], $o_conf, $o_conf['cle']);
												}
												else{
													$request->deleteContent($lastChild['tree_id'], $o_conf, $o_conf['cle']);

													if(isset($o_conf['external']) && !empty($o_conf['external']))	
													{
														foreach($o_conf['external'] as $key => $val)
														{
															$request->deleteContent($lastChild['tree_id'], $val, $val['key']);
														}
													}
												}
											}
										
									}
							}
					}
				}
				$_parent = $request->sortTree( $o_conf, $s_item);
				$aData = $request->selectComplexeContent($s_item, $o_conf, $s_key, $_parent);
			
				if(in_array("sort", $o_conf['more_actions']))
					$starter->database->sort_table($s_page, $s_config, $s_module, 'sortcomplexe', $aData, '', '');						
					
				$s_html = $starter->_get_lexique("mise à jour ok",1);
				$this->a_output['response_message'] = $s_html ;
				$this->a_output['response_field'] = $s_item ;
				$this->a_output['response_value'] = 1 ;
				$this->a_output['response_code'] = 0 ;

				// output
				$this->view();
			break;

			case '':
			default:
				$s_html = $starter->_get_lexique("erreur de mise à jour",1);
				$this->a_output['response_message'] = $s_html ;
				$this->a_output['response_code'] = 1 ;
				// output
				$this->view();
			break;
		}
    }

    private function view(){
    	// output
		echo json_encode($this->a_output);
		exit ;
    }
}
?>