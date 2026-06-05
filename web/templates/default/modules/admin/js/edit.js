//INIT VARS
var b_Masonry = false;

function croppfile(){

	alert('cropp');
}
function initEdit(){
	// <![CDATA[
		tinymce.init({
			language : sLang, // change language here
			selector: "textarea.isTyni",
			skin: "custom",
			entity_encoding : "raw",
			encoding: "UTF-8",
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen",
				"textcolor",
				"insertdatetime media table contextmenu paste moxiemanager",
				"template"
			],
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
			plugin_preview_height: 800,
			external_plugins: {
				"moxiemanager": '/lib/tinymce/plugins/moxiemanager/plugin.min.js'
			},
			valid_elements :"*[*],td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor]",
			extended_valid_elements :"*[*],td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor]",
			menubar: "edit insert view format table tools",
			toolbar: "undo redo | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image template",
			autosave_ask_before_unload: false,
			content_css : "/css/tiny.css",
			paste_word_valid_elements: "b,strong,i,em,h1,h2,u,p,ol,ul,li,a[href],table,th,tr,tbody,td,td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor]",
			paste_retain_style_properties:'all',
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
			min_height: 160,
			height : 180,
		  template_popup_height: "500",
		  template_popup_width: "500",
		  templates : [
			  {
				title: "test",
				url: "http://localhost/modules/admin/template/default/modules/special/templates/test.html",
			  },
			  {
				title: "grid",
				url: "http://localhost/modules/admin/template/default/modules/special/templates/grid.html",
			  }
		  ]
		}); 
	// ]]>
}

$('.textarea textarea').bind('input propertychange', function() {
	var tmp = $(this).css('line-height');
	$(this).height(tmp);
	$(this).height(this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth")) - parseFloat($(this).css("paddingTop")) - parseFloat($(this).css("paddingBottom")) + 0);
});

function orderForm(){
	
	$('.list_field.cropper, .list_field.default_image').parent().prepend('<br class="clearfix"/>');
	$('.list_field.cropper, .list_field.default_image').each(function(){
		$(this).parent().prepend(this);
	});
	
	$('.list_field.field_list').parent().prepend('<br class="clearfix"/>');
	$('.list_field.tree_downloads').each(function(){
		$(this).parent().prepend(this);
	});
	

	
	$('.list_field.file, .list_field.varchar, .list_field.field_list').parent().prepend('<br class="clearfix"/>');
	$('.list_field.password').each(function(){
		$(this).parent().prepend(this);
	});
	$('.list_field.file, .list_field.varchar, .list_field.field_list').each(function(){
		$(this).parent().prepend(this);
	});
	
	$('.list_field.checkbox').parent().prepend('<br class="clearfix"/>');
	$('.list_field.checkbox').each(function(){
		$(this).parent().prepend(this);
	});
}

function changeFileName(obj, name){
	//console.log('cpt=>'+cpt);

	var ext = name.split('.').pop();
	var newFileName =  '1' +'.' + ext;

	first_dz.options['url'] = "http://alumni.ecole-intuit-lab.com/fr/upload.html?userId="+ userId+"&filename="+newFileName;
	return newFileName;
}


$(window).on('load',function() {

	popup = document.getElementsByTagName("iframe")[0].contentWindow;

	
});

$(document).ready(function() {
	initEdit();
	
	if($('.date_').length>0)
	{ 
		$( ".date_" ).datepicker({
			dateFormat : "yy-mm-dd",
			changeMonth: false,
			changeYear : true
		});
		
	}
	$('div#right-content div.content-bloc div.final-content div.content-col h1').click(function(){
		var bloc = $(this).parent().children('.bloc_element');
		var iHeight = bloc.children('ul').height();

		if(bloc.height() === 0){
			bloc.animate({
				'height':iHeight + 'px'
			},300,'easeOutQuart',
			function(){
				bloc.css('height', '');
			});
		}
		else
			bloc.animate({'height':0},300,'easeOutQuart', function(){});
	});
	orderForm();

	if($('.dropzoneBloc').length > 0){
		$('.dropzoneBloc').each(function(){
			var theDrop = $(this).attr('id');			
			var theImg = new Dropzone('#'+theDrop, { 
				url: "/plugins/cropper.html?page=site&module=1&config_id=0&lang=fr&ilang=1&config=0&field=tree_icon",
				maxFiles:1,
				maxFilesize: 5, // MB
				addRemoveLinks: true,
				addCroppLinks: true,
				thumbnailWidth: 100,
				thumbnailHeight: 100,
				parallelUploads : 1,
	    		acceptedFiles: ".png,.jpg,.jpeg",
	    		renameFilename: ''   	
	    	});

			theImg.on("complete", function(file) {
				addButton('tree_icon','', 'del_link_');
				addButton('tree_icon','content/bdd/', 'view_link_');

				
			});

			theImg.on("maxfilesexceeded", function(file) {
				theImg.removeFile(file);
			});
			

			theImg.on("removedfile", function(file) {
				console.log("remove");
				console.log(file);

				// $.post('ajax/remove-image.html', {	userId:userId, number:1}, function(data){
				// 		//console.log(data);
				// });

			});

		});
	}
});
