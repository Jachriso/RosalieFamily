/**********************************/
/*          INIT VARS             */
/**********************************/
var bLoader = false;
var cropURL = null;


/**********************************/
/*          CROPPER VARS             */
/**********************************/

var cropper = null;
var Cropper = null;
var container = null;
var image = null;
var download = null;
var actions = null;
var dataX = null;
var dataY = null;
var dataHeight = null;
var dataWidth = null;
var dataRotate = null;
var dataScaleX = null;
var dataScaleY = null;

/**********************************/
/*         UPDATE ONLINE          */
/**********************************/
function updateOnline(iVal,sRel,iId)
{
	$.ajax(
	{
		type:"POST",
		url: sDomain + sLang + '/admin.html?action=ajax&case=update_online',
		context: document.body,
		data: {
			iItem: $('#'+sRel + '-' + iId).val(),
			iVal: iVal,
			page: $('#page').val(),
			iConfig: $('#iConfig').val(),
			module: $('#module').val(),
			token: $('#token').val(),
			ikey: $('#sKey').val(),
			sField: sRel
		}
	}).done(function(data) 
	{ 
	
		var response = eval('(' + data + ')');
		
		if(response.response_code == 0){
			if(response.response_value == "1") 
				$('span#switch-' + response.response_field).removeClass('switch-0').addClass('switch-1').find('span').html(1);
			else 
				$('span#switch-' + response.response_field).removeClass('switch-1').addClass('switch-0').find('span').html(0);
		}
		else alert(response.response_message);
								
	});	
}
	
function parentScroll(){
    return $(window).scrollTop();
}

function setField(oField,sValue){
	document.getElementById(oField).value = sValue;
}

function addButton(oField, sValue, skind){
	
	if(sValue != '')
		var s_href = document.getElementById(skind+oField).getAttribute("rel") + sValue; 
	else
		var s_href = 'javascript:void(0);'; 
	
	$('#'+skind+oField).attr('href', s_href);		
	$('#'+skind+oField).css('display','inline');
}
function deleteImg(sAsk, oField){
	if (confirm(sAsk)) {
		$('#'+oField).val('');
		$('#view_link_'+oField).css('display','none');
		$('#del_link_'+oField).css('display','none');
	}
}
function deleteItem(sAsk, sUri){
	if (confirm(sAsk)) {
		$.ajax(
		{
			type:"POST",
			url: sDomain + sLang + '/admin.html?action=ajax&case=delete_element',
			context: document.body,
			data: {
				iItem: sUri,
				page: $('#page').val(),
				iConfig: $('#iConfig').val(),
				module: $('#module').val(),
				addon: $('#addon').val(),
				token: $('#token').val(),
				ikey: $('#sKey').val()
			}
		}).done(function(data) 
		{ 
		
			var response = eval('(' + data + ')');
			
			if(response.response_code == 0){
				if(response.response_value == "1") 
					window.location.reload();
			}
			else alert(response.response_message);
									
		});	
	}
}
function sendEndLoadPage(sUri){
	if(oOpenNav != '') {
		oOpenNav = '{"index":['+oOpenNav+']}';
		sUri += '&nav=' + oOpenNav;
	}
	window.location.href = sUri;
}

function sendFormSearch(sField, iVal){

	if(iVal != '-1')
	{
		sAction = window.location.href;
		sAction = sAction.substr(0,sAction.indexOf("&navpage"));
		$('#' + sField).val(iVal);
		document.forms['engine_form'].action = sAction;
		
	}
	document.forms['engine_form'].submit();
}
function addOptimSearch(sField, iVal){
	var _insert = "`" + sField + "`:" + "'" + iVal + "'";
	optimSearch = _insert;
	$('#optim_search').val(optimSearch);
}

