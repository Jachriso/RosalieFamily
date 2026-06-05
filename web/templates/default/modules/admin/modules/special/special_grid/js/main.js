//INIT VARS
var gridster ;

function showChiffreElements(iValue){
	if(iValue == '1'){
		$('#chiffre_path').parent().hide();
		$('.detail_label').parent().hide();
		$('.detail_text').parent().hide();
		$('.detail_link').parent().hide();
		
		$('#chiffre_data_module').parent().show();
	}
	else if(iValue == '2'){
		$('#chiffre_data_module').parent().hide();
		
		$('#chiffre_path').parent().show();
		$('.detail_label').parent().show();
		$('.detail_text').parent().show();
		$('.detail_link').parent().show();
	}
}
	
	
$(document).ready(function() {
	
	chiffre_type = $('#chiffre_type').val();

	showChiffreElements(chiffre_type);
	if($(".gridster").length>0)
	grid = $(".gridster ul").gridster({
		widget_margins: [10, 10],
		widget_base_dimensions: [140, 140],
		max_cols: 5,
		draggable: {
            handle: '.draggable',
			stop: function(event, ui, $widget){ 
			    _grid = JSON.stringify(grid.serialize());
				$.ajax(
				{
					type:"POST",
					url: sDomain + sLang + '/admin.html?action=ajax&case=update_special_grid',
					context: document.body,
					data: {
						_grid		: _grid
					}
				}).done(function(data) 
				{ 
					var response = eval('(' + data + ')');
					if(response.response_code == 1) window.location.reload();
				
				});	
			}
        },
	}).data('gridster');
	
	$('div.close_grid').click(function(){
		grid.remove_widget($('.gridster li').eq($(this).parent().parent().index()));
		$.ajax(
		{
			type:"POST",
			url: sDomain + sLang + '/admin.html?action=ajax&case=delete_special_grid',
			context: document.body,
			data: {
				iID		: $(this).parent().parent().attr('rel')
			}
		}).done(function(data) 
		{ 
			var response = eval('(' + data + ')');
		
		});	
	});
	
	$('div.small_form-submit a').click(function(){
		grid.add_widget('<li class="new"></li>', 1, 1);
		$.ajax(
		{
			type:"POST",
			url: sDomain + sLang + '/admin.html?action=ajax&case=add_special_grid',
			context: document.body,
			data: {
				data_row		: $('div.gridster ul li').last().attr('data-row'),
				data_col		: $('div.gridster ul li').last().attr('data-col'),
			}
		}).done(function(data) 
		{ 
			var response = eval('(' + data + ')');
			var s_module = $('input#s_module').val();
			$('div.gridster ul li').last().html('<a href="' + sDomain + sLang + '/admin.html?page=content&module=' + s_module + '&config_id=0&addon=special_grid&action=edit&val_id=' + response.response_message + '">link</a>');
		
		});			
	});
});

$(window).on('load', function() {
});
