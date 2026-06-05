/*! HtmlEditor app.js
 * ================

 * @Author  Antonio Reina

 * @Email   <paoloantonioreina@gmail.com>
 * @version 0.0.2
 * @license MIT <http://opensource.org/licenses/MIT>
 */
/* global path */

$.cssHooks.backgroundColor = {
    get: function (elem) {
        if (elem.currentStyle)
            var bg = elem.currentStyle["background-color"];
        else if (window.getComputedStyle)
            var bg = document.defaultView.getComputedStyle(elem,
                    null).getPropertyValue("background-color");
        if (bg.search("rgb") == -1)
            return bg;
        else {
            bg = bg.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
            function hex(x) {
                return ("0" + parseInt(x).toString(16)).slice(-2);
            }

        }
    }
}

'use strict';
//Make sure jQuery has been loaded before app.js
if (typeof jQuery === "undefined") {
    throw new Error("HtmlEditor requires jQuery");
}


$(function () {
    //Set up the object
    _init();
});

/* ----------------------------------
 * ----------------------------------
 * All HTMLeditor functions are implemented below.
 */


function _init() {

    $(window).resize(function () {
        $("body").css("min-height", $(window).height() - 90);
        $(".htmlpage").css("min-height", $(window).height() - 160)
    });

    tinymce.init({
        menubar: false,
        skin: "custom",
        entity_encoding : "raw",
        encoding: "UTF-8",
        force_p_newlines: true,
        extended_valid_elements : "*[*]",
        valid_elements: "*[*]",
        selector: "#html5editor",
        plugins: [
                "advlist autolink lists link image charmap print anchor",
                "searchreplace visualblocks code fullscreen",
                "textcolor",
                "insertdatetime media table contextmenu paste moxiemanager colorpicker",
                "template"
        ],
        init_instance_callback: function(editor) {
            editor.on('input', function(e) {
                editor.settings.forced_root_block = editor.settings.forced_root_block;
                
            }); 
           
            editor.on('NodeChange', function (e) {
                editor.settings.forced_root_block = editor.settings.forced_root_block;
                
            });

            editor.on('Change', function (e) {
                editor.settings.forced_root_block = editor.settings.forced_root_block;
            });
          },
        setup: function(ed) {
            ed.settings.forced_root_block = 'p';
            ed.settings.forced_root_block_attrs = {
                'class': '',
            }
        },
        image_advtab: true,
        image_class_list: [
            {title: 'None', value: ''},
            {title: 'text-top', value: 'text-top'},
            {title: 'Baseline', value: 'baseline'},
            {title: 'top', value: 'top'},
            {title: 'middle', value: 'middle'},
            {title: 'bottom', value: 'bottom'},
            {title: 'text-bottom', value: 'text-bottom'},
            {title: 'left', value: 'left'},
            {title: 'right', value: 'right'}
        ],
        external_plugins: {
            "moxiemanager": '/!locked/lib/tinymce/plugins/moxiemanager/plugin.min.js'
        },
        moxiemanager_image_settings : { 
            view : 'thumbs', 
            extensions : 'jpg,png,gif',
            relative_urls : true,
            moxiemanager_path : '/../../../../../web/content/bdd/',
            url : '/content'
        },
        valid_elements :"*[*],td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor]",
        extended_valid_elements :"*[*],td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor]",
        toolbar: "styleselect | undo redo | bold italic | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image code",
        autosave_ask_before_unload: false,
        content_css : "/css/tiny.css",
        paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],table,th,tr,tbody,td,td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor]",
        paste_retain_style_properties:'all',
        autosave_ask_before_unload: false,
        style_formats: [
            {title: "Headers", items: [
                {title: "Header 2", format: "h2"},
                {title: "Header 3", format: "h2"}
            ]},
            /*{title: "Alignment", items: [
                {title: "Baseline", selector : 'img', styles : {'vertical-align:' : 'baseline'}},
                {title: "top", selector : 'img', styles : {'vertical-align:' : 'top'}},
                {title: "middle", selector : 'img', styles : {'vertical-align:' : 'middle'}},
                {title: "bottom", selector : 'img', styles : {'vertical-align:' : 'bottom'}},
                {title: "text-top", selector : 'img', styles : {'vertical-align:' : 'text-top'}},
                {title: "text-bottom", selector : 'img', styles : {'vertical-align:' : 'text-bottom'}},
                {title: "left", selector : 'img', styles : {'float:' : 'left'}},
                {title: "right", selector : 'img', styles : {'float:' : 'right'}}
            ]}*/
        ],
        textcolor_map: [
            "3B3C40", "Default",
            "86BC25", "Green",
        ],
    });

    tinymce.init({
        menubar: false,
        force_br_newlines: false,
        force_p_newlines: false,
        forced_root_block: '',
        extended_valid_elements : "*[*]",
    valid_elements: "*[*]",
        selector: "#html5editorLite",
        plugins: [
        ],
        toolbar: "forecolor backcolor | alignleft aligncenter alignright alignjustify code",
    });

    $("body").css("min-height", $(window).height() - 90);
    $(".htmlpage").css("min-height", $(window).height() - 160);
    // $(".htmlpage").sortable({connectWith: ".lyrow", opacity: .35, handle: ".drag"});
    $(".htmlpage, .htmlpage .column").sortable({connectWith: ".column", opacity: .35, handle: ".drag", stop: function (e, t) {
                autoSave();
            videoAspect();
        }});
    $(".sidebar-nav .lyrow").draggable({connectToSortable: ".htmlpage", helper: "clone", handle: ".drag", drag: function (e, t) {
            t.helper.width('100%')
        }, stop: function (e, t) {
            autoSave();
            videoAspect();
            $(".htmlpage .column").sortable({opacity: .35, connectWith: ".column"})
        }});

    $(".sidebar-nav .box").draggable({connectToSortable: ".column", helper: "clone", handle: ".preview", drag: function (e, t) {
            t.helper.width('100%')
        }, stop: function (e, t) {
            autoSave();
            /* if ( t.helper.data('type')==="map"|| t.helper.data('type')==="youtube" ) {
             var iframe = t.helper.find('div.view > iframe');

             var iframeId = iframe.assignId();
             $('#'+iframeId).attr('src',iframe.data('url'));
             }
             */

        }});

    $(document).on('click', 'a.clone', function (e) {
        e.preventDefault();
        var _s = $(this);

        var _row = _s.closest('.ui-draggable').clone();
        _row.hide();
        _row.insertAfter(_s.closest('.ui-draggable'));
        _row.slideDown();
        setTimeout(function(){
            autoSave();
        }, 500);

    });

    $(document).on('click', 'a.settings', function (e) {
        e.preventDefault();
        var _s = $(this);

        var part_id = _s.parent().parent().assignId();

        var part = _s.parent().parent();
        var column = _s.parent().parent().parent('.column');
        var row = _s.parent().parent().parent().parent('.row');

        prepareEditor(part, row, column);
    });


    $('a.btnpropa').on('click', function () {
        var rel = $(this).attr('rel');
        $('#buttonContainer a.btn').removeClass('btn-default')
                .removeClass('btn-success')
                .removeClass('btn-info')
                .removeClass('btn-danger')
                .removeClass('btn-info')
                .removeClass('btn-primary')
                .removeClass('btn-link')
                .addClass(rel);

    });
    $('a.btnpropb').on('click', function () {
        var rel = $(this).attr('rel');
        $('#buttonContainer a.btn').removeClass('btn-lg')
                .removeClass('btn-md')
                .removeClass('btn-sm')
                .removeClass('btn-xs')
                .addClass(rel);

    });

    $('a.btnprop').on('click', function () {
        var rel = $(this).attr('rel');
        $('#buttonContainer a.btn').toggleClass(rel);

    });

    $('#preferences').on('hidden.bs.modal', function () {
        $('#youtube').hide();
        $('#map').hide();
        $('#image').hide();
        $('#text').hide();
        $('#code').hide();
        $('#buttons').hide();
        // $('.active').removeClass('active');

    $('body, html').height('');
        setTimeout(function () {
            
            parent.setIFrameHeight();
        }, 50);
    });

    $("#save").click(function (e) {
        downloadLayoutSrc();
    });

    $('#srcSave').click(function () 
    {
        $.post('/plugins/pagebuilder/save.html', 
        {
            fieldtosave : $('#fieldtosave').val(),
            fieldtosaveedit : $('#fieldtosaveedit').val(),
            html: ($("#src").val()),
            htmledit: ($("#model").val())
        }, function (data) 
        {
            var response = eval('(' + data + ')');
            $('#'+response.response_field,  window.parent.document).val(response.response_content);
            $('#'+response.response_fieldedit,  window.parent.document).val(response.response_contentedit);
        }, 'html'
        );
    });

    $("#clear").click(function (e) {
        e.preventDefault();
        clearDemo()
    });
    $("#devpreview").click(function () {
        $("body").removeClass("edit sourcepreview");
        $("body").addClass("devpreview");
        removeMenuClasses();
        $(this).addClass("active");
        return false
    });


    $("#edit").click(function () {
        $('#add').hide();
        $("body").removeClass("devpreview sourcepreview");
        $("body").removeClass("tablet mobile");
        $("body").addClass("edit");
        removeMenuClasses();
        $(this).addClass("active");
        return false
    });


    $('#gallery').click(function(){
        $('#thepref').slideUp();
        $('#mediagallery').slideDown();
    });


    $("#sourcepreview").click(function () {
        $('#pc').addClass('active');
        $('#add').show();
        $("body").removeClass("edit");
        $("body").addClass("devpreview sourcepreview");
        removeMenuClasses();
        $(this).addClass("active");
        return false
    });



    $('#pc').click(function () {
        $("body").removeClass("tablet mobile");
        $('#app button').removeClass('active');
        $(this).addClass('active');
    });


    $('#mobile').click(function () {
        $("body").removeClass("tablet");
        $('#app button').removeClass('active');
        $(this).addClass('active');
        $("body").addClass("mobile");
    });


    $('#tablet').click(function () {
        $("body").removeClass("mobile");
        $('#app button').removeClass('active');
        $(this).addClass('active');
        $("body").addClass("tablet");
    });

    $(".nav-header").click(function () {
        $(".sidebar-nav .boxes, .sidebar-nav .rows").hide();
        $(this).next().slideDown()
    });


    removeElm();
    gridSystemGenerator();

}

