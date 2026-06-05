//INIT VARS
var b_Masonry = true;
var $container ;
var home_type = '';

function showHomeElements(iValue){
	if(iValue == '1'){
		$('#home_image').parent().hide();
		$('.detail_text').parent().hide();
		$('.detail_link').parent().hide();
		$('#home_data_module').parent().hide();
		$('.home_video').parent().hide();
				
		$('#home_tree').parent().show();
		$('.home_color').parent().show();
	}
	else if(iValue == '2'){
		$('#home_tree').parent().hide();
		$('#home_image').parent().hide();
		$('.detail_label').parent().hide();
		$('.detail_text').parent().hide();
		$('.detail_link').parent().hide();
		$('.home_color').parent().hide();
		$('.home_video').parent().hide();
		
		$('#home_data_module').parent().show();
	}
	else if(iValue == '3'){
		$('#home_tree').parent().hide();
		$('#home_data_module').parent().hide();
		$('.home_video').parent().hide();
		
		$('#home_image').parent().show();
		$('.detail_label').parent().show();
		$('.detail_text').parent().show();
		$('.detail_link').parent().show();
		$('.home_color').parent().show();
	}
	else if(iValue == '4'){
		$('#home_tree').parent().hide();
		$('#home_data_module').parent().hide();	
		$('.detail_text').parent().hide();
		$('.detail_link').parent().hide();
			
		$('.detail_label').parent().show();
		$('.home_color').parent().show();
		$('#home_image').parent().show();
		$('.home_video').parent().show();
	}	
}

function loadMasonry(){
	$container = $('#container');
	if($('div#container').width() > 1200) {
		$('div.grid-sizer').show();
		$container.masonry({
			columnWidth: ".grid-sizer",
			itemSelector: 'div.element',
			stamp: ".stamp"
		});
	}
	else if($('div#container').width() < 720) {
		$('div.grid-sizer').show();
		$container.masonry({
			columnWidth: ".grid-sizer",
			itemSelector: 'div.element',
			stamp: ".stamp"
		});
	}
	else {
		$('div.grid-sizer').hide();
		$container.masonry({columnWidth: 240,
			itemSelector: 'div.element',
			stamp: ".stamp"
		});
	}	
}

$(document).ready(function() {
	home_type = $('#home_type').val();

	showHomeElements(home_type);
	$(window).resize();
});

$(window).on('load', function() {
	$(window).resize();
});

$(window).on('resize', function() {
	if(b_Masonry) loadMasonry();
});