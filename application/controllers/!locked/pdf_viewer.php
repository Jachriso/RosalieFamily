<?php
$s_form_file = htmlentities($_GET['file']);

	$s_pdf_file_path = APPLICATION_PATH . '/../web/content/bdd/' . $s_form_file;
	$s_pdf_file_path_secure = APPLICATION_PATH . '/../secure/' . $s_form_file;

	if(!is_file($s_pdf_file_path))
	{
		$s_pdf_file = '';
		if(!is_file($s_pdf_file_path_secure))
		{
			$s_pdf_file = '';
		}
		else
			$s_pdf_file = $starter->MEDIA_DOWNLOAD . $s_form_file;			
	}else		
		$s_pdf_file = $starter->CDN_PATH . $s_form_file;
?>

<!DOCTYPE html>
<!--
Copyright 2012 Mozilla Foundation

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

Adobe CMap resources are covered by their own copyright and license:
http://sourceforge.net/adobe/cmap/wiki/License/
-->
<html dir="ltr" mozdisallowselectionprint moznomarginboxes>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="google" content="notranslate">
    <title>PDF viewer</title>
	
	<script type="text/javascript" src="../lib/jquery/js/jquery.js"></script> 
	<script type="text/javascript" src="../lib/jquery/js/jquery.gdocsviewer.min.js"></script> 
    <script type="text/javascript"> 
    /*<![CDATA[*/
    $(document).ready(function() {
        $('a.embed').gdocsViewer({width: 600, height: 750});
    });
    /*]]>*/
    </script> 
    </head>
<body>
<div style="width:960px; margin:0 auto; padding:20px;">
	<div>
		<a href="<?php echo $s_pdf_file;?>" class="embed" id="test"></a>
	</div>
</div>
</body>
</html>
<?php
exit;
?>