function loadRowSettings(row) {
    //RowSettings
    // paddings
    $('#tabRow input[data-ref="padding-top"]').val(row.css('padding-top'));
    $('#tabRow input[data-ref="padding-left"]').val(row.css('padding-left'));
    $('#tabRow input[data-ref="padding-right"]').val(row.css('padding-right'));
    $('#tabRow input[data-ref="padding-bottom"]').val(row.css('padding-bottom'));
    // margin
    $('#tabRow input[data-ref="margin-top"]').val(row.css('margin-top'));
    $('#tabRow input[data-ref="margin-left"]').val(row.css('margin-left'));
    $('#tabRow input[data-ref="margin-right"]').val(row.css('margin-right'));
    $('#tabRow input[data-ref="margin-bottom"]').val(row.css('margin-bottom'));
    // backgroundColor
    $('#rowbg').val(row.css('background-color'));
    // image
    $('#rowbgimage').val(row.css('background-image').replace(/^url\(['"]?/,'').replace(/['"]?\)$/,''));
    // css class
    $('#rowcss').val(row.attr('class'));
}

function saveRowSettings(row) {
    //RowSettings
    //padding
    row.css('padding-top', $('#tabRow input[data-ref="padding-top"]').val());
    row.css('padding-left', $('#tabRow input[data-ref="padding-left"]').val());
    row.css('padding-right', $('#tabRow input[data-ref="padding-right"]').val());
    row.css('padding-bottom', $('#tabRow input[data-ref="padding-bottom"]').val());
    // margin
    row.css('margin-top', $('#tabRow input[data-ref="margin-top"]').val());
    row.css('margin-left', $('#tabRow input[data-ref="margin-left"]').val());
    row.css('margin-right', $('#tabRow input[data-ref="margin-right"]').val());
    row.css('margin-bottom', $('#tabRow input[data-ref="margin-bottom"]').val());
    // backgroundColor
    row.css('background-color', $('#rowbg').val());
    // image
    if($("#rowbgimage").val()!="none")
    row.css('background-image',  'url("'+$("#rowbgimage").val()+'")');
    // css class
    row.removeClass();
    row.addClass($('#rowcss').val());
    //row.attr('css', $('#rowcss').val());
}

function loadColumnSettings(column) {
    // paddings
    $('#tabCol input[data-ref="padding-top"]').val(column.css('padding-top'));
    $('#tabCol input[data-ref="padding-left"]').val(column.css('padding-left'));
    $('#tabCol input[data-ref="padding-right"]').val(column.css('padding-right'));
    $('#tabCol input[data-ref="padding-bottom"]').val(column.css('padding-bottom'));
    // margin
    $('#tabCol input[data-ref="margin-top"]').val(column.css('margin-top'));
    $('#tabCol input[data-ref="margin-left"]').val(column.css('margin-left'));
    $('#tabCol input[data-ref="margin-right"]').val(column.css('margin-right'));
    $('#tabCol input[data-ref="margin-bottom"]').val(column.css('margin-bottom'));
    // backgroundColor
    $('#colbg').val(column.css('background-color'));
    // css class
    $('#colcss').val(column.attr('class'));
}
function saveColumnSettings(column) {
    //CellSettings
    //padding

    $('.row.clearfix').css('padding-top', 0);
    $('.row.clearfix').css('padding-left', 0);
    $('.row.clearfix').css('padding-right', 0);
    $('.row.clearfix').css('padding-bottom', 0);
    // margin
    $('.row.clearfix').css('margin-top', 0);
    $('.row.clearfix').css('margin-left', 0);
    $('.row.clearfix').css('margin-right', 0);
    $('.row.clearfix').css('margin-bottom', 0);
    /*
    column.css('padding-top', $('#tabCol input[data-ref="padding-top"]').val());
    column.css('padding-left', $('#tabCol input[data-ref="padding-left"]').val());
    column.css('padding-right', $('#tabCol input[data-ref="padding-right"]').val());
    column.css('padding-bottom', $('#tabCol input[data-ref="padding-bottom"]').val());
    // margin
    column.css('margin-top', $('#tabCol input[data-ref="margin-top"]').val());
    column.css('margin-left', $('#tabCol input[data-ref="margin-left"]').val());
    column.css('margin-right', $('#tabCol input[data-ref="margin-right"]').val());
    column.css('margin-bottom', $('#tabCol input[data-ref="margin-bottom"]').val());
*/
    // backgroundColor
    column.css('background-color', $('#colbg').val());
    // css class
    column.attr('class', $('#colcss').val());
}

function prepareEditor(part, row, column) {
    console.log('prepareEditor');
    console.log(part + ' ' + row + ' ' + column);
    var clone = part.clone();
    var confirm = $('#applyChanges');
    $('#preferencesTitle').html(part.data('typename'));

    $('.column .box').removeClass('active');
    part.addClass('active');
    confirm.unbind('click');

    var type = part.data('type');
    var panel = $('#Settings');

    loadRowSettings(row);
    loadColumnSettings(column);

    var o = part.find('div.view').children();
    var oid = o.assignId();
    $('#id').val(oid);
    $('#class').val(o.parent().parent().css('class'));
    $('#class').parent().show();
    $('#id').parent().show();
    switch (type) {

        
        case 'paragraph':
            var clonedPart = clone.find('div.view').html();
            var element = clone.find('div.view').data('info');
            var editor = tinyMCE.get('html5editor');
                editor.settings.forced_root_block = element;
            editor.setContent(clonedPart);
            $('#text').show();

            var o = part.find('div.view');
            confirm.bind('click', function (e) {
                e.preventDefault();
                saveRowSettings(row);
                saveColumnSettings(column);
                o.html(editor.getContent());
                if(!o.children("p").hasClass('paragraph'))
                    o.children("p").addClass("paragraph");
                if(o.children("h2").length > 0){
                    o.children("h2").attr('id', slugify(o.text()));
                }
                autoSave();
                //o.attr('class', $('#class').val());
            });

        break;

        case 'image':
            var img = part.find('.view img');

            $('#imgContent').html(img.clone().attr('width', '200'));
            $('#img-url').val(img.attr('src'));
            //$('#img-width').val(img.innerWidth());
            //$('#img-height').val(img.innerHeight());
            $('#img-title').val(img.attr('title'));
            $('#class').val(img.attr('class'));
            $('#img-rel').val(img.attr('rel'));
            $('#img-title').val(img.attr('title'));
            // $('#img-clickurl').val(img.attr('onClick'));
            $('#image').show();

            confirm.bind('click', function (e) {
                e.preventDefault();
                saveRowSettings(row);
                saveColumnSettings(column);
                img.attr('title', $('#img-title').val());
                img.attr('src', $('#img-url').val());
                //img.css('width', $('#img-width').val());
                //img.css('height', $('#img-height').val());
                img.attr('class', $('#class').val());
                img.attr('rel', $('#img-rel').val());
                //    img.attr('onClick', $('#img-clickurl').val());
                o.attr('id', $('#id').val());
                o.removeClass();
                o.addClass($('#class').val());
                autoSave();
            });

        break;

        case 'youtube' :
            var iframe = part.find('iframe');
            $('#youtube-video').html(iframe.clone().css('width', '100%'));
            $('#video-url').val(iframe.attr('src'));
            //$('#video-width').val(iframe.innerWidth());
            //$('#video-height').val(iframe.innerHeight());
            $('#youtube').show();

            confirm.bind('click', function (e) {
                $('#youtube-video iframe').attr('src', $('#video-url').val());
                e.preventDefault();
                saveRowSettings(row);
                saveColumnSettings(column);
                iframe.attr('src', $('#video-url').val());
                //o.css('width', $('#video-width').val());
                ///o.css('height', $('#video-height').val());
                o.attr('id', $('#id').val());
                o.attr('class', $('#class').val());
                autoSave();
            });
        break;

        case 'sound' :
            var blocsound = part.find('.view .blocsound');

            $('#sound-url').val(blocsound.attr('src'));
            $('#sound').show();

            confirm.bind('click', function (e) {
                e.preventDefault();
                saveRowSettings(row);
                saveColumnSettings(column);
                
                blocsound.attr('src',$('#sound-url').val());

                o.attr('id', $('#id').val());
                autoSave();
            });
                
        break;

        case 'pdf' :
            var iframe = part.find('iframe');
            $('#pdf').show();
            $('#pdf-url').val(iframe.attr('src'));
            confirm.bind('click', function (e) {
                e.preventDefault();
                saveRowSettings(row);
                saveColumnSettings(column);
                iframe.attr('src', $('#pdf-url').data('url') + $('#pdf-url').val());

                o.attr('id', $('#id').val());
                autoSave();
            });
                
        break;
        
        case 'map' :
            var iframe = part.find('iframe');
            var c = iframe.clone();
            $('#map-content').html(c.attr('width', '100%'));
            $('#address');
            $('#map').show();
            $('#map-width').val(iframe.innerWidth());
            $('#map-height').val(iframe.innerHeight());
            var url = iframe.attr('src');
            var latlon = gup('q', url).split(',');
            var z = gup('z', url);

            $('#latitude').val(latlon[0]);
            $('#longitude').val(latlon[1]);
            $('#zoom').val(z);

            //http://maps.google.com/maps?q=12.927923,77.627108&z=15&output=embed
            $('#latitude, #longitude, #zoom').change(function () {
                c.attr('src', 'http://maps.google.com/maps?q=' + $('#latitude').val() + ',' + $('#longitude').val() + '&z=' + $('#zoom').val() + '&output=embed');
            });

            confirm.bind('click', function (e) {
                e.preventDefault();
                saveRowSettings(row);
                saveColumnSettings(column);
                iframe.css('width', $('#map-width').val());
                iframe.css('height', $('#map-height').val());
                iframe.attr('src', 'http://maps.google.com/maps?q=' + $('#latitude').val() + ',' + $('#longitude').val() + '&z=' + $('#zoom').val() + '&output=embed');
                o.attr('id', $('#id').val());
                o.attr('class', $('#class').val());
                autoSave();
            });


        break;

        case 'code':
            $('#class').parent().hide();
            $('#id').parent().hide();

            var txt = $('#code');
            $('#codeeditor').remove();
            txt.append('<textarea id="codeeditor" style="min-height:150px;width:100%; display:block;">'+style_html(part.find('div.view').html())+'</textarea>');
            txt.show();


            /*

            var code = part.find('div.code');
            var txt = $('#code');
            $('#codeeditor').remove();
            txt.append('<textarea id="codeeditor" style="min-height:150px;width:100%; display:block;">'+style_html(code.data('code'))+'</textarea>');
            txt.show();

            txt.append('<div id="codeeditor" style="min-height:150px;width:100%; display:block;">' + code.data('code') + '</div>');
            var editor = ace.edit("codeeditor");
            editor.setTheme("ace/theme/monokai");
            editor.getSession().setMode("ace/mode/html");
            txt.show();
            confirm.bind('click', function (e) {
                e.preventDefault();
                saveRowSettings(row);
                saveColumnSettings(column);
                code.data('code', editor.getValue());
                code.html(editor.getValue());
            });
            */



            confirm.bind('click', function (e) {
                e.preventDefault();
                saveRowSettings(row);
                saveColumnSettings(column);
                //code.data('code', $('#codeeditor').val());
                part.find('div.view').html($('#codeeditor').val());
                autoSave();

            });
        break;

        case 'button' :

            var btn = part.find('.view > a.btn');
            var btn_id = btn.assignId();
            var clone = btn.clone();
            $('#buttonLabel').val(btn.text());
            $('#buttonHref').val(btn.attr('href'));
            $('#buttons').show();

            confirm.bind('click', function (e) {
                e.preventDefault();
                saveRowSettings(row);
                saveColumnSettings(column);
                btn.text($('#buttonLabel').val());
                btn.attr('href', $('#buttonHref').val());
               
                o.attr('id', $('#id').val());
                autoSave();
            });


        break;
    }
    $('#preferences').modal('show');
    //$('#preferences').show();
    //$('#preferences').addClass("show");
    setTimeout(function () {
        videoAspect();
        
        var tmp = $('#preferences .modal-dialog .modal-content').outerHeight();
        let scrollTop = parent.parentScroll() -400;

        $('#preferences .modal-dialog').height(tmp);
        $('#preferences .modal-dialog').css('top',scrollTop+'px');
        $('#preferences .modal-dialog').css('top',scrollTop+'px');
        $('#preferences .modal-dialog').css('top',scrollTop+'px');
        
        //$('body').height(tmp + 60);
        
        //alert($('#preferences .modal-dialog').outerHeight(true));
        //parent.setIFrameHeight();
    }, 150);
}

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".mce-window").length) {
        e.stopImmediatePropagation();
    }
});

