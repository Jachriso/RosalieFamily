<?php
header('Content-type: text/html; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
header("Cache-Control: max-age=3600, no-cache, no-store, must-revalidate, private"); //HTTP 1.1
header("Pragma: no-cache"); //HTTP 1.0
header("X-XSS-Protection: 1"); 
header("strict-transport-security: max-age=600");
header("Set-Cookie: name=value; httpOnly" );
header('X-Frame-Options: SAMEORIGIN');
?>
<!DOCTYPE HTML>
<!--
/*
 * jQuery File Upload Plugin Demo 9.1.0
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->
<html lang="en">
<head>
<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<meta charset="utf-8">
<title><?php echo $starter->_get_lexique('Upload multiple...');?></title>
<meta name="description" content="File Upload widget with multiple file selection, drag&amp;drop support, progress bars, validation and preview images, audio and video for jQuery. Supports cross-domain, chunked and resumable file uploads and client-side image resizing. Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap styles -->
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>!locked/lib/bootstrap/css/bootstrap.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>!locked/lib/jquery-uploader/css/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>!locked/lib/jquery-uploader/css/jquery.fileupload.css">
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>!locked/lib/jquery-uploader/css/jquery.fileupload-ui.css">

<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>!locked/css/reset.css">
<link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT . "templates/" . $starter->s_template . "/modules/admin/!locked/css/main.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>!locked/lib/jquery-uploader/css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="<?php echo $starter->HTTP_ROOT;?>!locked/lib/jquery-uploader/css/jquery.fileupload-ui-noscript.css"></noscript>
</head>
<body class="<?php if($_GET['embed']== true) echo 'embedded' ?> fileupload">
<div class="container text-center">
    <h1><?php echo $starter->_get_lexique('Upload multiple...');?></h1>
    <!-- The file upload form used as target for the file upload widget -->
    
      <div class="panel panel-default text-center">
        <div class="panel-body">
        <div class="addon-info">
<?php if(isset($a_data['maxfilesize'])){?>
                <p><?php echo $starter->_get_lexique('maxfilesize : ');?><strong><?php echo $starter->utils->displayBytesLabel($a_data['maxfilesize']);?></strong></p>
<?php }if(isset($a_data['allowedFileExtensions'])){?>
                <p><?php echo $starter->_get_lexique('extensions autorisées : ');?> (<strong><?php echo $a_data['allowedFileExtensions'];?></strong>)</p>
<?php }?>           
        </div>
        </div>
    </div>
    
    
    <form id="fileupload" action="//jquery-file-upload.appspot.com/" method="post" enctype="multipart/form-data">
        <input autocomplete="OFF" id="specialdir" name="specialdir" type="hidden" value="<?php echo $_SESSION['specialdir'];?>" >
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input autocomplete="OFF" type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        
        <!-- The table listing the files available for upload/download -->
        <div role="presentation" class="table table-striped text-center">
                <div class="files">
                    <div class="add-zone fileinput-button">
                    <img src="<?php echo $starter->MEDIA_PATH;?>interface/add.svg" alt="">
                    <input autocomplete="OFF" type="file" name="files[]" multiple>
                </div>
                </div>
        </div>
        
        <div class="row fileupload-buttonbar text-center">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                
                <button type="submit" class="btn start">
                    <span><?php echo $starter->_get_lexique("Uploader les images");?></span>
                </button>
                <button type="reset" class="btn cancel error" onclick="window.parent.$.fancybox.close();">
                    <span><?php echo $starter->_get_lexique('Fermer');?></span>
                </button>
                <!--<button type="button" class="btn delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span><?php echo $starter->_get_lexique('Supprimer...');?></span>
                </button>-->
                <input autocomplete="OFF" type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
    </form>

</div>
<!-- The blueimp Gallery widget -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">â€¹</a>
    <a class="next">â€º</a>
    <a class="close">ô—</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="template-upload fade text-center">
            <span class="preview fill"></span>
            <div class="info">
                <!--<p class="name">{%=file.name%}</p>-->
                <strong class="error text-danger"></strong>
                <p class="size"><?php echo $starter->_get_lexique('Processing...');?></p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </div>
            {% if (!i && !o.options.autoUpload) { %}
                 <button class="btn start" disabled>
                      <i class="glyphicon glyphicon-upload"></i>
                      <span><?php echo $starter->_get_lexique('Commencer');?></span>
                 </button>
            {% } %}
            {% if (!i) { %}
                <div class="buttons">
                     <span class="cancel">
                          <img class="picto" src="<?php echo $starter->MEDIA_PATH?>interface/delete.svg" alt="delete"/>
                     </span>
                </div>
            {% } %}
    </div>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <div class="template-download fade text-center">
     
            <span class="preview fill" style="background-image: url({%=file.thumbnailUrl%})">
                {% if (file.thumbnailUrl) { %}
                    <!--<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>-->
                {% } %}
            </span>
                
                
            
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
                
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
                
                
                
                <div class="buttons">
                
                {% if (file.url) { %}
                     <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}><img class="picto" src="<?php echo $starter->MEDIA_PATH;?>interface/preview.svg" alt="view"/></a>
                {% } %}
                
            {% if (file.deleteUrl) { %}
                <span class="delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <img class="picto" src="<?php echo $starter->MEDIA_PATH?>interface/delete.svg" alt="delete"/>
                </span>
                <input autocomplete="OFF" type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <span class="cancel">
                    <img class="picto" src="<?php echo $starter->MEDIA_PATH?>interface/delete.svg" alt="delete"/>
                </span>
            {% } %}
                </div>
                
    </div>
{% } %}
</script>
<script src="../!locked/lib/jquery/js/jquery.js"></script>
<script src="../!locked/lib/jquery/js/jquery-ui.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="../!locked/lib/jquery-uploader/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="../!locked/lib/jquery-uploader/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="../!locked/lib/jquery-uploader/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="../!locked/lib/jquery-uploader/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="../!locked/lib/jquery-uploader/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="../!locked/lib/jquery-uploader/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="../!locked/lib/jquery-uploader/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="../!locked/lib/jquery-uploader/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="../!locked/lib/jquery-uploader/js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
</body> 
</html>
