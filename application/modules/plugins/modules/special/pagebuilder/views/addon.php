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
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Security-Policy" content="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Html Editor</title>

        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="/!locked/lib/bootstrap/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="/!locked/lib/bootstrap/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.8.0/styles/default.min.css">

        <link rel="stylesheet" href="/templates/<?php echo $starter->s_template ;?>/modules/plugins/special/pagebuilder/css/theme.css">
        <link rel="stylesheet" type="text/css" href="/templates/<?php echo $starter->s_template ;?>/modules/plugins/special/pagebuilder/css/bootstrap-colorselector.css" />


        <script src="/!locked/lib/jquery/js/jquery.js"></script>
        <script src="/!locked/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/ace/1.2.0/min/ace.js"></script>
        <script src="/!locked/lib/tinymce_back/tinymce.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/!locked/lib/jquery/js/jquery-ui.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
        <script src="/templates/<?php echo $starter->s_template ;?>/modules/plugins/special/pagebuilder/js/bootstrap-colorselector.js"></script>

        <script> var path = '';

            function insertImg(image){
                $('#img-url').val(image);
                $('#imgContent').children('img').attr('src', image);
            }
        </script>
        <script language="javascript" type="text/javascript" src='/templates/<?php echo $starter->s_template ;?>/modules/admin/!locked/js//admin/js/main.js'></script>
        <script  src="/templates/<?php echo $starter->s_template ;?>/modules/plugins/special/pagebuilder/js/app.js"></script>

        <style>
        .lyrow{
            margin-bottom:10px;
        }
        </style>

    </head>
    <body class="edit">
        <div class="navbar navbar-inverse navbar-fixed-top navbar-htmleditor">
            <div class="navbar-header">
                <button data-target="navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                    <span class="glyphicon-bar"></span>
                    <span class="glyphicon-bar"></span>
                    <span class="glyphicon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav" id="menu-htmleditor">
                    <li>
                        <div class="btn-group" data-toggle="buttons-radio">
                            <button type="button" id="edit" class="active btn btn-primary"><i class="glyphicon glyphicon-edit "></i> Edit</button>
                            <button type="button" class="btn btn-primary" id="sourcepreview"><i class="glyphicon-eye-open glyphicon"></i> Preview</button>
                            <button type="button" id="save" class="btn btn-warning float-right"><i class="fa fa-save"></i>&nbsp;save</button>
                        </div>
                        &nbsp;
                        <div class="btn-group" data-toggle="buttons-radio" id='add' style='display: none;'>
                            <button type="button" class="active btn btn-default" id="pc"><i class="fa fa-laptop"></i> Desktop</button>
                            <button type="button" class="btn btn-default" id="tablet"><i class="fa fa-tablet"></i> Tablet</button>
                            <button type="button" class="btn btn-default" id="mobile"><i class="fa fa-mobile"></i> Mobile</button>
                        </div>
                    </li>
                </ul>

            </div><!--/.navbar-collapse -->

        </div><!--/.navbar-fixed-top -->

        <div class="container">
            <div class="row">
                <div class="">
                    <div class="sidebar-nav">

                        <ul class="nav nav-list ">
                            <h3>Columns</h3>
                            <li class="rows" id="estRows">
<?php foreach($a_grids as $_grids){ 
    if(is_file(dirname( __FILE__ ) . '/grids/' . $_grids . '.php'))
        require dirname( __FILE__ ) . '/grids/' . $_grids . '.php';
    }?>
                            </li>
                        </ul>
                        <br>
                        <ul class="nav nav-list">
                            <h3>Content</h3>
                            <li class="boxes" id="elmBase">

                                <!--
                                <div class="box box-element" data-type="header">
                                    <a href="#close" class="remove btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></a>
                                    <a class="drag btn btn-default btn-xs"><i class="glyphicon glyphicon-move"></i></a>
                                    <span class="configuration">
                                        <a class="btn btn-xs btn-warning settings"  href="#" ><i class="fa fa-gear"></i></a>
                                    </span>

                                    <div class="preview">
                                        <i class="fa fa-header fa-2x"></i>
                                        <div class="element-desc">header</div>
                                    </div>
                                    <div class="view">
                                        <h2>HEADER TITLE</h2>
                                    </div>
                                </div>
                                -->