function handleSaveLayout() {
    var e = $(".htmlpage").html();
    if (e != window.htmlpageHtml) {
        saveLayout();
        window.htmlpageHtml = e
    }
}

function gridSystemGenerator() {
    $(".lyrow .preview input").bind("keyup", function () {
        var e = 0;
        var t = "";
        var n = false;
        var r = $(this).val().split(" ", 12);
        $.each(r, function (r, i) {
            if (!n) {
                if (parseInt(i) <= 0)
                    n = true;
                e = e + parseInt(i);
                t += '<div class="col-md-' + i + ' column"></div>'
            }
        });
        if (e == 12 && !n) {
            $(this).parent().next().children().html(t);
            $(this).parent().find('.drag').show()
        } else {
            $(this).parent().find('.drag').hide()
        }
    })
}
function removeElm() {
    $(".htmlpage").delegate(".remove", "click", function (e) {
        var b = $(this).parent().css('border');
        $(this).parent().css('border', '2px solid red');

        if (confirm("Etes vous certain de vouloir supprimer cet élément ?")) {
            e.preventDefault();
           $(this).closest('.ui-draggable').remove();
            autoSave();

            if (!$(".htmlpage .lyrow").length > 0) {
                clearDemo();
            }
        } else {
            $(this).parent().css('border', b);
        }
    })
}
function clearDemo() {
    $(".htmlpage").empty()
}
function removeMenuClasses() {
    $("#menu-htmleditor li button").removeClass("active")
}
function changeStructure(e, t) {
    $("#download-layout ." + e).removeClass(e).addClass(t)
}
function cleanHtml(e) {
    $(e).parent().append($(e).children().html());
}