function initList(){
	if($('div.title-list').length > 0)
	{
		var actions = $('.result-list .first-list-item .action a').length;
		var checkbox = $('.title-list .check').length;
		var i_item_width = 100 / ($('div.title-list > div').length);
		
		$('div.title-list >div').each(function(){
			if(!$(this).hasClass('action'))
				$(this).css('width', 'calc((100% - 185px) / ' + ($('div.title-list > div').length - (checkbox + 1)) + ')');
		})
		
		$('ul.result-list li> div').each(function(){
			if(!$(this).hasClass('action'))
				$(this).css('width', 'calc((100% - 185px) / ' + ($('div.title-list > div').length - (checkbox + 1)) + ')');
		});
	}
	
	$('.switch').click(function(){
		var sRel = $(this).attr('rel');
		var iID = $(this).attr('id').substr(7);
		updateOnline($(this).find('span').html(),sRel,iID);
	});
	
	$('.switchEdit').click(function(){
		var sRel = $(this).attr('rel');
		var _val = ($(this).html() == 1 ? 0 : 1);
		$(this).removeClass('switch-' + $(this).html());
		$(this).addClass('switch-' + _val);	
		$('#' + sRel).val(_val)
		$(this).html(_val) ;
	});
}
function initSortableMain(){
	$('.list_item').css('cursor','move');
	$(function() {
		$( ".result-list" ).sortable({
			start: function( event, ui ) {
				_sCss = ui.item.css('background');	
				ui.item.css('background','#999');	
				ui.item.css('opacity','.3');			
			},
			stop: function (event, ui) {
				var data = $(this).sortable('serialize');
				ui.item.css('background',_sCss);	
				ui.item.css('opacity','inherit');		
				$.ajax(
				{
					type:"POST",
					url: sDomain + sLang + '/admin.html?action=ajax&case=update_sort',
					context: document.body,
					data: {
						s_config 	: $('#iConfig').attr('value'),
						module		: $('#module').val(),
						val_id		: ui.item.attr('rel'),
						i_pos		: ui.item.index(),
						page		: $('#page').val(),
						optimSearch : $('#optim_search').val(),
					}
				}).done(function(data) 
				{ 
					var response = eval('(' + data + ')');
				
					/*if(response.response_code == 0)
					{
						 alert(response.response_message);
					}else alert(response.response_message);*/
				});	
			}
		});
	});
}
function remove(id) {
    return (elem=document.getElementById(id)).parentNode.removeChild(elem);
}


/**********************************/
/*          CROPPER FCT             */
/**********************************/

  function isUndefined(obj) {
    return typeof obj === 'undefined';
  }

