<?php
// init vars
if(isset($_POST['datasrc'])) 		
	$base64String 		= $_POST['datasrc'];
if(isset($_POST['filename'])) 		
	$filename 			= $_POST['filename'];
//$base64String = "kfezyufgzefhzefjizjfzfzefzefhuze"; // I put a static base64 string, you can implement you special code to retrieve the data received via the request.
$filename = basename($filename);
$filePath = dirname( __FILE__ ) . "/../../../../../../web/content/bdd/" . $filename;

$base64String = str_replace('data:image/png;base64,', '', $base64String);
$base64String = str_replace(' ', '+', $base64String);
$base64String = str_replace('data:image/jpeg;base64,', '', $base64String);
$base64String = str_replace('data:image/gif;base64,', '', $base64String);
file_put_contents($filePath, base64_decode($base64String));
$a_output['response_code'] = 0 ;
$a_output['response_data'] = $filename ;

// output
echo json_encode($a_output);
exit ;
?>