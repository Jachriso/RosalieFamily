<?php 

$s_output = '<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />';

$s_output .= '<table>';

$s_output .= '<tr style="background:black; color:white; font-weight:bold">';

$s_output .= '<td></td>';

if($_POST['sType'] == "trafic_stat" && $starter->utils->is__countable($a_trafic_stat) && count($a_trafic_stat) > 0)
{
	foreach($a_group as $item => $value)
		$s_output .= '<td>' . $value['group_name'] . '</td>';
	
	$s_output .= '<td>' . $starter->_get_lexique('total',1) . '</td>';
	
	$s_output .= '</tr>';

	foreach($a_trafic_stat as $key => $val)
	{		
        if(isset($val['stat']) && $starter->utils->is__countable($val['stat']) && count($val['stat']) > 0)
		{
			$s_output .= '<tr>';
			
			$s_output .= '<td>' . $key . '</td>';
			                  
            foreach($a_group as $item => $value)			
				$s_output .= '<td>' . (isset($val['stat'][$item]['stats']) ? $val['stat'][$item]['stats'] : 0) . '</td>';
				
			$s_output .= '<td>' . $val['stat-total'] . '</td>';
			
			$s_output .= '</tr>';
        }
	} 
}
elseif($_POST['sType'] == "tree_stat" && $starter->utils->is__countable($a_tree_stat) && count($a_tree_stat) > 0)
{
	$s_output .= '<td></td>';
	
	$s_output .= '<td></td>';

	$s_output .= '<td></td>';
	
	foreach($a_group as $item => $value)
		$s_output .= '<td>' . $value['group_name'] . '</td>';
	
	$s_output .= '<td>' . $starter->_get_lexique('total',1) . '</td>';
	
	$s_output .= '</tr>';
	
	foreach($a_tree_stat as $key => $val)
	{		
        if(isset($val['stat']) && $starter->utils->is__countable($val['stat']) && count($val['stat']) > 0)
		{		      
			$s_output .= '<tr>';
			
			$s_output .= '<td bgcolor="#1762FF">' . $val['tree_label'] . '</td>';
	
			$s_output .= '<td></td>';
			
			$s_output .= '<td></td>';
		
			$s_output .= '<td></td>';
			                  
            foreach($a_group as $item => $value)			
				$s_output .= '<td>' . (isset($val['stat'][$item]['stats']) ? $val['stat'][$item]['stats'] : 0) . '</td>';
				
			$s_output .= '<td>' . $val['stat-total'] . '</td>';
			
			$s_output .= '</tr>';
			
            if(isset($val['children']) && $starter->utils->is__countable($val['children']) && count($val['children']) > 0)
			{
				foreach($val['children'] as $children => $childrenval)
				{
                    if(isset($childrenval['stat']) && $starter->utils->is__countable($childrenval['stat']) && count($childrenval['stat']) > 0)
					{
						$s_output .= '<tr>';
				
						$s_output .= '<td></td>';
					
						$s_output .= '<td bgcolor="#FEDA31">' . $childrenval['tree_label'] . '</td>';
						
						$s_output .= '<td></td>';
					
						$s_output .= '<td></td>';
						
						foreach($a_group as $item => $value)			
							$s_output .= '<td>' . (isset($childrenval['stat'][$item]['stats']) ? $childrenval['stat'][$item]['stats'] : 0) . '</td>';
							
						$s_output .= '<td>' . $childrenval['stat-total'] . '</td>';
						
						$s_output .= '</tr>';
						
						if(isset($childrenval['children']) && $starter->utils->is__countable($childrenval['children']) && count($childrenval['children']) > 0)
						{
							foreach($childrenval['children'] as $child => $childval)
							{
								if(isset($childval['stat']) && $starter->utils->is__countable($childval['stat']) && count($childval['stat']) > 0)
								{
									$s_output .= '<tr>';
							
									$s_output .= '<td></td>';
									
									$s_output .= '<td></td>';
								
									$s_output .= '<td bgcolor="#FFB117">' . $childval['tree_label'] . '</td>';
								
									$s_output .= '<td></td>';
									
									foreach($a_group as $item => $value)			
										$s_output .= '<td>' . (isset($childval['stat'][$item]['stats']) ? $childval['stat'][$item]['stats'] : 0) . '</td>';
										
									$s_output .= '<td>' . $childval['stat-total'] . '</td>';
									
									$s_output .= '</tr>';
									
									if(isset($childval['children']) && $starter->utils->is__countable($childval['children']) && count($childval['children']) > 0)
									{
										foreach($childval['children'] as $childEnd => $childEndval)
										{
											if(isset($childEndval['stat']) && $starter->utils->is__countable($childEndval['stat']) && count($childEndval['stat']) > 0)
											{
												$s_output .= '<tr>';
										
												$s_output .= '<td></td>';
												
												$s_output .= '<td></td>';
											
												$s_output .= '<td></td>';
											
												$s_output .= '<td bgcolor="#B90092">' . $childEndval['tree_label'] . '</td>';
												
												foreach($a_group as $item => $value)			
													$s_output .= '<td>' . (isset($childEndval['stat'][$item]['stats']) ? $childEndval['stat'][$item]['stats'] : 0) . '</td>';
													
												$s_output .= '<td>' . $childEndval['stat-total'] . '</td>';
												
												$s_output .= '</tr>';
									
											}
										}
									}
								}
							}
						}
					}
				}
			}
			else if(isset($val['stat-news']) && $starter->utils->is__countable($val['stat-news']) && count($val['stat-news']) > 0)
			{
				foreach($val['stat-news'] as $children => $childrenval)
				{
					if(isset($childrenval['stat']) && $starter->utils->is__countable($childrenval['stat']) && count($childrenval['stat']) > 0)
					{
						$s_output .= '<tr>';
				
						$s_output .= '<td></td>';
					
						$s_output .= '<td>' . $childrenval['news_title'] . '</td>';
						
						$s_output .= '<td></td>';
					
						$s_output .= '<td></td>';
						
						foreach($a_group as $item => $value)			
							$s_output .= '<td>' . (isset($childrenval['stat'][$item]['stats']) ? $childrenval['stat'][$item]['stats'] : 0) . '</td>';
							
						$s_output .= '<td>' . $childrenval['stat-total'] . '</td>';
						
						$s_output .= '</tr>';
					}
				}
			}
			else if(isset($val['stat-downloads']) && $starter->utils->is__countable($val['stat-downloads']) && count($val['stat-downloads']) >0)
			{
				foreach($val['stat-downloads'] as $children => $childrenval)
				{
					if(isset($childrenval['stat']) && $starter->utils->is__countable($childrenval['stat']) && count($childrenval['stat']) > 0)
					{
						$s_output .= '<tr>';
				
						$s_output .= '<td></td>';
					
						$s_output .= '<td>' . $childrenval['download_name'] . '</td>';
						
						$s_output .= '<td></td>';
					
						$s_output .= '<td></td>';
						
						foreach($a_group as $item => $value)			
							$s_output .= '<td>' . (isset($childrenval['stat'][$item]['stats']) ? $childrenval['stat'][$item]['stats'] : 0) . '</td>';
							
						$s_output .= '<td>' . $childrenval['stat-total'] . '</td>';
						
						$s_output .= '</tr>';
					}
				}
			}
        }
	} 
}
elseif($_POST['sType'] == "download_stat" && $starter->utils->is__countable($a_download_stat) && count($a_download_stat) > 0)
{
	$s_output .= '<td></td>';
	
	foreach($a_group as $item => $value)
		$s_output .= '<td>' . $value['group_name'] . '</td>';
	
	$s_output .= '<td>' . $starter->_get_lexique('total',1) . '</td>';
	
	$s_output .= '</tr>';

	foreach($a_download_stat as $key => $val)
	{		
        if(isset($val['stat']) && $starter->utils->is__countable($val['stat']) && count($val['stat']) > 0)
		{
			$s_output .= '<tr>';
			
			$s_output .= '<td>' . $val['download_name'] . '</td>';
			
			$s_output .= '<td></td>';
			                  
            foreach($a_group as $item => $value)			
				$s_output .= '<td>' . (isset($val['stat'][$item]['stats']) ? $val['stat'][$item]['stats'] : 0) . '</td>';
				
			$s_output .= '<td>' . $val['stat-total'] . '</td>';
			
			$s_output .= '</tr>';
			
			$s_output .= $val['stat'][$item]['detailxls'];
        }
	} 
}
elseif($_POST['sType'] == "commande_download_stat" && $starter->utils->is__countable($a_commande_download_stat) && count($a_commande_download_stat) > 0)
{
	$s_output .= '<td></td>';
	
	foreach($a_group as $item => $value)
		$s_output .= '<td>' . $value['group_name'] . '</td>';
	
	$s_output .= '<td>' . $starter->_get_lexique('total',1) . '</td>';
	
	$s_output .= '</tr>';

	foreach($a_commande_download_stat as $key => $val)
	{		
        if(isset($val['stat']) && $starter->utils->is__countable($val['stat']) && count($val['stat']) >0)
		{
			$s_output .= '<tr>';
			
			$s_output .= '<td>' . $val['stat-name'] . '</td>';
			
			$s_output .= '<td></td>';
			                  
            foreach($a_group as $item => $value)			
				$s_output .= '<td>' . (isset($val['stat'][$item]['stats']) ? $val['stat'][$item]['stats'] : 0) . '</td>';
				
			$s_output .= '<td>' . $val['stat-total'] . '</td>';
			
			$s_output .= '</tr>';
			
			$s_output .= $val['stat'][$item]['detailxls'];
        }
	} 
}
elseif($_POST['sType'] == "commandes_stat" && $starter->utils->is__countable($a_commandes_stat) && count($a_commandes_stat) > 0)
{
	$s_output .= '<td></td>';
	
	foreach($a_group as $item => $value)
		$s_output .= '<td>' . $value['group_name'] . '</td>';
	
	$s_output .= '<td>' . $starter->_get_lexique('total',1) . '</td>';
	
	$s_output .= '</tr>';

	foreach($a_commandes_stat as $key => $val)
	{		
        if(isset($val['stat']) && $starter->utils->is__countable($val['stat']) && count($val['stat']) > 0)
		{
			$s_output .= '<tr>';
			
			$s_output .= '<td>' . $val['stat-name'] . '</td>';
			
			$s_output .= '<td></td>';
			                  
            foreach($a_group as $item => $value)			
				$s_output .= '<td>' . (isset($val['stat'][$item]['stats']) ? $val['stat'][$item]['stats'] : 0) . '</td>';
				
			$s_output .= '<td>' . $val['stat-total'] . '</td>';
			
			$s_output .= '</tr>';
			
			$s_output .= $val['stat'][$item]['detailxls'];
        }
	} 
}
elseif($_POST['sType'] == "imt_stat" && $starter->utils->is__countable($a_playda_stat) && count($a_playda_stat) > 0)
{
	
	$s_output .= '</tr>';

	foreach($a_playda_stat as $key => $val)
	{		
        $s_output .= '<tr>';
			
		$s_output .= '<td>' .  $val['name'] . $val['stats'] . '</td>';
			 			
		$s_output .= '</tr>';
     
	} 
}elseif($_POST['sType'] == "users_stat" && $starter->utils->is__countable($a_users_stat) & count($a_users_stat) > 0)
{
		
	foreach ($a_users_stat[0] as $item => $value)
		
		$s_output .= '<td>' .  $item . '</td>';
			 			
	$s_output .= '</tr>';
	
	foreach ($a_users_stat as $key => $val)
	{
		$s_output .= '<tr>';
		
		$s_output .= '<td></td>';
		
		foreach ($val as $value)
		
			$s_output .= '<td>' .  $value . '</td>';
			 			
		$s_output .= '</tr>';
	}
}
$s_output .= '</table>';