function cleanRow(row) {

    row.children('.remove , .drag, .preview').remove();
    row.find('div.ui-sortable').removeClass('ui-sortable');

    //row.children('.view').find('br').remove();

    row.children('.view').children('.row').children('.column').each(function () {
        // se ci dovessero essere righe nella colonna allora :
        var col = $(this);

        col.removeClass('column');
        col.css('padding',0);
        col.children('.lyrow').each(function () {
            cleanRow($(this));
        });
        col.children('.box-element').each(function () {
            var element = $(this);
            element.children('.remove , .drag, .configuration, .preview').remove();
            element.parent().append(element.children('.view').html());
            element.remove();
        });

        col.children('p').attr('id','');
        //col.children('h2').attr('id','');
        col.children('h3').attr('id','');
        col.children('h4').attr('id','');
        col.children('ul').attr('id','');
        col.children('p').attr('style','');
        col.children('h2').attr('style','');
        col.children('h3').attr('style','');
        col.children('h4').attr('style','');
        col.children('ul').attr('style','');
    });
    row.parent().append(row.children('.view').html());
    row.remove();
}

function downloadLayoutSrc() {
    //  var e = "";
    $("#download-layout").children().html($(".htmlpage").html());

    // var t = $("#download-layout").children();
    $("#download-layout").children('.container').each(function (i) {
        var container = $(this);
        container.children('.lyrow').each(function (i) {
            var row = $(this);
            cleanRow(row);
        });
    });
    $('textarea#model').val($(".htmlpage").html());
    $('textarea#src').val(style_html($("#download-layout").html()));
    $('#download').modal('show');

}

