//init vars
Array.prototype.in_array = function(p_val) {
    var l = this.length;
    for(var i = 0; i < l; i++) {
        if(this[i] == p_val) {
            return true;
        }
    }
    return false;
}

Array.prototype.unset = function(val){
	var index = this.indexOf(val)
	if(index > -1){
		this.splice(index,1)
	}
}

function getDownloadItem(){
	var aItem = new Array;
	if(oItemDownloads != '') 
		aItem = oItemDownloads.split(',');
	
	$('.item_downloads input[type=checkbox]').each(function(){
		if($(this).is(':checked') && !aItem.in_array($(this).val())) oItemDownloads += ','+ $(this).val() ;
		else if(!$(this).is(':checked') && aItem.in_array($(this).val())){
			aItem.unset($(this).val());
			_oItemDownloads = oItemDownloads.split(',');
			_oItemDownloads.unset($(this).val());
			oItemDownloads = _oItemDownloads.join(',');
		}
	});

	if(aItem.length == 0) 
		oItemDownloads = oItemDownloads.substr(1);
	
	if(oItemDownloads != '') 
		document.getElementById('data').value = ('{\\"addonsId\\":['+oItemDownloads+']}');
	else 
		document.getElementById('data').value = '';

	//document.forms['download_form'].submit();

	parent.setField('user_statut', document.getElementById('data').value); 
}
function rawurlencode (str) {
    str = (str+'').toString();        
    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
                                                                                    replace(/\)/g, '%29').replace(/\*/g, '%2A');
}
$(document).ready(function() {
	getDownloadItem();
	$('input[type=checkbox]').click(function(){
		getDownloadItem();
	});
});