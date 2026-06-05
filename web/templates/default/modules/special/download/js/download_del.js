//init vars
var iTimer;

function download_del_callback(response_code, response_quantity, response_item){
	window.parent.$(".nb-download").children('span').html(response_quantity);
	var aItems = eval('(' + response_item + ')');
	for(var i=0;i<aItems.length;i++){
		window.parent.$("#download_" + aItems[i]).attr('checked',false);
		window.parent.$("#cart1_" +  aItems[i]).css('display','none');
		window.parent.$("#cart1_" +  aItems[i]).parent().parent().parent().removeClass('in-caddie');
		window.parent.$("#cart2_" +  aItems[i]).css('display','');
	}
	if(response_code == 0){
		clearTimeout(iTimer);
		iTimer = setTimeout(parent.reloadCurrent,3000);
	}
}
$(document).ready(function() {
});

$(window).load(function() {

});