function getIndent(level) {
    var result = '',
            i = level * 4;
    if (level < 0) {
        throw "Level is below 0";
    }
    while (i--) {
        result += ' ';
    }
    return result;
}

function style_html(html) {
    html = html.trim();
    var result = '',
            indentLevel = 0,
            tokens = html.split(/</);
    for (var i = 0, l = tokens.length; i < l; i++) {
        var parts = tokens[i].split(/>/);
        if (parts.length === 2) {
            if (tokens[i][0] === '/') {
                indentLevel--;
            }
            result += getIndent(indentLevel);
            if (tokens[i][0] !== '/') {
                indentLevel++;
            }

            if (i > 0) {
                result += '<';
            }

            result += parts[0].trim() + ">\n";
            if (parts[1].trim() !== '') {
                result += getIndent(indentLevel) + parts[1].trim().replace(/\s+/g, ' ') + "\n";
            }

            if (parts[0].match(/^(img|hr|br)/)) {
                indentLevel--;
            }
        } else {
            result += getIndent(indentLevel) + parts[0] + "\n";
        }
    }
    return result;
}

function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
}

function gup(name, url) {
    if (!url)
        url = location.href;
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(url);
    return results == null ? null : results[1];
}


(function ($) {

    $.fn.assignId = function () {
        var _self = $(this);
        var id = _self.attr('id');
        if (typeof id === typeof undefined || id === false) {

            id = s4() + '-' + s4() + '-' + s4() + '-' + s4();
            _self.attr('id', id);

        }
        return id;
    };

})(jQuery);
function autoSave() {
    videoAspect();

    $("#download-layout").children().html($(".htmlpage").html());

    // var t = $("#download-layout").children();
    $("#download-layout").children('.container').each(function (i) {
        var container = $(this);
        container.children('.lyrow').each(function (i) {
            var row = $(this);
            cleanRow(row);
        });
    });
    $('textarea#model').val($(".htmlpage").html());
    $('textarea#src').val(style_html($("#download-layout").html()));
    //$('#download').modal('show');

    $('#srcSave').trigger('click');
    /*$('#srcSave').click(function () 
    {
        $.post('/plugins/pagebuilder/save.html', 
        {
            fieldtosave : $('#fieldtosave').val(),
            fieldtosaveedit : $('#fieldtosaveedit').val(),
            html: style_html($("#src").val()),
            htmledit: style_html($("#model").val())
        }, function (data) 
        {
            var response = eval('(' + data + ')');
            $('#'+response.response_field,  window.parent.document).val(response.response_content);
            $('#'+response.response_fieldedit,  window.parent.document).val(response.response_contentedit);
        }, 'html'
        );
    });*/
    
    setTimeout(function () {
        //parent.setIFrameHeight();
        $('.btnclose').trigger('click');
    }, 50);
}