<?php foreach($a_templates as $_template){ 
    if(is_file(dirname( __FILE__ ) . '/templates/' . $_template . '.php'))
        require dirname( __FILE__ ) . '/templates/' . $_template . '.php';
    }?>
                                
                            </li>
                        </ul>
                    </div>
                </div>
                <!--/span-->
                <div class="htmlpage">
<?php echo (isset($_textbuilder['detail_textedit']) ? $_textbuilder['detail_textedit'] : '');?>
                </div>

                <!--/row-->

            </div><!--/.fluid-container-->



            <div class="modal fade" id="download" tabindex="-1" role="dialog" aria-labelledby="download" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class='fa fa-save'></i>&nbsp;Save as </h4>
                        </div>

                        <div class="modal-body" id='sourceCode'>
                            <textarea id="src" rows="10"></textarea>
                            <textarea id="model" rows="10" class="form-control"></textarea>
                        </div>
                        <div class="modal-footer">
                            <input autocomplete="OFF" type="hidden" id="fieldtosave" name="fieldtosave" value="<?php echo $s_form_field;?>">
                            <input autocomplete="OFF" type="hidden" id="fieldtosaveedit" name="fieldtosaveedit" value="<?php echo $s_form_fieldedit;?>">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-close'></i>&nbsp;Close</button>
                            <button type="button" class="btn btn-success" id="srcSave"><i class='fa fa-save'></i>&nbsp;Save</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="preferences" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content shadow">
                        <div class="modal-header">
                            <h4 class="modal-title" id="preferencesTitle"></h4>
                            <button type="button" class="close btnclose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body" id="preferencesContent">
                           <!--<iframe src="<?php echo $starter->HTTP_ROOT;?>plugins/pagebuilder/media-popup.html" style="width:100%; height:300px ; display:none;" frameborder="0" ></iframe>-->
                           <div  id="mediagallery"  style="overflow:auto;height:400px; display:none" >
                            <?php include dirname( __FILE__ ) . "/../controllers/media-popup.php";?>
                            <a class="btn btn-info" href="javascript:;" onclick="$('#mediagallery').hide();$('#thepref').show();">Return to image settings</a>
                           </div>
                            <div id="thepref">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#Settings" aria-controls="Settings" role="tab" data-toggle="tab">Settings</a></li>
                                    <li role="presentation"><a href="#CellSettings" aria-controls="profile" role="tab" data-toggle="tab">Cell settings</a></li>
                                    <li role="presentation"><a href="#RowSettings" aria-controls="messages" role="tab" data-toggle="tab">Row settings</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="Settings">
                                        <!-- header -->
                                        <div class="panel panel-body">



                                            <!----------------------------------------------------------------------------------->
                                            <!--                                      textarea                                 -->
                                            <!----------------------------------------------------------------------------------->
                                            <div id="ht" style="display: none;">
                                                <textarea id="html5editorLite" class="tinymceeditor"></textarea>
                                            </div>



                                            <!----------------------------------------------------------------------------------->
                                            <!--                                        text                                   -->
                                            <!----------------------------------------------------------------------------------->
                                            <!-- fine header -->
                                            <!-- text -->
                                            <div id="text" style="display: none;">
                                                <textarea id="html5editor" class="tinymceeditor"></textarea>
                                            </div>
                                            <!-- end text -->
                                            <!-- settaggio immagine -->



                                            <!----------------------------------------------------------------------------------->
                                            <!--                                        IMAGE                                  -->
                                            <!----------------------------------------------------------------------------------->
                                            <div id="image" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-5" >
                                                        <div id="imgContent">

                                                        </div>
                                                       <!-- <a class="btn btn-default form-control" href="#" id="gallery"><i class="icon-upload-alt"></i>&nbsp;Browse ....</a> -->

                                                        <a class="btn btn-xs btn-warning " href="javascript:moxman.browse({oninsert: function(args) {insertImg('<?php echo $starter->MEDIA_PATH;?>'+args.files[0].path);}});" ><i class="icon-upload-alt"></i>&nbsp;Browse ...</a>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="form-group">
                                                            <label for="img-url">Url :</label>
                                                            <input autocomplete="OFF" type="text" value="" id="img-url" class="form-control" />
                                                        </div>
                                                        <!--   <div class="form-group">
                                                               <label for="img-url">Click Url:</label>
                                                               <input type="text" value="" id="img-clickurl" class="form-control" />
                                                           </div>
                                                        -->
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="img-width">Width :</label>
                                                                    <input autocomplete="OFF" type="text" value="" id="img-width" class="form-control"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="img-height">Height :</label>
                                                                    <input autocomplete="OFF" type="text" value="" id="img-height" class="form-control"/>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="img-title">Title : </label>
                                                            <input autocomplete="OFF" type="text" value="" id="img-title" class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="img-rel">Rel :</label>
                                                            <input autocomplete="OFF" type="text" value="" id="img-rel" class="form-control"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                            <!----------------------------------------------------------------------------------->
                                            <!--                                       YOUTUBE                                 -->
                                            <!----------------------------------------------------------------------------------->
                                            <div id="youtube"  style="display:none">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="youtube-video">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="video-url">Video id :</label>
                                                                <input autocomplete="OFF" type="text" value="" id="video-url" class="form-control" />
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="video-width">Width :</label>
                                                                        <input autocomplete="OFF" type="text" value="" id="video-width" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="video-height">Height :</label>
                                                                        <input autocomplete="OFF" type="text" value="" id="video-height" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>



                                            <!----------------------------------------------------------------------------------->
                                            <!--                                        MAP                                    -->
                                            <!----------------------------------------------------------------------------------->
                                            <div id="map" style="display:none">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="map-content">

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="address">Latitude :</label>
                                                                <input autocomplete="OFF" type="text" value="" id="latitude" class="form-control" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="address">Longitude :</label>
                                                                <input autocomplete="OFF" type="text" value="" id="longitude" class="form-control" />
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="address">Zoom :</label>
                                                                <input autocomplete="OFF" type="text" value="" id="zoom" class="form-control" />
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="img-width">Width :</label>
                                                                        <input autocomplete="OFF" type="text" value="" id="map-width" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="img-height">Height :</label>
                                                                        <input autocomplete="OFF" type="text" value="" id="map-height" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            


                                            <!----------------------------------------------------------------------------------->
                                            <!--                                        button                                 -->
                                            <!----------------------------------------------------------------------------------->
                                            <div id="buttons" style="display:none">
                                                <div class="form-group">
                                                    <label> Label : </label>
                                                    <input autocomplete="OFF" type="text" class="form-control" id="buttonLabel"/>
                                                </div>

                                                <div class="form-group">
                                                    <label> Href : </label>
                                                    <input autocomplete="OFF" type="text" class="form-control" id="buttonHref"/>
                                                </div>
                                            </div>



                                            <!----------------------------------------------------------------------------------->
                                            <!--                                      download                                 -->
                                            <!----------------------------------------------------------------------------------->
                                            <div id="downloads" style="display:none">
                                                <div class="form-group">
                                                    <label> Label : </label>
                                                    <input autocomplete="OFF" type="text" class="form-control" id="downloadLabel"/>
                                                </div>
                                                <div>
                                                    <input type="hidden" id="downloadLink" value="" data-name="" data-country=""/>
                                                    <iframe id="select_download0" class="auto-height full" src="<?php echo $starter->HTTP_ROOT;?>plugins/select_download.html?{VALUE}" frameborder="0" data-value="" height="100%" width="100%"></iframe>
                                                </div>
                                            </div>




                                            <!----------------------------------------------------------------------------------->
                                            <!--                                  download button                              -->
                                            <!----------------------------------------------------------------------------------->
                                            <div id="downloadbs" style="display:none">
                                                <div class="form-group">
                                                    <label> Label : </label>
                                                    <input autocomplete="OFF" type="text" class="form-control" id="downloadbLabel" value="" />
                                                </div>
                                                <div>
                                                    <input type="hidden" id="downloadbLink" value="" data-name="" data-country=""/>
                                                    <iframe id="select_download" class="auto-height full" src="<?php echo $starter->HTTP_ROOT;?>plugins/select_download.html?{VALUE}" data-value="" frameborder="0" height="100%" width="100%"></iframe>
                                                </div>
                                            </div>




                                            <!----------------------------------------------------------------------------------->
                                            <!--                                  starter pack                              -->
                                            <!----------------------------------------------------------------------------------->
                                            <div id="starter" style="display:none">
                                                <div class="form-group">
                                                    <label> Label : </label>
                                                    <input autocomplete="OFF" type="text" class="form-control margB5" id="starterTitle" value=""/>
                                                    <textarea id="html5editorStarter" class="tinymceeditor"></textarea>
                                                    <label class="margT5"> Légende : </label>
                                                    <input autocomplete="OFF" type="text" class="form-control" id="starterLegend"/>
                                                </div>
                                                <div>
                                                    <input type="hidden" id="downloadstLink" value=""/>
                                                    <iframe class="auto-height full" src="<?php echo $starter->HTTP_ROOT;?>plugins/select_download.html?page=&module=&config_id=&lang=&ilang=&config=&field=&action=&val_id=" frameborder="0" height="100%" width="100%"></iframe>
                                                </div>
                                            </div>




                                            <!----------------------------------------------------------------------------------->
                                            <!--                                  Block Color                                  -->
                                            <!----------------------------------------------------------------------------------->
                                            <!-- POPIN ELEMENT COLOR -->
                                            <div id="colors"  style="display:none">
                                                 <div class="row">
                                                    <div class="col-md-12">
                                                        <div id="color-container">
                                                            Couleur
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="color-hexa">HEXA</label>
                                                                        <input type="text" value="" id="color-hexa" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="color-cmjnc">CMJN</label>
                                                                        <input type="text" value="" id="color-cmjnc" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="color-cmjnm">&nbsp;</label>
                                                                        <input type="text" value="" id="color-cmjnm" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="color-cmjnj">&nbsp;</label>
                                                                        <input type="text" value="" id="color-cmjnj" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="color-cmjnn">&nbsp;</label>
                                                                        <input type="text" value="" id="color-cmjnn" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="color-rvbr">RVB</label>
                                                                        <input type="text" value="" id="color-rvbr" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="color-rvbv">&nbsp;</label>
                                                                        <input type="text" value="" id="color-rvbv" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="color-rvbb">&nbsp;</label>
                                                                        <input type="text" value="" id="color-rvbb" class="form-control"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="color-pantone">Pantone</label>
                                                                <input type="text" value="" id="color-pantone" class="form-control" />
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>



                                            <!----------------------------------------------------------------------------------->
                                            <!--                                        code                                   -->
                                            <!----------------------------------------------------------------------------------->
                                            <div id="code"  style="display:none">
                                            </div>

                                            <!-- <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label> ID :  </label>
                                                        <input autocomplete="OFF" type="text" readonly class="form-control" id="id"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">

                                                        <label for="class"> Css class :  </label>
                                                        <input autocomplete="OFF" type="text" name="class" id="class" class="form-control" />

                                                    </div>
                                                </div>
                                            </div> -->
                                             
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="CellSettings">
                                        <div class="panel panel-body">
                                            <table width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #cccccc" id="tabCol">
                                                <tr>
                                                    <td>&nbsp;Margin</td>
                                                    <td></td>
                                                    <td><input autocomplete="OFF" type="text" size="4" class="form-control text-center" data-ref="margin-top" /></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td bgcolor="#f2f2f2">Padding</td>
                                                    <td bgcolor="#f2f2f2"><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="padding-top" /></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><input autocomplete="OFF" type="text" size="4" class="form-control text-center" data-ref="margin-left"></td>
                                                    <td bgcolor="#f2f2f2"><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="padding-left"></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td bgcolor="#f2f2f2"><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="padding-right"></td>
                                                    <td><input type="text" size="4" class="form-control text-center" data-ref="margin-right"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td bgcolor="#f2f2f2"><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="padding-bottom"></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="margin-bottom"></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Background color :</label>
                                                        <input autocomplete="OFF" type="text" class="form-control" id="colbg" />

                                                        <select id="colorselectorbg">
                                                            <option value="1" data-value="1" data-color="#A0522D">sienna</option>
                                                            <option value="2" data-value="2" data-color="#CD5C5C">indianred</option>
                                                            <option value="3" data-value="3" data-color="#FF4500">orangered</option>
                                                            <option value="4" data-value="4" data-color="#008B8B">darkcyan</option>
                                                            <option value="5" data-value="5" data-color="#B8860B">darkgoldenrod</option>
                                                            <option value="6" data-value="6" data-color="#32CD32">limegreen</option>
                                                            <option value="7" data-value="7" data-color="#FFD700">gold</option>
                                                            <option value="8" data-value="8" data-color="#48D1CC">mediumturquoise</option>
                                                            <option value="9" data-value="9" data-color="#87CEEB">skyblue</option>
                                                            <option value="10" data-value="10" data-color="#FF69B4">hotpink</option>
                                                            <option value="11" data-value="11" data-color="#87CEFA">lightskyblue</option>
                                                            <option value="12" data-value="12" data-color="#6495ED">cornflowerblue</option>
                                                            <option value="13" data-value="13" data-color="#DC143C">crimson</option>
                                                            <option value="14" data-value="14" data-color="#FF8C00">darkorange</option>
                                                            <option value="15" data-value="15" data-color="#C71585">mediumvioletred</option>
                                                            <option value="16" data-value="16" data-color="#000000">black</option>

                                                            <option value="17" data-value="17" data-color="#575757">grigio scuro</option>
                                                            <option value="18" data-value="18" data-color="#f2f2f2">grigio chiaro</option>
                                                            <option value="19" data-value="19" data-color="#efefef">marroncino</option>
                                                            <option value="20" data-value="20" data-color="#e7e0d8">marrone</option>
                                                            <option value="21" data-value="21" data-color="#d7d0c6">marrone scuro</option>
                                                            <option value="22" data-value="22" data-color="#263459">blu scuro</option>
                                                            <option value="23" data-value="23" data-color="#ffffff">bianco</option>

                                                        </select>
                                                        <script>
                                                        $('#colorselectorbg').colorselector({
                                                                  callback: function (value, color, title) {
                                                                      $("#colbg").val(color);
                                                                  }
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <!--
                                                    <div class="form-group">
                                                        <label>Css class :</label>
                                                        <input type="text" class="form-control" id="colcss" />
                                                    </div>
                                                -->
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="RowSettings">
                                        <div class="panel panel-body">
                                            <table width="100%" cellpadding="5" cellspacing="0" style="border:1px solid #cccccc" id="tabRow">
                                                <tr>
                                                    <td>&nbsp;Margin</td>
                                                    <td></td>
                                                    <td><input autocomplete="OFF" type="text" size="4" class="form-control text-center" data-ref="margin-top" /></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td bgcolor="#f2f2f2">Padding</td>
                                                    <td bgcolor="#f2f2f2"><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="padding-top" /></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td><input autocomplete="OFF" type="text" size="4" class="form-control text-center" data-ref="margin-left"></td>
                                                    <td bgcolor="#f2f2f2"><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="padding-left"></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td bgcolor="#f2f2f2"><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="padding-right"></td>
                                                    <td><input autocomplete="OFF" type="text" size="4" class="form-control text-center" data-ref="margin-right"></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td bgcolor="#f2f2f2"><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="padding-bottom"></td>
                                                    <td bgcolor="#f2f2f2"></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td><input autocomplete="OFF" type="text" size="4"  class="form-control text-center" data-ref="margin-bottom"></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </table>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Background color :</label>
                                                        <input autocomplete="OFF" type="text" class="form-control" id="rowbg" />


                                                        <select id="colorselectorrowbg">
                                                            <option value="1" data-value="1" data-color="#A0522D">sienna</option>
                                                            <option value="2" data-value="2" data-color="#CD5C5C">indianred</option>
                                                            <option value="3" data-value="3" data-color="#FF4500">orangered</option>
                                                            <option value="4" data-value="4" data-color="#008B8B">darkcyan</option>
                                                            <option value="5" data-value="5" data-color="#B8860B">darkgoldenrod</option>
                                                            <option value="6" data-value="6" data-color="#32CD32">limegreen</option>
                                                            <option value="7" data-value="7" data-color="#FFD700">gold</option>
                                                            <option value="8" data-value="8" data-color="#48D1CC">mediumturquoise</option>
                                                            <option value="9" data-value="9" data-color="#87CEEB">skyblue</option>
                                                            <option value="10" data-value="10" data-color="#FF69B4">hotpink</option>
                                                            <option value="11" data-value="11" data-color="#87CEFA">lightskyblue</option>
                                                            <option value="12" data-value="12" data-color="#6495ED">cornflowerblue</option>
                                                            <option value="13" data-value="13" data-color="#DC143C">crimson</option>
                                                            <option value="14" data-value="14" data-color="#FF8C00">darkorange</option>
                                                            <option value="15" data-value="15" data-color="#C71585">mediumvioletred</option>
                                                            <option value="16" data-value="16" data-color="#000000">black</option>

                                                            <option value="17" data-value="17" data-color="#575757">grigio scuro</option>
                                                            <option value="18" data-value="18" data-color="#f2f2f2">grigio chiaro</option>
                                                            <option value="19" data-value="19" data-color="#efefef">marroncino</option>
                                                            <option value="20" data-value="20" data-color="#e7e0d8">marrone</option>
                                                            <option value="21" data-value="21" data-color="#d7d0c6">marrone scuro</option>
                                                            <option value="22" data-value="22" data-color="#263459">blu scuro</option>
                                                            <option value="23" data-value="23" data-color="#ffffff">bianco</option>
                                                        </select>
                                                        <script>
                                                        $('#colorselectorrowbg').colorselector({
                                                                  callback: function (value, color, title) {
                                                                      $("#rowbg").val(color);
                                                                  }
                                                            });
                                                        </script>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label>Css class :</label>
                                                        <input autocomplete="OFF" type="text" class="form-control" id="rowcss" />
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Background image :</label>
                                                <input autocomplete="OFF" type="text" class="form-control" id="rowbgimage" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btnclose" data-dismiss="modal"><i class='fa fa-close'></i>&nbsp;Close</button>
                                <button type="button" class="btn btn-primary" id="applyChanges"><i class='fa fa-check'></i>&nbsp;Apply changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Small modal for alert-->

                <!--/span-->
                <div id="download-layout"><div class="container"></div></div>
            </div>
        <script type="text/javascript">
            var sDomain = '<?php echo $starter->HTTP_ROOT; ?>' ;
            var sLang = '<?php echo $starter->s_lang; ?>' ;
                       
        </script>
    </body>
</html>
