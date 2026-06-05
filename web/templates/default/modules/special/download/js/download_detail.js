//init vars

$(document).ready(function() {
	if($('.bxslider li').length>1){
		$('.bxslider').bxSlider({
			pagerCustom: '#bx-pager',
			auto: true
		});
	}

});