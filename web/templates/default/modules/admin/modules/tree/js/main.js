var _sCss = '';
var actionOpen = false;
var action;
var clickFired;

function initTree(){
	
	var clicking = false;
	var previousX, previousY;
	
	$('.item-element, .open-close').mousedown(function(e){
		previousX = e.clientX;
    	previousY = e.clientY;
    	clicking = true;
	});
	
	$('.item-element, .open-close').mouseup(function(e){
		
		if($(this).parent().find('.open-close').length !== 0 && e.clientX == previousX && e.clientY == previousY){
			//alert($(this).parent().find('.open-close').length);
			var item = $(this).parent().parent();
			if(!item.hasClass('open')){
				item.addClass('open');
				var calc = 0;
				item.find('>ul>li').each(function(){
					calc += $(this).height();
				});
				item.find('>ul').animate({
					'height': calc+'px'
					}, 400, function() {
					item.find('>ul').css('height', 'auto');
				});
			}
			else{
				item.removeClass('open');
				item.find('>ul').animate({'height': '0px'}, 400);
			}
		}
	});
}

function initSortable(){
	$('.list_item').css('cursor','move');
	$(function() {
		$( ".menu-niv1" ).sortable({
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
					url: sDomain + sLang + '/admin.html?action=ajax&case=update_tree',
					context: document.body,
					data: {
						s_config 	: $('#iConfig').attr('value'),
						module		: $('#module').val(),
						val_id		: ui.item.attr('rel'),
						i_pos		: ui.item.index(),
						page		: $('#page').val(),
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
		
		$( ".menu-niv2" ).sortable({
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
					url: sDomain + sLang + '/admin.html?action=ajax&case=update_tree',
					context: document.body,
					data: {
						s_config 	: $('#iConfig').attr('value'),
						module		: $('#module').val(),
						val_id		: ui.item.attr('rel'),
						i_pos		: ui.item.index(),
						page		: $('#page').val(),
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
		
		$( ".menu-niv3" ).sortable({
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
					url: sDomain + sLang + '/admin.html?action=ajax&case=update_tree',
					context: document.body,
					data: {
						s_config 	: $('#iConfig').attr('value'),
						module		: $('#module').val(),
						val_id		: ui.item.attr('rel'),
						i_pos		: ui.item.index(),
						page		: $('#page').val(),
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
		
		$( ".menu-niv4" ).sortable({
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
					url: sDomain + sLang + '/admin.html?action=ajax&case=update_tree',
					context: document.body,
					data: {
						s_config 	: $('#iConfig').attr('value'),
						module		: $('#module').val(),
						val_id		: ui.item.attr('rel'),
						i_pos		: ui.item.index(),
						page		: $('#page').val(),
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
		$( ".result-list" ).disableSelection();
	});
}

function actions(el){
	if(actionOpen != true){
		$('.action').addClass('hidden');
		el.closest('.action').addClass('open').removeClass('hidden');
		action = el;
		actionOpen = true;
	}
	else{
		$('.action').removeClass('hidden');
		action.closest('.action').removeClass('open');
		actionOpen = false;
	}
}

$(document).ready(function() {
	initTree();
	if(b_sortable) initSortable();
	$('.result-list').on('click', function(e){
		if(actionOpen == true){actions();}
		e.stopPropagation();
	});
	$('.action .more').on('click', function(e){
		actions($(this));
		e.stopPropagation();
	});
	
});
