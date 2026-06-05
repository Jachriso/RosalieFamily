//init vars
var iTimer;

function download_add_callback(response_quantity, response_item){
	window.parent.$(".nb-download").children('span').html(response_quantity);
	var aItems = eval('(' + response_item + ')');
	for(var i=0;i<aItems.length;i++){
		window.parent.$("#download_" + aItems[i]).attr('checked',true);
		window.parent.$("#cart1_" +  aItems[i]).css('display','block');
		window.parent.$("#cart2_" +  aItems[i]).parent().parent().parent().addClass('in-caddie');
		window.parent.$("#cart2_" +  aItems[i]).css('display','none');
	}
}
$(document).ready(function() {
});

$(window).load(function() {
	clearTimeout(iTimer);
	iTimer = setTimeout(parent.reloadCurrent,100);
});