$(document).ready(function() {
	
	initList();
	if(typeof b_sortable != 'undefined' && b_sortable && $('#itemSortable').length > 0)
		initSortableMain();
	//DROPZONE HANDLER HERE	
	//Dropzone.autoDiscover = false;
	if( $('#add-zone')){
		//var myDropzone0 = new Dropzone("#add-zone");
	}

	if( $('#vignette-upload').length > 0 && $('#vignette-upload').attr('data-uploadURL') != null){

		var optionsCrop = {
	        aspectRatio: _aspectRatio,
    		viewMode: 1,ready: function () {
      			croppable = true;
    		},
	        preview: '.img-preview',
	        build: function () {
	          console.log('build');
	        },
	        built: function () {
	          console.log('built');
	        },
	        cropstart: function (e) {
	          console.log('cropstart', e.detail.action);
	        },
	        cropmove: function (e) {
	          console.log('cropmove', e.detail.action);
	        },
	        cropend: function (e) {
	          console.log('cropend', e.detail.action);
	        },
	        crop: function (e) {
	          var data = e.detail;

	          console.log('crop');
	          dataX.value = Math.round(data.x);
	          dataY.value = Math.round(data.y);
	          dataHeight.value = Math.round(data.height);
	          dataWidth.value = Math.round(data.width);
	        //  dataRotate.value = !isUndefined(data.rotate) ? data.rotate : '';
	        //  dataScaleX.value = !isUndefined(data.scaleX) ? data.scaleX : '';
	        //  dataScaleY.value = !isUndefined(data.scaleY) ? data.scaleY : '';
	        },
	        zoom: function (e) {
	          console.log('zoom', e.detail.ratio);
	        }
	    };

		var myDropzone = new Dropzone("#vignette-upload", 
										{ 	url: $('#vignette-upload').attr('data-uploadURL'),
											createImageThumbnails : false,
											previewsContainer : false
										});

		console.log('Dropzone');
		//console.log(myDropzone);

		myDropzone.on('sending',function(file,xhr,formData){
			console.log('sending');
			formData.append('confData', $('#vignette-upload').attr('data-confData'));
		});

		myDropzone.on('error',function(file,errorMessage,xhr){
			console.log('---- ERROR ---');
			console.log(errorMessage);
			console.log(xhr);
			console.log('---- END ERROR ---');
		});
	
		myDropzone.on('success',function(file,response){

			var responseJSON = eval('(' + response + ')');
			console.log('6');
			
			if(responseJSON.open_crop ){
			console.log('7');
				$('.img-container').show();
				$('.docs-preview').show();
				$('#imgToCrop').attr('src',responseJSON.s_filename_url);

			console.log('8');
				Cropper = window.Cropper;
				//console = window.console || { log: function () {} };
				container = document.querySelector('.img-container');
				image = container.getElementsByTagName('img').item(0);
				download = document.getElementById('download');
				actions = document.getElementById('actions');
				dataX = document.getElementById('dataX');
				dataY = document.getElementById('dataY');
				dataHeight = document.getElementById('dataHeight');
				dataWidth = document.getElementById('dataWidth');
				dataRotate = document.getElementById('dataRotate');
				dataScaleX = document.getElementById('dataScaleX');
				dataScaleY = document.getElementById('dataScaleY');

				var image = document.getElementById('imgToCrop');
  				var button = document.getElementById('buttonCrop');
  				var result = document.getElementById('result');
  				//var croppable = false;
  				var cropper = new Cropper(image, optionsCrop);

			console.log('9');
  				button.onclick = function () {
    				var croppedCanvas;
    				var roundedCanvas;
    				var roundedImage;

			        croppedCanvas = cropper.getCroppedCanvas();
            		roundedCanvas = getRoundedCanvas(croppedCanvas);
			        roundedImage = document.createElement('img');
			        roundedImage.src = roundedCanvas.toDataURL();
			        saveDataImage(roundedImage.src, responseJSON.s_filename_url);
			        result.innerHTML = '';
			        result.appendChild(roundedImage);
			    };
			}
		});
	}
	//loaded();
});

function saveDataImage(sourceImg, sourceImgFileName){
	$.ajax(
	{
		type:"POST",
		url: sDomain + sLang + '/admin.html?action=ajax&case=saveDataImg',
		data:{
			datasrc: sourceImg,
			filename: sourceImgFileName
		},
		context: document.body
	
	}).done(function(data) 
	{
		var response = eval('(' + data + ')');
		if(response.response_code != 0) 
		{
			return NULL;
		}
		else 
		{
			$('#download_thumb').val(response.response_data);
			return canvas;
		}
				
	});
}

function getRoundedCanvas(sourceCanvas) {
  var canvas = document.createElement('canvas');
  var context = canvas.getContext('2d');
  var width = sourceCanvas.width;
  var height = sourceCanvas.height;

  canvas.width = width;
  canvas.height = height;
  context.imageSmoothingEnabled = true;
  context.drawImage(sourceCanvas, 0, 0, width, height);
  return canvas;
  /*context.globalCompositeOperation = 'destination-in';
  context.beginPath();
  context.arc(width , height , Math.min(width, height), 0, 1, true);
  context.fill();*/

}

function loaded(){
	$('.final-content').animate({'opacity': '1'}, 500, 'easeOutQuart');
}

function mediaContent(){
	$('.attachments-browser li.attachment.save-ready').click(function(){
		console.log('lklkkl');
		$(this).find('input[type=checkbox]').trigger('click');
		if($(this).find('input[type=checkbox]').is(':checked')){
			$( ".media-sidebar" ).prepend( '<li class="'+$(this).attr("rel")+'">'+$(this).find('thumbnail').html()+'</li>' );
		}else{
			$( ".media-sidebar li."+$(this).attr('rel')).remove();				
		}
	});
}