function videoAspect() {
    console.log('video aspect')
    $('iframe[src*="youtube"], iframe[src*="vimeo"]').each(function () {
        //$(this).height($(this).width() / (16 / 9));
    });
}

$(window).resize(function () {
    //videoAspect();
})


$(document).ready(function(){
    $('.lyrow').each(function(){
        var column = $(this);
        var values = $(this).find('input').val().split(' ');
        values.forEach(function(item){
            column.find('.preview').append('<div class="col'+item+'"></div>');
            column.find('.col'+item).outerWidth(1 / (12 / item) * 100);
        });
    })
    $(parent.window).scroll(function() {
        var iframe = frameElement;
        var top = -(iframe.offsetTop - parent.window.pageYOffset - 70 - 17);
        if(iframe.offsetTop - parent.window.pageYOffset - 70 <= 0 && $('.sidebar-nav').outerHeight() + top < $('body').height()){
            $('.sidebar-nav').css('top', top);
        }
        else if(iframe.offsetTop - parent.window.pageYOffset - 70 > 0){
            $('.sidebar-nav').css('top', 17);
        }
        else $('.sidebar-nav').css('top', $('body').height() - $('.sidebar-nav').outerHeight());
    });

    $('.btnclose').on('click',function(){
        $('#preferences').modal('hide');
    });
    
    videoAspect();
})
function slugify(str)
{
    str = str.replace(/^\s+|\s+$/g, '');

    // Make the string lowercase
    str = str.toLowerCase();

    // Remove accents, swap ñ for n, etc
    var from = "ÁÄÂÀÃÅČÇĆĎÉĚËÈÊẼĔȆÍÌÎÏŇÑÓÖÒÔÕØŘŔŠŤÚŮÜÙÛÝŸŽáäâàãåčçćďéěëèêẽĕȇíìîïňñóöòôõøðřŕšťúůüùûýÿžþÞĐđßÆa·/_,:;";
    var to   = "AAAAAACCCDEEEEEEEEIIIINNOOOOOORRSTUUUUUYYZaaaaaacccdeeeeeeeeiiiinnooooooorrstuuuuuyyzbBDdBAa------";
    for (var i=0, l=from.length ; i<l ; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    // Remove invalid chars
    str = str.replace(/[^a-z0-9 -]/g, '') 
    // Collapse whitespace and replace by -
    .replace(/\s+/g, '-') 
    // Collapse dashes
    .replace(/-+/g, '-'); 

    return str;
}